<?php

class Request
{
    public $post = [];
    public $get = [];
    public $cookie = [];
    public $session = [];

    public function __construct()
    {
        session_start();

        $this->post = $_POST;
        $this->get = $_GET;
        $this->cookie = $_COOKIE;
        $this->session = $_SESSION;
    }
}