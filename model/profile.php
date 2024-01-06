<?php

class Profile
{
    public Database $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function selectAll()
    {
        $result = $this->db->query('Select * From profile')->fetchAll();


        return $result;
    }

    public function selectById($id)
    {
        $result = $this->db->query('Select * From profile Where id = :id', [
            'id' => $id,
        ])->findOrFail();


        return $result;
    }

    public function add($id)
    {
        $result = $this->db->query('Insert into profile (id) values(:id)', [
            'id' => $id,
        ]);
        
        return $result;
    }

    public function deleteById($id)
    {
        $result = $this->db->query('Delete from profile where username = :id', [
            'id' => $id,
        ]);
        
        return $result;
    }

    public function update($id, $fullName = null, $email = null, $phone = null)
    {
        $result = $this->db->query('Update profile SET fullName = :fullName, email = :email, phone = :phone where id = :id', [
            'fullName' => $fullName,
            'email' => $email,
            'phone' => $phone,
            'id' => $id,
        ]);
        
        return $result;
    }

    public function search($value)
    {
        $result = $this->db->query("Select * from profile Where fullName Like :value OR email Like :value or phone Like :value", [
            'value' =>   '%' . $value . '%',
        ])->fetchAll();

        return $result;
    }

}