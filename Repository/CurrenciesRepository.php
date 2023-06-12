<?php

require_once 'Connection.php';

class CurrenciesRepository
{
    public function __construct(public readonly PDO $pdo)
    {
    }

    /**
     * @throws RepositoryException
     */
    public function getCurrencies(): array
    {
        try {
            $Currencies = $this->pdo->query('SELECT * FROM currencies ORDER BY `name` ASC;');
            return $Currencies->fetchAll();
        } catch (PDOException) {
            throw new RepositoryException('There was an error in PDO statement');
        }
    }

    /**
     * @throws RepositoryException
     */
    public function upsertCurrencies(array $currencies)
    {
        try {
            $query = $this->pdo->prepare('INSERT INTO currencies (name, code, mid) VALUES(:name, :code, :mid)
    ON DUPLICATE KEY UPDATE name = :name, code = :code, mid = :mid');
            foreach ($currencies as $currency) {
                $query->bindParam(':name', $currency['currency'], PDO::PARAM_STR);
                $query->bindParam(':code', $currency['code'], PDO::PARAM_STR);
                $query->bindParam(':mid', $currency['mid'], PDO::PARAM_STR);
                $query->execute();
            }
        } catch (PDOException) {
            throw new RepositoryException('There was an error in PDO statement');
        }
    }

    /**
     * @throws RepositoryException
     */
    public function getCurrencyMidByCode(string $code): float
    {
        try {
            $query = $this->pdo->prepare('SELECT `mid` FROM currencies WHERE `code` = :code;');
            $query->bindParam(':code', $code, PDO::PARAM_STR);
            $query->execute();
        } catch (PDOException) {
            throw new RepositoryException('There was an error in PDO statement');
        }
        return $query->fetchColumn();
    }
}
