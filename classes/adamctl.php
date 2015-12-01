<?php

require_once "corecfg.php";

class adamctl {

  function __construct() {
    $this->supid = 'none';
    $this->mode = 'off';

    $this->supid = $this->getPID();

    if ($this->supid != "none") {
      $this->mode = $this->checkStatus($this->supid);
    }  

  }

  function AEPStartCLient($port_offset=0) {
    global $ADAM_AEP_ADDR;
    global $ADAM_AEP_PORT;
    $this->sock = @fsockopen($ADAM_AEP_ADDR,$ADAM_AEP_PORT+$port_offset,$errno,$errstr,3);

    if ( $this->sock) {
        stream_set_blocking($this->sock, true);
        stream_set_timeout($this->sock,1);
    }
    return $this->sock;
  }

  function AEPIssueCmd($cmd) {

    fwrite($this->sock,$cmd . "\r\n");
    $ans = "";
    while( ! strstr($ans,"\r\n\r\n") ) {
      $ans .= fread($this->sock,128);
    }

    fclose($this->sock);
    if ($ans == "") $ans = "{}";
    return $ans;


  }


  function compile($data) {
    
    global $ADAM_PATH;
    global $ADAM_TMP;
    $outp = array();

    $result = 0;

    $tmp_cpath = "${ADAM_TMP}/cenv/";
    file_put_contents("${tmp_cpath}/temp.qs", $data);

    $cmd = "sudo ${ADAM_PATH}/bin/adam --compile -x ${tmp_cpath} -s temp.qs";

    exec($cmd,$outp,$result);
    return $result;
    
  }

  //quick backtest for non-saved strats, without saving.
  function qbacktest($data, $cfgid, $from, $to) {

    global $ADAM_PATH;
    global $ADAM_TMP;
    global $ADAM_AEP_PORT;

    $poffset = $this->findPort();
    $port = $ADAM_AEP_PORT + $ofset;

    $tmp_cpath = "${ADAM_TMP}/cenv/";
    file_put_contents("${tmp_cpath}/temp.qs", $data);

    //exports config
    exportCfg($cfgid ,null,"${tmp_cpath}/temp.cfg",false);

    $cmd = "sudo ${ADAM_PATH}/bin/adam -c ${tmp_cpath}/temp.cfg --backtest --backtest-from ${from} --backtest-to ${to} -p ${port} -x ${tmp_cpath} -s temp.qs &";
    exec($cmd,$outp,$result);
    return $offset;
  }

  function startReal() {
    global $ADAM_PATH;
    global $ADAM_TMP;
    $outp = array();

    //$pidtries = 10;

    $cmd = "sudo /etc/init.d/adam start";

    if (file_exists("$ADAM_TMP/needs_restart")) {
      unlink("$ADAM_TMP/needs_restart");
    }

    if ($this->checkStatus($this->supid) == 'off') {
      
      exec($cmd,$outp);

      /*
      $this->supid = $this->findRealPID();
      while ($pidtries > 0 && $this->supid == "")  {
        $pidtries--;
        $this->supid = $this->findRealPID();
        sleep(.2);
      }
      */

      //$this->setPID($this->supid);

    }
    
    else echo "ALREADY RUNNING!";

  }

  function stop() {
    global $ADAM_PIDFILE;
    exec("sudo /etc/init.d/adam stop");
    $this->mode = 'off';
  }

/*//POTENTIALLY DEPRECATED ! 
  //(but might still be useful if we launch adam foreground, inside  a screen)
  function setPID($pid,$pidfile=null) {
    global $ADAM_PIDFILE;
    if ($pidfile == null) {
      $pidfile = $ADAM_PIDFILE; 
    }

    $fh = fopen($pidfile,"w");
    if ($fh) {
      fputs($fh,$pid);
      fclose($fh);
    }

  }

  function findRealPID()  {
    global $ADAM_PATH;
    exec("ps aux|grep $ADAM_PATH|egrep -v '(sudo|gdb|screen|grep|php)'|awk '{print $2}'",$outp);
    if (count($outp) > 0) return $outp[0];
    else return "";

  }
  */

  function getPID($pid_f=null) {
    global $ADAM_PIDFILE;
    if ($pid_f == null ) $pidfile = $ADAM_PIDFILE;
    else $pidfile = $pid_f;
    
    $pid = @file_get_contents($pidfile);
    if ( $pid === false ) return 'none';
    else return $pid;

  }

  function checkStatus($pid) {
    
    if ($pid === 'none') return 'off';
    else {
        $result = shell_exec(sprintf("ps %d", $pid));

          if( count(preg_split("/\n/", $result)) > 2){
            return 'on';
          }
     return 'off';
    }
  }


  //This function finds an available port for backtesting
  function findPort() {

    global $ADAM_AEP_ADDR;
    global $ADAM_AEP_PORT;

    for ($offset=1;$offset< 1000;$offset++) {
      $this->sock = @fsockopen($ADAM_AEP_ADDR,$ADAM_AEP_PORT + $offset,$errno,$errstr,1);
      if (! $this->sock) return $offset;
    }
  }

  function getCompileErrors() {

    global $ADAM_TMP;

    $cp_errors = file_get_contents("$ADAM_TMP/compiler.errors.log");
    $cp_errors = trim( str_replace("\n","<br>", $cp_errors) );
    if ($cp_errors === false) $cp_errors = "";
    return $cp_errors;

  }


}?>