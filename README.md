#  Средний курс валют #
Средний курс валют по двум источникам

## Задание ##
Есть 2 сервиса, возвращающие курсы валют:
https://www.cbr.ru/development/SXML/

https://cash.rbc.ru/cash/json/converter_currency_rate/?currency_from=USD&currency_to=RUR&source=cbrf&sum=1&date=

Необходимо написать библиотеку, которая будет вычислять средний курс евро и доллара по этим двум сервисам на передаваемую дату. При недоступности одного из сервисов должно генерироваться исключение.

## Использование ##
```<?php

use AlenaFalkova\Rates\ExchangeRate;
use AlenaFalkova\Rates\Exception\ServerNotAvailable;

try {
    $handler = new ExchangeRate();
    $result = $handler->averageExchangeRate(
        new \DateTime(), //дата
        ['USD', 'EUR'] //массив с перечеслением необходимых валют, можно не передавать по-умолчанию будет ['USD', 'EUR']
    );
} catch(ServerNotAvailable $e) {
    echo $e->getMessage();
}
