<?php

class ApplicationModal {

 
   function get_unique_app_id()
	{
	   $conn = ConnectionManager::getConnection();
       $sql = "select  max(id) as maxid  from tbl_applications ";
	   $result = $conn->query($sql);
	   if($result->num_rows>0)
	   {
	     $row = $result->fetch_assoc();
		 $maxid = $row['maxid'];
		 $maxid = $maxid+1;
		 $uid = date('my').$maxid;
	   }else
	   {
	     $uid = date('my').'1';
	   }
	   $conn->close();
	   return $uid;
	
	}
 
	
	function newapplication($firstname,$lastname,$email,$contact_number,$aadhar_number,$pan_number,$second_person_name,$second_person_contact_number,$relationship_with_applicant,$suvidha_center_location,$comments,$transaction_type,$bank_name,$cheque_number,$cheque_date,$branch_name,$address,$district,$state,$host ,$application_type,$commonModal)
	{
	
	   $user =false;
	   $conn = ConnectionManager::getConnection();        	
	   $created_date = $transaction_date  = date("Y-m-d H:i:s");
	   $createipaddress = $_SERVER['REMOTE_ADDR'];
	   $application_id = $this->get_unique_app_id();
	   
	    $setting = $commonModal->get_commission_setting($application_type);
	  
	    $sql = "INSERT INTO tbl_applications (id,application_id,application_type, firstname, lastname, address, email, contact_number, aadhar_number, pan_number, second_person_name, second_person_contact_number, relationship_with_applicant, suvidha_center_location, suvidha_contact_number, subject, address1, district, state, fk_user, comments,paymenttype , created_date ,createipaddress ) VALUES (NULL,'$application_id','$application_type', '$firstname', '$lastname', '$address', '$email', '$contact_number', '$aadhar_number', '$pan_number', '$second_person_name', '$second_person_contact_number', '$relationship_with_applicant', '$suvidha_center_location', '', '', '', '$district', '$state', '".$_SESSION['userID']."', '$comments','$transaction_type' , '$created_date','$createipaddress')";
		 
		 
	
		
		      if ($conn->query($sql) === TRUE) {
                    $app_id = mysqli_insert_id($conn);
						
					 
					$amount = $setting['amount'];					 
				    $vivapath_payment_status = 5;			
					$upper_user=0;
				
                   				
				    $upperuser = $this->get_creator($_SESSION['userID']);
				    $upper_user = $upperuser['creator'];
				   
				   
				    if($transaction_type == "cash")
					{					
					 $payment_status = 1;
					 $vivapath_payment_status = 6;
					}
					  
				   if($transaction_type == "online")
				   {
				   
					$payment_status = 3;
					$vivapath_payment_status = 5;
				   }
				
					
					
				
	
				
			 	$sql = "INSERT INTO tbl_transaction (id, fk_application_id,application_type,upper_user ,host, host_type, host_firstname, host_lastname, host_email, host_contact, customer_firstname, customer_lastname, customer_email, customer_contact, txn_amount, payment_status, transaction_type, transaction_date, vivapath_payment_status, deletstatus) VALUES (NULL, '$app_id','$application_type' ,'$upper_user' ,'".$host['id']."', '".$host['user_type']."', '".$host['firstname']."', '".$host['lastname']."', '".$host['email']."', '".$host['contact_number']."', '$firstname', '$lastname', '$email', '$contact_number', '".$setting['amount']."', '$payment_status', '$transaction_type', '$transaction_date','$vivapath_payment_status', '1')";   
                     $conn->query($sql);
                     if($transaction_type=='online')					 
                      { $_SESSION['AppID'] = $app_id;
					  
					  }
					  
					 $tranID = mysqli_insert_id($conn);
					 $transaction_id = date('ymh').$tranID; 
					 
					 
					 
					  $sql = "update tbl_transaction set  transaction_id = '$transaction_id' where id = '$tranID' ";
					 $conn->query($sql);
					 
					 
					 
					 
					 
				///////////////////////////
					
					//suvidha kendra
					if($host['user_type']=='4')
					{
					   if($transaction_type == "cash")
					    {
					    
					        $amount = $setting['amount'];
					        $mycommission = $setting['suvidhBasicamount'];
							$vivapathAmount = $amount - $mycommission;
					       	$particular = 'BY MAIN';			
					         $sql = "INSERT INTO tbl_user_commission (id, applicationtype,host,host_type ,commission, applicationanum, transactionanum, transactionmode, createddate,particular ,vivapathAmount) VALUES (NULL, '$application_type','".$host['id']."' ,'".$host['user_type']."' ,'$mycommission', '$app_id', '$tranID', '$transaction_type', '$created_date','$particular','$vivapathAmount' )"; 
                             $conn->query($sql);
							 
							  $chosttype= $upperuser['user_type'];
							 
							
							 $particular = 'BY COMMISSION';
							 $commission_level = 'SUVIDHA';
							 
							 if($chosttype=='3')
							 {
							    
							    $mycommission = $setting['districtBasicamount'];
								
							    $sql = "INSERT INTO tbl_user_commission (id, applicationtype,host,host_type ,commission, applicationanum, transactionanum, transactionmode, createddate,particular,commission_level) VALUES (NULL, '$application_type','".$upperuser['creator']."' ,'".$upperuser['user_type']."' ,'$mycommission', '$app_id', '$tranID', '$transaction_type', '$created_date','$particular' ,'$commission_level')"; 
                                 $conn->query($sql);
								 
								  $upperuser = $this->get_creator($upperuser['creator']);
								  $chosttype1= $upperuser['user_type'];
								
								  if($chosttype1 == '2')
								  {
								  
								   
								     $mycommission = $setting['stateBasicamount'];
							         $sql = "INSERT INTO tbl_user_commission (id, applicationtype,host,host_type ,commission, applicationanum, transactionanum, transactionmode, createddate,particular,commission_level) VALUES (NULL, '$application_type','".$upperuser['creator']."' ,'".$upperuser['user_type']."' ,'$mycommission', '$app_id', '$tranID', '$transaction_type', '$created_date','$particular' ,'$commission_level')"; 
                                     $conn->query($sql);
								  
								  }
								 
							 
							 }
							 
							  if($chosttype=='2')
							 {
							         $mycommission = $setting['stateBasicamount'];
							          $sql = "INSERT INTO tbl_user_commission (id, applicationtype,host,host_type ,commission, applicationanum, transactionanum, transactionmode, createddate,particular,commission_level) VALUES (NULL, '$application_type','".$upperuser['creator']."' ,'".$upperuser['user_type']."' ,'$mycommission', '$app_id', '$tranID', '$transaction_type', '$created_date','$particular' ,'$commission_level')"; 
                                     $conn->query($sql);
							 
							 
							 }
						
					  
					    }
					  
					   if($transaction_type == "online")
					  {
					    
						
					  }
					  
					
					}		
					 
			  /////////////////////////
					 
					  
   				     $user = true;
					
					
               }
		 
		
	
	
	    $conn->close();
        return $user;
	
	}
	
	
	
	
	function newapplicationAdmin($firstname,$lastname,$email,$contact_number,$aadhar_number,$pan_number,$second_person_name,$second_person_contact_number,$relationship_with_applicant,$suvidha_center_location,$comments,$transaction_type,$bank_name,$cheque_number,$cheque_date,$branch_name,$address,$district,$state,$host ,$setting)
	{
	
	   $user =false;
	   $conn = ConnectionManager::getConnection();        	
	   $datetime = date("Y-m-d H:i:s");
	   
	   $application_id = $this->get_unique_app_id();
	   
	   $created_date = $transaction_date  = date("Y-m-d H:i:s");
	   $createipaddress = $_SERVER['REMOTE_ADDR'];
	 
	   //application_type = 1 for GST
		$application_type = 1;
		
	    $sql = "INSERT INTO tbl_applications (id,application_id,application_type, firstname, lastname, address, email, contact_number, aadhar_number, pan_number, second_person_name, second_person_contact_number, relationship_with_applicant, suvidha_center_location, suvidha_contact_number, subject, address1, district, state, fk_user, comments,isAdmin,paymenttype , created_date ,createipaddress ) VALUES (NULL,'$application_id','$application_type', '$firstname', '$lastname', '$address', '$email', '$contact_number', '$aadhar_number', '$pan_number', '$second_person_name', '$second_person_contact_number', '$relationship_with_applicant', '$suvidha_center_location', '', '', '', '$district', '$state', '".$_SESSION['VuserID']."', '$comments','1','$paymenttype' , '$created_date' , '$createipaddress')";
		 
		 
	
		
		      if ($conn->query($sql) === TRUE) {
                    $app_id = mysqli_insert_id($conn);
					
					
					$amount = $setting['amount'];
				
				    $vivapath_payment_status = 5;
					
					   if($transaction_type == "cash")
					   {
					      $payment_status = 1;  
						  $vivapath_payment_status = 6;
						
					   }
					  
					   if($transaction_type == "online")
					   {				    
						$payment_status = 3;
						$vivapath_payment_status = 5;
						
					   }
					  
					$upper_user = 0;
					
					
					
					//application_type=1 for GST
				$sql = "INSERT INTO tbl_transaction (id, fk_application_id,application_type,upper_user ,host, host_type, host_firstname, host_lastname, host_email, host_contact, customer_firstname, customer_lastname, customer_email, customer_contact, txn_amount, payment_status, transaction_type, transaction_date, vivapath_payment_status,isAdmin) VALUES (NULL, '$app_id','1' ,'$upper_user' ,'".$host['id']."', '1', '".$host['firstname']."', '".$host['lastname']."', '".$host['email']."', '".$host['contact_number']."', '$firstname', '$lastname', '$email', '$contact_number', '".$setting['amount']."', '$payment_status', '$transaction_type', '$transaction_date','$vivapath_payment_status','1')";   



					
                     $conn->query($sql);
                     if($transaction_type=='online')					 
                      { $_SESSION['VAppID'] = $app_id;}
					  
					 $tranID = mysqli_insert_id($conn);
					 $transaction_id = date('ymh').$tranID; 
					 
					 $sql = "update tbl_transaction set  transaction_id = '$transaction_id' where id = '$tranID' ";
					 $conn->query($sql);
					  
   				     $user = true;
					
					
               }
		 
		
	
	
	    $conn->close();
        return $user;
	
	}
	
	
	
	
	
