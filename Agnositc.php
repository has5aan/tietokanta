<?php


namespace Tietokanta;

use PDO;
use PDOStatement;

/**
 * Class Agnostic, a PDO based implementation of Tietokanta\AgnosticInterface.
 * @package Tietokanta
 */
class Agnostic implements AgnosticInterface
{
    /** @var PDO $db Instance of PDO. */
    private $db;

    /** @var string $connectionConfig Connection configuration. */
    private $connectionConfig;

    /** @var PDOStatement $statement Instance of PDO. */
    private $statement;

    public function __construct(string $connectionConfig)
    {
        $this->connectionConfig = $connectionConfig;
    }

    public function db()
    {
        return $this->db;
    }

    public function connectionConfig()
    {
        return $this->connectionConfig;
    }

    public function connect($connectionConfig = false) : AgnosticInterface
    {
        if ($connectionConfig)
            $this->connectionConfig = $connectionConfig;

        $this->db = new PDO($this->connectionConfig);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $this;
    }

    public function begin() : AgnosticInterface
    {
        $this->db->beginTransaction();

        return $this;
    }

    public function commit() : AgnosticInterface
    {
        $this->db->commit();
    }

    public function rollback() : AgnosticInterface
    {
        $this->db->rollback();
    }

    public function quote($literal)
    {
        return $this->db->quote($literal);
    }

    public function prepare($statement) : AgnosticInterface
    {
        $this->statement = $this->db->prepare($statement);

        return $this;
    }

    public function execute($parameters) : AgnosticInterface
    {
        $this->statement->execute($parameters);

        return $this;
    }

    public function queryParameters($query, $parameters) : AgnosticInterface
    {
        $this->prepare($query);

        $this->execute($parameters);

        return $this;
    }

    public function query($query) : AgnosticInterface
    {
        $this->prepare($query);

        $this->statement->execute();

        return $this;
    }

    public function fetchObject()
    {
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    public function fetchNumericRow()
    {
        return $this->statement->fetch(PDO::FETCH_NUM);
    }

    public function fetchAssociativeRow()
    {
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchNumericRows() : array
    {
        return $this->statement->fetchAll(PDO::FETCH_NUM);
    }

    public function fetchAssociativeRows() : array
    {
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchObjects() : array
    {
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }
}