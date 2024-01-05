<?php

class Account
{
    public Database $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function select($username, $password)
    {
        $result = $this->db->query('Select * From account Where username = :username and password = :password', [
            'username' => $username,
            'password' => $password,
        ])->findOrFail();


        return $result;
    }

    public function add($username, $password)
    {
        $result = $this->db->query('Insert into account (username, password) values(:username, :password)', [
            'username' => $username,
            'password' => $password,
        ]);
        
        return $result;
    }

    public function deleteByUsername($username)
    {
        $result = $this->db->query('Delete from account where username = :username', [
            'username' => $username,
        ]);
        
        return $result;
    }

    public function deleteByID($id)
    {
        $result = $this->db->query('Delete from account where id = :id', [
            'id' => $id,
        ]);
        
        return $result;
    }

    public function update($id, $username = '', $password = '')
    {
        $sql = '';
        if ($username != '') {
            $sql = $sql . 'username = :username';
        }
        if ($password != '') {
            if ($username != '') {
                $sql = $sql . ', ';
            }
            $sql = $sql . 'password = :password';
        }
        $result = $this->db->query('Update from account SET ' . $sql . ' where id = :id', [
            'username' => $username,
            'password' => $password,
            'id' => $id,
        ]);
        
        return $result;
    }
}