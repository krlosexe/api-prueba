<?php 
	/**
	 * LOGN
	 */

    header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	header('content-type: application/json; charset=utf-8');

	require_once "./Model.php";  
	class Notas  extends Conexion 
	{

		public function __construct() 
        { 
            parent::__construct(); 
           
        } 

		public function edit($id)
		{
			$model = new Model(); 

			$JSONData   = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);



            $update = $model->UpdateNotas($dataObject);

            if ($update) {
            	echo  json_encode(["success" => true, "data" => array("Operacion Exitosa")]);
            }else{
            	echo  json_encode(["success" => false, "error" => array("A ocurrido un error")]);
            }
		}


	}
 ?>