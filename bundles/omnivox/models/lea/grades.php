<?php namespace Omnivox\Models\Lea;

use Laravel\Bundle;
use Omnivox\Libraries\Curl,
	Omnivox\Entities;

require_once(Bundle::path('omnivox').'simple_html_dom.php');

class Grades {

	public static function getAllGrades()
	{
		$curl = new Curl();
		$html = $curl->get('https://johnabbott.omnivox.ca/intr/Module/ServicesExterne/Skytech.aspx?IdServiceSkytech=Skytech_Omnivox&lk=%2festd%2fcvie%3fmodule%3dnote%26item%3dintro');
		$curl = null;
		
		$html = str_get_html($html);
				
		$rows = $html->find('td[class=cvirContenuCVIR] table table table table', 2)->find('tr[bgcolor]');
		
		$grades = array();
		
		for ($i = 1; $i < count($rows); $i++) {
			$td = $rows[$i]->find('td');
			
			$description = explode(" ", preg_replace('/(\\r|\\n|&nbsp;|sect\.0*)/', "", $td[2]->find('font', 1)->plaintext));
			
			preg_match("/([0-9]+)%/", $td[3]->plaintext, $grade);
			preg_match("/([0-9]+)%/", $td[4]->plaintext, $average);
			
			$grades[] = new Entities\Lea\Grade(
				$td[2]->find('font', 0)->plaintext,
				$description[0],
				(int) $description[1],
				$grade ? $grade[1] : NULL,
				$average ? $average[1] : NULL,
				(int) $td[5]->find('font', 0)->plaintext
			);
		}
		
		return $grades;
	}

}