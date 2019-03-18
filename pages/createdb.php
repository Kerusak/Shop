<?php
include_once 'functions.php';
connect();

$ct1 = 'create table countries(
        id int not null auto_increment primary key,
        country VARCHAR(100) UNIQUE 
) DEFAULT charset="utf8"';

$ct2 = 'create table cities(
        id int not null auto_increment primary key,
        city VARCHAR(100),
        country_id int,
        foreign key(country_id) REFERENCES countries(id) on delete CASCADE,
        ucity varchar(200)
) DEFAULT charset="utf8"';

$ct3 = 'create table hotels(
        id int not null auto_increment primary key,
        hotel VARCHAR(100),
        city_id int,
        foreign key(city_id) REFERENCES cities(id) on delete CASCADE,
        country_id int,
        foreign key(country_id) REFERENCES countries(id) on delete CASCADE,
        stars int,
        cost int,
        info VARCHAR(1024) 
) DEFAULT charset="utf8"';

$ct4 = 'create table images(
        id int not null auto_increment primary key,
        image_path VARCHAR(100),
        hotel_id int,
        foreign key(hotel_id) REFERENCES hotels(id) on delete CASCADE
) DEFAULT charset="utf8"';

$ct5 = 'create table roles(
        id int not null auto_increment primary key,
        role VARCHAR(255)
) DEFAULT charset="utf8"';

$ct6 = 'create table users(
        id int not null auto_increment primary key,
        login VARCHAR(255) UNIQUE,
        password VARCHAR(128),
        email VARCHAR(128),
        discount int,
        role_id int,
        foreign key(role_id) REFERENCES roles(id) on delete CASCADE,
        avatar VARCHAR(200)
) DEFAULT charset="utf8"';

mysql_query($ct1);
log_db(mysql_errno());
mysql_query($ct2);
log_db(mysql_errno());
mysql_query($ct3);
log_db(mysql_errno());
mysql_query($ct4);
log_db(mysql_errno());
mysql_query($ct5);
log_db(mysql_errno());
mysql_query($ct6);
log_db(mysql_errno());















