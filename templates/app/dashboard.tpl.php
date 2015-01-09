<?php 
?>

<div class="app-display" id="dashboard" style="display:block">
	    <div class="page-header">
		  <h3><?= $lang_array['app']['dashboard']  ?>
		    <small><?= $lang_array['app']['dashboard_subtitle']  ?></small>
          </h3>
      </div>

      <div class="row-fluid">
        
          <div class="app-headed-white-frame" style="height:268px;width:100%">
            <div class="app-headed-frame-header">
          	    <h4><?= $lang_array['app']['pnl'] ?></h4>
            </div>
  
            <div style="text-align:center;width:100%">
              <div class="dashboard-graph" id="dashboard-graph-pnl" style="height:227px;width:400px;margin-left:auto;margin-right:auto">
              </div>
            </div>

          </div>
      </div>

      <div class="row-fluid" style="margin-top:30px">
  
          <div class="app-headed-white-frame" style="height:200px">
            <div class="app-headed-frame-header">
                <h4><?= $lang_array['app']['positions'] ?></h4>
            </div>

          </div>
      </div>



      <div class="row-fluid" style="margin-top:30px">

      	<div class="span12">
      	  <div class="app-headed-white-frame" style="height:200px">
      	    <div class="app-headed-frame-header" style="margin-bottom:0px">
      	  	    <h4><?= $lang_array['app']['lastlog'] ?></h4>
      	    </div>

            <div id="app-dashboard-lastlogs"></div>

      	  </div>
      	</div>      

      </div>

      <?php
          loadVHViews($vhms,'dashboard');
      ?>



</div>

<script type="text/javascript">

  setInterval('adamUpdateDBPNLGraph()',10000);
  setInterval('adamUpdateDBNBPOSGraph()',20000);

  $('#dashboard').bind('afterShow',function()  {

    $('.dashboard-graph').each(function(index,elt){
      
      adamUpdateDBPNLGraph();
      adamUpdateDBNBPOSGraph();

    });


  });

</script>
