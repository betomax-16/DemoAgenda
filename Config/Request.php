<?php namespace Config;
  /**
   *
   */
  class Request
  {
    private $controlador;
    private $metodo;
    private $argumento;
    private $controllerDefautl = 'contacto';

    public function __construct()
    {
      if (isset($_GET['url'])) {
        //OBTENCION DEL VALOR QUE CONTIENE LA VARIABLE "URL" DEFINIDA EN EL ARCHIVO
        //.htaccess
        $ruta = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
        $ruta = explode('/', $ruta);
        $ruta = array_filter($ruta);
        //SI LA VARIABLE "URL" NO CONTIENE DATOS, USAR UN CONTROLADOR POR DEFECTO
        //EN ESTE CASO "CONTACTO"
        if (count($ruta) == 0 || $ruta[0] == 'index.php') {
          $this->controlador = $controllerDefautl;
        }
        else {
          $this->controlador = strtolower(array_shift($ruta));
        }
        $this->metodo = strtolower(array_shift($ruta));
        if (!$this->metodo) {
          $this->metodo = 'index';
        }
        $this->argumento = $ruta;
      }
      else {
        $this->controlador = 'contacto';
        $this->metodo = 'index';
      }
    }

    public function __get($property){
        if (isset($_FILES[$property])) {
          return $_FILES[$property];
        }
        if(isset($_POST[$property])) {
            return $_POST[$property];
        }
    }

    public function getControlador()
    {
      return $this->controlador;
    }

    public function getMetodo()
    {
      return $this->metodo;
    }

    public function getArgumento()
    {
      return $this->argumento;
    }
  }

?>
