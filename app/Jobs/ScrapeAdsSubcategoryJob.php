<?php

namespace App\Jobs;

use App\Models\AdCategory;
use App\Services\AdsCrawlerService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScrapeAdsSubcategoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $category;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AdCategory $category)
    {
        $this->category = $category;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        AdsCrawlerService::scrapeCategory($this->category);
    }
}
