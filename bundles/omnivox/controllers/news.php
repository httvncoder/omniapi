<?php

use Omnivox\Models\News,
	Omnivox\Libraries\Output;

class Omnivox_News_Controller extends Base_Controller {

	public $restful = true;
	
	public function get_index($format)
	{
		$response = array();
		
		try {
			$news = News::getAllNews();
			
			$response['success'] = true;
			$response['result'] = $news;
		}
		catch (Exception $e) {
			$response['success'] = false;
			$response['message'] = $e->getMessage();
		}
				
		return Output::outputWithFormat($response, $format);
	}

}