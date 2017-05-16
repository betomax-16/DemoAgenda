<?php namespace Config;

  /**
   *
   */
  class View
  {
    private function obtenerExtends($texto)
    {
      $pos = strpos($texto, '{{extends:')+strlen('{{extends:');
      if ($pos) {
        for ($i=$pos; $i < strlen($texto); $i++) {
          if($texto[$i] == '}'){
            $posFin = $i;
            break;
          }
        }
        return substr($texto, $pos, $posFin-$pos);
      }
      return false;
    }

    private function obtenerContenido($texto, $tagIni, $tagFin)
    {
      if (strpos($texto, $tagIni)) {
        $ini = strpos($texto, $tagIni)+strlen($tagIni);
        $fin = strpos($texto, $tagFin);
        $aux = substr($texto, $ini, $fin-$ini);
        return str_replace($tagFin, '', $aux);
      }
      return '';
    }

    function __construct($file, $params=NULL)
    {
      $ruta = ROOT.'Vistas'.DS.$file.'.php';
      if (is_readable($ruta)) {
        ob_start();
        require_once $ruta;
        $str = ob_get_contents();
        $extends = $this->obtenerExtends($str).'.php';
        $styles = $this->obtenerContenido($str, '{{styles}}', '{{stylesEnd}}');
        $scripts = $this->obtenerContenido($str, '{{scripts}}', '{{scriptsEnd}}');
        $body = $this->obtenerContenido($str, '{{body}}', '{{bodyEnd}}');
        ob_end_clean();
        if ($extends != '.php') {
          ob_start();
          require_once ROOT.'Vistas'.DS.$extends;
          $template = ob_get_contents();
          $str = str_replace('{{body}}', $body, $template);
          $str = str_replace('{{styles}}', $styles, $str);
          $str = str_replace('{{scripts}}', $scripts, $str);
          ob_end_clean();
        }
        echo $str;
      }
      else {
        echo $ruta.' no exite;';
        exit;
      }
    }
  }

?>
