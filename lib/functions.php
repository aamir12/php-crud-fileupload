<?php 






function setmessage($type,$msg)
{
   if($type=='success')
   {
     $heading = 'Success !';
   }

   if($type=='danger')
   {
     $heading = 'Error !';
   }


   $_SESSION['mymsg'] = '<div class="alert alert-'.$type.' alert-dismissable">
   <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
   <strong>'.$heading.'</strong> '.$msg.'
   </div>'; 


}

function getmessage()
{
    if(isset($_SESSION['mymsg']))
    { 
     echo  $_SESSION['mymsg'];
     unset($_SESSION['mymsg']);
    }
}


function escape($str)
{
    $db =  new Database(); 
    $conn = $db->getConnection();
    $str = trim(mysqli_real_escape_string($conn,$str));
    $conn->close(); 
    return $str;
}
 
function escapemydata($data = array(),$esckey='')
{
   foreach($data as $key => $value)
   {
     if($esckey==$key)
      continue;
     $data[$key] = escape($value);
   }
   return $data;
}

function printerror($data)
{
  echo '<pre>';
  print_r($data);
  echo '</pre>';
   die();
}

                     
function setInput($data,$key,$type,$match=''){
  if(!empty($data[$key])){
 
    $val = $data[$key];
    switch ($type) {
      case 'select':
       echo $val==$match?'selected="selected"':'';
      break;
      case 'checkbox':
         if(is_array($val)){
          echo  in_array($match, $val)?'checked="checked"':'';          
         }else 
         echo  $val==$match?'checked="checked"':'';
       
      break;
      case 'input':
        echo $val;
      break;    
     
    }
      
  }

}


function uploadSingleFile($file,$option){
    
        
      if(array_key_exists('extension', $option)){
          $allowed_image_extension = $option['extension'];
          // Get image file extension
          $file_extension = pathinfo($file["name"], PATHINFO_EXTENSION);

          if (! in_array($file_extension, $allowed_image_extension)) {
            $response = array(
            "status" => false,
            "message" => "Upload only ".implode(',',$option['extension'])." files only."
            );
            return $response;
          }
      }

      if(array_key_exists('sizeLimit', $option)){
        if (($file["size"] > $option['sizeLimit'][0])) {
            $response = array(
            "status" => false,
            "message" => "Image size exceeds ".$option['sizeLimit'][1]
            );
            return $response;
         } 
      }

      if(array_key_exists('dimension', $option)){
         $fileinfo = @getimagesize($file["tmp_name"]);
         $width = $fileinfo[0];
         $height = $fileinfo[1];      
          if ($width > $option['dimension'][0] || $height > $option['dimension'][1]) {
              $response = array(
              "status" => false,
              "message" => "Image dimension should be within ".$option['dimension'][0]."X". $option['dimension'][1]
            );

            return $response;   
          }
      }

       $strDtMix = @date("d").substr((string)microtime(), 2, 8);
       $uploadfile = $strDtMix.".".pathinfo($file["name"], PATHINFO_EXTENSION);

        $target = $option['path'].$uploadfile;

        if (move_uploaded_file($file["tmp_name"], $target)) {
            $response = array(
                "status" => true,
                "fileName" => $uploadfile
            );
        } else {
            $response = array(
                "status" => false,
                "message" => "Problem in uploading image files."
            );
        }

        return $response;
}

function unlinkFiles($files,$path){
  foreach ($files as $file ) {
     unlink($path.$file);
  }
}


?>