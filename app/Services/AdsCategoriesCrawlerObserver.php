<?php

namespace App\Services;

use App\Models\AdCategory;
use App\Models\AdSubcategory;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use Symfony\Component\DomCrawler\Crawler;

class AdsCategoriesCrawlerObserver extends CrawlObserver
{
    public function crawled($url, $response, $foundOnUrl = null)
    {
        $domCrawler = new Crawler(
            (string)$response->getBody()
        );

        $domCrawler->filter('div.filaCat div.categoria')->each(function ($categorySection) use ($url, $domCrawler) {
            $categoryName = $categorySection->filter('div.cat1Item > a')->text();

            echo "Current category $categoryName\n";

            $categoryTitle = $categorySection->filter('div.cat1Item > a')->attr('title');
            $categoryUrl = $categorySection->filter('div.cat1Item > a')->attr('href');
            $categoryIcon = $domCrawler->filter("img[alt*=\"$categoryTitle\"]")->attr('src');

            $category = AdCategory::firstOrCreate(
                ['name' => $categoryName],
                ['icon' => $categoryIcon, 'url' => "https://www.milanuncios.com" . $categoryUrl]
            );

            $categorySection->filter('div.cat2Item > a')->each(function ($subCategory) use ($category) {
                $subcategoryName = $subCategory->text();

                if ($subcategoryName == 'MÁS...') return;
                echo " - Current subcategory $subcategoryName\n";

                $subcategoryUrl = $subCategory->attr('href');

                AdSubcategory::firstOrCreate(
                    ['name' => $subcategoryName, 'category_id' => $category->id],
                    ['url' => 'https://www.milanuncios.com' . $subcategoryUrl]
                );
            });
        });

        echo "\nFinished\n\n";

        exit(0);
    }

    public function crawlFailed($url, $requestException, $foundOnUrl = null)
    {
        echo $requestException->getMessage();
    }
}
