create database library character set utf8mb4 collate utf8mb4_unicode_ci;
create table user (
  user_id int not null auto_increment,
  email varchar(320) not null,
  name varchar(100) not null,
  borrow_count int not null default 0,
  contact_no varchar(15) not null,
  image_path varchar(100) not null,
  fine int not null default 0,
  created_at datetime not null,
  updated_at datetime not null,
  primary key (user_id),
  unique (email),
  unique (contact_no)
);
create table category (
  category_id int not null,
  category_name varchar(100) not null,
  category_count int not null default 0,
  created_at datetime not null,
  updated_at datetime not null,
  primary key (category_id),
  unique (category_name)
);
create table book (
  book_id int not null auto_increment,
  isbn varchar(17) not null,
  title varchar(100) not null,
  author_name varchar(100) not null,
  pub_year int not null,
  total_count int not null,
  current_count int not null,
  publisher varchar(100) not null,
  created_at datetime not null,
  updated_at datetime not null,
  category_id int not null,
  primary key (book_id),
  foreign key (category_id) references category(category_id),
  unique (isbn)
);
create table borrow (
  book_id int not null,
  user_id int not null,
  issue_date datetime not null,
  due_date datetime not null,
  created_at datetime not null,
  updated_at datetime not null,
  primary key (book_id, user_id),
  foreign key (book_id) references book(book_id) on delete cascade,
  foreign key (user_id) references user(user_id) on delete cascade
);

DELIMITER $$
CREATE TRIGGER after_book_insert AFTER INSERT ON book FOR EACH ROW BEGIN
     UPDATE category
     SET category_count = category_count + 1
     WHERE category_id=new.category_id;
END;
$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER after_book_insert AFTER DELETE ON book FOR EACH ROW BEGIN
     UPDATE category
     SET category_count = category_count - 1
     WHERE category_id=new.category_id;
END;
$$
DELIMITER ;