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

    public function add($id, $fullName = null, $email = null, $phone = null, $avatar = "assets/images/default_avatar.jpg")
    {
        if (!isset($avatar)) {
            $avatar = "assets/images/default_avatar.jpg";
        }

        $result = $this->db->query('Insert into profile (id, fullName, email, phone, avatar) values(:id, :fullName, :email, :phone, :avatar)', [
            'id' => $id,
            'fullName' => $fullName,
            'email' => $email,
            'phone' => $phone,
            'avatar' => $avatar,
        ]);
        
        return $result;
    }

    public function deleteById($id)
    {
        $result = $this->db->query('Delete from profile where id = :id', [
            'id' => $id,
        ]);
        
        return $result;
    }

    public function update($id, $fullName = null, $email = null, $phone = null, $avatar = "assets/images/default_avatar.jpg")
    {
        if (!isset($avatar)) {
            $avatar = "assets/images/default_avatar.jpg";
        }

        $result = $this->db->query('Update profile SET fullName = :fullName, email = :email, phone = :phone, avatar = :avatar where id = :id', [
            'fullName' => $fullName,
            'email' => $email,
            'phone' => $phone,
            'avatar' => $avatar,
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