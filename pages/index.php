<?php

  require_once ('include/functions.inc.php');

  if (!isset($_SESSION)) session_start();
  if (isset($_SESSION['uinfos'])) header('location:/app');
  include("include/header.inc.php");
  require_once("lang/$lang/templates/login.lang.php");


?>


  <div class="container">

   <div style="text-align:center;background:white">
    <img src="/img/vhlogo.png"/>    
   </div>

  <!-- <div class="alter_panel" style="margin-top:50px;background-image:url('/img/megaphone.svg'); background-repeat:no-repeat;background-size:80%;background-position:center -50px;"> -->
   <div class="alter_panel" style="margin-top:20px;padding-bottom:10px">
    <div class="container" style="margin-top:0px">
      <div class="row-fluid">
        <div class="span1"></div>
        <div class="span10" style="">
          <h3><?= $lang_array['templates']['login']['title']?>
     	    <small><?= $lang_array['templates']['login']['subtitle']  ?></small>
	        </h3>

        </div>
        <div class="span1"></div>
      </div>
      
      <div id="modal-alert-enveloppe" class="alert alert-error" style="display:none">
        <div id="modal-alert"></div>
      </div>

        <form style="padding-bottom:0px;margin-bottom:0px">
         
           <div class="well" style="text-align:center;padding-bottom:7px;">
           <input type="text" class="input-xlarge" placeholder="<?= $lang_array['templates']['login']['username'] ?>" id="login_username"/><br>
          <input  type="password" class="input-xlarge" style="margin-top:10px" placeholder="<?= $lang_array['templates']['login']['password'] ?>" id="login_password" />
          </div>
        <div style="padding-bottom:15px">
         <a style="float:right;margin-top:-7px;margin-right:15px" class="btn btn-success" href="#" onclick="login();"><?= $lang_array['templates']['login']['connect_btn']?></a>
        </div>
       </form>

   </div>

   </div>

   <script type="text/javascript">
     $('#login_password').keydown(function (event) {
         var keypressed = event.keyCode || event.which;
         if (keypressed == 13) {
             login();
         }
     });
   </script>

<?php ?>