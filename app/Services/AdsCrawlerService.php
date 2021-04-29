<?php

namespace App\Services;

use App\Jobs\ScrapeAdsSubcategoryJob;
use App\Models\AdSubcategory;
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
            ->startCrawling('https://www.milanuncios.com/anuncios');
    }

    public static function scrapCategoriesAds(){
        AdSubcategory::all()->each(function($subcategory){
            echo "Dispatching subcategory {$subcategory->name}\n";
            ScrapeAdsSubcategoryJob::dispatchSync($subcategory);
        });

    }
}

