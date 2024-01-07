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

    public function selectById($id)
    {
        $result = $this->db->query('Select * From account Where id = :id', [
            'id' => $id,
        ])->findOrFail();


        return $result;
    }

    public function selectByUsername($username)
    {
        $result = $this->db->query('Select * From account Where username = :username', [
            'username' => $username,
        ])->findOrFail();


        return $result;
    }

    public function add($username, $password, $role = 1)
    {
        if ($this->selectByUsername($username) != 'fail') {
            return "Username already exists";
        }

        $result = $this->db->query('Insert into account (username, password, role) values(:username, :password, :role)', [
            'username' => $username,
            'password' => $password,
            'role' => $role,
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
        if ($this->selectByUsername($username) == 'fail') {
            return "Username already exists";
        }

        $result = $this->db->query('Update account SET username = :username, password = :password where id = :id', [
            'username' => $username,
            'password' => $password,
            'id' => $id,
        ]);
        
        return $result;
    }
}