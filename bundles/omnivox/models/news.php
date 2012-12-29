<?php

namespace Omnivox\Models;

use Laravel\Bundle;
use Omnivox\Libraries\Curl;
use Omnivox\Entities;

use Symfony\Component\DomCrawler\Crawler;

require_once(Bundle::path('omnivox').'simple_html_dom.php');

class News
{
    public static function getAllNews()
    {
        $curl = new Curl();
        $html = $curl->get('https://johnabbott.omnivox.ca/intr/webpart.gestion?IdWebPart=00000000-0000-0000-0003-000000000007');
        unset($curl);

        /*
        $html = str_get_html($html);

        $alerts = array();
        foreach ($crawler as $node) {
            $node = new Crawler($node);
            $alert = new \stdClass();

            $alert->name = $node->filter('span[class=TitreQDN]')->text();
            $alert->description = $node->filter('span[class=DescriptionQDN]')->text();
            $alert->url = $node->filter('a')->attr('href');

            $alerts[] = $alert;
        }


        $news = array();

        foreach ($html->find('div[class=newsWrapper]') as $e) {
            $url = $e->find('td[class=msgTitreMessage] a[class=msgTitreMessage]', 0);
            $source = $e->find('td[class=msgProvenanceMessage]');

            $news[] = new Entities\News(
                html_entity_decode($e->find('td[class=msgTitreMessage]', 0)->plaintext),
                html_entity_decode($source[0]->plaintext),
                isset($source[1]) ? html_entity_decode($source[1]->plaintext) : NULL,
                html_entity_decode($e->find('div[class=msgContenuDernierMessage]', 0)->plaintext),
                $url ? $url->href : $url
            );
        }
        */

        $crawler = new Crawler();
        $crawler->addContent($html);
        $crawler = $crawler->filter('div[class=newsWrapper]');

        $news = array();

        foreach ($crawler as $node) {
            $node = new Crawler($node);
            $article = new \stdClass();
            $source = $node->filter('td[class=msgProvenanceMessage]');
            $url = $node->filter('td[class=msgTitreMessage] a[class=msgTitreMessage]');

            $article->title = $node->filter('td[class=msgTitreMessage]')->text();
            $article->date = $source->text();
            $article->source = $source->count() > 1 ? $source->eq(1)->text() : null;
            $article->content = "";
            $article->url = $url->count() > 0 ? $url->attr('href') : null;

            $content = $node->filter('div[class~=msgContenuDernierMessage]');
            foreach ($content as $e) {
                $e->normalize();
                $article->content = $e->C14N();
                break;
            }

            $news[] = $article;
        }

        return $news;
    }
}
