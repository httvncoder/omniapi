<?php

class Calendar_Controller extends Base_Controller {

	public $restful = true;

	private $seasons = array(
		'1' => 'Winter',
		'2' => 'Summer',
		'3' => 'Fall'
	);

	private $search = array(' Ii', ' Iii', ' Iv', ' Vi');
	private $replace = array(' II', ' III', ' IV', ' VI');

	public function get_index()
	{
		return View::make('calendar.index');
	}

	public function post_auth()
	{
		if (!Input::has('id') || !Input::has('password') || !is_numeric(Input::get('id')) || strlen(Input::get('id')) != 7) {
			return json_encode(array(
				'success' => false,
				'message' => "Your student ID number or password is invalid."
			));
		}

		$result = Controller::call('omnivox::auth@index', array(
			'json',
			Input::get('id'),
			Input::get('password')
		));

		return $result;
	}

	/*
	public function get_list()
	{
		$result = Controller::call('omnivox::schedule@index', array(
			'json'
		));

		return $result;
	}
	*/

	public function get_download()
	{
		if (!Input::has('semester') || !Input::has('date-from') || !Input::has('date-to') || !is_numeric(Input::get('semester'))) {
			return Response::error('404');
		}

		$startDate = strtotime(urldecode(Input::get('date-from')));
		$endDate = strtotime(urldecode(Input::get('date-to')));

		if ($startDate === false || $endDate === false) {
			return Response::error('404');
		}

		if ($startDate > $endDate) {
			$swapped = $startDate;
			$startDate = $endDate;
			$endDate = $swapped;
		}

		$result = Controller::call('omnivox::schedule@index', array(
			'json'
		));

		$decoded = json_decode($result);

		if ($decoded->success == false) {
			return View::make('calendar.error')->with('error', $decoded->message ?: "Unexpected error.");
		}

		//            0  1  2  3  4  5  6
		$days = array(0, 0, 0, 0, 0, 0, 0);
		//            S  M  T  W  T  F  S

		$temp = $startDate;

		// First partial week
		while ($temp / 60 / 60 / 24 % 7 != 3 && $temp <= $endDate) {
			$days[date('w', $temp)]++;
			$temp += 86400;
		}

		// Complete weeks (S-S)
		while ($temp + 604800 <= $endDate) {
			for ($i = 0; $i <= 6; $i++) {
				$days[$i]++;
			}
			$temp += 604800;
		}

		// Final partial week
		while ($temp <= $endDate) {
			$days[date('w', $temp)]++;
			$temp += 86400;
		}

		header('Content-Description: File Transfer');
		header('Content-Type: text/calendar');
		header('Content-Disposition: attachment; filename=calendar.ics');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		echo "BEGIN:VCALENDAR\r\n";
		echo "PRODID:-//Paslawski.me//JAC Schedule Exporter//EN\r\n";
		echo "VERSION:2.0\r\n";
		echo "CALSCALE:GREGORIAN\r\n";
		echo "METHOD:PUBLISH\r\n";
		echo "X-WR-CALNAME:Schedule\r\n";
		echo "X-WR-CALDESC:John Abbott schedule for " . $this->seasons[substr(Input::get('semester'), 4, 1)] . ' ' . substr(Input::get('semester'), 0, 4) . "\r\n";

		$day = (int) date('w', $startDate);
		$classesOnDay = array();

		for ($i = 0; $i <= 6; $i++) {
			//echo "\n\n>>> ".date('r', $startDate)." (day=".$day.", count=".$days[$day].")\n\n";

			if ($startDate > $endDate) {
				break;
			}

			if ($days[$day] == 0) {
				continue;
			}

			foreach ($decoded->result as $class) {
				if ($class->day != $day) {
					continue;
				}

				$uid = uniqid(mt_rand(), true);

				echo "BEGIN:VEVENT\r\n";

				echo "SUMMARY:" . str_replace($this->search, $this->replace, Str::title($class->name)) . "\r\n";
				echo "LOCATION:" . str_replace(';', ', ', $class->room) . "\r\n";
				echo "DESCRIPTION:{$class->teacher}\r\n";

				echo "DTSTART;TZID=America/Montreal:" . date('omd\THis', $startDate + ($class->startTime * 3600)) . "\r\n";
				echo "DTEND;TZID=America/Montreal:" . date('omd\THis', $startDate + ($class->endTime * 3600)) . "\r\n";
				echo "DTSTAMP:" . date('omd\THis\Z') . "\r\n";

				if ($days[$day] > 1) {
					echo "RRULE:FREQ=WEEKLY;COUNT=" . $days[$day] . "\r\n";
				}

				echo "UID:{$uid}@paslawski.me\r\n";
				echo "STATUS:CONFIRMED\r\n";
				echo "TRANSP:OPAQUE\r\n";
				echo "END:VEVENT\r\n";
			}

			$startDate += 86400;
			$day = ($day + 1) % 7;
		}

		echo "END:VCALENDAR";

		exit;
	}
}