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
	(485932, 'Donald', 'Clinton', 2, 'Senior', 1, 8876);

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
	('N47892', 300, 2, 3, 'B747'),
	('N21094', 180, 2, 3, 'B737'),
	('N009', 190, 2, 3, 'MD80'),
	('N3029', 290, 2, 3, 'A380'),
	('N10998', 150, 1, 2, 'DC9'),
	('N5674', 150, 2, 3, 'B727'),
	('N55521', 175, 2, 3, 'A250'),
	('N3847', 300, 2, 3, 'B747'),
	('N09982', 300, 2, 3, 'B747'),
	('N1029', 180, 2, 3, 'B737'),
	('N77837', 290, 2, 3, 'A380'),
	('N77994', 190, 2, 2, 'MD80');

INSERT INTO flights VALUES
	(454, '2016-11-19', 1129, 'DALLAS', 'PARIS', '07:00:00', '17:30:00', 'N3029', 123492, 887362, null, 99872, 485932, 473829),
	(5540, '2016-11-21', 899, 'PARIS', 'CHICAGO', '16:00:00', '05:00:00', 'N47892', 382901, 887362, null, 776573, 372819, 485932);

INSERT INTO customer VALUES
	(1, 'Susan', Miller);

INSERT INTO reservation VALUES
	('B4091', 5540, 1, 899);