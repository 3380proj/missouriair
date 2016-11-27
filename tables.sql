SET foreign_key_checks = 0;
DROP TABLE IF EXISTS employee, certification, equipment, flight, customer, reservation, logging, authentication;
SET foreign_key_checks = 1;

CREATE TABLE employee
(
	emp_id INTEGER AUTO_INCREMENT PRIMARY KEY,
	fname VARCHAR(30), 
	lname VARCHAR(30), 
	job_type INTEGER,			/*0-admin, 1-pilot, 2-FA*/
	rank VARCHAR(20), 			/*pilot or FA*/
	status BOOLEAN, 		/*pilot*/
	hours INTEGER				/*pilot*/
);

CREATE TABLE certification
(
	emp_id INTEGER,
	equipment VARCHAR(10),
	FOREIGN KEY (emp_id) REFERENCES employee(emp_id) ON DELETE CASCADE,
	PRIMARY KEY (emp_id, equipment)
);

CREATE TABLE equipment
(
	serial VARCHAR(10) PRIMARY KEY,
	seats INTEGER,
	equipment VARCHAR(10),
	pilots INTEGER,
	att INTEGER
);

CREATE TABLE flight
(
	number INTEGER PRIMARY KEY,
	day DATE,
	price DECIMAL(13,2),
	origin VARCHAR(20),
	dest VARCHAR(20),
	dep TIME,
	arr TIME,
	aircraft VARCHAR(10),
	pilot_1 INTEGER,
	pilot_2 INTEGER,
	pilot_3 INTEGER,
	att_1 INTEGER,
	att_2 INTEGER,
	att_3 INTEGER,
	FOREIGN KEY (aircraft) REFERENCES equipment(serial),
	FOREIGN KEY (pilot_1) REFERENCES employee(emp_id),
	FOREIGN KEY (pilot_2) REFERENCES employee(emp_id),
	FOREIGN KEY (pilot_3) REFERENCES employee(emp_id),
	FOREIGN KEY (att_1) REFERENCES employee(emp_id),
	FOREIGN KEY (att_2) REFERENCES employee(emp_id),
	FOREIGN KEY (att_3) REFERENCES employee(emp_id)
);

CREATE TABLE customer
(
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	fname VARCHAR(20),
	lname VARCHAR(20)
);

CREATE TABLE reservation
(
	id INTEGER AUTO_INCREMENT PRIMARY KEY,
	flight INTEGER,
	customer INTEGER,
	price DECIMAL(13,2),
	FOREIGN KEY (flight) REFERENCES flight(number),
	FOREIGN KEY (customer) REFERENCES customer(id)
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
	FOREIGN KEY (user_cust) REFERENCES customer(id),
	FOREIGN KEY (flight_num) REFERENCES flight(number)
);

CREATE TABLE authentication
(
	user_id INTEGER PRIMARY KEY,
    user_name VARCHAR(50),
	pass_hash VARCHAR(15),
	FOREIGN KEY (user_id) REFERENCES employee(emp_id)
);
