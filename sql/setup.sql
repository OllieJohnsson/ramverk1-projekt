CREATE DATABASE IF NOT EXISTS rv1proj;

USE rv1proj;

SET NAMES UTF8;


CREATE USER IF NOT EXISTS 'user'@'localhost' IDENTIFIED BY 'pass';
GRANT ALL ON rv1proj.* TO 'user'@'localhost';
