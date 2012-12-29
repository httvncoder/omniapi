<?php namespace Omnivox\Models;

use Laravel\Session;
use Omnivox\Libraries\Curl;
use Symfony\Component\DomCrawler\Crawler;

class Auth {

	public static function login($id, $pwd)
	{
		$curl = new Curl();

		// Get the 'k' csrf value
		$html = $curl->get('https://johnabbott.omnivox.ca/intr/Module/Identification/Login/Login.aspx');

		$crawler = new Crawler();
		$crawler->addContent($html);
		$crawler = $crawler->filter('input[name=k]');

		if ($crawler->count() == 0) {
			throw new \Exception("An error occured while authenticating you.");
		}

		$k = $crawler->first()->attr('value');

		// Send login request
		$html = $curl->post('https://johnabbott.omnivox.ca/intr/Module/Identification/Login/Login.aspx?ReturnUrl=/',
							'StatsEnvUsersNbCouleurs=24&StatsEnvUsersResolution=1920&TypeIdentification=Etudiant&NoDA='.$id.'&PasswordEtu='.$pwd.'&x=0&y=0'.'&k='.$k);
		unset($curl);

		$crawler = new Crawler();
		$crawler->addContent($html);
		$crawler = $crawler->filter('div[id=MsgErreurLogin]');

		if ($crawler->count() > 0) {
			throw new \Exception("Your Student ID number or your password is invalid.");
		}

		return true;
	}

	public static function logout()
	{
		$curl = new Curl();
		$curl->get('https://johnabbott.omnivox.ca/intr/Module/Identification/Quitter.aspx');
		unset($curl);

		Session::flush();

		return true;
	}

}