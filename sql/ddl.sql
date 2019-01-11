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
    `text` TEXT NOT NULL,
    `posted` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `userId` INT,

	PRIMARY KEY (id),
	FOREIGN KEY (userId) REFERENCES `user`(id)
) ENGINE INNODB CHARACTER SET UTF8 COLLATE UTF8_swedish_ci;


CREATE TABLE `answer` (
    `id` INT AUTO_INCREMENT NOT NULL,
    `text` TEXT NOT NULL,
    `posted` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `questionId` INT,
    `userId` INT,
    `accepted` BOOL DEFAULT 0

	PRIMARY KEY (id),
    FOREIGN KEY (questionId) REFERENCES `question`(id),
	FOREIGN KEY (userId) REFERENCES `user`(id)
) ENGINE INNODB CHARACTER SET UTF8 COLLATE UTF8_swedish_ci;


CREATE TABLE `tag` (
	`id` INT AUTO_INCREMENT NOT NULL,
    `name` VARCHAR(30) NOT NULL UNIQUE,

	PRIMARY KEY (`id`, `name`)
) ENGINE INNODB CHARACTER SET UTF8 COLLATE UTF8_swedish_ci;


CREATE TABLE `questionComment` (
    `id` INT AUTO_INCREMENT NOT NULL,
    `text` TEXT NOT NULL,
    `posted` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `targetId` INT,
    `userId` INT,

	PRIMARY KEY (id),
    FOREIGN KEY (targetId) REFERENCES `question`(id),
	FOREIGN KEY (userId) REFERENCES `user`(id)
) ENGINE INNODB CHARACTER SET UTF8 COLLATE UTF8_swedish_ci;


CREATE TABLE `answerComment` (
    `id` INT AUTO_INCREMENT NOT NULL,
    `text` TEXT NOT NULL,
    `posted` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `targetId` INT,
    `userId` INT,

	PRIMARY KEY (id),
    FOREIGN KEY (targetId) REFERENCES `answer`(id),
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





-- VIEWS
DROP VIEW IF EXISTS numberOfQuestions;
CREATE VIEW numberOfQuestions AS
    SELECT
        user.id AS userId,
        COALESCE(COUNT(question.id), 0) AS questions
    FROM
        user
            LEFT JOIN
        question ON question.userId = user.id
    GROUP BY user.id
;


DROP VIEW IF EXISTS numberOfAnswers;
CREATE VIEW numberOfAnswers AS
    SELECT
        user.id AS userId,
        COALESCE(COUNT(answer.id), 0) AS answers
    FROM
        user
            LEFT JOIN
        answer ON answer.userId = user.id
    GROUP BY user.id
;


DROP VIEW IF EXISTS numberOfQuestionComments;
CREATE VIEW numberOfQuestionComments AS
    SELECT
        user.id AS userId,
        COALESCE(COUNT(questionComment.id), 0) AS questionComments
    FROM
        user
            LEFT JOIN
        questionComment ON questionComment.userId = user.id
    GROUP BY user.id
;


DROP VIEW IF EXISTS numberOfAnswerComments;
CREATE VIEW numberOfAnswerComments AS
    SELECT
        user.id AS userId,
        COALESCE(COUNT(answerComment.id), 0) AS answerComments
    FROM
        user
            LEFT JOIN
        answerComment ON answerComment.userId = user.id
    GROUP BY user.id
;
