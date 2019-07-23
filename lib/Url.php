<?php



class Url{

    public static function redirect($location){
        header("Location: ".$location);
        die();
    }

   public static function refreshme(){
    header("Refresh:0");
    die();
    }

	

}