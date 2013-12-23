
create table user(
username varchar(100), 
ID integer not null auto_increment primary key, 
password varchar(20)
); 

create table message(
ID integer auto_increment primary key,
content text, 
time varchar(30), 
ownerID integer, 
threadID integer
);

create table member(
threadID integer, 
userID integer
); 

create table thread(
threadID integer auto_increment primary key, 
ownerID integer
); 


insert into user(username, password) values('loc', '123'); 
insert into user(username, password) values('loc', '123'); 

