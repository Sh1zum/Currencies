<?php

class ExchangeCurrencies
{
    public function exchange(float $sourceRate, float $destinationRate, float $amount): float
    {
        return ($sourceRate / $destinationRate) * $amount;
    }
}
