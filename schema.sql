CREATE DATABASE yeticave
    DEFAULT CHARACTER SET utf8mb4;

USE yeticave;

CREATE TABLE categories
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(255) NOT NULL UNIQUE,
    symbol_code VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE lots
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    dt_add      DATETIME(0) DEFAULT CURRENT_TIMESTAMP,
    title       VARCHAR(255) NOT NULL,
    description TEXT,
    img         VARCHAR(255) NOT NULL,
    price_add   FLOAT        NOT NULL,
    dt_finish   DATETIME,
    step_rate   INT          NOT NULL,
    category_id INT UNSIGNED,
    user_id     INT UNSIGNED,
    user_win_id INT UNSIGNED
);

CREATE TABLE rates
(
    id        INT AUTO_INCREMENT PRIMARY KEY,
    dt_add    DATETIME DEFAULT CURRENT_TIMESTAMP,
    price_add DECIMAL NOT NULL,
    user_id   INT UNSIGNED,
    lot_id    INT UNSIGNED
);

CREATE TABLE users
(
    id       INT AUTO_INCREMENT PRIMARY KEY,
    dt_reg   DATETIME DEFAULT CURRENT_TIMESTAMP,
    email    VARCHAR(255) NOT NULL UNIQUE,
    name     VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    message  VARCHAR(255)
);

CREATE INDEX dt_finish ON lots (dt_finish);

CREATE INDEX lot_id ON rates (lot_id);
