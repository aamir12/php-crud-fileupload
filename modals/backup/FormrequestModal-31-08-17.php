<?php

class FormrequestModal {

 	function get_unique_formrequest_id()
	{
	   $conn = ConnectionManager::getConnection();
       $sql = "select  max(auto_number) as maxid  from tbl_form_request ";
	   $result = $conn->query($sql);
	   if($result->num_rows>0)
	   {
	     $row = $result->fetch_assoc();
		 $maxid = $row['maxid'];
		 $maxid = $maxid+1;
		 $uid = date('ym').$maxid;
	   }else
	   {
	     $uid = date('ym').'1';
	   }
	   $conn->close();
	   return $uid;
	
	}
	
	
	function addnewformrequest($userModal,$adminid,$userid,$numForms,$applicaton_type,$performRate,$rechargeby,$rechargeamount,          $noformswallet)
	{ 
	
	   $conn = ConnectionManager::getConnection();
	   $admin = $userModal->get_admin_user($adminid);
	   extract($admin);
	
	   $user = $userModal->get_single_user($userid);
	   extract($user);
	   

	    $check =false;
       $transactionid = $this->get_unique_formrequest_id();
       $transctiondate = date('Y-m-d H:i:s');
       if($rechargeby=='online')
        {	   
		
		$totalAmount = $performRate * $numForms;
       $sql = "INSERT INTO tbl_form_request (auto_number, applicaton_type, id, firstname, lastname, contact_number, email, vivapath, vivapath_firstname, vivapath_lastname, vivapath_contact, vivapath_email, numForms, totalAmount, performRate, transactionid, payment_status, vivapath_status, transctiondate,rechargeby) VALUES (NULL, '$applicaton_type', '$id', '$firstname', '$lastname', '$contact_number', '$email', '$vivapath', '$vivapath_firstname', '$vivapath_lastname', '$vivapath_contact', '$vivapath_email', '$numForms', '$totalAmount', '$performRate', '$transactionid', '3', '5', '$transctiondate','$rechargeby')";
       }
	   
	    if($rechargeby=='wallet')
	   {	   
	   $sql = "INSERT INTO tbl_form_request (auto_number, applicaton_type, id, firstname, lastname, contact_number, email, vivapath, vivapath_firstname, vivapath_lastname, vivapath_contact, vivapath_email, numForms, totalAmount, performRate, transactionid, payment_status, vivapath_status, transctiondate,rechargeby) VALUES (NULL, '$applicaton_type', '$id', '$firstname', '$lastname', '$contact_number', '$email', '$vivapath', '$vivapath_firstname', '$vivapath_lastname', '$vivapath_contact', '$vivapath_email', '$noformswallet', '$rechargeamount', '$performRate', '$transactionid', '1', '6', '$transctiondate','$rechargeby')";	   
	   }
	   
	   
       if($conn->query($sql)==true)
	   {
	   $check =true;
	   
	   $appid = mysqli_insert_id($conn);
	      if($rechargeby=='online')
          {
	        $_SESSION['FORM_REQ_ID'] = $appid ;
		  }
	   
	   }
	   
	   $conn->close();
	   return $check;
 	   
	
	}
	
	
	
	
	function addnewformrequest1($userModal,$adminid,$userid,$numForms,$applicaton_type,$rechargeby,$rechargeamount,$noformswallet , $commonModal)
	{ 
	
	   $conn = ConnectionManager::getConnection();
	   $admin = $userModal->get_admin_user($adminid);
	   extract($admin);
	
	   $user = $userModal->get_single_user($userid);
	   extract($user);
	   

	   $check =false;
       $transactionid = $this->get_unique_formrequest_id();
       $transctiondate = date('Y-m-d H:i:s');
	   
	   $setting = $commonModal->get_commission_setting($applicaton_type);
	   $performRate = $setting['amount'];
       if($rechargeby=='online')
       {	   
		
		
		
		$totalAmount = $performRate * $numForms;
		
		$txnper = $commonModal->get_setting_value('PAYMENT_GATEWAY');
		$txnamount = round($totalAmount*$txnper/100 , 2);
		
		$gstper = $commonModal->get_setting_value('GST');
		$gstamount = round($txnamount*$gstper/100 , 2);
		
		$total_deduction = $gstamount + $txnamount;
		
		$vivapathRecieved = $totalAmount - $total_deduction;
		$vivapath_amount = $totalAmount - $total_deduction;
	
	   $sql = "INSERT INTO tbl_form_request (auto_number, applicaton_type, id, firstname, lastname, contact_number, email, vivapath, vivapath_firstname, vivapath_lastname, vivapath_contact, vivapath_email, numForms, totalAmount, performRate, transactionid, payment_status, vivapath_status, transctiondate, rechargeby, txnper, txnamount, gstper, gstamount, total_deduction, vivapath_amount, vivapathRecieved) VALUES (NULL, '$applicaton_type', '$id', '$firstname', '$lastname', '$contact_number', '$email', '$vivapath', '$vivapath_firstname', '$vivapath_lastname', '$vivapath_contact', '$vivapath_email', '$numForms', '$totalAmount', '$performRate', '$transactionid', '3', '5', '$transctiondate', '$rechargeby','$txnper', '$txnamount', '$gstper', '$gstamount', '$total_deduction', '$vivapath_amount', '$vivapathRecieved')";
	   
	   
       }
	   
	    if($rechargeby=='wallet')
	   {	   
	   $sql = "INSERT INTO tbl_form_request (auto_number, applicaton_type, id, firstname, lastname, contact_number, email, vivapath, vivapath_firstname, vivapath_lastname, vivapath_contact, vivapath_email, numForms, totalAmount, performRate, transactionid, payment_status, vivapath_status, transctiondate,rechargeby) VALUES (NULL, '$applicaton_type', '$id', '$firstname', '$lastname', '$contact_number', '$email', '$vivapath', '$vivapath_firstname', '$vivapath_lastname', '$vivapath_contact', '$vivapath_email', '$noformswallet', '$rechargeamount', '$performRate', '$transactionid', '1', '6', '$transctiondate','$rechargeby')";	   
	   }
	   
	   
       if($conn->query($sql)==true)
	   {
	     $check =true;
	   
	      $appid = mysqli_insert_id($conn);
	      if($rechargeby=='online')
          {
	        $_SESSION['FORM_REQ_ID'] = $appid ;
		  }
	   
	   }
	   
	   $conn->close();
	   return $check;
 	   
	
	}
	
	
	
	
	
	
	function get_new_form_approval_request()
	{
	
	
	}
	
	
	function get_paid_form_request($auto_number)
	{
	 $conn = ConnectionManager::getConnection();
	 $fr = false;
	 $sql = "select * from tbl_form_request where auto_number = '$auto_number' and deletestatus='1' and payment_status = '1' ";
	 $result = $conn->query($sql);
	 if($result->num_rows>0)
	 {
	  
	    $row = $result->fetch_assoc();
                $fr = $row;
	 }
	 $conn->close();
	 return $fr;
	
	}
	
	
	
	
	function getall_paid_form_request()
	{
	 $conn = ConnectionManager::getConnection();
	 
	   $sql = "select tfr.auto_number as id , tfr.numForms , tfr.totalAmount ,tu.uid,tu.firstname ,tu.lastname,tu.contact_number,tu.email,tfr.payment_status , tfr.transactionid , tfr.vivapath_status,tfr.transctiondate  from  tbl_users as tu inner join tbl_form_request as tfr   on tu.id=tfr.id   where  tfr.deletestatus='1' and tfr.payment_status = '1' ";
	 
	
	 
   $records = array();
	 $result = $conn->query($sql);
	 if($result->num_rows>0)
	 {
	    while ($row = $result->fetch_assoc()) {
                $fr = $row;
                array_push($records, $fr);
            }   
	 }
	 $conn->close();
	 return $records;
	
	}
	
	
	
	
	function update_approval_request($auto_number,$vivapath_status)
	{
	 $conn = ConnectionManager::getConnection();
	 $fr = false;
	 $sql = "update tbl_form_request set vivapath_status = '$vivapath_status' where auto_number = '$auto_number'";
		if($conn->query($sql)==true)
		{
			$fr = true;
		}
	 
	  $conn->close();
	 return $fr;
	
	}
	
	
	function get_form_request($auto_number)
	{
	 $conn = ConnectionManager::getConnection();
	 $fr = false;
	 $sql = "select * from tbl_form_request where auto_number = '$auto_number' and deletestatus='1' and id = '".$_SESSION['userID']."'";
	 $result = $conn->query($sql);
	 if($result->num_rows>0)
	 {
	  
	    $row = $result->fetch_assoc();
                $fr = $row;
	 }
	 $conn->close();
	 return $fr;
	
	}
	
	
	function get_formrequest_by_token($auto_number)
	{
	    $conn = ConnectionManager::getConnection();
        $apps = false;
        $sql = "select * from tbl_form_request where md5(auto_number) = '$auto_number' and deletestatus='1' and id = '".$_SESSION['userID']."'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
                $apps = $row;
               
			}
            
    
        $conn->close();
        return $apps;	
	
	}
	
	
	function changePaymentTxnFailed($id,$txnid,$hostid)
	{
	   $conn = ConnectionManager::getConnection();		
		$sql = "update  tbl_form_request set  payment_status  = '2' , vivapath_status = '5' , txnid= '$txnid' where id = '$hostid' and auto_number = '$id'  ";
		
		$result = $conn->query($sql);
		$conn->close();
	
	}
	
	
	function changeRechargePaymentStatus($id,$txnid,$amount,$hostid,$commonModal)		
	{
	    $conn = ConnectionManager::getConnection();
		
		$gstper =  $commonModal->get_setting_value('GST');
        $txnper = $commonModal->get_setting_value('PAYMENT_GATEWAY');

		$txn_pay_amount = ($txnper*$amount/100);		
		$gst_pay_amount = ($gstper*$txn_pay_amount/100);		
		$total_deduction = $txn_pay_amount  + $gst_pay_amount ;		
		$vivapath_amount = $amount - $total_deduction;
		
		$sql = "update  tbl_form_request set  payment_status  = '1',vivapath_status = '6',txnid= '$txnid'
		,gstper = '$gstper',txnper = '$txnper',
		txn_pay_amount = '$txn_pay_amount',
		gst_pay_amount = '$gst_pay_amount',
		total_deduction = '$total_deduction',
		vivapath_amount = '$vivapath_amount'  where id = '$hostid' and auto_number = '$id'  ";
		
		$result = $conn->query($sql);
		$conn->close();
        
	  
	}
	
	
	function changeRechargePaymentStatus1($id,$txnid,$amount,$hostid,$commonModal)		
	{
	    $conn = ConnectionManager::getConnection();
		
		$gstper =  $commonModal->get_setting_value('GST');
        $txnper = $commonModal->get_setting_value('PAYMENT_GATEWAY');

		$txn_pay_amount = ($txnper*$amount/100);		
		$gst_pay_amount = ($gstper*$txn_pay_amount/100);		
		$total_deduction = $txn_pay_amount  + $gst_pay_amount ;		
		$vivapath_amount = $amount - $total_deduction;
		
		$sql = "update  tbl_form_request set  payment_status  = '1',vivapath_status = '6',txnid= '$txnid'
		  where id = '$hostid' and auto_number = '$id'  ";
		
		$result = $conn->query($sql);
		$conn->close();
        
	  
	}
	
	
	
}
