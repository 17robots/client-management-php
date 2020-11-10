-- file for setting up the database and all of the related items

create schema clientmanagement;

CREATE USER 'clientmanager'@'localhost' IDENTIFIED WITH mysql_native_password BY 'clientmanager';GRANT ALL PRIVILEGES ON *.* TO 'clientmanager'@'localhost'

use clientmanagement;

create table users ( id int not null AUTO_INCREMENT primary key, datecreated timestamp, firstname varchar(255), lastname varchar(255), username varchar(255), email varchar(255), userpassword varchar(255) ) engine=InnoDB

create table attachments ( id int not null AUTO_INCREMENT primary key, datecreated timestamp, onstraint creatorid foreign key (id) references users(id), filename varchar(255) COLLATE utf8_unicode_ci not null, uploadedon timestamp, status enum('1','0') COLLATE utf8_unicode_ci not null default '1' ) engine=InnoDB;

create table contacts ( id int not null AUTO_INCREMENT primary key, datecreated timestamp, constraint creatorid foreign key (id) references users(id), constraint peojectid foreign key (id) references projects(id), firstname varchar(255), lastname varchar(255), email varchar(255), maincontact boolean ) engine=InnoDB;

create table clients ( id int not null AUTO_INCREMENT primary key, datecreated timestamp, constraint creatorid foreign key (id) references users(id), clientname varchar(255), clientaddress varchar(255), clientphone varchar(255), clientemail varchar(255) )engine=InnoDB;

create table projects ( id int not null AUTO_INCREMENT primary key, datecreated timestamp, constraint creatorid foreign key (id) references users(id), constraint clientid foreign key (id) references clients(id), projectname varchar(255), projectdescription text, estimatedhours float, rate float, paymenttype varchar(255), totalinvoiced float, duedate datetime, closed boolean ) engine=InnoDB;

create table tasks ( id int not null AUTO_INCREMENT primary key, datecreated timestamp, constraint creatorid foreign key (id) references users(id), constraint projectid foreign key (id) references projects(id), constraint milestoneid foreign key (id) references milestones(id), description text, completed boolean ) engine=InnoDB;

create table events ( id int not null AUTO_INCREMENT primary key, datecreated timestamp, constraint creatorid foreign key (id) references users(id), constraint taskid foreign key (id) references tasks(id), summary varchar(255), notes text, finishedtime timestamp, overridehours float ) engine=InnoDB;

create table milestones ( id int not null AUTO_INCREMENT primary key, datecreated timestamp, constraint creatorid foreign key (id) references users(id), constraint projectid foreign key (id) references projects(id), milestonename varchar(255), duedate datetime ) engine=InnoDB;

create table phones ( id int not null AUTO_INCREMENT primary key, datecreated timestamp, constraint creatorid foreign key (id) references users(id), constraint contactid foreign key (id) references contacts(id), phonetype varchar(255), phonenumber varchar(255) ) engine=InnoDB;