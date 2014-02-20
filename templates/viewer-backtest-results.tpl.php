<?php

   include("backtest.php");

   if (!isset($_REQUEST['backtest_id'])) die("ERROR: No backtest id");

   $bt = new backtest();
   $bt->id = $_REQUEST['backtest_id'];
   @$bt->load();

   $results = $bt->getResultsList();

?>

     <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalDest();" >&times;</button>
     <h3 id="backtest-resviewer-title" ><?=  $lang_array['app']['backtest_resviewer_title']  ?>: <?=  $bt->name  ?></h3>
     </div>
     <div class="modal-body" style="padding-bottom:0px">
         <div id="modal-alert-enveloppe" class="alert alert-error" style="display:none">
           <div id="modal-alert"></div>
         </div>

                <div class="app-headed-white-frame" style="height:150px;margin-top:20px">
                  <div class="app-headed-frame-header" style="margin-bottom:0px">
                      <h4><?= $lang_array['app']['backtests'] ?></h4>
                  </div>
 
                  <select id="viewer-backtest-resultslist" style="height:120px;width:100%;border:0px" MULTIPLE>
                
                  <?php foreach ($results as $result) { 
                    $result['date'] = date('d-m-Y H:i:s',$result['date']);
                  ?>
                    <option value="<?= $result['tstamp'] ?>" ><?= $lang_array['app']['btof'] . " " . $result['date'] ?></option>
                  <?php } ?>

                  </select>
                
                </div>

                <div class="app-headed-white-frame" style="height:320px;margin-top:20px">
                  <div class="app-headed-frame-header" style="margin-bottom:0px">
                      <h4><?= $lang_array['app']['results'] ?></h4>
                  </div>

                  <ul class="nav nav-tabs">
                     <li class="active">
                        <a onclick="adamResultNav($(this));" class="result-navlink" id ="main"><?= $lang_array['app']['main'] ?></a>
                      </li>
                     <li>
                        <a onclick="adamResultNav($(this));" class="result-navlink" id="positions"><?= $lang_array['app']['pos'] ?></a>
                      </li> 
                     <li>
                        <a onclick="adamResultNav($(this));" class="result-navlink" id="values"><?= $lang_array['app']['values'] ?></a>
                      </li>
                  </ul>


                  <div class="result-frame" id="result-frame-main">

                    <table class="table table-stripped">

                     <tr>
                       <td><b><?= $lang_array['app']['start']?></b></td>
                       <td id="result_start"></td>
                     </tr>

                     <tr>
                       <td><b><?= $lang_array['app']['end']?></b></td>
                       <td id="result_stop"></td>
                     </tr>

                     <tr>
                       <td><b><?= $lang_array['app']['pnl']?></b></td>
                       <td id="result_pnl"></td>
                     </tr>

                     <tr>
                       <td><b><?= $lang_array['app']['takenpos']?></b></td>
                       <td id="result_takenpos"></td>
                     </tr>

                     <tr>
                       <td><b><?= $lang_array['app']['remainingpos']?></b></td>
                       <td id="result_remainingpos"></td>
                     </tr>
                    </table>                  
                  </div>

                  <div class="result-frame" id="result-frame-positions">

                    <div class="span4">
                    </div>

                    <div class="span8">

                    
                    </div>



                  </div>

                  <div class="result-frame" id="result-frame-values">

                    <div class="row-fluid">

                    <div class="span4">

                      <select id="result_values_selector" style="width:100%;height:220px;" MULTIPLE>
 
                      </select>

                    </div>

                    <div class="span8">

                       <table class="table table-stripped">

                         <tr>
                           <td><?= $lang_array['app']['name'] ?></td>
                           <td id="result_value_name"></td>
                         </tr>

                         <tr>
                           <td><?= $lang_array['app']['highest'] ?></td>
                           <td id="result_value_highest"></td>
                         </tr>

                         <tr>
                           <td><?= $lang_array['app']['lowest'] ?></td>
                           <td id="result_value_lowest"></td>
                         </tr>

                         <tr>
                           <td><?= $lang_array['app']['variation'] ?></td>
                           <td id="result_value_variation"></td>
                         </tr>

                         <tr>
                           <td><?= $lang_array['app']['stddev'] ?></td>
                           <td id="result_value_deviation"></td>
                         </tr>

                       </div>

                    </div>
          
                   </div>


                  </div>

                  <!-- <div id="backtest-result-content" style="background-color:white;height:290px;overflow-y:scroll"></div> -->
                </div>



      <script type="text/javascript">
        <?php if (count($results) > 0 ) { ?>
          adamLoadBTResult(<?= $bt->id ?>, <?= $results[0]['tstamp'] ?> );
        <?php } ?>
        
        $('#viewer-backtest-resultslist').change(function() {
                                                
          adamLoadBTResult(<?= $bt->id  ?>, $('#viewer-backtest-resultslist').val()[0] );

        });


     function adamResultNav(obj) {
       $('.result-frame').hide();
       $('#result-frame-' +  obj.attr('id') ).show();
       $('.result-navlink').parent().removeClass('active');
       obj.parent().addClass('active');
     }


      </script>