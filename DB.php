<?php

/**
 * Created by PhpStorm.
 * User: Stephan
 * Date: 23.05.2018
 * Time: 09:29
 */
class DB
{
    /** @var  string */
    private $conection;

    /** @var  string */
    private $executedQuery;

    /**
     * DB constructor.
     */
    public function __construct()
    {
        $this->conection = mssql_connect(MSSQL_HOST, MSSQL_USER, MSSQL_PASSWORD);
        mssql_select_db(MSSQL_DATABASE, $this->conection);
        echo 'Connecting to SQL-Server on ' . MSSQL_HOST . PHP_EOL;
    }

    /**
     * @param array $queryParts
     * @return mixed
     */
    public function query($queryParts)
    {
        $query = '';
        foreach ($queryParts as $part) {
            $query .= $part . ' ' . PHP_EOL;
        }
        $this->executedQuery = mssql_query($query, $this->conection);

        if (!$this->executedQuery) {
            echo PHP_EOL . mssql_get_last_message();
            echo PHP_EOL . $query . PHP_EOL;
            die();
        }
    }

    /**
     * @param $queryParts
     * @return object
     */
    public function getOne($queryParts)
    {
        $this->query($queryParts);
        return mssql_fetch_object($this->executedQuery);
    }

    /**
     * @param $queryParts
     * @return object
     */
    public function getAll($queryParts)
    {
        $this->query($queryParts);
        $rows = [];
        while ($row = mssql_fetch_object($this->executedQuery)) {
            $rows[] = $row;
        }
        return $rows;
    }
}