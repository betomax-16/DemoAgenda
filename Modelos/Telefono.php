<?php namespace Modelos;

    class Telefono{
        private $telefono;
        private $descripcion;
        private $idTel;
        private $idContacto;
        private $conex;

        function __construct(){
         $this->conex = new Conexion();
         //obtengo un array con los parámetros enviados a la función
         $params = func_get_args();
         //saco el número de parámetros que estoy recibiendo
         $num_params = func_num_args();
         //cada constructor de un número dado de parámtros tendrá un nombre de función
         //atendiendo al siguiente modelo __construct1() __construct2()...
         $funcion_constructor ='__construct'.$num_params;
         //compruebo si hay un constructor con ese número de parámetros
         if (method_exists($this,$funcion_constructor)) {
           //si existía esa función, la invoco, reenviando los parámetros que recibí en el constructor original
           call_user_func_array(array($this,$funcion_constructor),$params);
         }
        }

        //ahora declaro una serie de métodos constructores que aceptan diversos números de parámetros
      	function __construct2($telefono, $descripcion){
          $this->telefono = $telefono;
          $this->descripcion = $descripcion;
      	}

        function __construct4($id, $idContacto, $telefono, $descripcion){
          $this->idTel = $id;
          $this->idContacto = $idContacto;
          $this->telefono = $telefono;
          $this->descripcion = $descripcion;
      	}

        public function __get($property){
            if(property_exists($this, $property)) {
                return $this->$property;
            }
        }

        public function __set($property, $value){
            if(property_exists($this, $property)) {
                $this->$property = $value;
            }
        }

        public function agregar($idContacto){
            if ($this->conex->conn->connect_errno) {
                echo "Error: Fallo al conectarse a MySQL debido a: \n";
                echo "Errno: " . $this->conex->conn->connect_errno . "\n";
                echo "Error: " . $this->conex->conn->connect_error . "\n";
                exit;
            }
            else{
                $sql = 'INSERT INTO telefonos (id_Contacto,telefono,descripcion) VALUES (?, ?, ?)';
                $parametros = [$idContacto,$this->telefono,$this->descripcion];
                $this->conex->ejecutarConsulta($sql, 'iss', $parametros);
                $this->idTel = mysqli_insert_id($this->conex->conn);
                $this->idContacto = $idContacto;
            }
        }

        public function actualizar(){
          if ($this->conex->conn->connect_errno) {
              echo "Error: Fallo al conectarse a MySQL debido a: \n";
              echo "Errno: " . $this->conex->conn->connect_errno . "\n";
              echo "Error: " . $this->conex->conn->connect_error . "\n";
              exit;
          }
          else{
            $sql = 'UPDATE telefonos SET telefono = ? ,descripcion = ? WHERE id = ?';
            $parametros = [$this->telefono,$this->descripcion,$this->idTel];
            $this->conex->ejecutarConsulta($sql, 'ssi', $parametros);
          }
        }

        public function eliminar(){
          if ($this->conex->conn->connect_errno) {
           echo "Error: Fallo al conectarse a MySQL debido a: \n";
           echo "Errno: " . $this->conex->conn->connect_errno . "\n";
           echo "Error: " . $this->conex->conn->connect_error . "\n";
           exit;
          }
          else{
            $sql = 'DELETE FROM telefonos WHERE id = ?';
            $parametros = [$this->idTel];
            $this->conex->ejecutarConsulta($sql, 'i', $parametros);
          }
        }

        static function telefonos($idContacto){
          $conexion = new Conexion();
          if ($conexion->conn->connect_errno) {
             echo "Error: Fallo al conectarse a MySQL debido a: \n";
             echo "Errno: " . $conexion->conn->connect_errno . "\n";
             echo "Error: " . $conexion->conn->connect_error . "\n";
             exit;
           }
           else{
             $telefonos = [];
             $sql = "SELECT * FROM telefonos WHERE id_Contacto = ?";
             if ($datos = $conexion->ejecutarConsulta($sql, 'i', [$idContacto])) {
               for ($i=0; $i < count($datos); $i++) {
                 $telefonos[] = new Telefono($datos[$i]['id'], $datos[$i]['id_Contacto'], $datos[$i]['telefono'], $datos[$i]['descripcion']);
               }
             }
             return $telefonos;
           }
        }

        static function remover($idTel)
        {
          $conexion = new Conexion();
          if ($conexion->conn->connect_errno) {
             echo "Error: Fallo al conectarse a MySQL debido a: \n";
             echo "Errno: " . $conexion->conn->connect_errno . "\n";
             echo "Error: " . $conexion->conn->connect_error . "\n";
             exit;
           }
           else{
             $sql = 'DELETE FROM telefonos WHERE id = ?';
             $parametros = [$idTel];
             $conexion->ejecutarConsulta($sql, 'i', $parametros);
           }
        }
    }
?>
