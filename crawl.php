<?php
namespace WebCrawler;

use \WebCrawler\DB;
use \WebCrawler\Network;

require_once __DIR__ .'/vendor/autoload.php';
require_once '/src/config.php';

libxml_use_internal_errors(true); // disables libxml errors

// get sitemap in xml format
$httpResponse = Network::getInstance()->getResource($argv[1]);
$xml = simplexml_load_string($httpResponse['body']);

if($xml === false)
{
    echo 'There\'s something wrong. Please check this XML sitemap and make sure the site is not down. Thank you!';
}
else
{
    // Singletons shouldn't be used on applications as a rule of thumb.
    // Please README.md and look at a side note on this Singleton-based design.
    Crawler::getInstance()
      ->init(DB::getInstance(), Network::getInstance())
      ->go($xml);
}
