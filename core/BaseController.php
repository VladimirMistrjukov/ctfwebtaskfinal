<?php
require __DIR__ . '/DataBaseConnector.php';
require __DIR__ . '/Request.php';

class BaseController
{
    /**
     * @var DataBaseConnector
     */
    protected $db;

    /**
     * @var Request
     */
    protected $request;

    public function __construct($dbFileName)
    {
        $this->db = new DataBaseConnector($dbFileName);
        $this->request = new Request();
    }
}