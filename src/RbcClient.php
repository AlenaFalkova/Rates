<?php

namespace AlenaFalkova\Rates;

use GuzzleHttp\Client;

class RbcClient extends Client
{
    protected const API_URL = 'https://cash.rbc.ru/cash/json/converter_currency_rate/';

    /**
     * Получение курса валют
     *
     * @param \DateTimeInterface $date
     * @param array $currencies
     * @return array
     * @throws \App\Models\CRM\ServerRbcNotAvailable
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getExchangeRate(\DateTimeInterface $date, array $currencies): array
    {
        $result = [];

        foreach ($currencies as $currency) {
            $response = $this->request('GET', self::API_URL, [
                    'query' => [
                        'currency_from' => $currency,
                        'currency_to' => 'RUR',
                        'source' => 'cbrf',
                        'sum' => 1,
                        'date' => $date->format('Y-m-d')
                    ]
                ]
            );

            if ($response->getStatusCode() != 200) {
                throw new ServerRbcNotAvailable();
            }

            $result[$currency] = json_decode($response->getBody()->getContents())->data->sum_result;
        }

        return $result;
    }
}