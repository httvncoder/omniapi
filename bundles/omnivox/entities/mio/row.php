<?php namespace Omnivox\Entities\Mio;

class Row {
	
	public $sender;
	public $date;
	public $subject;
	public $body;
	public $status;
	
	public function __construct($sender, $date, $subject, $body)
	{
		$this->sender = $sender;
		$this->date = $date;
		$this->subject = $subject;
		$this->body = $body;
		//$this->
	}

}