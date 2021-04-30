<?php

namespace App\Console\Commands;

use App\Services\AdsCrawlerService;
use Illuminate\Console\Command;

class CrawlAdsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler:ads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape the list of ads associated to the categories in the db';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        AdsCrawlerService::dispatchScrapeSubcategoriesJobs();
        return 0;
    }
}
