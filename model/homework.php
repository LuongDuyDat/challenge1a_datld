<?php

class Homework
{
    public Database $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function selectByExerciseID($id)
    {
        $result = $this->db->query('Select * From homeworks where exercise_id = :id;', [
            'id' => $id,
        ])->fetchAll();


        return $result;
    }

    public function selectByStudentID($id)
    {
        $result = $this->db->query('Select * From homeworks Where student_id = :id', [
            'id' => $id,
        ])->fetchAll();


        return $result;
    }

    public function select($exercise_id, $student_id)
    {
        $result = $this->db->query('Select * From homeworks Where student_id = :student_id and exercise_id = :exercise_id', [
            'student_id' => $student_id,
            'exercise_id' => $exercise_id,
        ])->findOrFail();


        return $result;
    }

    public function add($exercise_id, $student_id)
    {
        $result = $this->db->query('Insert into homeworks (exercise_id, student_id) values(:exercise_id, :student_id)', [
            'exercise_id' => $exercise_id,
            'student_id' => $student_id,
        ]);
        
        return $result;
    }

    public function deleteByStudentID($id)
    {
        $result = $this->db->query('Delete from homeworks where student_id = :student_id', [
            'student_id' => $id,
        ]);
        
        return $result;
    }
}