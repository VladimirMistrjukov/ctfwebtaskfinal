<?php

class DataBaseQueryResult
{
    /**
     * @var SQLite3Result
     */
    private $result;

    public function __construct(SQLite3Result $result)
    {
        $this->result = $result;
    }

    public function fetchRow()
    {
        return $this->result->fetchArray(SQLITE3_ASSOC);
    }

    public function fetchOne()
    {
        return $this->result->fetchArray(SQLITE3_NUM)[0];
    }
}

class DataBaseConnector
{
    /**
     * @var SQLite3
     */
    private $db;

    public function __construct($dbFileName)
    {
        $this->db = new SQLite3($dbFileName);
    }

    public function executeQuery($queryText)
    {
        $this->db->exec($queryText);
    }

    public function executeQueryWithResult($queryText)
    {
        return new DataBaseQueryResult($this->db->query($queryText));
    }

    public function escapeValue($value)
    {
        return SQLite3::escapeString($value);
    }
}
