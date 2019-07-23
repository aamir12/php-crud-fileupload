<?php
 include_once "config.php" ;
 include_once BASE_DIR."/modals/ContactModal.php";
 $ContactModal = new ContactModal();
 $thispage = MAIN_URL."index.php";
 $data = array();
 $action="add";

if(isset($_POST['submit']))
{  

   $data = escapemydata($_POST,'hobbies');
   unset($data['action']);
   unset($data['submit']);
   unset($data['singleimage']);
   
   $data['hobbies'] = isset($data['hobbies'])?implode(',', $data['hobbies']):'';
   $data['active'] = isset($data['active'])?$data['active']:0;
  

   if($_POST['action']=="add")
   {
      unset($data['id']); 
      
      $option = array(
         'extension' => array('jpg','png','jpeg'),
         'sizeLimit' => array(1000000,'1mb'),
         'path' => 'uploads/'
      );

       
      

      $imageStatus = uploadSingleFile($_FILES["image"],$option);
      //printerror($imageStatus);
      if($imageStatus['status']){
        $data['image'] = $imageStatus['fileName'];
         // multiple image upload
         
          $imageArray = array();
          $hasUploadError = false;
          $multiImage =  isset($_FILES['multiImage']['name'])?$_FILES['multiImage']['name']:array();
          $cc = count($multiImage);
          if( $cc>0){
               $images = $_FILES['multiImage'];
               for($i=0;$i< $cc ; $i++ ){
                  $file = array(
                    'name' => $images['name'][$i],
                    'type' => $images['type'][$i],
                    'tmp_name' => $images['tmp_name'][$i],
                    'error' => $images['error'][$i],
                    'size' => $images['size'][$i]
                  );

                 $img =   uploadSingleFile($file,$option);
                 if($img['status']){              
                   array_push($imageArray, $img['fileName']);
                 }else{
                   array_push($imageArray,$imageStatus['fileName']);
                   $hasUploadError = true;
                   break;
                 }
               }

          }
          
              
          if($hasUploadError){
            unlinkFiles($imageArray,$option['path']);
            setmessage('danger','Invalid File');
          }else{             
              // end of multiple image upload
              $ContactModal->add($data);
              setmessage('success','Contact Add Successfully');
          }

          //$ContactModal->add($data);
          //setmessage('success','Contact Add Successfully');
         
      }else{
        setmessage('danger','Invalid File');
      }
 

     
   }else 
   if($_POST['action']=="update")
   { $id = $data['id'];
     unset($data['id']);
     $ContactModal->update($data,$id);       
     setmessage('success','Contact Update Successfully');
     
   } 


     Url::redirect($thispage);
    
}



 if(isset($_GET['action']) && $_GET['action'] =="Delete")
 {
    $id = !empty($_GET['id'])?$_GET['id']:'';
    $data = $ContactModal->delete($id);
    setmessage('success','Contact Delete Successfully');
  
    Url::redirect($thispage);
    
 }

 if(isset($_GET['action']) && $_GET['action'] =="Edit")
 {
    $id = !empty($_GET['id'])?$_GET['id']:'';
    $data = $ContactModal->getrow($id);

    if($data==false)
    {
       Url::redirect($thispage);
    }
    $data['hobbies'] = explode(',', $data['hobbies']);


    $action="update";  
 }

 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Crud Operation Using Opps</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" >
  <link rel="stylesheet" href="<?php echo MAIN_URL;?>assets/css/style.css">
