<?php namespace Modelos;
  /**
   *
   */
  class Conexion
  {
    private $host = DBHOST;
    private $database = DBNAME;
    private $user = DBUSER;
    private $pass = DBPASS;
    private $conn;

    function __construct()
    {
      $this->conn = new \mysqli($this->host, $this->user, $this->pass, $this->database);
    }

    public function __get($property){
        if(property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function ejecutarConsulta($sql, $types = null, $params = null)
    {
      $stmt = $this->conn->prepare($sql);
      if ($stmt) {
        if ($types && $params) {
            $bind_names[] = $types;
            for ($i=0; $i<count($params); $i++)
            {
              $bind_name = 'bind' . $i;
              $$bind_name = $params[$i];
              $bind_names[] = &$$bind_name;
            }
            call_user_func_array(array($stmt, 'bind_param'), $bind_names);
        }
        $stmt->execute();
        $meta = $stmt->result_metadata();

        if ($meta) {
          while ($field = $meta->fetch_field()) {
            $var = $field->name;
            $$var = null;
            $parameters[$field->name] = &$$var;
          }

          call_user_func_array([$stmt, 'bind_result'], $parameters);
          $datos = [];
          while($stmt->fetch())
          {
              $datos[] = array_flip(array_flip($parameters));
          }
          $stmt->close();          
          return $datos;
        }

        $stmt->close();
        //http://stackoverflow.com/questions/5100046/how-to-bind-mysqli-bind-param-arguments-dynamically-in-php
        //print_r($output->get_result($sql, 'ss',array('1','Tk')));
      }
    }

  }

?>
