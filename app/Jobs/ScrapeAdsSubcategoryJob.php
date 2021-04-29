<?php

namespace App\Jobs;

use App\Models\AdSubcategory;
use App\Services\AdsCrawlerObserver;
use GuzzleHttp\RequestOptions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Crawler\Crawler;

class ScrapeAdsSubcategoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $subcategory;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AdSubcategory $subcategory)
    {
        $this->subcategory = $subcategory;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Crawler $crawler, AdsCrawlerObserver $crawlerObserver)
    {
        $crawler::create([RequestOptions::HTTP_ERRORS => false])
            ->setCrawlObserver($crawlerObserver)
            ->startCrawling($this->subcategory->url);
    }
}
