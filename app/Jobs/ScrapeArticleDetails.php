<?php

namespace App\Jobs;

use App\Models\Ad;
use App\Services\AdsCrawlerService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScrapeArticleDetails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ad;

    /**
     * Job created to scrape an ad details page
     * @param Ad $ad The ad to scrape
     */
    public function __construct(Ad $ad)
    {
        $this->ad = $ad;
    }

    /**
     * Execute the job and scrape more data from the details page
     *
     * @return void
     */
    public function handle()
    {
        AdsCrawlerService::scrapeAdDetails($this->ad);
    }
}
