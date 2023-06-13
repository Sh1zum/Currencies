<?php

class View
{

    public function viewCurrencies(array $currencies, array $exchanges, ?string $error, ?string $success)
    {
        echo $this->viewHead() . $this->viewBody($currencies, $exchanges, $error, $success) . $this->viewFooter();
    }

    protected function viewHead(): string
    {
        return '
        <html>
        <head>
        <title>Exchange</title>
        <link rel="stylesheet" href="Views/Style/style.css">
        <meta charset="UTF-8">
        </head>
        <body>
        ';
    }

    protected function viewBody(array $currencies, $exchanges, ?string $error, ?string $success): string
    {
        if ($error !== "") {
            return $this->errorHandling($error);
        }
        return $this->successHandling($success). $this->currenciesTable($currencies) . $this->getCurrenciesForm() . $this->exchangeCurrenciesForm($currencies) . $this->exchangesTable($exchanges);
    }

    protected function viewFooter(): string
    {
        return '</body></html>';
    }

    protected function getCurrenciesForm(): string
    {
        return '<form method="POST">
                <input type="submit" value="Update Currencies" class="default_submit_button">
                <input type="hidden" name="form" value="update_currencies">
                </form>';
    }

    protected function exchangeCurrenciesForm(array $currencies): string
    {
        if (!empty($currencies)) {
            $exchangeForm = '<form method="post">';
            $exchangeForm .= '<label for="source_currency">Source currency:</label>';
            $exchangeForm .= '<select name="source_currency" id="source_currency" required="required" class="default_select">';
            foreach ($currencies as $currency) {
                $exchangeForm .= '<option value=' . $currency['code'] . '>' . $currency['name'] . '</option>';
            }
            $exchangeForm .= '</select>';
            $exchangeForm .= '<label for="source_amount">Source amount</label>';
            $exchangeForm .= '<input type="number" name="source_amount" id="source_amount"  required="required" class="default_input"></br>';
            $exchangeForm .= '<label for="destination_currency">Target currency:</label>';
            $exchangeForm .= '<select name="destination_currency" id="destination_currency"  required="required" class="default_select">';
            foreach ($currencies as $currency) {
                $exchangeForm .= '<option value=' . $currency['code'] . '>' . $currency['name'] . '</option>';
            }
            $exchangeForm .= '</select></br>';
            $exchangeForm .= '<input type="hidden" name="form" value="exchange_currencies">';
            $exchangeForm .= '<input type="submit" value="Exchange Currencies" class="default_submit_button">';
            $exchangeForm .= '</form>';

            return $exchangeForm;
        }

        return '';
    }

    protected function currenciesTable(array $currencies): string
    {
        if (!empty($currencies)) {

            $currenciesTable = '<table class="default_table"><thead><tr><th>Name</th><th>Code</th><th>Rate</th></tr></thead><tbody>';

            foreach ($currencies as $currency) {
                $currenciesTable .= '<tr>
                <td>' . $currency['name'] . '</td>
                <td>' . $currency['code'] . '</td>
                <td>' . $currency['mid'] . '</td>
            </tr>';
            }
            $currenciesTable .= '</tbody></table>';
            return $currenciesTable;
        }
        return '';
    }

    protected function errorHandling($error): string
    {
        return '<div class="error">' . $error . '</div>';
    }
    protected function successHandling($success): string
    {
        return '<div class="success">' . $success . '</div>';
    }

    protected function exchangesTable(array $exchanges): string
    {
        if (!empty($exchanges)) {
            $exchangesTable = '<table class="default_table"><thead><tr><th>Source name</th><th>Destination name</th><th>Amount</th><th>Rate</th><th>Date</th></tr></thead><tbody>';

            foreach ($exchanges as $exchange) {

                $exchangesTable .= '<tr>
                <td>' . $exchange['source_name'] . '</td>
                <td>' . $exchange['destination_name'] . '</td>
                <td>' . $exchange['amount'] . '</td>
                <td>' . $exchange['rate'] . '</td>
                <td>' . $exchange['date'] . '</td>
            </tr>';
            }
            $exchangesTable .= '</tbody></table>';
            return $exchangesTable;
        }
        return '';
    }

}
