<?php
namespace WebCrawler;
/**
 * Crawler class
 *
 * A simple web crawler.
 */
class Crawler extends \WebCrawler\Singleton
{
    /**
     * Maximum number of links to be indexed.
     */
    const MAX_LINKS = 200;
    /**
     * Database object.
     *
     * @var \WebCrawler\DB Database handler.
     */
    protected $db;
    /**
     * Network object.
     *
     * @var \WebCrawler\Network Network handler.
     */
    protected $network;
    /**
     * Initializes the values.
     */
    public function init($db, $network)
    {
        $this->db = $db;
        $this->network = $network;
        return $this;
    }
    /**
     * Indexes the given resource.
     *
     * @param array $data
     */
    protected function index($data)
    {
        echo "Indexing {$data['url']} ..." . PHP_EOL;
        // basic input filter
        $code = $this->db->escape($data['httpResponse']['header']['code']);
        $url = $this->db->escape($data['url']);
        $content = $this->db->escape($data['httpResponse']['body']);
        // insert resource into database
        $sql = "INSERT INTO resources (http_code, url, content) "
            . "VALUES ('{$data['httpResponse']['header']['code']}', '{$data['url']}', '$content')";
        $this->db->query($sql);
        // wait 4 seconds
        sleep(4);
    }
    /**
     * Scans the given XML sitemap searching resources to be indexed.
     *
     * @param \SimpleXMLElement $xml
     */
    public function go($xml)
    {
        $nIndexed = 0;
        if ($xml->getName() === 'sitemapindex')
        {
            // loop through the sitemaps
            foreach($xml->sitemap as $xmlSitemap)
            {
                $httpResponse = $this->network->getResource((string)$xmlSitemap->loc);
                $sitemap = simplexml_load_string($httpResponse['body']);
                foreach($sitemap->url as $url)
                {
                    if($nIndexed <= self::MAX_LINKS-1)
                    {
                        $this->index([
                            'url' => (string)$url->loc,
                            'httpResponse' => $this->network->getResource((string)$url->loc)
                        ]);
                        $nIndexed += 1;
                    }
                    else
                    {
                        break 2;
                    }
                }
            }
        }
        elseif ($xml->getName() === 'urlset')
        {
            foreach($xml->url as $url)
            {
                if($nIndexed <= self::MAX_LINKS-1)
                {
                    $this->index([
                        'url' => (string)$url->loc,
                        'httpResponse' => $this->network->getResource((string)$url->loc)
                    ]);
                    $nIndexed += 1;
                }
                else
                {
                    break;
                }
            }
        }
        echo "Sitemap already indexed." . PHP_EOL;
    }
}
