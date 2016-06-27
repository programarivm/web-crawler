## Simple Web Crawler

* Author: Jordi Bassagañas, [programarivm.com](http://programarivm.com)
* Version: 1.0.0
* License: GPL

### Features

I am happy to share with you this PHP code snippet. It scans XML sitemaps and stores the HTML documents found into a MySQL database. Feel free to adapt it to your own purposes and programming style!

- Scans a sitemap in XML format
- The sitemap must be defined according to the [Sitemap protocol](http://www.sitemaps.org/protocol.html)
- Stores the resources found into a database for further analysis
- This is a PHP CLI script intended to be run from the command line

### Setup

First of all, create the crawler's database. Please take the `web-crawler/docs/database.sql` script and run it on your favorite MySQL client software. As you can see, this MySQL script is very simple:

	DROP DATABASE IF EXISTS my_crawler;

	CREATE DATABASE my_crawler;

	USE my_crawler;

	GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, INDEX, ALTER, LOCK TABLES, CREATE TEMPORARY TABLES
	ON my_crawler.* TO 'mc_user'@'localhost' IDENTIFIED BY 'password';

	CREATE TABLE resources (
    	id int UNSIGNED NOT NULL AUTO_INCREMENT,
	    http_code varchar(3) NOT NULL,
    	url varchar(2048) NOT NULL,
    	content TEXT,
    	created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    	PRIMARY KEY (id)
	);


Now take the `web-crawler` folder and install it wherever you want in your file system. Finally, cd the `web-crawler` folder and run a command as follows:

    php crawl.php https://foobar.com/sitemap_index.xml

The above will start indexing resources and produce an output like this:

	Indexing https://foobar.com ...
	Indexing https://foobar.com/one-resource/ ...
	Indexing https://foobar.com/two-resources/ ...
	Indexing https://foobar.com/three-resources/ ...

Be a little patient! Queries are run every 4 seconds by default in a non-intrusive way.

Once the indexing process is finished the message below will be prompted:


	Sitemap already indexed.

That's it. Now you can look at your database and analyze HTML documents.

### A Side Note on the Singleton-Based Design

Singletons shouldn't be used on applications as a rule of thumb. However, in this app I've wanted to do an experiment. I've just tried to find a solution to the classical problem of having multiple classes (in this case `Crawler` and `Network`) which inherit from one single `Singleton` class. It works! For further information on this topic please look at these resources:

* [Inherited Java Singleton Problem](http://c2.com/cgi/wiki?InheritedJavaSingletonProblem)
* [PHP and an abstract Singleton](http://selfcontained.us/2011/04/20/php-and-an-abstract-singleton/)
