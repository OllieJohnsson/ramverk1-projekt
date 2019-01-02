
DROP TABLE IF EXISTS `questionTag`;
DROP TABLE IF EXISTS `questionComment`;
DROP TABLE IF EXISTS `answerComment`;
DROP TABLE IF EXISTS `tag`;
DROP TABLE IF EXISTS `answer`;
DROP TABLE IF EXISTS `question`;
DROP TABLE IF EXISTS `user`;



CREATE TABLE `user` (
    `id` INT AUTO_INCREMENT NOT NULL,
    `username` VARCHAR(256) NOT NULL,
    `email` VARCHAR(256) NOT NULL,
    `firstName` VARCHAR(256) NOT NULL,
    `lastName` VARCHAR(256) NOT NULL,
    `password` VARCHAR(256) NOT NULL,

	PRIMARY KEY (id)
) ENGINE INNODB CHARACTER SET UTF8 COLLATE UTF8_swedish_ci;


CREATE TABLE `question` (
    `id` INT AUTO_INCREMENT NOT NULL,
    `title` VARCHAR(256) NOT NULL,
    `text` VARCHAR(256) NOT NULL,
    `posted` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `userId` INT,

	PRIMARY KEY (id),
	FOREIGN KEY (userId) REFERENCES `user`(id)
) ENGINE INNODB CHARACTER SET UTF8 COLLATE UTF8_swedish_ci;



CREATE TABLE `answer` (
    `id` INT AUTO_INCREMENT NOT NULL,
    `text` VARCHAR(256) NOT NULL,
    `posted` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `questionId` INT,
    `userId` INT,

	PRIMARY KEY (id),
    FOREIGN KEY (questionId) REFERENCES `question`(id),
	FOREIGN KEY (userId) REFERENCES `user`(id)
) ENGINE INNODB CHARACTER SET UTF8 COLLATE UTF8_swedish_ci;


CREATE TABLE `tag` (
	`id` INT AUTO_INCREMENT NOT NULL,
    `name` VARCHAR(256) NOT NULL UNIQUE,

	PRIMARY KEY (`id`, `name`)
) ENGINE INNODB CHARACTER SET UTF8 COLLATE UTF8_swedish_ci;



CREATE TABLE `questionComment` (
    `id` INT AUTO_INCREMENT NOT NULL,
    `text` VARCHAR(256) NOT NULL,
    `posted` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `questionId` INT,
    `userId` INT,

	PRIMARY KEY (id),
    FOREIGN KEY (questionId) REFERENCES `question`(id),
	FOREIGN KEY (userId) REFERENCES `user`(id)
) ENGINE INNODB CHARACTER SET UTF8 COLLATE UTF8_swedish_ci;


CREATE TABLE `answerComment` (
    `id` INT AUTO_INCREMENT NOT NULL,
    `text` VARCHAR(256) NOT NULL,
    `posted` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `answerId` INT,
    `userId` INT,

	PRIMARY KEY (id),
    FOREIGN KEY (answerId) REFERENCES `answer`(id),
	FOREIGN KEY (userId) REFERENCES `user`(id)
) ENGINE INNODB CHARACTER SET UTF8 COLLATE UTF8_swedish_ci;






-- CONNECTIONS


CREATE TABLE questionTag (
    `questionId` INT NOT NULL,
    `tagId` INT NOT NULL,

	PRIMARY KEY (questionId, tagId),
	FOREIGN KEY (questionId) REFERENCES `question`(id),
    FOREIGN KEY (tagId) REFERENCES `tag`(id)
) ENGINE INNODB CHARACTER SET UTF8 COLLATE UTF8_swedish_ci;




-- CREATE TABLE questionComment (
--     `questionId` INT NOT NULL,
--     `commentId` INT NOT NULL,
--
-- 	PRIMARY KEY (questionId, commentId),
-- 	FOREIGN KEY (questionId) REFERENCES `question`(id),
--     FOREIGN KEY (commentId) REFERENCES `comment`(id)
-- ) ENGINE INNODB CHARACTER SET UTF8 COLLATE UTF8_swedish_ci;
--
--
--
-- CREATE TABLE answerComment (
--     `answerId` INT NOT NULL,
--     `commentId` INT NOT NULL,
--
-- 	PRIMARY KEY (answerId, commentId),
-- 	FOREIGN KEY (answerId) REFERENCES `answer`(id),
--     FOREIGN KEY (commentId) REFERENCES `comment`(id)
-- ) ENGINE INNODB CHARACTER SET UTF8 COLLATE UTF8_swedish_ci;
