<?php  
require_once "conexion.php"; 

header('Access-Control-Allow-Origin: *');

    class Model extends Conexion 
    {     
        public function __construct() 
        { 
            parent::__construct(); 
        } 

        public function get_users($username, $password) 
        { 
            $result = $this->_db->query('SELECT * FROM usuarios 
                                            where username = "'.$username.'" and  password = "'.$password.'" '); 
             
            $users = $result->fetch_all(MYSQLI_ASSOC); 
            return $users; 
        } 


        public function SaveToken($user, $token)
        {
            $result = $this->_db->query('UPDATE usuarios set token = "'.$token.'" where id = "'.$user.'"'); 
        }



        public function get_usersByid($id)
        {
            $result = $this->_db->query('SELECT * FROM usuarios 
                                            where id = "'.$id.'"'); 
             
            $users = $result->fetch_all(MYSQLI_ASSOC); 
            return $users; 
        }


        public function storeEstudent($data)
        {
            $result = $this->_db->query("INSERT INTO `estudiantes`(`nombre`, `edad`) VALUES ('".$data->nombre."','".$data->edad."')");


            $result = $this->_db->query('SELECT * FROM estudiantes order by id desc'); 

            $fila = $result->fetch_all(MYSQLI_ASSOC); 

            if ($result) {
                return $fila[0]["id"];
            }
        }


        public function storeNotas($id_estudiante, $id_curso)
        {
           $result = $this->_db->query("INSERT INTO `notas`(`id_estudiante`, `id_curso`) VALUES ('".$id_estudiante."','".$id_curso."')");
        }



        public function storeCurso($data)
        {
            $result = $this->_db->query("INSERT INTO `cursos` (`nombre`) VALUES ('".$data->nombre."')");

            if ($result) {
                return true;
            }
        }



        public function listCursos()
        {
            $result = $this->_db->query("SELECT * FROM cursos order by id desc");
            $list  = $result->fetch_all(MYSQLI_ASSOC); 
            return $list; 
        }



        public function listEstudent()
        {
            $result = $this->_db->query("SELECT estudiantes.*, notas.*, cursos.nombre as name_curso FROM estudiantes, notas, cursos
                                        where notas.id_estudiante = estudiantes.id
                                        and cursos.id = notas.id_curso order by estudiantes.id desc
                                ");

            $list  = $result->fetch_all(MYSQLI_ASSOC); 
            return $list; 
        }


        public function listEstudentById($id)
        {
           $result = $this->_db->query("SELECT estudiantes.*, notas.*, cursos.nombre as name_curso FROM estudiantes, notas, cursos
                                        where notas.id_estudiante = estudiantes.id
                                        and cursos.id = notas.id_curso and estudiantes.id = '".$id."'
                                ");

            $list  = $result->fetch_all(MYSQLI_ASSOC); 
            return $list; 
        }


        public function listCurso($id)
        {
            $result = $this->_db->query("SELECT * FROM cursos where id =  '".$id."'");
            $row = $result->fetch_all(MYSQLI_ASSOC); 
            return $row; 
        }



        public function UpdateCurso($data, $id)
        {
            $result = $this->_db->query('UPDATE cursos set nombre = "'.$data->nombre.'" where id = "'.$id.'"'); 
            
            return $result; 
        }



        public function UpdateEstudent($data, $id)
        {
            $result = $this->_db->query('UPDATE estudiantes set nombre = "'.$data->nombre.'", edad = "'.$data->edad.'" where id = "'.$id.'"'); 
            
            return $result; 
        }



        public function UpdateEstudentCurso($id_curso, $id)
        {
            $result = $this->_db->query('UPDATE notas set id_curso = "'.$id_curso.'" where id_estudiante = "'.$id.'"'); 
            
            return $result; 
        }






        public function deleteCurso($id)
        {
            $result = $this->_db->query('DELETE FROM cursos where id = "'.$id.'"'); 
            
            return $result; 
        }



        public function deleteEstdent($id)
        {
            $result = $this->_db->query('DELETE FROM estudiantes where id = "'.$id.'"'); 
            
            return $result; 
        }



        public function UpdateNotas($data)
        {
            $result = $this->_db->query('UPDATE notas set nombre_evaluacion = "'.$data->nombre_evaluacion.'",
                                         calificacion =  "'.$data->calificacion.'" where id_estudiante = "'.$data->id_estudiante.'"

                                        and id_curso = "'.$data->id_curso.'"
                                        '); 
            
            return $result; 
        }



        public function getCsv()
        {
            $result = $this->_db->query("SELECT estudiantes.*, notas.*, cursos.nombre as name_curso FROM estudiantes, notas, cursos
                                        where notas.id_estudiante = estudiantes.id
                                        and cursos.id = notas.id_curso 

                                        and notas.calificacion > 3.5
        
                                        order by estudiantes.id desc
                                ");

            $list  = $result->fetch_all(MYSQLI_ASSOC); 
            return $list; 
        }


    } 
?>