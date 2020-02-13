<?php

namespace Tietokanta;

use PDO;
use PDOStatement;
use stdClass;

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

    /**
     * Constructs the implementation of AgnosticInterface with provided configurations.
     * @param string $connectionConfig Connection details for the underlying database.
     */
    public function __construct($connectionConfig)
    {
        $this->connectionConfig = $connectionConfig;
    }

    /**
     * Opens a connection to the corresponding database implementation.
     * @param string|boolean $connectionConfig Connection details for the underlying database.
     * @return AgnosticInterface Current instance of AgnosticInterface implementation.
     *
     */
    public function connect($connectionConfig = false) : AgnosticInterface
    {
        if ($connectionConfig)
            $this->connectionConfig = $connectionConfig;

        $this->db = new PDO($this->connectionConfig);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $this;
    }

    /**
     * Returns the provider specific concrete database connection or the underlying abstraction layer object.
     * @return mixed Database connection.
     */
    public function db()
    {
        return $this->db;
    }

    /**
     * Returns the connection configuration provided using connect().
     * @return array|string Connection details for the underlying database.
     */
    public function connectionConfig()
    {
        return $this->connectionConfig;
    }


    /**
     * Begins a new transaction.
     * @return AgnosticInterface The current instance of AgnosticInterface implementation.
     */
    public function begin() : AgnosticInterface
    {
        $this->db->beginTransaction();

        return $this;
    }

    /**
     * Commits the active transaction.
     * @return AgnosticInterface The current instance of AgnosticInterface implementation.
     */
    public function commit() : AgnosticInterface
    {
        $this->db->commit();
    }

    /**
     * Rollbacks the active transaction.
     * @return AgnosticInterface The current instance of AgnosticInterface implementation.
     */
    public function rollback() : AgnosticInterface
    {
        $this->db->rollback();
    }

    /**
     * Quotes a string to be used in a query.
     * @param string $literal Value to be quoted.
     * @return string|boolean Quoted literal.
     */
    public function quote($literal)
    {
        return $this->db->quote($literal);
    }

    /**
     * Prepares the provided statement.
     * @param string $statement Statement to be prepared.
     * @return AgnosticInterface Current instance of AgnosticInterface implementation.
     */
    public function prepare($statement) : AgnosticInterface
    {
        $this->statement = $this->db->prepare($statement);

        return $this;
    }

    /**
     * Executes the prepared statement with the provided parameters.
     * @param array $parameters The parameters to bind to the previously prepared statement.
     * @return AgnosticInterface Current instance of AgnosticInterface implementation.
     */
    public function execute($parameters) : AgnosticInterface
    {
        $this->statement->execute($parameters);

        return $this;
    }
    /**
     * Prepares and executes the provided query.
     * @param string $query Query to be executed.
     * @return AgnosticInterface Current instance of AgnosticInterface implementation.
     */
    public function query($query) : AgnosticInterface
    {
        $this->prepare($query);

        $this->statement->execute();

        return $this;
    }

    /**
     * Prepares and executes the query with the provided parameters.
     * @param string $query Query to be executed.
     * @param array $parameters The parameters to bind to the provided query.
     * @return AgnosticInterface Current instance of AgnosticInterface implementation.
     */
    public function queryParameters($query, $parameters) : AgnosticInterface
    {
        $this->prepare($query);

        $this->execute($parameters);

        return $this;
    }

    /**
     * Returns the current row as an object.
     * @return stdClass|NULL
     */
    public function fetchObject()
    {
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Returns the current row as an enumerated array.
     * @return array|NULL
     */
    public function fetchNumericRow()
    {
        return $this->statement->fetch(PDO::FETCH_NUM);
    }

    /**
     * Returns the current row as an associative array.
     * @return array|NULL
     */
    public function fetchAssociativeRow()
    {
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Returns all rows as a numeric array.
     * @return array
     */
    public function fetchNumericRows() : array
    {
        return $this->statement->fetchAll(PDO::FETCH_NUM);
    }

    /**
     * Returns all rows as an associative array.
     * @return array
     */
    public function fetchAssociativeRows() : array
    {
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Returns all rows as an array of objects.
     * @return array
     */
    public function fetchObjects() : array
    {
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }
}