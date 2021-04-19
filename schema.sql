CREATE DATABASE yeticave
    DEFAULT CHARACTER SET utf8mb4;

USE yeticave;

CREATE TABLE categories (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            title VARCHAR(200) NOT NULL UNIQUE,
                            symbol_code VARCHAR(200) NOT NULL UNIQUE
);

CREATE TABLE lots (
                     id INT AUTO_INCREMENT PRIMARY KEY,
                     dt_add DATETIME(0),
                     title VARCHAR(200) NOT NULL,
                     description TEXT,
                     img VARCHAR(200) NOT NULL UNIQUE,
                     price_add INT NOT NULL,
                     dt_finish DATETIME,
                     step_rate INT NOT NULL,
                     category_id INT UNSIGNED,
                     user_id INT UNSIGNED,
                     user_win_id INT UNSIGNED
);

CREATE TABLE rates (
                      id INT AUTO_INCREMENT PRIMARY KEY,
                      dt_add DATETIME(0),
                      price_add DECIMAL NOT NULL,
                      user_id INT UNSIGNED,
                      lot_id INT UNSIGNED
);

CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       dt_reg DATETIME(0),
                       email VARCHAR(200) NOT NULL UNIQUE,
                       name VARCHAR(200) NOT NULL,
                       password VARCHAR(200) NOT NULL,
                       contacts VARCHAR(200)
);

