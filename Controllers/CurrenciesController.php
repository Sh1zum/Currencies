<?php

require_once 'Views/Currencies/View.php';
require_once 'Connection.php';
require_once 'Repository/CurrenciesRepository.php';
require_once 'Repository/ExchangesRepository.php';
require_once 'Services/NBPApi.php';
require_once 'Services/ExchangeCurrencies.php';
require_once 'Services/Validators/CurrenciesValidator.php';
require_once 'Exceptions/ConnectionException.php';

class CurrenciesController
{
    public function handle()
    {
        $connection = new Connection();
        try {
            $dbConnection = $connection->connect();
        } catch (ConnectionException $e) {
            $view = new View();
            $view->viewCurrencies([], [], $e->getMessage());
            return;
        }
        $currenciesRepository = new CurrenciesRepository($dbConnection);
        $error = '';
        if ($_POST) {
            try {
                if ($_POST['form'] == 'update_currencies') {
                    $NbpApi = new NBPApi();
                    $apiCurrencies = $NbpApi->handle();
                    $currenciesRepository->upsertCurrencies($apiCurrencies);
                } elseif ($_POST['form'] == 'exchange_currencies') {
                    $currencies = $currenciesRepository->getCurrencies();
                    $currencyValidator = new CurrenciesValidator();
                    $currencyValidator->validateCurrenciesCodes(array_column($currencies, 'code'), $_POST['source_currency']);
                    $currencyValidator->validateCurrenciesCodes(array_column($currencies, 'code'), $_POST['destination_currency']);
                    $currencyValidator->validateCurrencyAmount($_POST['source_amount']);
                    $exchangeCurrenciesService = new ExchangeCurrencies();
                    $sourceCurrencyValue = $currenciesRepository->getCurrencyMidByCode($_POST['source_currency']);
                    $destinationCurrencyValue = $currenciesRepository->getCurrencyMidByCode($_POST['destination_currency']);
                    $exchangedCurrency = $exchangeCurrenciesService->exchange($sourceCurrencyValue, $destinationCurrencyValue, $_POST['source_amount']);
                    $exchangeRepository = new ExchangesRepository($dbConnection);
                    $exchangeRepository->insertToExchanges($_POST['source_currency'], $_POST['destination_currency'], $_POST['source_amount'], $exchangedCurrency);
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        if (!isset($currencies)) {
            try {
                $currencies = $currenciesRepository->getCurrencies();
            } catch (RepositoryException $e) {
                $error = $e->getMessage();
            }

        }
        if (!isset($exchangeRepository)) {
            $exchangeRepository = new ExchangesRepository($dbConnection);
        }
        try {
            $exchangesResults = $exchangeRepository->getExchanges();
        } catch (RepositoryException $e) {
            $error = $e->getMessage();
        }
        $view = new View();
        $view->viewCurrencies($currencies, $exchangesResults, $error);
    }
}
