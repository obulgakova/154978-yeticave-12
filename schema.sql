CREATE DATABASE yeticave
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE category (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            title CHAR NOT NULL UNIQUE,
                            symbol_code CHAR NOT NULL UNIQUE
);

CREATE TABLE lot (
                     id INT AUTO_INCREMENT PRIMARY KEY,
                     dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                     title CHAR NOT NULL,
                     description TEXT,
                     img CHAR NOT NULL UNIQUE,
                     price_add INT NOT NULL,
                     dt_finish TIMESTAMP,
                     step_rate INT NOT NULL
);

CREATE TABLE rate (
                      id INT AUTO_INCREMENT PRIMARY KEY,
                      dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                      price_add DECIMAL NOT NULL
);

CREATE TABLE user (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       dt_reg TIMESTAMP,
                       email VARCHAR(128) NOT NULL UNIQUE,
                       name CHAR NOT NULL,
                       password CHAR NOT NULL,
                       contacts CHAR
);

