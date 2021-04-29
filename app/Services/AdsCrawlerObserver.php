<?php

namespace App\Services;

use App\Models\Ad;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use Symfony\Component\DomCrawler\Crawler;

class AdsCrawlerObserver extends CrawlObserver
{
    public function crawled($url, $response, $foundOnUrl = null)
    {
        $domCrawler = new Crawler(
            (string)$response->getBody()
        );

        $domCrawler->filter('div.ma-AdList article.ma-AdCard')->each(function ($adTile) {
            $reference = $adTile->filter('p.ma-AdCard-adId')->text();
            $reference = ltrim($reference, 'r');

            echo "Current Ad reference $reference\n";

            $title = $adTile->filter('h2.ma-AdCard-title-text > a')->text();
            $province = $adTile->filter('span.ma-AdCard-location')->text();

            $price = $adTile->filter('span.ma-AdCard-price-value')->text();
            $price = str_replace(['€', '.'], '', $price);

            $description = $adTile->filter('p.ma-AdCardDescription-text')->text();
            $freeShipping = $adTile->filter('span.ma-AdCard-metadataTag--shippable')->count() > 0;
            $url = $adTile->filter('h2.ma-AdCard-title-text > a')->attr('href');

            Ad::firstOrCreate(
                ['reference' => $reference],
                [
                    'title' => $title,
                    'price' => $price,
                    'description' => $description,
                    'free_shipping' => $freeShipping,
                    'url' => $url
                ]
            );
        });
    }

    public function crawlFailed($url, $requestException, $foundOnUrl = null)
    {
        echo $requestException->getMessage();
    }
}
