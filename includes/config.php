<?php
//ob_start();
session_start();
session_regenerate_id();

//set timezone


//load classes as needed

function __autoload($class) {
   
   $class = strtolower($class);

	//if call from within assets adjust the path
   $classpath = 'classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	} 	
	
	//if call from within admin adjust the path
   $classpath = '../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	}
	
	//if call from within admin adjust the path
   $classpath = '../../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	} 		
	 
}

  //require_once('classes/class.database.php');
   //database credentials
   $username = 'root';
   $password = '';
   $host = 'localhost';
   $dbname = 'exo_jamb';
   $options = array();

   try{
      $db = new Database($username, $password, $host, $dbname, $options);
   } catch (PDOException $e){
      die("Error! Connection failed.<br/>");
   }catch(Exception $e){
      die("General error! Failed to connect to server.<br/>");
   }

?>