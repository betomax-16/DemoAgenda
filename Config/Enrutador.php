<?php namespace Config;

  /**
   *
   */
  class Enrutador
  {
    private static function anyParameterIsRequest($class, $method)
    {
      $clase = new \ReflectionClass($class);
      $metodo = $clase->getMethod($method);
      $reflectionParams = $metodo->getParameters();
      $bandera = false;
      for ($i=0; $i <count($reflectionParams); $i++) {
        $result = preg_match('/[>] ([A-z]+) /', $reflectionParams[$i], $matches) ? $matches[1] : null;
        if ($result != null && $result == 'Config\Request') {
          $bandera = true;
          break;
        }
      }
      return $bandera;
    }

    public static function run(Request $request)
    {
      $controlador = $request->getControlador().'Controller';
      $ruta = ROOT.'Controllers'.DS.$controlador.'.php';
      $metodo = $request->getMetodo();
      if ($metodo == 'index.php') {
        $metodo = 'index';
      }
      $argumento = $request->getArgumento();
      if (is_readable($ruta)) {
        $mostrar = 'Controllers\\'.$controlador;
        $controlador = new $mostrar;
        if (!isset($argumento)) {
          if (self::anyParameterIsRequest($controlador, $metodo)) {
            call_user_func_array([$controlador, $metodo],[new Request()]);
          }
          else {
            call_user_func_array([$controlador, $metodo],[]);
          }
        }
        else {                  
          if (self::anyParameterIsRequest($controlador, $metodo)) {
            $argumento[] = new Request();
            call_user_func_array([$controlador, $metodo],$argumento);
          }
          else {
            call_user_func_array([$controlador, $metodo], $argumento);
          }
        }
      }
      else {
        echo $ruta.' no exite;';
        exit;
      }
    }
  }

?>
