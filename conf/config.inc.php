<?php
  $SITE_ROOT = '/usr/local/adam/admin/web';
  $MODULES_PATH='/usr/local/adam/admin/vhmodules';
  $MAIL_FROM = "no-reply@chiliconfig.com";
  $CONTACT_EMAIL = "clement@digi-nation.com";

  $ADAM_PATH = "/usr/local/adam/";
  $ADAM_TMP = "/tmp/adam";
  $ADAM_PIDFILE = "$ADAM_TMP/adam.pid";

  $ADAM_BT_EXPORTS = "/usr/local/adam/admin/data/dumps";

  $ADAM_AEP_ADDR = "127.0.0.1";
  $ADAM_AEP_PORT = 9999;
  
  $VH_VERSION = "2.0";
  $API_VERSION= "1.0.0";
  $API_LASTMOD = "2013-09-07";

  $LANG_LIST = array('en' => 'English' , 'fr' => 'Français');

  $INCLUDE_PATHS = array ('/usr/local/adam/admin',
			  '/usr/local/adam/admin/includes',
			  '/usr/local/adam/admin/classes',
			  '/usr/local/adam/admin/lib',
			  '/usr/local/adam/admin/templates',
			  '/usr/local/adam/admin/lang'
 			 );

  foreach($INCLUDE_PATHS as $incpath) {
    set_include_path(get_include_path() . ':' . $incpath);
  }

  //$dbhandler = new SQLiteDatabase( dirname(__FILE__) . '/../data/vh.sqlite');

  try{
    $dbhandler = new PDO('sqlite:'.dirname(__FILE__).'/../data/vh.sqlite');
    $dbhandler->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbhandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT
} catch(Exception $e) {
    echo "Impossible d'accéder à la base de données SQLite : ".$e->getMessage();
    die();
}

?>
