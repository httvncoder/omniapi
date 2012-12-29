<?php

use Omnivox\Models\MIO;
use Omnivox\Libraries\Output;

class Omnivox_Mio_Controller extends Base_Controller
{
	public $restful = true;

	public $status = 200;

	public $provider = 'Omnivox\Models\MIO';

	public function get_inbox($format)
	{
		$provider = $this->provider;

		try {
			$response = $provider::inbox(Input::get('page', '0'));
		}
		catch (Exception $e) {
			$this->status = 400;
			$response = array('error' => $e->getMessage());
		}

		return Output::response($response, $this->status);
	}

	public function get_sent($format)
	{
		$status = 200;

		try {
			if (Session::get('auth-mio') !== true) {
				MIO::authenticate();
			}

			$response = MIO::sent(Input::get('page', '0'));
		}
		catch (Exception $e) {
			$status = 400;
			$response = array('error' => $e->getMessage());
		}

		return Output::outputWithFormat($response, $format, $status);
	}

	public function get_trash($format)
	{
		$status = 200;

		try {
			if (Session::get('auth-mio') !== true) {
				MIO::authenticate();
			}

			$response = MIO::trash(Input::get('page', '0'));
		}
		catch (Exception $e) {
			$status = 400;
			$response = array('error' => $e->getMessage());
		}

		return Output::outputWithFormat($response, $format, $status);
	}

	public function get_totalPages($format)
	{
		$status = 200;

		try {
			if (Session::get('auth-mio') !== true) {
				MIO::authenticate();
			}

			$response = MIO::totalPages();
		}
		catch (Exception $e) {
			$status = 400;
			$response = array('error' => $e->getMessage());
		}

		return Output::outputWithFormat($response, $format, $status);
	}

	public function get_message($format)
	{
		$status = 200;

		try {
			if (Session::get('auth-mio') !== true) {
				MIO::authenticate();
			}

			$response = MIO::message(Input::get('id'));
		}
		catch (Exception $e) {
			$status = 400;
			$response = array('error' => $e->getMessage());
		}

		return Output::outputWithFormat($response, $format, $status);
	}

	public function get_send($format)
	{
		$status = 200;

		try {
			if (Session::get('auth-mio') !== true) {
				MIO::authenticate();
			}

			$response = MIO::send();
		}
		catch (Exception $e) {
			$status = 400;
			$response = array('error' => $e->getMessage());
		}

		return Output::outputWithFormat($response, $format, $status);
	}
}