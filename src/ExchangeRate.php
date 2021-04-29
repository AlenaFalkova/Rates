<?php

namespace AlenaFalkova\Rates;

use App\Models\CRM\CbrClient;
use App\Models\CRM\RbcClient;

class ExchangeRate
{
    /**
     * @var CbrClient
     */
    private $cbrClient;
    /**
     * @var RbcClient
     */
    private $rbcClient;

    public function __construct()
    {
        $this->cbrClient = new CbrClient();
        $this->rbcClient = new RbcClient();
    }

    /**
     * Получение средних значений курсов
     *
     * @param string|null $date
     * @param string[] $currencies
     * @return array
     * @throws \Exception
     */
    public function averageExchangeRate(\DateTimeInterface $date = null, $currencies = ['USD','EUR']): array
    {
        $avgRates = [];

        $rateCbr = $this->cbrClient->getExchangeRate($date, $currencies);
        $rateRbc = $this->rbcClient->getExchangeRate($date, $currencies);

        foreach ($currencies as $currency) {
            $avgRates[$currency] = ($rateCbr[$currency] + $rateRbc[$currency]) / 2;
        }

        return $avgRates;
    }
}
