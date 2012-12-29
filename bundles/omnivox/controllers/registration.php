<?php

use Omnivox\Models\Registration,
	Omnivox\Libraries\Output;

class Omnivox_Registration_Controller extends Base_Controller {

	public $restful = true;

	public function get_seats($format)
	{
		$status = 200;

		try {
			//if (Session::get('auth-mio') !== true) {
			//	MIO::authenticate();
			//}

			$response = Registration::getSeats(Input::get('course'));
		}
		catch (Exception $e) {
			$status = 400;
			$response = array('error' => $e->getMessage());
		}

		return Output::outputWithFormat($response, $format, $status);
	}

}