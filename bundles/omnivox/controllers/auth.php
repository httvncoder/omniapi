<?php

use Omnivox\Models\Auth,
	Omnivox\Libraries\Output;

class Omnivox_Auth_Controller extends Base_Controller {
	
	public $restful = true;
	
	public function get_index($format, $id, $pwd)
	{
		$response = array();
		
		try {
			$result = Auth::login($id, $pwd, $this->url);
			
			if ($result === true) {
				Session::put('auth', true);
				Session::put('id', $id);
				Session::put('auth-schedule', false);
			}
			
			$response['success'] = true;
		}
		catch (Exception $e) {
			$response['success'] = false;
			$response['message'] = $e->getMessage();
		}
				
		return Output::outputWithFormat($response, $format);
	}
	
	public function post_index($format)
	{
		$response = array();
		
		try {
			if (Input::get('id') == null || Input::get('id') == "" || !is_numeric(Input::get('id')) ||
				Input::get('password') == null || Input::get('password') == "") {
				throw new Exception("Malformed student ID or password.");
			}
			
			$result = Auth::login(Input::get('id'),
								  Input::get('password'),
								  $this->url);
			
			if ($result === true) {
				Session::put('auth', true);
				Session::put('id', Input::get('id'));
				Session::put('auth-schedule', false);
			}
			
			$response['success'] = true;
		}
		catch (Exception $e) {
			$response['success'] = false;
			$response['message'] = $e->getMessage();
		}
						
		return Output::outputWithFormat($response, $format);
	}
	
	public function get_logout($format)
	{
		$response = array();
		
		try {
			$result = Auth::logout();
						
			$response['success'] = true;
		}
		catch (Exception $e) {
			$response['success'] = false;
			$response['message'] = $e->getMessage();
		}
				
		return Output::outputWithFormat($response, $format);
	}

}