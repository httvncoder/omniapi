<?php

use Omnivox\Models\Schedule;
use Omnivox\Libraries\Output;

class Omnivox_Schedule_Controller extends Base_Controller {

	public $restful = true;

	public function get_index($format)
	{
		try {
			if (Session::get('auth-schedule') !== true) {
				Schedule::authenticate();
			}

			if (!Input::has('semester')) {
				$result = Schedule::getSemesterList();
			}
			else {
				$result = Schedule::getSchedule();
			}

			$response['success'] = true;
			$response['result'] = $result;
		}
		catch (Exception $e) {
			$response['success'] = false;
			$response['message'] = $e->getMessage();
		}

		return Output::outputWithFormat($response, $format);
	}
}