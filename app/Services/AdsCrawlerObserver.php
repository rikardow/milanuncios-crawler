<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\AdSubcategory;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use Symfony\Component\DomCrawler\Crawler;

class AdsCrawlerObserver extends CrawlObserver
{
    protected $subcategory;

    public function __construct(AdSubcategory $subcategory)
    {
        $this->subcategory = $subcategory;
    }

    public function crawled($url, $response, $foundOnUrl = null)
    {
        $domCrawler = new Crawler(
            (string)$response->getBody()
        );

        $domCrawler->filter('div.ma-AdList article.ma-AdCard')->each(function ($adTile) {
            $reference = $adTile->filter('p.ma-AdCard-adId')->text();
            $reference = ltrim($reference, 'r');

            $url = $adTile->filter('h2.ma-AdCard-title-text > a')->attr('href');

            echo "Current Ad reference $reference with url $url\n";

            $title = $adTile->filter('h2.ma-AdCard-title-text > a')->text();
            $location = $adTile->filter('span.ma-AdCard-location')->text();

            $priceElement = $adTile->filter('span.ma-AdCard-price-value');
            $price = null;

            if ($priceElement->count() > 0) {
                $price = $adTile->filter('span.ma-AdCard-price-value')->text();
                $price = str_replace(['€', '.'], '', $price);
            }

            $description = $adTile->filter('p.ma-AdCardDescription-text')->text();
            $freeShipping = $adTile->filter('span.ma-AdCard-metadataTag--shippable')->count() > 0;

            $pictureElement = $adTile->filter('figure.ma-AdCard-photoContainer > img');
            $pictures = [];
            if ($pictureElement->count() > 0) {
                $pictures[] = $pictureElement->attr('src');
            }

            $tags = [];

            $adTile->filter('span.ma-AdTag-label')->each(function ($tag) use (&$tags) {
                $tags[] = $tag->text();
            });

            Ad::firstOrCreate(
                ['reference' => $reference],
                [
                    'title' => $title,
                    'price' => $price,
                    'description' => $description,
                    'free_shipping' => $freeShipping,
                    'url' => $url,
                    'location' => $location,
                    'tags' => json_encode($tags),
                    'images' => json_encode($pictures),
                    'subcategory_id' => $this->subcategory->id
                ]
            );
        });
    }

    public function crawlFailed($url, $requestException, $foundOnUrl = null)
    {
        echo $requestException->getMessage();
    }
}
