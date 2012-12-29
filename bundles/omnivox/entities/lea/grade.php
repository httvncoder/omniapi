<?php namespace Omnivox\Entities\Lea;

class Grade {
	
	public $name;
	public $number;
	public $section;
	
	public $grade;
	public $average;
	public $absenceHours;
	
	public function __construct($name, $number, $section, $grade, $average, $absenceHours)
	{
		$this->name = $name;
		$this->number = $number;
		$this->section = $section;
		$this->grade = $grade;
		$this->average = $average;
		$this->absenceHours = $absenceHours;
	}

}