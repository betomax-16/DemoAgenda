<?php namespace Controllers;

  use Modelos\Telefono;
  /**
   *
   */
  class TelefonoController
  {    
    public function eliminar($id){
      Telefono::remover($id);
    }
  }

?>
