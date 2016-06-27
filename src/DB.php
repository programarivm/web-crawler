<?php
namespace WebCrawler;
/**
 * Databasae class.
 */
class DB extends \WebCrawler\Singleton
{
    private $mysqli;

    protected function __construct()
    {
        $this->mysqli = new \MySQLI(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
        $this->mysqli->set_charset("utf8");
    }

    public function getHandler()
    {
        return $this->mysqli;
    }

    public function query($sql)
    {
        $this->mysqli->query($sql);
    }

    public function escape($data)
    {
        return $this->mysqli->real_escape_string($data);
    }
}
