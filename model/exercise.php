<?php

class Exercise
{
    public Database $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function selectAll()
    {
        $result = $this->db->query('Select * From exercises;')->fetchAll();

        return $result;
    }

    public function add($name, $size, $teacher_id, $file_path)
    {
        $result = $this->db->query('Insert into exercises (name, size, teacher_id, file_path) values(:name, :size, :teacher_id, :file_path)', [
            'name' => $name,
            'size' => $size,
            'teacher_id' => $teacher_id,
            'file_path' => $file_path
        ]);
        
        return $result;
    }

    public function deleteById($id)
    {
        $result = $this->db->query('Delete from messages where id = :id', [
            'id' => $id,
        ]);
        
        return $result;
    }
}