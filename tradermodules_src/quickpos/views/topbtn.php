<?php

  require_once("corecfg.php");
  require_once("valuecfg.php");

  global $lang;
  include ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");

  $acfg = getActiveCfg();
  $values = getCfgValues($acfg->id); 

?>


<button id="quickpos-topbtn-open" rel="tooltip" title="<?= $lang_array['quickpos']['open_tooltip']  ?>" class="btn" onclick="toggleQPOpenView()"><i class="icon-white icon-fire"></i></button>
<button id="quickpos-topbtn-poslist" rel="tooltip" title="<?= $lang_array['quickpos']['poslist_tooltip'] ?>"class="btn" onclick="toggleQPPosView()"><i class="icon-white icon-screenshot"></i></button>


<div id="QPOpenView" style="position:absolute;width:300px;z-index:200;display:none;background:#131517;border:1px solid black;margin-left:-50px">

  <div class="well" style="text-align:center">

   <div style="margin-left:auto;margin-right:auto;width:130px;text-align:left">
      <label><?= $lang_array['quickpos']['size_stop_limit'] ?></label>
      <input class="prompt" id="QPSSL" value="10:20:0" style="width:130px;height:30px;font-size:16px">
   </div>
  </div>
  <table class="table">

  <?php
    foreach ( $values as $v ) {
  ?>


    <tr>
    	<td>
    	  <?= $v->name ?>
    	</td>

    	<td style="width:60px">
          <button class="btn btn-danger" onclick="QPOpen('sell','<?= $v->name ?>')">SELL</button> 
    	</td>

    	<td style="width:50px">
          <button class="btn btn-primary" onclick="QPOpen('buy','<?= $v->name ?>')">BUY</button>
    	</td>

  <?php } ?>

  </table>

</div>


<div id="QPPosView" style="width:300px;background:#131517;border:1px solid black;z-index:201;position:absolute;display:none;margin-left:-50px">
</div>


<script type="text/javascript">

var qpv_int;

function toggleQPOpenView() {
  if ( $('#QPOpenView').is(':hidden')) $('#QPOpenView').show();
  else $('#QPOpenView').hide();
}

function toggleQPPosView() {

  if ( $('#QPPosView').is(':hidden')) {

    qpv_int = setInterval("updateQPosView()",1000);    
    $('#QPPosView').show();


  }
  else {
  	$('#QPPosView').hide();
  	clearInterval(qpv_int);
  }
}

function updateQPosView()  {
  $('#QPPosView').html($('.poslist').html());
  $('#QPPosView #postable').removeClass('table-bordered');
  $('#QPPosView #postable').removeClass('table-striped');
  $('#QPPosView #postable').css('margin-bottom','0px');
  $('#QPPosView #postable').css('padding-bottom','0px');
  $('#QPPosView .s_hide').hide();

}


function QPOpen(way, name) {

  var ssl = $('#QPSSL').val();
  qateSendOrder( 'openpos:' + name + ":" + way + ":" + ssl );
  $('#QPView').hide();

  //updates pos list right after having sent order
  qateUpdatePosList();
  
}


 $('#quickpos-topbtn-open').tooltip({'placement': 'bottom','container': 'body'});
 $('#quickpos-topbtn-poslist').tooltip({'placement': 'bottom','container': 'body'});

</script>