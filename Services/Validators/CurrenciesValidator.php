<?php

require_once 'Exceptions/ValidationException.php';

class CurrenciesValidator
{
    /**
     * @throws ValidationException
     */
    public function validateCurrenciesCodes(array $currenciesCodes, string $currencyCode): void
    {
        if ($currenciesCodes || $currencyCode) {
            if (!in_array($currencyCode, $currenciesCodes)) {
                throw new ValidationException('There is no such currency code in our database');
            }
        }
    }

    /**
     * @throws ValidationException
     */
    public function validateCurrencyAmount($amount):void
    {
        $amount=floatval($amount);
        if($amount ==0){
            throw new ValidationException('source amount must be greater than 0');
        }
    }
}