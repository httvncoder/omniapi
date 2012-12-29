<?php namespace Omnivox\Entities;

class Alert {
	
	public $name;
	public $description;
	public $url;
	
	public function __construct($name, $description, $url)
	{
		$this->name = $name;
		$this->description = $description;
		$this->url = $url;
	}

}