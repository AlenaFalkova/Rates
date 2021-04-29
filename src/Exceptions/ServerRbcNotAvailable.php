<?php

namespace AlenaFalkova\Rates\Exceptions;


class ServerRbcNotAvailable extends \Exception implements ServerNotAvailable
{
    protected $message = 'Сервис РБК временно недоступен';
}