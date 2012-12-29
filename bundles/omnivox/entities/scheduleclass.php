<?php namespace Omnivox\Entities;

class ScheduleClass {
	
	public $name;
	public $number;
	public $section;
	public $room;
	public $teacher;
	
	public $day;
	public $startTime;
	public $endTime;
	
	public function __construct($name, $number, $section, $room, $teacher, $day, $startTime, $endTime)
	{
		$this->name = $name;
		$this->number = $number;
		$this->section = $section;
		$this->room = $room;
		$this->teacher = $teacher;
		$this->day = $day;
		$this->startTime = $startTime;
		$this->endTime = $endTime;
	}
	
}