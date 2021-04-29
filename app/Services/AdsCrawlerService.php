<?php

namespace App\Services;

use App\Jobs\ScrapeAdsSubcategoryJob;
use App\Models\AdSubcategory;
use GuzzleHttp\RequestOptions;
use Spatie\Browsershot\Browsershot;
use Spatie\Crawler\Crawler;

class AdsCrawlerService
{
    /**
     * Make a call to to specified url and return
     */
    public static function refreshCategories()
    {
        Crawler::create([RequestOptions::HTTP_ERRORS => false])
            ->setCrawlObserver(new AdsCategoriesCrawlerObserver)
            ->setMaximumDepth(1)
            ->startCrawling('https://www.milanuncios.com/anuncios');
    }

    public static function dispatchScrapeSubcategoriesJobs()
    {
        AdSubcategory::all()->each(function ($subcategory) {
            echo "Dispatching subcategory {$subcategory->name}\n";
            ScrapeAdsSubcategoryJob::dispatchSync($subcategory);
        });
    }

    public static function scrapeSubcategory($subcategory)
    {
        Crawler::create([RequestOptions::HTTP_ERRORS => false])
            ->setCrawlFulfilledHandlerClass(AdsCrawlerFulfilledHandler::class)
            ->setCrawlObserver(new AdsCrawlerObserver($subcategory))
            ->setMaximumDepth(0)
            ->startCrawling($subcategory->url);

        echo "\nFinished subcategory {$subcategory->name}\n\n";
    }
}

