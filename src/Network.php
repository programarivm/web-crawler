<?php
namespace WebCrawler;
/**
 * Network class.
 *
 * Performs network operations.
 */
class Network extends \WebCrawler\Singleton
{
    /**
     * Gets an HTTP resource.
     *
     * @param string $url
     * @return array
     */
    public function getResource($url)
    {
        $options = [
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_ENCODING       => "",       // handle compressed
            CURLOPT_USERAGENT      => "test",   // name of client
            CURLOPT_AUTOREFERER    => true,     // set referrer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // time-out on connect
            CURLOPT_TIMEOUT        => 120,      // time-out on response
            CURLOPT_SSL_VERIFYPEER => false     // ssl
        ];

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);

        $httpBody = curl_exec($ch);

        $response = [
            'header' => [
                'code' =>  curl_getinfo($ch, CURLINFO_HTTP_CODE),
                'size' => curl_getinfo($ch, CURLINFO_HEADER_SIZE)
            ],
            'body' => $httpBody
        ];

        curl_close($ch);

        return $response;
    }
}
