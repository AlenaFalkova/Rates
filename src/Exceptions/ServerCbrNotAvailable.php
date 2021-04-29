<?php

namespace AlenaFalkova\Rates\Exceptions;


class ServerCbrNotAvailable extends \Exception implements ServerNotAvailable
{
    protected $message = 'Сервис ЦБР временно недоступен';
}