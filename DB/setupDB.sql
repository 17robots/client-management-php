-- file for setting up the database and all of the related items

drop schema if exists clientmanagement;

create schema clientmanagement;

DROP USER if exists 'clientmanager'@'localhost';

FLUSH PRIVILEGES;

CREATE USER 'clientmanager'@'localhost' IDENTIFIED WITH mysql_native_password BY 'clientmanager';GRANT ALL PRIVILEGES ON *.* TO 'clientmanager'@'localhost';

use clientmanagement;

create table users ( 
  id int not null AUTO_INCREMENT primary key,
  datecreated timestamp, firstname varchar(255),
  lastname varchar(255),
  username varchar(255),
  email varchar(255),
  password varchar(255)
) engine=InnoDB;

create table clients ( 
  id int not null AUTO_INCREMENT primary key,
  datecreated timestamp,
  creatorid int(11),
  foreign key(creatorid) references users(id) on delete set null on update cascade,
  clientname varchar(255),
  clientaddress varchar(255),
  clientphone varchar(255),
  clientemail varchar(255)
) engine=InnoDB;

create table projects (
  id int not null AUTO_INCREMENT primary key,
  datecreated timestamp,
  creatorid int(11),
  foreign key (creatorid) references users(id) on delete set null on update cascade,
  clientid int(11),
  foreign key (clientid) references clients(id) on delete set null on update cascade,
  projectname varchar(255),
  projectdescription text,
  estimatedhours float,
  rate float,
  paymenttype varchar(255),
  totalinvoiced float,
  duedate datetime,
  closed boolean
) engine=InnoDB;

create table attachments (
  id int not null AUTO_INCREMENT primary key,
  datecreated timestamp,
  creatorid int(11),
  foreign key(creatorid) references users(id) on delete set null on update cascade,
  filename varchar(255) COLLATE utf8_unicode_ci not null,
  uploadedon timestamp,
  status enum('1','0') COLLATE utf8_unicode_ci not null default '1'
) engine=InnoDB;

create table contacts (
  id int not null AUTO_INCREMENT primary key,
  datecreated timestamp,
  creatorid int(11),
  foreign key(creatorid) references users(id) on delete set null on update cascade,
  projectid int(11),
  foreign key (projectid) references projects(id) on delete set null on update cascade,
  firstname varchar(255),
  lastname varchar(255),
  email varchar(255),
  maincontact boolean
) engine=InnoDB;

create table milestones (
  id int not null AUTO_INCREMENT primary key,
  datecreated timestamp,
  creatorid int(11),
  foreign key(creatorid) references users(id) on delete set null on update cascade,
  projectid int(11),
  foreign key (projectid) references projects(id) on delete set null on update cascade,
  milestonename varchar(255),
  datedue datetime
) engine=InnoDB;

create table tasks (
  id int not null AUTO_INCREMENT primary key,
  datecreated timestamp,
  creatorid int(11),
  foreign key(creatorid) references users(id) on delete set null on update cascade,
  projectid int(11),
  foreign key (projectid) references projects(id) on delete set null on update cascade,
  milestoneid int(11),
  foreign key (milestoneid) references milestones(id) on delete set null on update cascade,
  description text,
  completed boolean 
) engine=InnoDB;

create table events (
  id int not null AUTO_INCREMENT primary key,
  datecreated timestamp,
  creatorid int(11),
  foreign key(creatorid) references users(id),
  taskid int(11),
  foreign key (taskid) references tasks(id),
  summary varchar(255),
  notes text,
  finishedtime timestamp,
  overridehours float
) engine=InnoDB;

create table phones (
  id int not null AUTO_INCREMENT primary key,
  datecreated timestamp,
  creatorid int(11),
  foreign key(creatorid) references users(id),
  contactid int(11),
  foreign key (contactid) references contacts(id),
  phonetype varchar(255),
  phonenumber varchar(255)
) engine=InnoDB;
