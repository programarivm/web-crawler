<?php
namespace WebCrawler;

use \WebCrawler\DB;
use \WebCrawler\Network;

require_once __DIR__ .'/vendor/autoload.php';
require_once '/src/config.php';

// Singletons shouldn't be used on applications as a rule of thumb.
// Please README.md and look at a side note on this particular Singleton-based design.

$crawler = Crawler::getInstance()->init(
  DB::getInstance(),
  Network::getInstance()
);

try
{
  $crawler->loadXml($argv[1])->go();
}
catch (\Exception $e)
{
  echo $e->getMessage();
}
