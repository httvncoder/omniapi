<?php

use Omnivox\Models\Alerts;
use Omnivox\Libraries\Output;

class Omnivox_Alerts_Controller extends Base_Controller
{

    public $restful = true;

    public function get_index($format)
    {
        $response = array();

        try {
            $alerts = Alerts::getAllAlerts();

            $response['success'] = true;
            $response['result'] = $alerts;
        }
        catch (Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        }

        return Output::outputWithFormat($response, $format);
    }

}