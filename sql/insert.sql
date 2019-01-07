

INSERT INTO `user` (username, email, firstName, lastName, password)
VALUES
('ollieJ', 'oliver.johnsson@me.com', 'Oliver', 'Johnsson', '$2y$10$ehpd5wqRgOSp59z0x7Rk0em2hHCPh76Ne46.5qYUNawicbNdGy8cu'),
('dolan', 'kalle.anka@me.com', 'Kalle', 'Anka', '$2y$10$ehpd5wqRgOSp59z0x7Rk0em2hHCPh76Ne46.5qYUNawicbNdGy8cu'),
('jony', 'tommy.wiseau@me.com', 'Tommy', 'Wiseau', '$2y$10$ehpd5wqRgOSp59z0x7Rk0em2hHCPh76Ne46.5qYUNawicbNdGy8cu')
;



INSERT INTO `question` (`title`, `text`, `userId`)
VALUES
('Vem spelade hunden?', 'Vem var det som spelade hunden i blomsterbutiken, när Johnny säger "Oh hi doggie"?', '1'),
('En fråga', 'Blablablalalbalba', '2'),
('En annan fråga', 'Blablablalalbalba', '2')
;



INSERT INTO `answer` (`text`, `questionId`, `userId`)
VALUES
('Här är mitt ank-svar', '2', '2'),
('Jag tror det var han som också spelar Mark.', '1', '2'),
('Nej, det var jag1', '1', '3')
;



INSERT INTO `tag` (`name`)
VALUES
('Apor'),
('Johnny'),
('Hi')
;



INSERT INTO `questionTag` (`questionId`, `tagId`)
VALUES
('2', '1'),
('1', '2'),
('1', '3'),
('3', '1')
;



INSERT INTO `questionComment`(`text`, `targetId`, `userId`)
VALUES
('Coolt!!!', '1', '1')
;



INSERT INTO `answerComment`(`text`, `targetId`, `userId`)
VALUES
('Hahaha!', '1',  '1')
;
