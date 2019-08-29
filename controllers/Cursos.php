<?php 
	/**
	 * LOGN
	 */

    header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	header('content-type: application/json; charset=utf-8');

	require_once "./Model.php";  
	class Cursos  extends Conexion 
	{

		public function __construct() 
        { 
            parent::__construct(); 
           
        } 

		public  function postCreate()
		{

			$model = new Model(); 

			$JSONData   = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);


            $insert = $model->storeCurso($dataObject);

            if ($insert) {
            	echo  json_encode(["success" => true, "data" => array("Registro Exitoso")]);
            }else{
            	echo  json_encode(["success" => false, "error" => array("A ocurrido un error")]);
            }
            
		}


		public function getList()
		{
			$model = new Model(); 
			$data  = $model->listCursos();

			echo json_encode(["success" => true, "data" => $data]);
		}


		public function getcurso($id)
		{
			$model = new Model(); 
			$data  = $model->listCurso($id);

			if ($data) {
				echo json_encode(["success" => true, "data" => $data[0]]);
			}else{
				echo json_encode(["success" => false, "error" => "No se encontro"]);
			}

		}



		public function edit($id)
		{
			$model = new Model(); 

			$JSONData   = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

          
            $update = $model->UpdateCurso($dataObject, $id);

            if ($update) {
            	echo  json_encode(["success" => true, "data" => array("Operacion Exitosa")]);
            }else{
            	echo  json_encode(["success" => false, "error" => array("A ocurrido un error")]);
            }
		}



		public function delete($id)
		{
			$model = new Model(); 

			$JSONData   = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

          
            $update = $model->deleteCurso($id);

            if ($update) {
            	echo  json_encode(["success" => true, "data" => array("Operacion Exitosa")]);
            }else{
            	echo  json_encode(["success" => false, "error" => array("A ocurrido un error")]);
            }
		}


	}
 ?>