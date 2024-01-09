<?php

class HomeworkFile
{
    public Database $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function selectByID($id)
    {
        $result = $this->db->query('Select * From homework_files where id = :id;', [
            'id' => $id,
        ])->findOrFail();


        return $result;
    }

    public function selectByHomeworkID($id)
    {
        $result = $this->db->query('Select * From homework_files where homework_id = :id;', [
            'id' => $id,
        ])->fetchAll();


        return $result;
    }

    public function add($homework_id, $file_path, $name, $size)
    {
        $result = $this->db->query('Insert into homework_files (homework_id, file_path, name, size) values(:homework_id, :file_path, :name, :size)', [
            'homework_id' => $homework_id,
            'file_path' => $file_path,
            'name' => $name,
            'size' => $size,
        ]);
        
        return $result;
    }

    public function deleteByID($id)
    {
        $result = $this->db->query('Delete from homework_files where id = :id', [
            'id' => $id,
        ]);
        
        return $result;
    }
}