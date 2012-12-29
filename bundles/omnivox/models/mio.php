<?php

namespace Omnivox\Models;

use Laravel\Bundle;
use Laravel\Session;
use Omnivox\Libraries\Curl;
use Omnivox\Entities;
use Symfony\Component\DomCrawler\Crawler;

class MIO {

	public static function authenticate()
	{
		$curl = new Curl();
		$html = $curl->get('https://johnabbott.omnivox.ca/WebApplication/Module.MIOE/Login.aspx');
		$curl = null;

		if (strpos($html, 'RedirectToMainPage("https://johnabbott.omnivox.ca/WebApplication/Module.MIOE/Default.aspx");') === false) {
			throw new Exception('Could not authenticate you to the MIO service.');
		}

		Session::put('auth-mio', true);
		\Log::info("MIO auth successful.");

		return true;
	}

	public static function totalPages()
	{
		$curl = new Curl();
		$html = $curl->get('https://johnabbott.omnivox.ca/WebApplication/Module.MIOE/Commun/Message/MioListe.aspx?NomCategorie=SEARCH_FOLDER_MioRecu');
		unset($curl);

		$crawler = new Crawler();
		$crawler->addHtmlContent($html, "ISO-8859-1");

		$js = $crawler->filterXPath('//div[@class="divPagination"]/a[@title=">>"]')->attr('href');
		preg_match("/'([0-9]+)'/", $js, $pages);

		if ($pages === null) {
			throw new \Exception("Could not load your MIO.");
		}

		return $pages[1];
	}

	public static function inbox($page = '0')
	{
		$curl = new Curl();
		$html = $curl->post('https://johnabbott.omnivox.ca/WebApplication/Module.MIOE/Commun/Message/MioListe.aspx?NomCategorie=SEARCH_FOLDER_MioRecu', '__EVENTTARGET=ctl00$cntFormulaire$btnChangerPage&__EVENTARGUMENT=' . $page);
		unset($curl);

		$crawler = new Crawler();
		$crawler->addContent($html);
		$crawler = $crawler->filter('table[id=lstMIO] tr[class~=norm]');

		$messages = array();
		foreach ($crawler as $node) {
			$node = new Crawler($node);
			$message = new \stdClass();

			$message->id = substr($node->filter('input[type=checkbox]')->attr('id'), 3);
			$message->sender = $node->filter('span[class=msgUser]')->text();
			$message->date = $node->filter('td[class=date]')->text();
			$message->subject = $node->filter('td[class=lsTdTitle] em')->text();
			$message->body = trim($node->filterXPath('//td[@class="lsTdTitle"]/div/text()')->text(), chr(0xC2).chr(0xA0));
			$message->read = strpos($node->attr('class'), 'newmsg') === false;

			$messages[] = $message;
		}

		return $messages;
	}

	public static function sent($page = '0')
	{
		$curl = new Curl();
		$html = $curl->post('https://johnabbott.omnivox.ca/WebApplication/Module.MIOE/Commun/Message/MioListe.aspx?NomCategorie=SEARCH_FOLDER_MioEnvoye', '__EVENTTARGET=ctl00$cntFormulaire$btnChangerPage&__EVENTARGUMENT=' . $page);
		unset($curl);

		$crawler = new Crawler();
		$crawler->addContent($html);
		$crawler = $crawler->filter('table[id=lstMIO] tr[class~=norm]');

		$messages = array();
		foreach ($crawler as $node) {
			$node = new Crawler($node);
			$message = new \stdClass();

			$message->id = substr($node->filter('input[type=checkbox]')->attr('id'), 3);
			$message->sender = $node->filter('span[class=msgUser]')->text();
			$message->date = $node->filter('td[class=date]')->text();
			$message->subject = $node->filter('td[class=lsTdTitle] em')->text();
			$message->body = trim($node->filterXPath('//td[@class="lsTdTitle"]/div/text()')->text(), chr(0xC2).chr(0xA0));
			$message->recipientsRead = $node->filterXPath('//td[@class="lectures"]//td[1]')->text();
			$message->totalRecipients = $node->filterXPath('//td[@class="lectures"]//td[3]')->text();

			$messages[] = $message;
		}

		return $messages;
	}