	function  get_creator($userid)
	{	  
		$conn = ConnectionManager::getConnection();
		$creatoruser =array(
		 'creator'=>0,
		 'user_type'=>0,
		 'isAdminCreate'=>0
		);
		
		$sql = "SELECT b.id ,b.user_type , b.isAdminCreate  FROM tbl_users as a  inner join tbl_users as b on b.id=a.creator where a.id='$userid'";	   
		$result= $conn->query($sql);
		if($result->num_rows>0)
		{
			$row = $result->fetch_assoc();			
			$creatoruser['creator'] = $row['id'];
			$creatoruser['user_type'] = $row['user_type'];
			$creatoruser['isAdminCreate'] = $row['isAdminCreate'];
		}
		$conn->close();
		return $creatoruser;
	}
	
	
	
	
	
	
	
	
	function update_balance($uid,$amount)
	{
	   $conn = ConnectionManager::getConnection();
       $sql = "UPDATE tbl_users SET balance = balance + '" .$amount. "' WHERE id = '".$uid. "'";
	   $conn->query($sql);
	   $conn->close();
	}
	
	
	function get_application_form()
	{
	   $conn = ConnectionManager::getConnection();
        $apps = array();
          $sql = "SELECT ta.*,tt.*,ta.id as appid,tt.id as tid
		        FROM 
		 tbl_applications as ta inner join  tbl_transaction as tt on  tt.fk_application_id = ta.id 
		 WHERE ta.fk_user = '".$_SESSION['userID']."' and ta.isAdmin = '0'";
	
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc())
			{
                $app = $row;
                array_push($apps, $app);
			}
            
        }
        $conn->close();
        return $apps;
	
	}
	
	
	function get_application($id)
	{
	    $conn = ConnectionManager::getConnection();
        $apps = false;
        $sql = "SELECT ta.*,tt.*,ta.id as appid,tt.id as tid , ta.isAdmin as taisAdmin 
		        FROM 
		 tbl_applications as ta inner join  tbl_transaction as tt on  tt.fk_application_id = ta.id 
		 WHERE  ta.id = '$id'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
                $apps = $row;
               
			}
            
    
        $conn->close();
        return $apps;
	
	
	}
	
	
	function get_application_by_token($id)
	{
	    $conn = ConnectionManager::getConnection();
        $apps = false;
         $sql = "SELECT ta.*,tt.*,ta.id as appid,tt.id as tid , ta.isAdmin as taisAdmin 
		        FROM 
		 tbl_applications as ta inner join  tbl_transaction as tt on  tt.fk_application_id = ta.id 
		 WHERE  md5(ta.id) = '$id' and ta.fk_user = '".$_SESSION['userID']."' ";

		 
		 
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
                $apps = $row;
               
			}
            
    
        $conn->close();
        return $apps;	
	
	}
	
	
	function changePaymentStatus($trid,$txnid,$hostid)
	{
	    $conn = ConnectionManager::getConnection();
		
		$sql = "update tbl_transaction set  payment_status  = '1' , vivapath_payment_status = '6' , txnid= '$txnid' where host = '$hostid' and id = '$trid' ";
		
		$result = $conn->query($sql);
		$conn->close();
       
	  
	}
	
	
	function changePaymentTxnFailedApplication($trid,$txnid,$hostid)
	{
	    $conn = ConnectionManager::getConnection();
		
		$sql = "update tbl_transaction set  payment_status  = '2' , vivapath_payment_status = '5' , txnid= '$txnid' where host = '$hostid' and id = '$trid' ";
		
		$result = $conn->query($sql);
		$conn->close();
        
	  
	}
	
	
	
	function get_application_form_admin()
	{
	   $conn = ConnectionManager::getConnection();
        $apps = array();
          $sql = "SELECT ta.*,tt.*,ta.id as appid,tt.id as tid
		        FROM 
		 tbl_applications as ta inner join  tbl_transaction as tt on  tt.fk_application_id = ta.id 
		 WHERE ta.fk_user = '".$_SESSION['VuserID']."' and ta.isAdmin = '1' ";
	
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc())
			{
                $app = $row;
                array_push($apps, $app);
			}
            
        }
        $conn->close();
        return $apps;
	
	}
	
	
	function check_appication_form($id,$tid)
	{
	   $conn = ConnectionManager::getConnection();
        $apps = false;
          $sql = "SELECT ta.*,tt.*,ta.id as appid,tt.id as tid
		        FROM 
		 tbl_applications as ta inner join  tbl_transaction as tt on  tt.fk_application_id = ta.id 
		 WHERE ta.fk_user = '".$_SESSION['userID']."' and ta.id ='$id' and tt.id = '$tid'";
	
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
           
            $apps= true;
        }
        $conn->close();
        return $apps;
	
	}
	
	
	
	function get_allapplications_form()
	{
	   $conn = ConnectionManager::getConnection();
        $apps = array();
        $sql = "SELECT ta.*,tt.*,ta.id as appid,tt.id as tid
		        FROM 
		 tbl_applications as ta inner join  tbl_transaction as tt on  tt.fk_application_id = ta.id ";
	
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc())
			{
                $app = $row;
                array_push($apps, $app);
			}
            
        }
        $conn->close();
        return $apps;
	
	}
	
	function viva_application_data($id)
	{
	   $conn = ConnectionManager::getConnection();
        $app = false;
         $sql = "SELECT ta.*,tt.*,ta.id as appid,tt.id as tid
		        FROM 
		 tbl_applications as ta inner join  tbl_transaction as tt on  tt.fk_application_id = ta.id  where ta.id = '$id'";
	
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc())
			{
                $app = $row;
               
			}
            
        }
        $conn->close();
        return $app;
	
	
	}
	
	
	
	
	
	
	function application_data($id)
	{
	  $conn = ConnectionManager::getConnection();
        $app = false;
        $sql = "SELECT ta.*,tt.*,ta.id as appid,tt.id as tid
		        FROM 
		 tbl_applications as ta inner join  tbl_transaction as tt on  tt.fk_application_id = ta.id  where ta.id = '$id' and ta.fk_user= '".$_SESSION['userID']."'";
	
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc())
			{
                $app = $row;
                
			}
            
        }
        $conn->close();
        return $app;
	
	
	}
	

	
	
	function count_application1()
	{
	  $conn = ConnectionManager::getConnection();
	  $sql = "select count(id) as myapp from tbl_user_commission where deletestatus = '1'  and host = '".$_SESSION['userID']."'";
	  $result= $conn->query($sql);
	  $row = $result->fetch_assoc();
	  $myapp = $row['myapp'];
	
	  $conn->close();
	  return $myapp;
	
	}
	
	
	
	function count_availabel_form()
	{
		$conn = ConnectionManager::getConnection();
		
		
		 $sql = "select count(id) as totalcashform from tbl_transaction where vivapath_payment_status ='6' and deletstatus = '1' and payment_status = '1' and host = '".$_SESSION['userID']."' and isAdmin = '0' and transaction_type = 'cash' ";
		
		
		
	    $result= $conn->query($sql);
	    $row = $result->fetch_assoc();
	    $totalcashform = $row['totalcashform'];
		
		 $sql = "select sum(numForms) as purchaseform from tbl_form_request where id = '".$_SESSION['userID']."'  and payment_status = '1' and vivapath_status = '6' and deletestatus ='1'";
		
		$result= $conn->query($sql);
	    $row = $result->fetch_assoc();
	    $purchaseform = $row['purchaseform'];
		
		$availabelform = $purchaseform - $totalcashform;

		$conn->close();
		return $availabelform;
	}
	
	
	function count_application()
	{
	  $conn = ConnectionManager::getConnection();
	  $sql = "select count(id) as myapp from tbl_transaction where vivapath_payment_status ='6' and deletstatus = '1' and payment_status = '1'";
	  $result= $conn->query($sql);
	  $row = $result->fetch_assoc();
	  $myapp = $row['myapp'];
	  
	  
	  $result= $conn->query($sql);
	  $row = $result->fetch_assoc();
	  $myapp1 = $row['myapp'];
	 
	   $tmyapp = $myapp1;
	  $conn->close();
	  return $tmyapp;
	
	}
	
	
function get_user_application_by_fill($from,$to,$user)
{
	  $conn = ConnectionManager::getConnection();
	  $apps = array();
		
     $cond = "";
	 $condArr = array();	 
	 
	if($from!="" && $to !="")
	{
	$condArr[] = " ta.created_date between '".$from."' and  '".$to."' ";	
	}
	
	if($from!="" && $to =="")
	{
	 $condArr[] = " ta.created_date like '%".$from."%' ";	
	}
	
	
	if($from=="" && $to !="")
	{
	 $condArr[] = " ta.created_date like '%".$to."%' ";	 
	}
	
	if(count($condArr)>0)
	{
	$cond = " and ( ".implode(" and ",$condArr)." )";
	}
	
		
	$sql = "SELECT tt.id as ttid,tt.*,ta.id as taid,ta.*  FROM  tbl_applications as ta inner join tbl_transaction as tt on ta.id = tt.fk_application_id  where  ta.fk_user = '".$user."' and tt.payment_status='1' and tt.vivapath_payment_status = '6' and ta.paymenttype = 'cash'  ".$cond;

	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc())
		{
			$app = $row;
			array_push($apps, $app);
		}
		
	}
	  
	  
	  $conn->close();
	  return $apps;
	
}
	
	
	
}
