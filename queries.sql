INSERT INTO categories
SET title       = 'Доски и лыжи',
    symbol_code = 'boards';
INSERT INTO categories
SET title       = 'Крепления',
    symbol_code = 'attachment';
INSERT INTO categories
SET title       = 'Ботинки',
    symbol_code = 'boots';
INSERT INTO categories
SET title       = 'Одежда',
    symbol_code = 'clothing';
INSERT INTO categories
SET title       = 'Инструменты',
    symbol_code = 'tools';
INSERT INTO categories
SET title       = 'Разное',
    symbol_code = 'other';


INSERT INTO users
SET dt_reg   = NOW(),
    email    = 'fox@gmail.com',
    name     = 'Fox',
    password = 'foxsecret',
    contacts = 'fox.telegram';
INSERT INTO users
SET dt_reg   = NOW(),
    email    = 'box@gmail.com',
    name     = 'Box',
    password = 'boxsecret',
    contacts = 'box.telegram';


INSERT INTO lots
SET title       = '2014 Rossignol District Snowboard',
    description = 'Описание 2014 Rossignol District Snowboard',
    img         = 'img/lot-1.jpg',
    price_add   = '10999',
    dt_finish   = '2021.05.05',
    step_rate   = '100',
    category_id = '1',
    user_id     = '1',
    user_win_id = '1';
INSERT INTO lots
SET title       = 'DC Ply Mens 2016/2017 Snowboard',
    description = 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами.',
    img         = 'img/lot-2.jpg',
    price_add   = '159999',
    dt_finish   = '2021.05.06',
    step_rate   = '200',
    category_id = '1',
    user_id     = '1',
    user_win_id = '2';
INSERT INTO lots
SET title       = 'Крепления Union Contact Pro 2015 года размер L/XL',
    description = 'Описание Крепления Union Contact Pro 2015 года размер L/XL',
    img         = 'img/lot-3.jpg',
    price_add   = '8000',
    dt_finish   = '2021.05.05',
    step_rate   = '300',
    category_id = '2',
    user_id     = '1',
    user_win_id = '1';
INSERT INTO lots
SET title       = 'Ботинки для сноуборда DC Mutiny Charocal',
    description = 'Описание Ботинки для сноуборда DC Mutiny Charocal',
    img         = 'img/lot-4.jpg',
    price_add   = '10999',
    dt_finish   = '2021.05.07',
    step_rate   = '400',
    category_id ='3',
    user_id     = '2',
    user_win_id = '2';
INSERT INTO lots
SET title       = 'Куртка для сноуборда DC Mutiny Charocal',
    description = 'Описание Куртка для сноуборда DC Mutiny Charocal',
    img         = 'img/lot-5.jpg',
    price_add   = '7500',
    dt_finish   = '2021.05.05',
    step_rate   = '500',
    category_id = '4',
    user_id     = '2',
    user_win_id = '1';
INSERT INTO lots
SET title       = 'Маска Oakley Canopy',
    description = 'Описание Маска Oakley Canopy',
    img         = 'img/lot-6.jpg',
    price_add   = '5400',
    dt_finish   = '2021.05.08',
    step_rate   = '600',
    category_id = '7',
    user_id     = '2',
    user_win_id = '2';


INSERT INTO rates
SET dt_add    = NOW(),
    price_add = '12000',
    user_id   = '1',
    lot_id    = '1';
INSERT INTO rates
SET dt_add    = NOW(),
    price_add = '15000',
    user_id   = '2',
    lot_id    = '1';


SELECT *
FROM categories;

SELECT l.title,
       l.price_add,
       img,
       (SELECT MAX(r.price_add) FROM rates r WHERE r.lot_id = l.id) current_price,
       c.title                                                      category_title
FROM lots l
         JOIN categories c ON l.category_id = c.id
WHERE dt_finish > NOW();

SELECT l.title,
       l.price_add,
       img,
       (SELECT MAX(r.price_add) FROM rates r WHERE r.lot_id = l.id) current_price,
       c.title                                                      category_title
FROM lots l
         JOIN categories c ON l.category_id = c.id
WHERE l.id = 1;

UPDATE lots
SET title = 'Новое название'
WHERE id = 1;

SELECT *
FROM rates
WHERE lot_id = 1
ORDER BY dt_add DESC;
