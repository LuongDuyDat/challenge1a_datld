<?php

class Message
{
    public Database $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function selectAllByReceiverID($id)
    {
        $result = $this->db->query('Select * From messages Where receiver_id = :id', [
            'id' => $id,
        ])->fetchAll();

        return $result;
    }

    public function add($sender_id, $receiver_id, $content)
    {
        $result = $this->db->query('Insert into messages (sender_id, receiver_id, content) values(:sender_id, :receiver_id, :content)', [
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'content' => $content,
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

    public function update($id, $content)
    {
        $result = $this->db->query('Update messages SET content = :content where id = :id', [
            'content' => $content,
            'id' => $id,
        ]);
        
        return $result;
    }
}