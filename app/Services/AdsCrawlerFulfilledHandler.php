<?php

namespace App\Services;

use Spatie\Crawler\Handlers\CrawlRequestFulfilled;

class AdsCrawlerFulfilledHandler extends CrawlRequestFulfilled
{
    protected function getBodyAfterExecutingJavaScript($url): string
    {
        exit();
        $browsershot = $this->crawler->getBrowsershot();
        $browsershot->waitForFunction('window.scrollBy(0, document.body.scrollHeight)', $pollingInMilliseconds, $timeoutInMilliseconds);
        $browsershot->waitUntilNetworkIdle();

        $browsershot->setUrl((string)$url);
        $browsershot->evaluate('window.scrollBy(0, document.body.scrollHeight)');

        $html = $browsershot->bodyHtml();

        return html_entity_decode($html);
    }
}
