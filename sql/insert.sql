

INSERT INTO `user` (username, email, firstName, lastName, password)
VALUES
('ollieJ', 'oliver.johnsson@me.com', 'Oliver', 'Johnsson', '$2y$10$ehpd5wqRgOSp59z0x7Rk0em2hHCPh76Ne46.5qYUNawicbNdGy8cu'),
('dolan', 'kalle.anka@me.com', 'Kalle', 'Anka', '$2y$10$ehpd5wqRgOSp59z0x7Rk0em2hHCPh76Ne46.5qYUNawicbNdGy8cu'),
('TommyWiseau', 'tommy.wiseau@me.com', 'Tommy', 'Wiseau', '$2y$10$ehpd5wqRgOSp59z0x7Rk0em2hHCPh76Ne46.5qYUNawicbNdGy8cu')
;



INSERT INTO `question` (`title`, `text`, `userId`)
VALUES
('Vem spelade hunden?', 'Vem var det som spelade hunden i blomsterbutiken, när Johnny säger "Oh hi doggy"? ![doggy](https://media.giphy.com/media/l0HU7Wwvf1m5rCVhu/giphy.gif)
', '1'),
('Varför kastar de boll hela tiden?', 'Vid flera tillfällen i filmen kastar huvudkaraktärerna amerikansk fotboll fram och tillbaka. Ibland iklädda tuxedo. Varför?? ![football](https://media.giphy.com/media/H4ObDrEF4zuBa/giphy.gif)', '2'),
('Lisas mammas bröstcancer??', 'Varför kommer det fram att Lisas mamma har bröstcancer, för att sen aldrig följas upp? Fyller det någon speciell funktion?', '2'),
('Känner inte igen Johnny?', 'Hur kommer det sig att kvinnan i blomsterbutiken säger "Oh hi Johnny I didn\'t know it was you"? Det kan bara finnas en människa i världen som ser ut som honom.', '1'),
('Dennys ålder?', 'Är det meningen att karaktären Denny ska föreställa ett barn eller en vuxen? Det känns väldigt oklart. Han beter sig som ett barn, men ser äldre ut..', '3')
;



INSERT INTO `answer` (`text`, `questionId`, `userId`)
VALUES
('Jag tror det var han som också spelar Mark.', '1', '2'),
('Kan det va han?? [länk](https://www.imdb.com/name/nm4924059/?ref_=nmls_hd)', '1', '3'),
('Vi gjorde det som en ball grej.', '2', '3'),
('Jag har ju solglasögon på i den scenen. Jag tänker att det kan va därför?', '4', '3')
;



INSERT INTO `tag` (`name`)
VALUES
('Johnny'),
('Oh-hi-doggy'),
('blomsterbutiken'),
('skådespelare'),
('football'),
('tuxedo'),
('cancer'),
('Lisasmamma'),
('Denny'),
('barn'),
('vuxen')
;



INSERT INTO `questionTag` (`questionId`, `tagId`)
VALUES
('1', '1'),
('1', '2'),
('1', '3'),
('1', '4'),
('2', '5'),
('2', '6'),
('3', '7'),
('3', '8'),
('4', '1'),
('4', '3'),
('5', '9'),
('5', '10'),
('5', '11')
;



INSERT INTO `questionComment`(`text`, `targetId`, `userId`)
VALUES
('Alltså han till höger!', '1', '1')
;



INSERT INTO `answerComment`(`text`, `targetId`, `userId`)
VALUES
('Nej de e inte samma!!', '2',  '1'),
('Haha', '3',  '2')
;
