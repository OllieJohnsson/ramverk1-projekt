CREATE DATABASE IF NOT EXISTS rv1proj;

USE rv1proj;

CREATE USER IF NOT EXISTS 'user'@'localhost' IDENTIFIED BY 'pass';
GRANT ALL ON rv1proj.* TO 'user'@'localhost';

SET NAMES UTF8;
