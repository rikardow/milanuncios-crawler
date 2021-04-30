<?php

namespace App\Services;

use App\Models\Ad;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use Symfony\Component\DomCrawler\Crawler;

class AdsDetailsCrawlerObserver extends CrawlObserver
{
    protected $ad;

    /**
     * AdsCrawlerObserver constructor.
     * @param Ad $ad Inject the $ad to update it during the process
     */
    public function __construct(Ad $ad)
    {
        $this->ad = $ad;
    }

    /**
     * get the img from inside the ad details in case we don't have an image before
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

        $imageElement = $domCrawler->filter('div.pagAnuFoto img, img.sui-ImageSlider-image');
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
