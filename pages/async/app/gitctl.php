<?php

  require_once('include/functions.inc.php');
  use Gitonomy\Git\Repository;

  $repository = new Repository($GIT_LOCATION);

  $lang = 'en';
  selectLanguage();
  require_once("lang/$lang/app.lang.php");

  function getActiveBranch() {

    global $repository;
    $outp = $repository->run('branch',array());
    $moutp = explode("\n",$outp);

    foreach($moutp as $br) {

      if (preg_match('/^\*/',$br)) {
        return trim(str_replace('* ','',$br));
      }
    }
    return "None";
  }

  if (!verifyAuth()) die('You are not logged');

  if (!isset($_REQUEST['action'])) die('No action Provided');

  $action = $_REQUEST['action'];

  //Create Branch function
  if ($action == 'createbranch') {
    $branch_name = $_REQUEST['branch_name'];
    $repository->run('checkout', array('-b',$branch_name));
  }

  if ($action == 'checkout') {
    $branch_name = $_REQUEST['branch_name'];
    $repository->run('checkout', array($branch_name)); 
  }
  
  else if ($action == 'deletebranch') {
    $branch_name = $_REQUEST['branch_name'];
    $repository->run('branch', array('-D',$branch_name));   
  }

  else if ($action == 'getbranches') {

    $active_branch = getActiveBranch();

    $branches = array();
    foreach ($repository->getReferences()->getBranches() as $branch) {
        
        $branches[] = array( 'name' => $branch->getName() , 'active' => ( $branch->getName() == $active_branch ) ? true: false );
    }
    echo json_encode($branches);
  }

  else if ($action == 'getinfos') {

  }

  else if ($action == 'commit') {
    $commit_message = $_REQUEST['commit_message'];

    $commit_lines = explode("\n",$commit_message);

    $commit_args = array('--author', 
                         $_SESSION['uinfos']['username'] . 
                         ' <' . $_SESSION['uinfos']['username'] . '@' . 
                         $_SERVER['SERVER_NAME'] . '>' );

    foreach($commit_lines as $line) {
      $commit_args[] = "-m";
      $commit_args[] = $line;
    }
    
    $repository->run('add', array('-A'));
    $repository->run('commit', $commit_args );
  }

  else if ($action == 'checkpending') {

    $pending = false;
    $nstrats = 0;
    $nmods = 0;

    $outp = $repository->run('status',array());

    $pending = ( strstr($outp,'nothing to commit')  !== false ) ? false : true;

    if ($pending) {

      $outp = $repository->run('ls-files',array());    

      $handle = opendir($GIT_LOCATION);
      while(false !== ($entry = readdir($handle))) {
        if ( endsWith( $entry, '.qsm' ) ) $nmods++;
        else if ( endsWith( $entry, '.qs' )  ) $nstrats++;
      }
    }
    
    echo json_encode(array('pending' => $pending , 'nstrats' => $nstrats, 'nmods' => $nmods));
  
  }

?>