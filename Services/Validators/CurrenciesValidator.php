<?php

require_once 'Exceptions/ValidationException.php';

class CurrenciesValidator
{
    /**
     * @throws ValidationException
     */
    public function validate(array $currenciesCodes, string $currencyCode): void
    {
        if ($currenciesCodes || $currencyCode) {
            if (!in_array($currencyCode, $currenciesCodes)) {
                throw new ValidationException('There is no such currency code in our database');
            }
        }
    }
}