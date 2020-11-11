INSERT INTO state(state) VALUES(1);
INSERT INTO state(state) VALUES(0);
INSERT INTO `type`(name) VALUES('mensual');
INSERT INTO `type`(name) VALUES('semestral');
INSERT INTO `type`(name) VALUES('anual');
INSERT INTO plan(name, description, cost) VALUES('Netflips', 'Movies, series and documentaries', 15);
INSERT INTO `user` (firstname, lastname, email, birthdate, password, is_admin) 
VALUES('Ringo', 'Starr', 'star@gmail.com', '1940-07-07', '$2y$10$ebBEox6QhQOkDJ1TXg8/0eStdApHMIkSn0DETk19ZJJK04Gw7xvdSr', true);
