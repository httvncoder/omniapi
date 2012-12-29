<?php

namespace Omnivox\Models;

use Laravel\Bundle;
use Omnivox\Libraries\Curl;
use Omnivox\Entities;

use Symfony\Component\DomCrawler\Crawler;

class Registration
{
    public static function getSeats($course)
    {
        $curl = new Curl();
        $curl->get('https://johnabbott.omnivox.ca/intr/Module/ServicesExterne/Skytech.aspx?IdServiceSkytech=Skytech_Omnivox&lk=%2festd%2finsc%2finsc.ovx');
        $curl->get('https://johnabbott-estd.omnivox.ca/estd/LoadSession.ovx?veriflogin=sso&lk=%2Festd%2Finsc%2Finsc%2Eovx');
        $curl->get('https://johnabbott-estd.omnivox.ca/estd/Menu.ovx?lk=%2Festd%2Finsc%2Finsc%2Eovx');
        $html = $curl->get('https://johnabbott-estd.omnivox.ca/estd/insc/CoursDispo.ovx?NoEquiv=201NYC&AnSes=20132&NoEtu=1000000&ServEns=1&Mode=A');
        unset($curl);

        $crawler = new Crawler();
        $crawler->addContent($html);
        $crawler = $crawler->filterXPath('//table//table//tr[2]/td[3]/font/b');

        return $crawler->text();
    }
}
