<?php

namespace App\Services;

use App\Jobs\ScrapeAdsSubcategoryJob;
use App\Models\Ad;
use App\Models\AdCategory;
use GuzzleHttp\RequestOptions;
use Spatie\Crawler\Crawler;

class AdsCrawlerService
{
    /**
     * Scrape the website in search of categories and subcategories to populate the db
     */
    public static function refreshCategories()
    {
        // For some reason this is returning 404 but good data so ignore errors
        Crawler::create([RequestOptions::HTTP_ERRORS => false])
            ->setCrawlObserver(new AdsCategoriesCrawlerObserver)
            ->setMaximumDepth(1)
            ->startCrawling('https://www.milanuncios.com/anuncios');
    }

    /**
     * Dispatch the job that will scrape the category ads list in
     * another process to take advantage of concurrency
     */
    public static function dispatchScrapeSubcategoriesJobs()
    {
        AdCategory::all()->each(function ($category) {
            echo "Dispatching category {$category->name}\n";
            ScrapeAdsSubcategoryJob::dispatch($category);
        });
    }


    /**
     * Go through the list of ads in the category and save it in the db
     * @param $category
     */
    public static function scrapeCategory($category)
    {
        // For some reason this is returning 404 but good data so ignore errors
        Crawler::create([RequestOptions::HTTP_ERRORS => false])
            ->setCrawlObserver(new AdsCrawlerObserver($category))
            ->setMaximumDepth(0)
            ->startCrawling($category->url);

        echo "\nFinished Category {$category->name}\n\n";
    }


    /**
     * Scrape the ad details page to harvest more data
     * that's not available in the list of the category
     * @param Ad $ad the ad to scrape
     */
    public static function scrapeAdDetails(Ad $ad)
    {
        // For some reason this is returning 404 but good data so ignore errors
        Crawler::create([RequestOptions::HTTP_ERRORS => false])
            ->setCrawlObserver(new AdsDetailsCrawlerObserver($ad))
            ->setMaximumDepth(0)
            ->startCrawling($ad->url);
    }
}

