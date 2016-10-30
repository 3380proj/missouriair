SET foreign_key_checks = 0;
DROP TABLE IF EXISTS employee, equipment, flight, customer, reservation, logging, authentication;
SET foreign_key_checks = 1;

CREATE TABLE employee
(
	emp_id INTEGER PRIMARY KEY,
	lname VARCHAR(30), 
	fname VARCHAR(30), 
	phone INTEGER, 
	address VARCHAR(100), 
	SSN INTEGER,
	email VARCHAR(60),
	job_type INTEGER,			/*0-admin, 1-pilot, 2-FA*/
	title VARCHAR(20), 			/*administrator*/
	rank VARCHAR(20), 			/*pilot or FA*/
	gender CHAR,				/*FA*/
	active_status BOOLEAN, 		/*pilot*/
	certification VARCHAR(60), 	/*pilot*/
	hours INTEGER				/*pilot*/
);

CREATE TABLE equipment
(
	equipment_id INTEGER PRIMARY KEY,
	num_seats INTEGER,
	type VARCHAR(10),
	pilots INTEGER,
	flight_attendants INTEGER
);

CREATE TABLE flight
(
	flight_num INTEGER PRIMARY KEY,
	days INTEGER,
	price DECIMAL(13,2),
	origin VARCHAR(20),
	destination VARCHAR(20),
	equipment_id INTEGER,
	pilot1 INTEGER,
	pilot2 INTEGER,
	fa1 INTEGER,
	fa2 INTEGER,
	fa3 INTEGER,
	fa4 INTEGER,
	FOREIGN KEY (equipment_id) REFERENCES equipment(equipment_id),
	FOREIGN KEY (pilot1) REFERENCES employee(emp_id),
	FOREIGN KEY (pilot2) REFERENCES employee(emp_id),
	FOREIGN KEY (fa1) REFERENCES employee(emp_id),
	FOREIGN KEY (fa2) REFERENCES employee(emp_id),
	FOREIGN KEY (fa3) REFERENCES employee(emp_id),
	FOREIGN KEY (fa4) REFERENCES employee(emp_id)
);

CREATE TABLE customer
(
	customer_id INTEGER PRIMARY KEY,
	fname INTEGER,
	lname INTEGER,
	age INTEGER,
	bag_num INTEGER
);

CREATE TABLE reservation
(
	reservation_id INTEGER PRIMARY KEY,
	flight_num INTEGER,
	customer_id INTEGER,
	departure TIME,
	arrival TIME,
	FOREIGN KEY (flight_num) REFERENCES flight(flight_num),
	FOREIGN KEY (customer_id) REFERENCES customer(customer_id)
);

CREATE TABLE logging
(
	log_num INTEGER PRIMARY KEY,
	ip VARCHAR(15),
	action_TIME TIME,
	action VARCHAR(20),
	user_emp INTEGER,
	user_cust INTEGER,
	flight_num INTEGER,
	FOREIGN KEY (user_emp) REFERENCES employee(emp_id),
	FOREIGN KEY (user_cust) REFERENCES customer(customer_id),
	FOREIGN KEY (flight_num) REFERENCES flight(flight_num)
);

CREATE TABLE authentication
(
	user_id INTEGER PRIMARY KEY,
	pass_hash VARCHAR(64),
	FOREIGN KEY (user_id) REFERENCES employee(emp_id)
);