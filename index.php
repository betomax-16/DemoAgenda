<?php
  require_once 'Config/Config.php';
  require_once 'Config/Autoload.php';

  define('DS',DIRECTORY_SEPARATOR);
  define('ROOT',realpath(dirname(__FILE__)).DS);
  define('URL','/agendaSOAP/');
  define('ASSETS',URL.'Public'.DS);
  define('ROOTASSETS', ROOT.'Public'.DS);

  //define('URL',$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
  //define('URL',$_SERVER['REQUEST_URI']);

  Config\Autoload::run();
  Config\Enrutador::run(new Config\Request());
?>
