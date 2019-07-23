<?php
//error_reporting(0);
session_start();
require_once 'lib/Database.php';
require_once 'lib/Url.php';
require_once 'lib/Pagination.php';
require_once 'lib/functions.php';


define('BASE_DIR', dirname(__FILE__));


/************Define URL Constant*****/

define("ADMIN_URL","http://localhost/mycrud/admin/");
define("MAIN_URL","http://localhost/mycrud/");

/**********end of url************/

/****Database Configuration*****/

define('DB_HOST', 'localhost');
define('DB_NAME', 'mycrud');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

/****end of database configuration****/




 

?>