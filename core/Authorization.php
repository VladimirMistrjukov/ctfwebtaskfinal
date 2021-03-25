<?php

class Authorization
{
    /**
     * @var DataBaseConnector
     */
    private $db;
    private $user = null;

    public function __construct($db)
    {
        $this->db = $db;

        if (!empty($_SESSION['user_id'])) {
            $this->user = $this->db->executeQueryWithResult(
                'SELECT * FROM users WHERE id=' . $_SESSION['user_id'])->fetchRow();
        }
    }

    public function isAuthorized(): bool
    {
        return !empty($this->user);
    }

    public function getCurrentUser()
    {
        return $this->user;
    }

    public function logout()
    {
        $this->user = null;
        session_destroy();
    }

    public function getCurrentUserId()
    {
        return !empty($this->user) ? $this->user['id'] : null;
    }

    public function findUserByLogin($login)
    {
        return $this->db->executeQueryWithResult(
            "SELECT * FROM users WHERE login='{$login}'")->fetchRow();
    }

    public function authorizeUser($login, $password): bool
    {
        $user = $this->db->executeQueryWithResult(
            "SELECT * FROM users WHERE login='{$login}' AND password='{$password}'")->fetchRow();

        if (!empty($user['id'])) {
            $this->user = $user;
            $_SESSION['user_id'] = $user['id'];
            return true;
        } else {
            return false;
        }
    }

    public function registerUser($login, $password): bool
    {
        $user = $this->findUserByLogin($login);

        if (!empty($user)) {
            return false;
        } else {
            $this->db->executeQuery("INSERT INTO users (login, password)  VALUES ('{$login}', '{$password}')");
            $this->authorizeUser($login, $password);
            return true;
        }
    }
}