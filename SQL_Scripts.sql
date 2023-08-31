# Scripts for Creating Users in the database
DROP USER IF EXISTS 'joe'@'%';
CREATE USER 'joe'@'%' IDENTIFIED BY 'password';
DROP USER IF EXISTS 'vet1'@'%';
CREATE USER 'vet1'@'%' IDENTIFIED BY 'password';
DROP USER IF EXISTS 'vet2'@'%';
CREATE USER 'vet2'@'%' IDENTIFIED BY 'password';
DROP USER IF EXISTS 'nurse1'@'%';
CREATE USER 'nurse1'@'%' IDENTIFIED BY 'password';
DROP USER IF EXISTS 'nurse2'@'%';
CREATE USER 'nurse2'@'%' IDENTIFIED BY 'password';
DROP USER IF EXISTS 'nurse3'@'%';
CREATE USER 'nurse3'@'%' IDENTIFIED BY 'password';

# Script to Create Database and associated Tables

DROP DATABASE IF EXISTS JoeVet;
CREATE DATABASE JoeVet;

# Select Database to use
USE JoeVet;

DROP TABLE IF EXISTS Customer;
CREATE TABLE Customer(
    cust_id INT, 
    name VARCHAR(64), 
    ccard CHAR(12), 
    address VARCHAR(128), 
    picture LONGBLOB,
    PRIMARY KEY (cust_id)
)engine=InnoDB;

DROP TABLE IF EXISTS Pets;
CREATE TABLE Pets(
    pet_id INT, 
    cust_id INT,
    animal VARCHAR(64), 
    dob DATE, 
    picture LONGBLOB,
    PRIMARY KEY (pet_id), 
    CONSTRAINT pet_customer FOREIGN KEY (cust_id)
    REFERENCES Customer(cust_id)
)engine=InnoDB;


DROP TABLE IF EXISTS Staff;
CREATE TABLE Staff(
    staff_id SMALLINT, 
    job_title VARCHAR(64),
    name VARCHAR(64), 
    address VARCHAR(128), 
    picture LONGBLOB, 
    PRIMARY KEY (staff_id)
)engine=InnoDB;

DROP TABLE IF EXISTS Appointment;
CREATE TABLE Appointment(
    app_id INT, 
    staff_id SMALLINT, 
    symptons VARCHAR(128),
    pet_id INT, 
    date DATE, 
    PRIMARY KEY (app_id), 
    CONSTRAINT app_staff FOREIGN KEY (staff_id)
    REFERENCES Staff (staff_id), 
    CONSTRAINT app_pet FOREIGN KEY (pet_id)
    REFERENCES Pets(pet_id)
)engine=InnoDB;


DROP TABLE IF EXISTS Diagnosis_Medication;
CREATE TABLE Diagnosis_Medication(
    diag_id INT, 
    app_id INT, 
    staff_id SMALLINT, 
    date DATE, 
    diagnosis VARCHAR(64),
    medication VARCHAR(64),
    PRIMARY KEY (diag_id), 
    CONSTRAINT diag_appointment FOREIGN KEY (app_id)
    REFERENCES Appointment (app_id), 
    CONSTRAINT diag_staff FOREIGN KEY (staff_id)
    REFERENCES Staff (staff_id) 
)engine=InnoDB;

DROP TABLE IF EXISTS Bill;
CREATE TABLE Bill(
    bill_id INT, 
    diag_id INT, 
    amount FLOAT, 
    PRIMARY KEY (bill_id), 
    CONSTRAINT bill_diagnosis FOREIGN KEY (diag_id)
    REFERENCES Diagnosis_Medication (diag_id)
)engine=InnoDB;

DROP TABLE IF EXISTS Payment;
CREATE TABLE Payment(
    pay_id INT, 
    bill_id INT, 
    amount FLOAT, 
    date DATE, 
    payment VARCHAR(32),
    PRIMARY KEY (pay_id), 
    CONSTRAINT pay_bill FOREIGN KEY (bill_id)
    REFERENCES Bill (bill_id)
)engine=InnoDB;

# Script to load data into database
LOAD DATA INFILE 'C:/Users/damie/ProjectDataBase/tables/customer.csv' 
INTO TABLE Customer
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(cust_id, name, ccard, address, @picture)
SET picture = LOAD_FILE(CONCAT('C:/Users/damie/ProjectDataBase/Images/', @picture));


LOAD DATA INFILE 'C:/Users/damie/ProjectDataBase/tables/pet.csv' 
INTO TABLE Pets
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(pet_id, animal, cust_id, dob, @picture)
SET picture = LOAD_FILE(CONCAT('C:/Users/damie/ProjectDataBase/Images/', @picture, '.jpg'));

LOAD DATA INFILE 'C:/Users/damie/ProjectDataBase/tables/staff.csv' 
INTO TABLE Staff
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS
(staff_id, job_title, name, address, @picture)
SET picture = LOAD_FILE(CONCAT('C:/Users/damie/ProjectDataBase/Images/', @picture, '.jpg'));

LOAD DATA INFILE 'C:/Users/damie/ProjectDataBase/tables/appointment.csv' 
INTO TABLE Appointment
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'C:/Users/damie/ProjectDataBase/tables/diagnosis_medication.csv' 
INTO TABLE Diagnosis_Medication
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'C:/Users/damie/ProjectDataBase/tables/bill.csv' 
INTO TABLE Bill
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'C:/Users/damie/ProjectDataBase/tables/payment.csv' 
INTO TABLE Payment
FIELDS TERMINATED BY ',' 
LINES TERMINATED BY '\r\n'
IGNORE 1 ROWS;
