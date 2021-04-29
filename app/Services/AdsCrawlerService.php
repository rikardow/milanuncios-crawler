<?php

namespace App\Services;

use App\Jobs\ScrapeAdsSubcategoryJob;
use App\Models\AdCategory;
use GuzzleHttp\RequestOptions;
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
        AdCategory::all()->each(function ($category) {
            echo "Dispatching category {$category->name}\n";
            ScrapeAdsSubcategoryJob::dispatchSync($category);
        });
    }

    public static function scrapeCategory($category)
    {
        Crawler::create([RequestOptions::HTTP_ERRORS => false])
            ->setCrawlObserver(new AdsCrawlerObserver($category))
            ->setMaximumDepth(0)
            ->startCrawling($category->url);

        echo "\nFinished Category {$category->name}\n\n";
    }
}

