CREATE DATABASE yeticave
    DEFAULT CHARACTER SET utf8mb4;

USE yeticave;

CREATE TABLE categories (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            title CHAR(255) NOT NULL UNIQUE,
                            symbol_code CHAR(255) NOT NULL UNIQUE
);

CREATE TABLE lots (
                     id INT AUTO_INCREMENT PRIMARY KEY,
                     dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                     title CHAR(255) NOT NULL,
                     description TEXT,
                     img CHAR(255) NOT NULL UNIQUE,
                     price_add INT NOT NULL,
                     dt_finish TIMESTAMP,
                     step_rate INT NOT NULL,
                     category_id INT UNSIGNED,
                     user_id INT UNSIGNED
);

CREATE TABLE rates (
                      id INT AUTO_INCREMENT PRIMARY KEY,
                      dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                      price_add DECIMAL NOT NULL,
                      user_id INT UNSIGNED,
                      lot_id INT UNSIGNED
);

CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       dt_reg TIMESTAMP,
                       email CHAR(255) NOT NULL UNIQUE,
                       name CHAR(255) NOT NULL,
                       password CHAR(255) NOT NULL,
                       contacts CHAR(255)
);

