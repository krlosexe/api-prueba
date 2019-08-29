<?php 
	/**
	 * LOGN
	 */

    header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	header('content-type: application/json; charset=utf-8');

	require_once "./Model.php";  
	class Estudent  extends Conexion 
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


            $last_id = $model->storeEstudent($dataObject);

            $model->storeNotas($last_id, $dataObject->curso);


            if ($last_id) {
            	echo  json_encode(["success" => true, "data" => array("Registro Exitoso")]);
            }else{
            	echo  json_encode(["success" => false, "error" => array("A ocurrido un error")]);
            }
            
		}


		public function getList()
		{
			$model = new Model(); 
			$data  = $model->listEstudent();

			echo json_encode(["success" => true, "data" => $data]);
		}


		public function getData($id)
		{
			$model = new Model(); 
			$data  = $model->listEstudentById($id);

			echo json_encode(["success" => true, "data" => $data[0]]);
		}

		public function edit($id)
		{
			$model = new Model(); 

			$JSONData   = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

          	
            $update = $model->UpdateEstudent($dataObject, $id);
            $update = $model->UpdateEstudentCurso($dataObject->id_curso, $id);



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

          
            $update = $model->deleteEstdent($id);

            if ($update) {
            	echo  json_encode(["success" => true, "data" => array("Operacion Exitosa")]);
            }else{
            	echo  json_encode(["success" => false, "error" => array("A ocurrido un error")]);
            }
		}






		public function getCsv()
		{
			$model = new Model(); 
			$data  = $model->getCsv();

			echo json_encode(["success" => true, "data" => $data]);
		}


	}
 ?>