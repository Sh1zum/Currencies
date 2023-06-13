<?php

require_once 'Exceptions/ConnectionException.php';

class Connection
{
    /**
     * @throws ConnectionException
     */
    public function connect(): PDO
    {
        $user = '37435088_currencies';
        $pass = 'I1LQbttD';
        try {
            return new PDO('mysql:host=serwer2307765.home.pl;dbname=37435088_currencies', $user, $pass);

        } catch (PDOException $e) {
            throw new ConnectionException('There is a problem with connection to database');
        }
    }
}
