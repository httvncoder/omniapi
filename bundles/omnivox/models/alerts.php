<?php

namespace Omnivox\Models;

use Laravel\Bundle;
use Symfony\Component\DomCrawler\Crawler;
use Omnivox\Libraries\Curl;
//use Omnivox\Entities;

//require_once(Bundle::path('omnivox').'simple_html_dom.php');

class Alerts
{
    public static function getAllAlerts()
    {
        $curl = new Curl();
        $html = $curl->get('https://johnabbott.omnivox.ca/intr/webpart.ajax?IdWebPart=00000000-0000-0000-0003-000000000008');
        unset($curl);

        /* Disabled in favor of new DomCrawler method
        $dom = str_get_html($html);
        $alerts = array();

        foreach ($dom->find('div[class=Savq]') as $e) {
            $alerts[] = new Entities\Alert(
                $e->find('span[class=TitreQDN]', 0)->plaintext,
                $e->find('span[class=DescriptionQDN]', 0)->plaintext,
                $e->find('a', 0)->href
            );
        }
        */

        $crawler = new Crawler();
        $crawler->addContent($html);
        $crawler = $crawler->filter('div[class=Savq]');

        $alerts = array();
        foreach ($crawler as $node) {
            $node = new Crawler($node);
            $alert = new \stdClass();

            $alert->name = $node->filter('span[class=TitreQDN]')->text();
            $alert->description = $node->filter('span[class=DescriptionQDN]')->text();
            $alert->url = $node->filter('a')->attr('href');

            $alerts[] = $alert;
        }

        return $alerts;
    }
}