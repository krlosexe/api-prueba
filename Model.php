<?php  
require_once "conexion.php"; 

header('Access-Control-Allow-Origin: *');

    class Model extends Conexion 
    {     
        public function __construct() 
        { 
            parent::__construct(); 
        } 

        public function get_users() 
        { 
            $result = $this->_db->query('SELECT * FROM usuarios'); 
             
            $users = $result->fetch_all(MYSQLI_ASSOC); 
             
            return $users; 
        } 
    } 
?>