INSERT INTO employee VALUES
	(382901, 'Frank', 'Cessna', 1, 'Captain', 1, 18370),
	(388929, 'Sue', 'Grumman', 1, 'Captain', 1, 14799),
	(483792, 'John', 'Piper', 1, 'First Officer', 0, 11870),
	(887362, 'Mark', 'Northrup', 1, 'Senior Captain', 1, 21226),
	(123492, 'Mary', 'Seneca', 1, 'Senior Captain', 1, 19433),
	(99872, 'Cybil', 'Smith', 2, 'Senior', 1, 14309),
	(372819, 'Simon', 'Said', 2, 'Junior', 1, 2887),
	(776573, 'Janet', 'Johnson', 2, 'Senior', 1, 7654),
	(111980, 'Hillary', 'Trump', 2, 'Senior', 1, 13101),
	(485932, 'Donald', 'Clinton', 2, 'Senior', 1, 8876),
	(111111, 'Admin', 'Istrator', 0, null, 1, null);

INSERT INTO certification VALUES
	(382901, 'B747'),
	(382901, 'B737'),
	(388929, 'DC9'),
	(388929, 'MD80'),
	(483792, 'MD80'),
	(483792, 'L1011'),
	(887362, 'B747'),
	(887362, 'A380'),
	(887362, 'B737'),
	(123492, 'A380');

INSERT INTO equipment VALUES
	('N47892', 300, 'B747', 2, 3),
	('N21094', 180, 'B737', 2, 3),
	('N009', 190, 'MD80', 2, 3),
	('N3029', 290, 'A380', 2, 3),
	('N10998', 150, 'DC9', 1, 2),
	('N5674', 150, 'B727', 2, 3),
	('N55521', 175, 'A250', 2, 3),
	('N3847', 300, 'B747', 2, 3),
	('N09982', 300, 'B747', 2, 3),
	('N1029', 180, 'B737', 2, 3),
	('N77837', 290, 'A380', 2, 3),
	('N77994', 190, 'MD80', 2, 2);

INSERT INTO flight VALUES
	(454, '2016-11-19', 1129, 'DALLAS', 'PARIS', '07:00:00', '17:30:00', 'N3029', 123492, 887362, null, 99872, 485932, 111980),
	(5540, '2016-11-21', 899, 'PARIS', 'CHICAGO', '16:00:00', '05:00:00', 'N47892', 382901, 887362, null, 776573, 372819, 485932),
	(1249, '2016-11-22', 1129, 'ST LOUIS', 'LOS ANGELES', '10:00:00', '4:00:00', 'N3029', 382901, 887362, null, 776573, 485932, 111980);

INSERT INTO customer VALUES
	(1, 'Susan', 'Miller');

INSERT INTO reservation VALUES
	('B4091', 5540, 1, 899);

INSERT INTO authentication VALUES
	(99872, 'csmith', 'secret'),
	(111111, 'admin', 'secret');

INSERT INTO `logging` VALUES
	(1,'10.7.5.236','2016-11-25','19:29:00','RESERVE','Created Reservation 2 on flight 454',NULL,2,454),
	(2,'10.7.36.182','2016-11-25','19:33:00','CERTIFY','Added certification A380 to pilot 382901',111111,NULL,NULL),
	(3,'10.7.5.236','2016-11-25','19:33:00','CERTIFY','Added certification DC9 to pilot 111111',111111,NULL,NULL),
	(4,'10.7.36.182','2016-11-25','19:34:00','CERTIFY','Added certification B737 to pilot 388929',111111,NULL,NULL),
	(5,'10.7.36.182','2016-11-25','19:44:00','CUSTOMER','Removed customer 1',111111,NULL,NULL),
	(6,'10.7.36.182','2016-11-25','19:44:00','CUSTOMER','Removed customer 1',111111,NULL,NULL),
	(7,'10.7.36.182','2016-11-29','19:53:00','EQUIP','Removed equipment N5674',111111,NULL,NULL);