# phonebook v2
Test phonebook app на Yii2 (v2)

Намеренно не используется виджет GridView
Отличается от предыдущей версии большим использованием JavaScript

1. Создание БД и таблиц:

-- База данных: `test`
>Структура таблицы `contact`
>>CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

> Структура таблицы `phone`
>>CREATE TABLE `phone` (
  `id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `phone` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

>ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

>ALTER TABLE `phone`
  ADD PRIMARY KEY (`id`);

>Внешний ключ таблицы `phone`
>>ALTER TABLE `phone` ADD CONSTRAINT `phone_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
2. Склонировать репозиторий в корень веб-сервера
>git clone https://github.com/icewickru/phonebook.git

3. Подтянуть композером зависимости
>composer install

4. Задать в config/db.php логин и пароль от БД
