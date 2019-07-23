<?php

class ContactModal 
{


    public function allcontact() 
    {
        $db = new Database();
        $data = $db->get('contacts');
        return $data;

    }


    public function getrow($id) 
    {
        $db = new Database();
        $condition['where'] = array('id'=>$id);
        $condition['return_type']='single';
        $data = $db->get('contacts',$condition);
        return $data;

    }

    public function add($data) 
    {
        $db = new Database();
        $db->insert('contacts',$data);

    }

    public function update($data,$id) 
    {
        $db = new Database();
        $condition = array('id'=>$id);
        $db->update('contacts',$data,$condition);
    }

     public function delete($id) 
    {
        $db = new Database();
        $condition = array('id'=>$id);
        $data = $db->delete('contacts',$condition);
        return $data;
    }


}


?>

