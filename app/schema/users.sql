create table users(
	id int(10) not null primary key auto_increment,
	username varchar(100),
	password varchar(100),
	display_name text,

	created_at timestamp default now(),
	updated_at timestamp default now() ON UPDATE now()
);