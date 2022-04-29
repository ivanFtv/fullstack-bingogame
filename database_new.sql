CREATE DATABASE bingo;

CREATE TABLE bingo.users (
  id bigint(255) PRIMARY KEY AUTO_INCREMENT ,
  firstname varchar(50) NOT NULL,
  lastname varchar(50) NOT NULL,
  username varchar(255) UNIQUE NOT NULL,
  password varchar(255) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  credits int NOT NULL DEFAULT 10,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE bingo.history (
  id bigint(255) PRIMARY KEY AUTO_INCREMENT ,
  bet int NOT NULL,
  result varchar(11) NOT NULL,
  email VARCHAR(255) NOT NULL,
  win int(10) NOT NULL,
  date timestamp DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (email) REFERENCES bingo.users(email)
);

INSERT INTO bingo.users (firstname, lastname, username, password, email) VALUES
('Marco', 'Longo', 'mlongo_1234', 'mlongo', 'mlongo@gmail.com'),
('Ivan', 'Pellegatta', 'ipelle_1234', 'ipelle', 'ipelle@gmail.com'),
('John', 'Doe', 'jdoe_1234', 'jdoe', 'jdoe@gmail.com');


INSERT INTO bingo.history (bet, result, email, win) VALUES
(5, '---', 'jdoe@gmail.com', 0),
(2, 'Terno', 'mlongo@gmail.com', 4),
(2, 'Quaterna', 'mlongo@gmail.com', 6),
(2, 'Terno', 'ipelle@gmail.com', 4),
(5, 'Cinquina', 'ipelle@gmail.com', 25);