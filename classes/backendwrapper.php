<?php

require_once("corecfg.php");
require_once("backend.php");

class backendWrapper {

  function __construct() {

    //fetch current backend config  
    $current_conf = getActiveCfg();
    $this->backend = new backend();
    $this->backend->id = $current_conf->backend_id;
    $this->backend->load();
    $this->backend_params = array( 'host' => $current_conf->backend_host,
                                   'port' => $current_conf->backend_port,
                                   'username' => $current_conf->backend_username,
                                   'password' => $current_conf->backend_password,
                                   'database' => $current_conf->backend_db );

    //loads influxdb requirements and initializes handlers.
    if ($this->backend->module_name == "influxdbbe") {
      require_once("BaseHTTP.php");
      require_once("DB.php");
      require_once("Cursor.php");
      require_once("Client.php");

      $this->client = new \crodas\InfluxPHP\Client($this->backend_params['host'],
                                                   $this->backend_params['port'],
                                                   $this->backend_params['username'],
                                                   $this->backend_params['password']);

      $this->dbh = $this->client->getDatabase($this->backend_params['database']);

    } 

  }

  function query($indice_name,$tinf,$tsup) {
    if ($this->backend->module_name == "influxdbbe") {
      return influx_query($indice_name,$tinf,$tsup);
    }
  }
 
  function influx_query($indice_name,$tinf,$tsup) {

  }

}


?>