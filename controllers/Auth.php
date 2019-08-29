<?php 
	/**
	 * LOGN
	 */

    header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	header('content-type: application/json; charset=utf-8');

	require_once "./Model.php";  
	class Auth  extends Conexion 
	{

		public function __construct() 
        { 
            parent::__construct(); 
           
        } 

		public  function getUser($id)
		{
			if ($id == "null") {
				echo  json_encode(["success" => false, "error" => array("token" => "111")]);
				return false;
			}
			$usuarioModel = new Model(); 
			$user = $usuarioModel->get_usersByid($id);

			echo  json_encode(["success" => true, "data" => array("token" => $user[0]["token"])]);
		}


		public  function postUser()
		{
			
			$usuarioModel = new Model(); 
			$JSONData   = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

		    $user = $usuarioModel->get_users($dataObject->username, $dataObject->password);

		    if ($user) {
		    	$cadena = rand(5, 15);

		    	self::saveToken($user[0]["id"], md5($cadena));

				echo  json_encode(["success" => true, "message" => array("token" => md5($cadena), "id_user" => $user[0]["id"])]);
		    }else{
		    	echo  json_encode(["success" => false, "error" => array("Usuario y/o Clave invalida")]);
		    }
		}



		public function saveToken($id_user, $token)
		{
			$usuarioModel = new Model(); 
			$usuarioModel->SaveToken($id_user, $token);
		}

	}
 ?>