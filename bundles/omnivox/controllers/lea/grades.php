<?php

use Omnivox\Models\Lea\Grades,
	Omnivox\Libraries\Output;

class Omnivox_Lea_Grades_Controller extends Base_Controller {

	public $restful = true;
	
	public function get_index($format)
	{
		$response = array();
		
		try {
			$grades = Grades::getAllGrades();
			
			$response['success'] = true;
			$response['result'] = $grades;
		}
		catch (Exception $e) {
			$response['success'] = false;
			$response['message'] = $e->getMessage();
		}
				
		return Output::outputWithFormat($response, $format);
	}

}