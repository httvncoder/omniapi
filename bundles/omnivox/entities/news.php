<?php namespace Omnivox\Entities;

class News {

	public $name;
	public $date;
	public $source;
	public $description;
	public $url;

	public function __construct($name, $date, $source, $description, $url)
	{
		$this->name = mb_check_encoding($name, 'UTF-8') ? $name : utf8_encode($name);
		$this->date = mb_check_encoding($date, 'UTF-8') ? $date : utf8_encode($date);
		$this->source = mb_check_encoding($source, 'UTF-8') ? $source : utf8_encode($source);
		$this->description = mb_check_encoding($description, 'UTF-8') ? $description : utf8_encode($description);
		$this->url = mb_check_encoding($url, 'UTF-8') ? $url : utf8_encode($url);
	}

}