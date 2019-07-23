<?php

class CalendarModal 
{


    public function allevents() 
    {
        $db = new Database();
        $data = $db->get('calendar');
        return $data;

    }


    public function getrow($id) 
    {
        $db = new Database();
        $condition['where'] = array('EventID'=>$id);
        $condition['return_type']='single';
        $data = $db->get('calendar',$condition);
        return $data;

    }

    public function add($data) 
    {
        $db = new Database();
        $db->insert('calendar',$data);

    }

    public function update($data,$id) 
    {
        $db = new Database();
        $condition = array('EventID'=>$id);
        $db->update('calendar',$data,$condition);
    }

     public function delete($id) 
    {
        $db = new Database();
        $condition = array('EventID'=>$id);
        $data = $db->delete('calendar',$condition);
        return $data;
    }


}


?>

