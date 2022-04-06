drop database pilotstudie;
create database pilotstudie;
use pilotstudie;

Create table elpriser(
	distrikt varchar(6), 
	EURMWh int,
	datum date,
	startHour int,
	endHour int,
	primary key (distrikt, datum, startHour, endHour)
)ENGINE=INNODB;