</head>
<body>


  
<div class="container">
  
  <div class="box">

   <?php
    if(isset($_GET['action']) && ($_GET['action']=="Add" || $_GET['action']=="Edit"))
    {
    ?>

   <div class="row">
     <div class="col-md-8"><h4><?php echo $_GET['action']?> Contact</h4></div>
     <div class="col-md-4 text-right"><a href="<?php echo $thispage;?>" class="btn btn-sm btn-info"> All Contact</a></div>
   </div>

   <div class="row">
     <div class="col-md-12">
       
   <form method="post" action="" enctype="multipart/form-data">
    <div class="form-group">
      <label for="firstname">FirstName</label>
      <input type="text" name="firstname"  id="firstname"  class="form-control" required value="<?php setInput($data,'firstname','input') ?>">
    </div>
    
    <div class="form-group">
      <label for="lastname">LastName</label>
      <input type="text" name="lastname"  id="lastname"  class="form-control" required value="<?php setInput($data,'lastname','input') ?>">
    </div>
    

    <div class="form-group">
      <label for="email">Email</label>
      <input type="text" name="email"  id="email" class="form-control" rquired value="<?php setInput($data,'email','input') ?>">
    </div>

    <div class="form-group">
      <label for="mobile">Mobile</label>
      <input type="text" name="mobile"  id="mobile" class="form-control" rquired value="<?php setInput($data,'mobile','input') ?>">
    </div>


    <div class="form-group">
      <label for="mobile">Gender</label>
      <select name="gender" id="gender" class="form-control" required="">
        <option value="">Select Gender</option>
        <option value="Male" <?php setInput($data,'gender',"select",'Male') ?> >Male</option>
        <option value="Female" <?php setInput($data,'gender',"select",'Female') ?>>Female</option>
      </select>
     
    </div>


    <div class="checkbox">
      <label>
        <input 
        type="checkbox" 
        name="hobbies[]" 
        value="cricket" 
        <?php setInput($data,'hobbies',"checkbox",'cricket') ?>>
        Cricket
      </label>
      <label><input 
        type="checkbox" 
        name="hobbies[]" 
        value="football"
        <?php setInput($data,'hobbies',"checkbox",'football') ?>>
        Football
      </label>
    </div>


  
    

    <div class="form-group">
      <label for="">Address</label>
      <textarea name="address" class="form-control" required><?php setInput($data,'address','input') ?></textarea>
    </div>

    <div class="checkbox">
      <label>
        <input 
        type="checkbox" 
        name="active" 
        value="1" 
        <?php setInput($data,'active',"checkbox",1) ?>>
        Enable Profile
      </label>   
    </div>



   <div class="form-group">
    <label for="">Single File</label>
    <input type="file" name="image" class="form-control">
   </div>

    <div class="form-group">
    <label for="">Multiple File</label>
     <input type="file" name="multiImage[]" class="form-control" multiple="multiple" >
   </div>



    <input type="hidden" name="id" value="<?php setInput($data,'id','input') ?>">
    <input type="hidden" name="singleimage" value="<?php setInput($data,'image','input') ?>">
    <input type="hidden" name="action" value="<?php echo $action ;?>">
    <input type="submit" class="btn btn-sm btn-success" value="Submit" name="submit" >
    
   </form>

     </div>
   </div>

   <?php
    }else 
    {
      ?>





  <div class="row">
    
    <div class="col-md-8">
     <h4>List of Contacts</h4>    
    </div>
    <div class="col-md-4 text-right">
      <a href="<?php echo $thispage.'?action=Add';?>" class="btn btn-sm btn-primary">Add</a>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <?php 
      getmessage();
      ?>
      <div class="table-responsive">
        
      <table class="table table-condensed table-bordered">
        <tr>
          <th>FirstName</th>
          <th>LastName</th>
          <th>Email</th>
          <th>Mobile</th>
          <th>Address</th>
          <th>Action</th>
        </tr>
       <?php
        $contacts = $ContactModal->allcontact();
        if($contacts)
        {

        foreach($contacts as $contact)
         {
          ?>

        <tr>
          <td><?php echo $contact['firstname'] ;?></td>
          <td><?php echo $contact['lastname'] ;?></td>
          <td><?php echo $contact['email'] ;?></td>
          <td><?php echo $contact['mobile'] ;?></td>
          <td><?php echo $contact['address'] ;?></td>
          <td>            

            <a href="<?php echo $thispage.'?action=Edit&id='.$contact['id']?>" class="btn btn-sm btn-info">
              Edit
            </a>

            <a href="<?php echo $thispage.'?action=Delete&id='.$contact['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this record ?');">
              Delete
            </a>
            
        </td>
        </tr>

          <?php
         }  
        } 
       ?>
      </table>
      
      </div>


     <h2 class="text-center"><span class="text-success">Crud</span> operation in <span class="text-danger">1 minute</span></h2>
     <h1 class="text-center"><span class="text-info">Codexking.com</span></h1>

    </div>  


  </div>

   <?php
    }
   ?>

  </div>


</div>

</body>

 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</html>
