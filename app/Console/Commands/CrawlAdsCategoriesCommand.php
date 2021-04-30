<?php

namespace App\Console\Commands;

use App\Services\AdsCrawlerService;
use Illuminate\Console\Command;

class CrawlAdsCategoriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape all the ad categories and populate the database';

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
        AdsCrawlerService::refreshCategories();
        return 0;
    }
}
