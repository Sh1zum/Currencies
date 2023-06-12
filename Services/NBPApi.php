<?php

require_once 'Exceptions/ApiException.php';

class NBPApi
{
    /**
     * @throws ApiException
     */
    public function handle(): array
    {
        try {
            $currenciesTableA = @file_get_contents("http://api.nbp.pl/api/exchangerates/tables/A");
            $currenciesTableB = @file_get_contents("http://api.nbp.pl/api/exchangerates/tables/B");
            if ($currenciesTableA === false || $currenciesTableB === false) {
                throw new ApiException('There was an Error during the HTTP REQUEST');
            } else {
                return array_merge(json_decode($currenciesTableA, true)[0]['rates'], json_decode($currenciesTableB, true)[0]['rates']);
            }
        } catch (Exception) {
            throw new ApiException('There was an Error during the HTTP REQUEST');
        }
    }
}