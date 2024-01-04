<?php

class Account
{
    public Database $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function loginVerify($username, $password)
    {
        $result = $this->db->query('Select * From account Where username = :username and password = :password', [
            'username' => $username,
            'password' => $password,
        ])->findOrFail();


        if ($result != 'fail')
        {
            return true;
        }

        return false;
    }
}