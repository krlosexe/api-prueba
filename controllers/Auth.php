<?php 
	/**
	 * LOGN
	 */

	require_once "./Model.php";  
	class Auth  extends Conexion 
	{

		public function __construct() 
        { 
            parent::__construct(); 
        } 

		public static function getUser()
		{

			echo  json_encode(["success" => true, "data" => $_GET["nombre"]]);
		}


		public static function postUser()
		{

			$usuarioModel = new Model(); 
		    $a_users = $usuarioModel->get_users();


		    header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
			header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
			header('content-type: application/json; charset=utf-8');


			$JSONData = file_get_contents("php://input");
             $dataObject = json_decode($JSONData);

			echo  json_encode(["success" => true, "data" => "asdasd"]);
		}

	}
 ?>