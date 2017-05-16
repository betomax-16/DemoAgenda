<?php namespace Modelos;

class Contacto{

        private $telefonos;
        private $nombre;
        private $direccion;
        private $foto;
        private $fotoAnterior;
        private $email;
        private $id;
        private $conn;

        function __construct(){
          $this->telefonos = [];
          $this->conn = new Conexion();

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

      	function __construct4($nombre, $direccion, $email, $foto){
      		$this->nombre = $nombre;
          $this->direccion = $direccion;
          $this->email = $email;
          $this->foto = $foto;
          $this->fotoAnterior = $foto;
      	}

      	function __construct5($id, $nombre, $direccion, $email, $foto){
          $this->id = $id;
          $this->nombre = $nombre;
          $this->direccion = $direccion;
          $this->email = $email;
          $this->foto = $foto;
          $this->fotoAnterior = $foto;
      	}

        public function __get($property){
            if(property_exists($this, $property)) {
                if ($property == 'telefonos') {
                  $this->telefonos = Telefono::telefonos($this->id);
                }
                return $this->$property;
            }
        }

        public function __set($property, $value){
            if(property_exists($this, $property)) {
                $this->$property = $value;
            }
        }

        public static function contactos(){
          $conexion = new Conexion();
          if ($conexion->conn->connect_errno) {
             echo "Error: Fallo al conectarse a MySQL debido a: \n";
             echo "Errno: " . $conexion->conn->connect_errno . "\n";
             echo "Error: " . $conexion->conn->connect_error . "\n";
             exit;
           }
           else{
             $contactos = [];
             $sql = "SELECT * FROM contactos";
             if ($datos = $conexion->ejecutarConsulta($sql)) {
               for ($i=0; $i < count($datos); $i++) {
                 $contactos[] = new Contacto($datos[$i]['id'], $datos[$i]['nombre'], $datos[$i]['direccion'], $datos[$i]['email'], $datos[$i]['foto']);
               }
             }
             return $contactos;
           }
        }

        static function buscar($idContacto){
          $conexion = new Conexion();
          if ($conexion->conn->connect_errno) {
             echo "Error: Fallo al conectarse a MySQL debido a: \n";
             echo "Errno: " . $conexion->conn->connect_errno . "\n";
             echo "Error: " . $conexion->conn->connect_error . "\n";
             exit;
           }
           else{
             $sql = "SELECT * FROM contactos WHERE id = ?";
             if ($datos = $conexion->ejecutarConsulta($sql, 'i', [$idContacto])) {
               return new Contacto($datos[0]['id'], $datos[0]['nombre'], $datos[0]['direccion'], $datos[0]['email'], $datos[0]['foto']);
             }
           }
        }

        public function guardar(){
          if ($this->conn->conn->connect_errno) {
             echo "Error: Fallo al conectarse a MySQL debido a: \n";
             echo "Errno: " . $this->conn->conn->connect_errno . "\n";
             echo "Error: " . $this->conn->conn->connect_error . "\n";
             exit;
           }
           else{
             $fotoNombre = '';
             if (is_array($this->foto) && $this->foto['error'] == 0) {
               $ext = $this->foto['type'];
               if($ext == 'image/jpeg' || $ext == 'image/jpg' || $ext == 'image/png'){
                   $ext = explode('/',$ext)[1];
               }
               $fotoNombre = md5(date("YmdHis")).'.'.$ext;
             }
             $sql = "INSERT INTO contactos(nombre,direccion,email,foto) VALUES (?, ?, ?, ?)";
             $parametros = [$this->nombre, $this->direccion, $this->email, $fotoNombre];
             $this->conn->ejecutarConsulta($sql, 'ssss', $parametros);
             $this->id = mysqli_insert_id($this->conn->conn);
             foreach($this->telefonos as $tel){
                 $tel->agregar($this->id);
             }
             if (is_array($this->foto) && $this->foto['error'] == 0) {
               copy($this->foto['tmp_name'], ROOTASSETS.'imagenes'.DS.$fotoNombre);
             }             
           }
        }

        public function actualizar(){
          if (isset($this->id)) {
            if ($this->conn->conn->connect_errno) {
               echo "Error: Fallo al conectarse a MySQL debido a: \n";
               echo "Errno: " . $this->conn->conn->connect_errno . "\n";
               echo "Error: " . $this->conn->conn->connect_error . "\n";
               exit;
             }
             else{
               $fotoNombre = $this->foto['error'] != 0 ? $this->fotoAnterior : $this->foto;
               if (is_array($this->foto) && $this->foto['error'] == 0) {
                 $ext = $this->foto['type'];
                 if($ext == 'image/jpeg' || $ext == 'image/jpg' || $ext == 'image/png'){
                     $ext = explode('/',$ext)[1];
                 }
                 $fotoNombre = md5(date("YmdHis")).'.'.$ext;
                 if ($this->foto['name'] != $this->fotoAnterior) {
                   unlink(ROOTASSETS.'imagenes'.DS.$this->fotoAnterior);
                 }
               }
               $sql = 'UPDATE contactos SET nombre = ?, direccion = ?, email = ?, foto = ? WHERE id = ?';
               $parametros = [$this->nombre,$this->direccion,$this->email,$fotoNombre, $this->id];
               $this->conn->ejecutarConsulta($sql, 'ssssi', $parametros);
               foreach($this->telefonos as $tel){
                   $tel->actualizar();
               }
               if (is_array($this->foto) && $this->foto['error'] == 0) {
                 copy($this->foto['tmp_name'], ROOTASSETS."imagenes".DS.$fotoNombre);
                 $this->fotoAnterior = $fotoNombre;
                 $this->foto = $fotoNombre;
               }
             }
          }
        }

        public function agregarTelefono(Telefono $telefono){
          if ($this->id != '') {
            $telefono->agregar($this->id);
          }
          array_push($this->telefonos, $telefono);
        }

        public function eliminar(){
          if ($this->conn->conn->connect_errno) {
             echo "Error: Fallo al conectarse a MySQL debido a: \n";
             echo "Errno: " . $this->conn->conn->connect_errno . "\n";
             echo "Error: " . $this->conn->conn->connect_error . "\n";
             exit;
           }
           else{
             $sql = 'DELETE FROM contactos WHERE id = ?';
             $parametros = [$this->id];
             $this->conn->ejecutarConsulta($sql, 'i', $parametros);
             if ($this->fotoAnterior != '') {
               unlink(ROOTASSETS.'imagenes'.DS.$this->fotoAnterior);
             }
           }
        }
    }
?>
