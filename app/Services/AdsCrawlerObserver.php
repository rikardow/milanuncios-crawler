<?php

namespace App\Services;

use App\Jobs\ScrapeArticleDetails;
use App\Models\Ad;
use App\Models\AdCategory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use Symfony\Component\DomCrawler\Crawler;

class AdsCrawlerObserver extends CrawlObserver
{
    protected $category;

    /**
     * AdsCrawlerObserver constructor.
     * @param AdCategory $category Inject the category to use the id later
     */
    public function __construct(AdCategory $category)
    {
        $this->category = $category;
    }

    /**
     * Once we have the response parse the body and save the data in a new row in the db
     *
     * @param UriInterface $url
     * @param ResponseInterface $response
     * @param null $foundOnUrl
     */
    public function crawled(UriInterface $url, ResponseInterface $response, $foundOnUrl = null)
    {
        $domCrawler = new Crawler(
            (string)$response->getBody()
        );

        $domCrawler->filter('div.aditem')->each(function ($adTile) {
            $reference = $adTile->filter('div.aditem-header > .x5')->text();
            $reference = ltrim($reference, 'r');

            $url = $adTile->filter('a.aditem-detail-title')->attr('href');
            $url = "https://www.milanuncios.com/" . $url;

            echo "Current Ad reference $reference with url $url\n";

            $title = $adTile->filter('a.aditem-detail-title')->text();
            $locationElement = $adTile->filter('div.list-location-region');

            $location = null;
            if ($locationElement->count() > 0) {
                $location = $locationElement->text();
            }

            $priceElement = $adTile->filter('div.aditem-price');
            $price = null;

            if ($priceElement->count() > 0) {
                $price = $priceElement->text();
                $price = str_replace(['€', '.'], '', $price);
            }

            $description = $adTile->filter('div.aditem-detail > div.tx')->text();
            $freeShipping = $adTile->filter('span.ma-AdCard-metadataTag--shippable')->count() > 0;

            $imageElement = $adTile->filter('div.aditem-image img, img.ef');
            $image = null;
            if ($imageElement->count() > 0) {
                $image = $imageElement->attr('src');
            }

            $tags = [];

            $adTile->filter('div.tag-mobile')->each(function ($tag) use (&$tags) {
                $tags[] = $tag->text();
            });

            $ad = Ad::firstOrCreate(
                ['reference' => $reference],
                [
                    'title' => $title,
                    'price' => $price,
                    'description' => $description,
                    'free_shipping' => $freeShipping,
                    'url' => $url,
                    'location' => $location,
                    'tags' => json_encode($tags),
                    'image' => $image,
                    'category_id' => $this->category->id
                ]
            );

            if ($image == null) {
                ScrapeArticleDetails::dispatch($ad);
            }
        });
    }

    public function crawlFailed($url, $requestException, $foundOnUrl = null)
    {
        echo $requestException->getMessage();
    }
}
