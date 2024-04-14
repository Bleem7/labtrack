drop database if exists lab_track;

CREATE DATABASE lab_track;

USE lab_track;

CREATE TABLE Academic_year (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	start_date DATE NOT NULL,
	end_date DATE NOT NULL,
	scheduling_terms ENUM('weekly', 'bi-weekly', 'monthly') NOT NULL
	
);


CREATE TABLE Tasks (
    TaskID INT AUTO_INCREMENT PRIMARY KEY,
    task_name VARCHAR(100) NOT NULL,
    TaskDueDate DATE NOT NULL
);



CREATE TABLE notifications (
	id INT AUTO_INCREMENT PRIMARY KEY,
	message TEXT NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE reminders (
	taskname VARCHAR(255) NOT NULL,
	reminder_date DATE NOT NULL,
	reminder_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	Email VARCHAR(100) NOT NULL
    
);



CREATE TABLE Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(200) NOT NULL,
    Password VARCHAR(300) NOT NULL,
    Email VARCHAR(100) NOT NULL
);


