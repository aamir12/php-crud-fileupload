<?php

include_once 'config.php';
include_once BASE_DIR."/modals/CalendarModal.php";

if($_POST['action']=='1')
{  
  $CalendarModal = new CalendarModal();
  $result = $CalendarModal->allevents();
  echo json_encode($result);

}

if($_POST['action']=='2')
{
  
  $CalendarModal = new CalendarModal();
  $data = $_POST;
  $data['Start'] = DateTime::createFromFormat("d/m/Y H:i A",$data["Start"])->format("Y-m-d H:i:s");
  if(!$data['IsFullDay'])
   $data['End'] = DateTime::createFromFormat("d/m/Y H:i A",$data["End"])->format("Y-m-d H:i:s");
   else
   unset($data['End']);



   unset($data['action']);
  if($data['EventID']>0) //edit
  {  	
  	$id = $data['EventID'];  	
  	$CalendarModal->update($data,$id);
    $res['status'] = true;
    
  }else
  {
  	unset($data['EventID']);
  	$CalendarModal->add($data);
    $res['status'] = true;
  }
  echo json_encode($res);

}

if($_POST['action']=='3')
{
  $id = $_POST['eventID'];
  $CalendarModal = new CalendarModal();
  $CalendarModal->delete($id);
  $res['status'] = true;
  echo json_encode($res);

}


?>