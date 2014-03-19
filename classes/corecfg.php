<?php

require_once('adamobject.php');

class corecfg  extends adamobject {

	function __construct() {

	}

  function getBroker() {

     require_once('brokercfg.php');
     global $dbhandler;

     $dbh = $dbhandler->query("SELECT brokercfg.id as id FROM corecfg, brokercfg WHERE corecfg.id ='" . $this->id . 
                       "' AND corecfg.broker_id = brokercfg.id ;");

     $ans = $dbh->fetch();
     $b = new brokercfg();
     $b->id = $ans['id'];
     $b->load($ans);
     return $b;

  }

  function getBrokerModule() {
  
     global $dbhandler;
     $b = $this->getBroker();
     $dbh = $dbhandler->query("SELECT * FROM broker WHERE id = '" . $b->broker_id . "';");
     $ans = $dbh->fetch();
     return $ans;

  }


  function remap($params) {
      if (!isset($params->id)) {
          $params->created = time();
          $params->updated = $params->created;
          $params->aep_enable = 1;
          $params->aep_listen_port = 9999;
          $params->aep_listen_addr = '127.0.0.1';
      }
      parent::remap($params);
  }

  function save() {
       $values = "";
       if ( isset($this->values) ) {
          $values = $this->values;
          unset($this->values);
       }
       parent::save();
       if ($values != "") {
          $this->saveValues($values);
       }
  }

  function saveValues($values) {

     global $dbhandler;
     $res = $dbhandler->query("DELETE FROM valuecfg_map WHERE config_id = '" . $this->id . "';");
     if (!is_array($values)) {
       $varray = json_decode($values);
     }
     else {
       $varray = $values;
     }

     foreach($varray as $v) {
        $query = sprintf("INSERT INTO valuecfg_map (config_id,indice_id)  VALUES ('%d','%d');", $this->id ,$v);
        $res = $dbhandler->query($query);
     }
  }

  function activate() {
      global $dbhandler;
      $res = $dbhandler->query("UPDATE corecfg SET active = 0;");
      $res = $dbhandler->query("UPDATE corecfg SET active = 1 WHERE id='" . $this->id . "';");
  }


  function delete() {
    global $dbhandler;
    $res = $dbhandler->query("DELETE FROM valuecfg_map WHERE config_id = '" . $this->id . "';");
    parent::delete();
  }

}


function getCoreConfigs() {

  global $dbhandler;
  $cconfs = array();

  $dbh = $dbhandler->query("SELECT id FROM corecfg;");

  while($ans = $dbh->fetch()) {

    $c = new corecfg();
    $c->id = $ans['id'];
    $c->load();
    $cconfs[] = $c;
  }
  return $cconfs;
}


function getActiveCfg() {

   global $dbhandler;
   $dbh = $dbhandler->query("SELECT id FROM corecfg WHERE active = 1;");
   $ans = $dbh->fetch();
   $cfg = new corecfg();
   $cfg->id = $ans['id'];
   $cfg->load();
   return $cfg;
}

function getCfgValues($cfg_id) {
   
   $values = array();
   global $dbhandler;
   $dbh = $dbhandler->query("SELECT indice_id FROM valuecfg_map WHERE config_id = '$cfg_id';");
   while($ans = $dbh->fetch()) {
       $value = new valuecfg();
       $value->id = $ans['indice_id'];
       $value->load();
       $values[] = $value;
   }

  return $values;
}


function exportCfg($cfg_id = null,$strat_id = null,$dest = null,$nr = true) {

  require_once('strategy.php');
  require_once('valuecfg.php');

  global $ADAM_PATH;

  if ($cfg_id == null) {
      $cfg = getActiveCfg();
  }
  else {
     $cfg = new corecfg();
     $cfg->id = $cfg_id;
     $cfg->load();
  }

  if ($strat_id == null) {
      $strat = getActiveStrat();
  }
  else {
     $strat = new strategy();
     $strat->id = $strat_id;
     $strat->load();
  }

  $fh = null;
  if ($dest == null) {
      $fh = fopen($ADAM_PATH . "/etc/adam.conf","w");
  }
  else {
      $fh = fopen($dest,"w");
  }

  $broker = $cfg->getBrokerModule();
  $values = getCfgValues($cfg->id); 
  $exp_stratname = $strat->export();
  //export all found modules
  exportStratModules();

  fwrite($fh,"aep_enable = " . $cfg->aep_enable . "\n");
  fwrite($fh,"aep_listen_addr = " . $cfg->aep_listen_addr . "\n");
  fwrite($fh,"aep_listen_port = " . $cfg->aep_listen_port . "\n\n");

  fwrite($fh, "broker = " . $broker['module_name'] . "\n\n");
  fwrite($fh,"mm_capital = " . $cfg->mm_capital . "\n");

  foreach($values as $value) {

      $valuestr = sprintf("indice = %s %d %d %s %s %s %s\n",
                          $value->name,
                          $value->pnl_pp,
                          $value->min_stop,
                          $value->broker_map,
                          $value->unit,
                          $value->start_hour,
                          $value->end_hour
      );

      fwrite($fh,$valuestr);
  }

  fwrite($fh,"strat = " . $exp_stratname . "\n\n" );
  fwrite($fh,"mm_max_openpos = " . $cfg->mm_max_openpos . "\n");
  fwrite($fh,"mm_max_openpos_per_epic = " . $cfg->mm_max_openpos_per_epic . "\n");
  fwrite($fh,"mm_reverse_pos_lock = " . $cfg->mm_reverse_pos_lock . "\n");
  fwrite($fh,"mm_reverse_pos_force_close = " . $cfg->mm_reverse_pos_force_close. "\n");
  fwrite($fh,"mm_max_loss_percentage_per_trade = " . $cfg->mm_max_loss_percentage_per_trade. "\n");
  fwrite($fh,"mm_critical_loss_percentage = " . $cfg->mm_critical_loss_percentage . "\n");

  fwrite($fh,$cfg->extra . "\n\n");
  fclose($fh);

  
  if ($nr) {
    $fh2 = fopen("/tmp/adam/needs_restart","w");
    fwrite($fh2,"1");
    fclose($fh2);
  }

}

?>