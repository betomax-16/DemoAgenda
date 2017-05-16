<?php namespace Controllers;

  use Config\View;
  use Config\Request;
  use Modelos\Contacto;
  use Modelos\Telefono;
  /**
   *
   */
  class ContactoController
  {
    public function index(){
      $contactos = Contacto::contactos();
      new View('contacto/index', ['contactos' => $contactos]);
    }    

    public function agregar(){
      new View('contacto/agregarContacto');
    }

    public function guardar(Request $request){
      $nuevosTelefonos = [];

      for ($i=0; $i < count($_POST['telefonosN']); $i++) {
        $tel = $request->telefonosN[$i];
        $des = $request->descripcionesN[$i];
        $nuevosTelefonos[] = new Telefono($tel, $des);
      }

      $c = new Contacto($request->nombre, $request->direccion, $request->email, $request->foto);
      foreach ($nuevosTelefonos as $telfono) {
        $c->agregarTelefono($telfono);
      }
      $c->guardar();
    }

    public function editar($id){
      $contacto = Contacto::buscar($id);
      new View('contacto/editarContacto',['contacto' => $contacto]);
    }

    public function actualizar(Request $request){
      $nuevosTelefonos = [];
      for ($i=0; $i < count($request->telefonosN); $i++) {
        $tel = $request->telefonosN[$i];
        $des = $request->descripcionesN[$i];
        array_push($nuevosTelefonos, new Telefono($tel, $des));
      }

      $contacto = Contacto::buscar($request->id);
      foreach ($nuevosTelefonos as $telefono) {
        $contacto->agregarTelefono($telefono);
      }
      $contacto->nombre = $request->nombre;
      $contacto->direccion = $request->direccion;
      $contacto->email = $request->email;
      $contacto->foto = $request->foto;
      $telefonos = $contacto->telefonos;

      for ($i=0; $i < count($request->idsE); $i++) {
        $tel = $request->telefonosE[$i];
        $des = $request->descripcionesE[$i];
        $idTel = $request->idsE[$i];
        foreach ($telefonos as $telefono) {
          if ($telefono->idTel == $idTel) {
            $telefono->telefono = $tel;
            $telefono->descripcion = $des;
          }
        }
      }
      $contacto->actualizar();

      //$contactos = Contacto::contactos();
      //new View('contacto/index', ['contactos' => $contactos]);
      //header('Location: http://localhost:8080/agenda/index.php');
    }

    public function eliminar($id){
      $c = Contacto::buscar($id);
      $c->eliminar();
    }
  }


?>
