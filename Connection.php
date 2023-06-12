<?php

require_once 'Exceptions/ConnectionException.php';

class Connection
{
    /**
     * @throws ConnectionException
     */
    public function connect(): PDO
    {
        $user = 'root';
        $pass = '';
        try {
            return new PDO('mysql:host=localhost;dbname=test', $user, $pass);

        } catch (PDOException $e) {
            throw new ConnectionException('There is a problem with connection to database');
        }
    }
}
