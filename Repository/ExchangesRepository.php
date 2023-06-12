<?php

require_once 'Connection.php';
require_once 'Exceptions/RepositoryException.php';

class ExchangesRepository
{
    public function __construct(public readonly PDO $pdo)
    {
    }

    /**
     * @throws RepositoryException
     */
    public function insertToExchanges(string $sourceCode, string $destinationCode, float $amount, float $rate)
    {
        try {
            $query = $this->pdo->prepare('INSERT INTO exchanges (source_code, destination_code, amount, rate, date)
VALUES(:source_code, :destination_code, :amount, :rate, :date)');
            $query->bindParam(':source_code', $sourceCode, PDO::PARAM_STR);
            $query->bindParam(':destination_code', $destinationCode, PDO::PARAM_STR);
            $query->bindParam(':amount', $amount, PDO::PARAM_STR);
            $query->bindParam(':rate', $rate, PDO::PARAM_STR);
            $date = (new DateTime())->format('Y-m-d H:i:s');
            $query->bindParam(':date', $date, PDO::PARAM_STR);
            $query->execute();

        } catch (PDOException) {
            throw new RepositoryException('There was an error in PDO statement');
        }
    }

    /**
     * @throws RepositoryException
     */
    public function getExchanges(): array
    {
        try {
            $exchanges = $this->pdo->query('SELECT * FROM exchanges ORDER BY `date` DESC;');
            return $exchanges->fetchAll();
        } catch (PDOException) {
            throw new RepositoryException('There was an error in PDO statement');
        }
    }
}