	public static function trash($page = '0')
	{
		$curl = new Curl();
		$html = $curl->post('https://johnabbott.omnivox.ca/WebApplication/Module.MIOE/Commun/Message/MioListe.aspx?NomCategorie=SEARCH_FOLDER_MioSupprimer', '__EVENTTARGET=ctl00$cntFormulaire$btnChangerPage&__EVENTARGUMENT=' . $page);
		unset($curl);

		$crawler = new Crawler();
		$crawler->addContent($html);
		$crawler = $crawler->filter('table[id=lstMIO] tr[class~=norm]');

		$messages = array();
		foreach ($crawler as $node) {
			$node = new Crawler($node);
			$message = new \stdClass();

			$message->id = substr($node->filter('input[type=checkbox]')->attr('id'), 3);
			$message->sender = $node->filterXPath('//span[@class="msgUser"]/text()')->text();
			$message->date = $node->filter('td[class=date]')->text();
			$message->subject = $node->filter('td[class=lsTdTitle] em')->text();
			$message->body = trim($node->filterXPath('//td[@class="lsTdTitle"]/div/text()')->text(), chr(0xC2).chr(0xA0));

			$readCount = $node->filterXPath('//td[@class="lectures"]//td');
			if ($readCount->count() >= 3) {
				$message->recipientsRead = $readCount->eq(0)->text();
				$message->totalRecipients = $readCount->eq(2)->text();
			}

			$messages[] = $message;
		}

		return $messages;
	}

	public static function message($id)
	{
		$curl = new Curl();
		$html = $curl->get('https://johnabbott.omnivox.ca/WebApplication/Module.MIOE/Commun/Message/MioDetail.aspx?NomCategorie=SEARCH_FOLDER_MioRecu&m=' . $id);
		unset($curl);

		$crawler = new Crawler();
		$crawler->addHtmlContent($html, 'ISO-8859-1');

		$message = new \stdClass();

		// Parse sender information
		$message->sender = new \stdClass();

		$sender = str_replace("\xC2\xA0", ' ', $crawler->filterXPath('//td[@class="cDe"]')->text());
		$posCourse = strpos($sender, '(');

		$message->sender->name = $posCourse === false ? trim($sender) : substr($sender, 0, $posCourse - 1);
		$message->sender->type = $crawler->filterXPath('//td[@class="cDe"]/a')->attr('class') == 'dest_professeur' ? 'teacher' : 'student';

		if ($posCourse !== false) {
			// Parse list of courses the sender has in common with recipient
			$list = substr($sender, $posCourse + 1, strlen($sender) - $posCourse - 2);
			$message->sender->courses = explode(', ', $list);
		}

		// Parse recipients
		$message->recipients = array();

		if ($crawler->filterXPath('//div[@class="lstDestH"]')->count()) {
			// Multiple recipients
			foreach ($crawler->filterXPath('//td[@id="tdACont"]//td[@class="nd"]') as $node) {
				$node = new Crawler($node);
				$recipient = new \stdClass();

				$recipient->name = trim($node->text(), "\xC2\xA0");
				$recipient->type = $node->filterXPath('//a')->attr('class') ?: $node->filterXPath('//a')->attr('title');
				$recipient->type = ($recipient->type == 'Student' || strpos(strtolower($recipient->type), 'etudiant') !== false) ? 'student' : 'teacher';

				$message->recipients[] = $recipient;
			}
		}
		else {
			// Only one recipient
			$message->recipients[] = trim($crawler->filterXPath('//td[@id="tdACont"]/text()')->text(), "\xC2\xA0");
		}

		$message->subject = $crawler->filterXPath('//td[@class="cSujet"]')->text();
		$message->date = str_replace("\xC2\xA0", ' ', $crawler->filterXPath('//td[@class="cDate"]')->text());

		// Get body of message as HTML
		foreach ($crawler->filterXPath('//td[@class="cBody"]') as $body) {
			// To exclude the <td> tag in the output, iterate over children of $body
			$message->body = '';
			foreach ($body->childNodes as $node) {
				$message->body .= $node->ownerDocument->saveHTML($node);
			}
		}

		return $message;
	}

	public static function send()
	{
		//1b3a2eb3-1ce8-4f17-961c-f263b9e1d995
		$params = "__EVENTTARGET=ctl00%24cntFormulaire%24btnSend&ctl00%24cntFormulaire%24txtSujet=subjecthere&ctl00%24cntFormulaire%24ftbMioNouveau=messagebodyhere&ctl00%24cntFormulaire%24hidAjout=0900ba9c-4d73-4189-9659-8af51cd982c8&DEST_OID_ESTD_0900BA9C-4D73-4189-9659-8AF51CD982C8=OID_ESTD_0900BA9C-4D73-4189-9659-8AF51CD982C8%A7Christopher+Paslawski%A7ESTD%A7&ctl00%24cntFormulaire%24confirmRetour%24btnAction=none&ctl00%24cntFormulaire%24confirmEnvoi%24btnAction=none";
		$curl = new Curl();
		$html = $curl->post('https://johnabbott.omnivox.ca/WebApplication/Module.MIOE/Commun/Composer/NouveauMessage.aspx', $params);
		unset($curl);

		echo $html;

		return array();
		//$crawler = new Crawler();
		//$crawler->addHtmlContent($html, 'ISO-8859-1');
	}
}