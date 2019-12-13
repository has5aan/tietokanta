<?php


namespace Tietokanta;

use stdClass;

/**
 * Interface AgnosticInterface represents a fluent API for database interaction, inspired by PDO.
 * @package Tietokanta
 */
interface AgnosticInterface
{
    /**
     * Opens a connection to the corresponding database implementation.
     * @param array|boolean $connectionConfig Connection details for the underlying database.
     * @return AgnosticInterface Current instance of AgnosticInterface implementation.
     *
     */
    public function connect($connectionConfig = false) : AgnosticInterface;

    /**
     * Returns the provider specific concrete database connection or the underlying abstraction layer object.
     * @return mixed Database connection.
     */
    public function db();

    /**
     * Returns the connection configuration provided using connect().
     * @return array|string Connection details for the underlying database.
     */
    public function connectionConfig();

    /**
     * Begins a new transaction.
     * @return AgnosticInterface The current instance of AgnosticInterface implementation.
     */
    public function begin() : AgnosticInterface;

    /**
     * Commits the active transaction.
     * @return AgnosticInterface The current instance of AgnosticInterface implementation.
     */
    public function commit() : AgnosticInterface;

    /**
     * Rollbacks the active transaction.
     * @return AgnosticInterface The current instance of AgnosticInterface implementation.
     */
    public function rollback() : AgnosticInterface;

    /**
     * Quotes a string to be used in a query.
     * @param string $literal Value to be quoted.
     * @return string|boolean Quoted literal.
     */
    public function quote($literal);

    /**
     * Prepares the provided statement.
     * @param string $statement Statement to be prepared.
     * @return AgnosticInterface Current instance of AgnosticInterface implementation.
     */
    public function prepare($statement) : AgnosticInterface;

    /**
     * Executes the prepared statement with the provided parameters.
     * @param array $parameters The parameters to bind to the previously prepared statement.
     * @return AgnosticInterface Current instance of AgnosticInterface implementation.
     */
    public function execute($parameters) : AgnosticInterface;

    /**
     * Prepares and executes the provided query.
     * @param string $query Query to be executed.
     * @return AgnosticInterface Current instance of AgnosticInterface implementation.
     */
    public function query($query) : AgnosticInterface;

    /**
     * Prepares and executes the query with the provided parameters.
     * @param string $query Query to be executed.
     * @param array $parameters The parameters to bind to the provided query.
     * @return AgnosticInterface Current instance of AgnosticInterface implementation.
     */
    public function queryParameters($query, $parameters) : AgnosticInterface;

    /**
     * Returns the current row as an object.
     * @return stdClass|NULL
     */
    public function fetchObject();

    /**
     * Returns the current row as an enumerated array.
     * @return array|NULL
     */
    public function fetchNumericRow();

    /**
     * Returns the current row as an associative array.
     * @return array|NULL
     */
    public function fetchAssociativeRow();

    /**
     * Returns all rows as a numeric array.
     * @return array
     */
    public function fetchNumericRows() : array;

    /**
     * Returns all rows as an associative array.
     * @return array
     */
    public function fetchAssociativeRows() : array;

    /**
     * Returns all rows as an array of objects.
     * @return array
     */
    public function fetchObjects() : array;
}