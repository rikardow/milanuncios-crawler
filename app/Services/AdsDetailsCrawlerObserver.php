<?php

namespace App\Services;

use App\Jobs\ScrapeArticleDetails;
use App\Models\Ad;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use Symfony\Component\DomCrawler\Crawler;

class AdsDetailsCrawlerObserver extends CrawlObserver
{
    protected $ad;

    public function __construct(Ad $ad)
    {
        $this->ad = $ad;
    }

    public function crawled($url, $response, $foundOnUrl = null)
    {
        $domCrawler = new Crawler(
            (string)$response->getBody()
        );

        $imageElement = $domCrawler->filter('div.pagAnuFoto img');
        if ($imageElement->count() > 0) {
            $image = $imageElement->attr('src');
            echo "Image found! $image\n";
            $this->ad->update(['image' => $image]);
        }
    }

    public function crawlFailed($url, $requestException, $foundOnUrl = null)
    {
        echo $requestException->getMessage();
    }
}
