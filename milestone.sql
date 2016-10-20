CREATE TABLE employee
(
	user_id integer PRIMARY KEY,
	lname varchar(30), 
	fname varchar(30), 
	phone integer, 
	address varchar(100), 
	SSN integer,
	email varchar(60)
);

/*CREATE TABLE administrator
(
	userID integer PRIMARY KEY,
	lName varchar(30), 
	fName varchar(30), 
	phone integer, 
	address varchar(100), 
	SSN integer,
	email varchar(60),
	title varchar(60)
);

CREATE TABLE pilot
(
	userID integer PRIMARY KEY,
	lName varchar(30), 
	fName varchar(30), 
	phone integer, 
	address varchar(100), 
	SSN integer,
	email varchar(60),
	stat varchar(120),
	rank varchar(80),
	certification varchar(120),
	total_hours integer
);

CREATE TABLE flight_attendant
(
	userID integer PRIMARY KEY,
	lName varchar(30), 
	fName varchar(30), 
	phone integer, 
	address varchar(100), 
	SSN integer,
	email varchar(60),
	gender varchar(20),
	rank varchar(80);
);*/

CREATE TABLE equipment
(
	equipment_id integer PRIMARY KEY,
	num_seats integer,
	type varchar(10),
	pilots integer,
	flight_attendants integer
);

CREATE TABLE flight
(
	flight_num integer PRIMARY KEY,
	days integer,
	price decimal(13,2),
	origin varchar(20),
	destination varchar(20),
	FOREIGN KEY equipment_id REFERENCES equipment(equipment_id)
	/*FOREIGN KEY pilot REFERENCES pilot(user_id),
	FOREIGN KEY flight_attendant(user_id)*/
);

CREATE TABLE reservation
(
	reservation_id integer PRIMARY KEY,
	FOREIGN KEY flight_num REFERENCES flight(flight_num) NOT NULL,
	FOREIGN KEY customer_id REFERENCES customer(customer_id) NOT NULL,
	departure time,
	arrival time
);

CREATE TABLE customer
(
	customer_id integer PRIMARY KEY,
	fname integer,
	lname integer,
	age integer,
	bag_num integer
);

CREATE TABLE logging
(
	log_num int PRIMARY KEY,
	ip varchar(15),
	action_time time,
	action varchar(20),
	FOREIGN KEY user_emp REFERENCES employee(user_id),
	FOREIGN KEY user_cust REFERENCES customer(customer_id),
	FOREIGN KEY flight_num REFERENCES flight(flight_num)
);

CREATE TABLE authentication
(
	FOREIGN KEY user_id integer REFERENCES employee(user_id),
	pass_hash varchar(64),
	PRIMARY KEY user_id
);