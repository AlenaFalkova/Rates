<?php

namespace AlenaFalkova\Rates;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class CbrClient extends Client
{
    protected const API_URL = 'http://www.cbr.ru/scripts/XML_daily.asp';

    /**
     * Получение курса валют
     *
     * @param \DateTimeInterface $date
     * @param array $currencies
     * @return array
     * @throws \App\Models\CRM\ServerCbrNotAvailable
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getExchangeRate(\DateTimeInterface $date, array $currencies): array
    {
        $response = $this->request('GET', self::API_URL, [
            'query' => [
                'date_req' => $date->format('d/m/Y')
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            throw new ServerCbrNotAvailable();
        }

        return $this->proccessResultXML($response, $currencies);
    }

    /**
     * Получение данных из XML ответа
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param array $currencies
     * @return array
     * @throws \Exception
     */
    protected function proccessResultXML(ResponseInterface $response, array $currencies): array
    {
        $result = [];
        $answer = $response->getBody()->getContents();

        $xml = new \SimpleXMLElement($answer);

        foreach ($currencies as $currency) {
            $oXMLElement = $xml->xpath("//Valute/CharCode[text()='{$currency}']/..")[0];

            $result[$currency] = (float)str_replace(',', '.', $oXMLElement->Value) / (int)$oXMLElement->Nominal;
        }

        return $result;
    }
}