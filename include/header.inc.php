<?php
   if (file_exists("include/functions.inc.php")) {
      require_once("include/functions.inc.php");
   }
   else require_once("functions.inc.php");

   $lang = 'en';
   selectLanguage();
   setlocale (LC_TIME, $lang . '_' . strtoupper($lang) . '.UTF-8');
   require_once("lang/$lang/main.lang.php");
   $title = getPageTitle();
?>

<!DOCTYPE HTML>
<html>
  <head>    
    <META http-equiv="Content-Type" Content="text/html; charset=UTF-8">
    <META name="Keywords" content="<?= $metas['keywords']  ?>">
    <META name="Description" content="<?= $metas['descr']  ?>">

    <title><?= $title ?></title>

    <LINK REL="SHORTCUT ICON" href="/img/quotek_q.png">
    <LINK rel=stylesheet type="text/css" href="/css/bootstrap.css">
    <LINK rel="stylesheet" href="/css/bootstrap_ex.css">
    <LINK rel=stylesheet type="text/css" href="/css/quotek.css">

    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/bootstrap.js"></script>
    <script type="text/javascript" src="/js/quotek.js"></script>
  </head>
  <body>

  <div class="wrapper">
    <div style="background:white;color:black" id="ajaxdbg"></div>
    <div class="modal" id="modal_win" style="display:none"></div>
    <div id="modal_bg" style="display:block!important"></div>
