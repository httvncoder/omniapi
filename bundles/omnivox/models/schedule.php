<?php namespace Omnivox\Models;

use Laravel\Bundle,
    Laravel\Input,
    Laravel\Session,
    Laravel\Log;
use Omnivox\Libraries\Curl,
    Omnivox\Entities\ScheduleClass;

require_once(Bundle::path('omnivox').'simple_html_dom.php');

class Schedule {

    public static function getSchedule()
    {
        $curl = new Curl();
        $html = $curl->post('https://johnabbott-estd.omnivox.ca/estd/hrre/horaire.ovx', 'AnSession='.Input::get('semester'));
        //Log::info('https://johnabbott-estd.omnivox.ca/estd/hrre/VisualiseHoraire.ovx?NoDa='.Session::get('id').'&AnSession='.Input::get('semester'));
        $html = $curl->get('https://johnabbott-estd.omnivox.ca/estd/hrre/VisualiseHoraire.ovx?NoDa='.Session::get('id').'&AnSession='.Input::get('semester'));
        $curl = null;

        //echo($html);

        $html = str_get_html($html);

        //$html = file_get_html("/Applications/MAMP/htdocs/omniapi/temp/testhtml/schedule-geoff-w2013.html");

        if ($html->find('input[name=MotPass]')) {
            throw new \Exception("You must enter your password online to view your schedule.");
        }

        $rows = $html->find('table[class=CelluleHoraire] tr');

        if (empty($rows)) {
            throw new \Exception("Could not load the schedule. Please ensure you are able to view it online.");
        }

        $classes = array();

        for ($i = 1; $i < count($rows); $i++) { // Iterate over all rows
            $td = $rows[$i]->find('td');
            for ($j = 1; $j < count($td); $j++) { // Iterate over all cells in row
                if (isset($td[$j]->rowspan) /*&& $td[$j]->bgcolor == "#ffffff"*/) {
                    // Found a class cell

                    $info = preg_split('/<br\s?\/>/', preg_replace('/(&nbsp;|<\/?b>|Classroom\s)/', '', $td[$j]->children(0)->innertext), -1, PREG_SPLIT_NO_EMPTY);

                    if (isset($info[1])) {
                        $number = preg_split('/ sec.0*/', $info[1], -1, PREG_SPLIT_NO_EMPTY);
                    } else {
                        $number = null;
                    }

                    $startTime = 0.5 * $i + 7.5;
                    $class = new ScheduleClass(
                        $info[0], // Name
                        isset($number[0]) ? $number[0] : '', // Course number
                        isset($number[1]) ? $number[1] : '', // Section
                        isset($info[2]) ? $info[2] : '', // Room
                        isset($info[3]) ? $info[3] : '', // Teacher
                        $j, // Day
                        $startTime, // Start time
                        $startTime + $td[$j]->rowspan * 0.5 // End time
                    );

                    /*
                    $day = $j;
                    do {
                        $collision = false;
                        // Iterate over existing classes on the same day
                        foreach ($classes as $c) {
                            if ($c->day == $day &&
                                (($c->startTime >= $class->startTime && $c->startTime < $class->endTime) ||
                                ($c->endTime > $class->startTime && $c->endTime <= $class->endTime))) {
                                // Class collision detected
                                $class->day++;
                                $day++;
                                $collision = true;
                            }
                        }
                    } while ($collision == true); // Stop when there are no more collisions
                    */

                    for ($day = 1; $day <= $class->day && $day <= 5; $day++) {
                        foreach ($classes as $c) {
                            if ($c->day == $day &&
                                $c->startTime != $class->startTime &&
                                (($c->startTime > $class->startTime && $c->startTime < $class->endTime) ||
                                ($c->endTime > $class->startTime && $c->endTime <= $class->endTime))) {
                                // Class collision detected
                                $class->day++;
                                break;
                            }
                        }
                    }

                    $classes[] = $class;

                }
            }
        }

        return $classes;
    }

    public static function getSemesterList()
    {
        $curl = new Curl();
        $html = $curl->get('https://johnabbott-estd.omnivox.ca/estd/hrre/horaire.ovx');
        $curl = null;

        //echo htmlentities($html);

        $html = str_get_html($html);

        $semesters = $html->find('select[name=AnSession]', 0);

        if ($semesters === null) {
            throw new \Exception("The Schedule module is unavailable for the moment. auth=" . Session::get('auth-schedule'));
        }

        $response = array();

        foreach ($semesters->find('option') as $e) {
            $response[] = $e->value;
        }

        return $response;
    }

    public static function confirmSchedule()
    {
        $curl = new Curl();
        $html = $curl->post('https://johnabbott-estd.omnivox.ca/estd/hrre/Confirmation.ovx?AnSession=20131', 'MotPass=' . Input::get('password') . '&Confirm=Confirm');
        $html = str_get_html($html);

        // TODO: Possibly change cURL class to return array including URL, check if URL is still Confirmation.ovx

        if ($html->find('input[name=MotPass]')) {
            throw new \Exception("The password you entered is invalid. Please try again.");
        }

        return;
    }

    public static function authenticate()
    {
        Log::info("Authenticating for horaire.ovx...");

        $curl = new Curl();
        $html = $curl->get('https://johnabbott.omnivox.ca/intr/Module/ServicesExterne/Skytech.aspx?IdServiceSkytech=Skytech_Omnivox&lk=%2festd%2fhrre%2fHoraire.ovx');

        $html = str_get_html($html);

        //preg_match('/[0-9]+;URL=(.*)/', $html->find('meta[HTTP-EQUIV=Refresh]', 0)->content, $url);

        // Second HTTP redirect hop
        if ($html->find('meta[content*=LoadSession.ovx]', 0) !== null) {
            $html = $curl->get('https://johnabbott-estd.omnivox.ca/estd/LoadSession.ovx?veriflogin=sso&lk=%2Festd%2Fhrre%2Fhoraire%2Eovx');
        }
        else if ($html->find('meta[content*=Menu.ovx]', 0) !== null) {
            // Not the first authentication
            $html = $curl->get('https://johnabbott-estd.omnivox.ca/estd/Menu.ovx?lk=%2Festd%2Fhrre%2Fhoraire%2Eovx');
        }
        else {
            $curl = null;
            Log::info("Couldn't authenticate. Bailing out.");
            throw new \Exception("Couldn't access your schedule.");
        }

        $curl = null;

        Session::put('auth-schedule', true);
        Log::info("Authentication successful.");

        return true;
    }

}