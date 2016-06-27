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
