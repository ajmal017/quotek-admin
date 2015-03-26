<?php

   global $lang;
   include ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");
   require_once "valuecfg.php";
   require_once "corecfg.php";

   $cfg = getActiveCfg();
   $vals = getCfgValues($cfg->id);

   
?>

<div id="visualize-tooltip" style="display:none;position:absolute;padding:4px;background:#131517;border-radius:4px;font-size:11px;opacity:1.0!important;z-index:3000">
</div>


<div class="app-display" id="visualize">
        
  	    <div class="title">
  		  <h3>Visualize
  		    <small><?= $lang_array['visualize']['subtitle']  ?></small>
            </h3>
        </div>

        <div class="row-fluid">
          <div class="navbar">
            <div class="app-headed-white-frame" style="padding:15px">

              <div class="span4">

                <div class="span3">
                    <h4>Début:</h4>
                 </div>

                 <div class="span9">

                  <div id="visualize-datepicker-tinf" class="input-append date" style="margin-top:15px">
                  <input id="visualize-input-tinf" data-format="yyyy-MM-dd hh:mm:ss" type="text" style="font-size:14px!important;height:29px "></input>
                  <span class="add-on btn-warning" style="padding-top:4px!important;padding-bottom:4px!important;background:#FF9200!important">
                    <i data-time-icon="icon-time icon-white" data-date-icon="icon-calendar icon-white">
                    </i>
                  </span>
                </div>

              </div>


              </div>

              <div class="span4">
                <div class="span3">
                  <h4>Fin:</h4>
                </div>

                <div class="span9">

                  <div id="visualize-datepicker-tsup" class="input-append date" style="margin-top:15px">
                  <input id="visualize-input-tsup" data-format="yyyy-MM-dd hh:mm:ss" type="text" style="font-size:14px!important;height:29px "></input>
                  <span class="add-on btn-warning" style="padding-top:4px!important;padding-bottom:4px!important;background:#FF9200!important">
                    <i data-time-icon="icon-time icon-white" data-date-icon="icon-calendar icon-white">
                    </i>
                  </span>
                </div>

                </div>

              </div>

              <div class="span4" style="text-align:right">
                <div class="btn-group" style="margin-top:12px!important">
                <a id="btn-autoupdate" class="btn btn-primary" onclick="toggleAutoUpdate()">Autoupdate: true</a>
                <a id="btn-visualize" class="btn btn-success disabled">
                  Visualize!
                </a>
                </div>
              </div>


            </div>
          </div>
        </div>


        <div class="row-fluid" id="graphlarge" style="padding-top:30px;padding-bottom:30px"></div>

        <div class="row-fluid">

        <?php

        $i=0;
        foreach($vals as $v) {
          $i++;
        ?>

        <div class="span6">
          <div class="app-headed-white-frame" style="height:300px">
            <div class="app-headed-frame-header">
              <div class="span6">
                <h4><?= $v->name ?></h4>
              </div>
              <div class="span6" style="text-align:right">
                <div class="btn-group" style="margin-top:11px;margin-right:10px">
                  
                   <a linked-asset="<?= $v->name ?>" id="visualize-ratebtn" onclick="changeRefresh($(this))" class="btn btn-info" style="padding:1px!important;padding-left:10px!important;padding-right:10px!important;font-size:10px!important;height:16px!important">20s</a>

                   <a linked-asset="<?= $v->name ?>" id="visualize-resbtn" onclick="changeGraphRes($(this))" class="btn btn-success" style="padding:1px!important;padding-left:10px!important;padding-right:10px!important;font-size:10px!important;height:16px!important">30s</a>

                  <a id="candlebtn" class="btn btn-small" rel="tooltip" title="<?= $lang_array['visualize']['candle'] ?>">
                    <i class="icon-indent-right icon-white"></i>
                  </a>

                  <a id="rbtn" class="btn btn-primary btn-small" onclick="enlargeGraph('<?= $v->name ?>');" rel="tooltip" title="<?= $lang_array['visualize']['enlarge_graph'] ?>">
                    <i class="icon-fullscreen icon-white"></i>
                  </a>
 
                  


                </div>
              </div>
            </div>
              <div linked-asset="<?= $v->name ?>" id="visualize-draw" style="height:267px;text-align:center;">
              <br><img src="/img/loader2.gif" style="width:25px;margin-top:100px"/>
             </div>

             <div class="deltapopup" linked-asset="<?= $v->name ?>" style="position:relative;font-size:30px;margin-top:-150px;width:100px;height:100px;float:right"></div>


          </div>
        </div>

        <?php
          if ($i %2 == 0) {
            echo "</div><div class=\"row-fluid\" style=\"margin-top:25px\">";
          }
        }

        ?>

      </div>


</div>


<script type="text/javascript">

  <?php foreach($vals as $v) { ?>
  var plot<?= str_replace('_','', $v->name) ?> = null;
  var au<?= str_replace('_','', $v->name) ?> = null;
  <?php } ?>


  function changeRefresh(ratebtn) {

    var rate_millisecs = 20000;

    if (ratebtn.html() == '20s') {
      ratebtn.html('1s');
      rate_millisecs = 1000;
    }

    else if (ratebtn.html() == '1s') {
      ratebtn.html('5s');
      rate_millisecs = 5000;
    }

    else if (ratebtn.html() == '5s') {
      ratebtn.html('10s');
      rate_millisecs = 10000;
    }

    if (ratebtn.html() == '10s') {
      ratebtn.html('20s');
      rate_millisecs = 20000;
    }

    var iname = ratebtn.attr('linked-asset');
    var auname = 'au' + iname.replace('_','');
    
    eval('clearInterval(' + auname + ');');

    set_interval_str = "setInterval(\"" + "displayGraph('" + iname + "', plot" + iname.replace('_','') + ")\"," + rate_millisecs + ");";

    eval( auname + " = " + set_interval_str );
    
  }

  function changeGraphRes(resbtn)  {

    if (resbtn.html() == 'rt') resbtn.html('5s');
    else if (resbtn.html() == '5s') resbtn.html('30s');
    else if (resbtn.html() == '30s') resbtn.html('1m');
    else if (resbtn.html() == '1m') resbtn.html('5m');
    else if (resbtn.html() == '5m') resbtn.html('20m');
    else if (resbtn.html() == '20m') resbtn.html('1h');
    else if (resbtn.html() == '1h') resbtn.html('4h');
    else if (resbtn.html() == '4h') resbtn.html('1d');
    else if (resbtn.html() == '1d') resbtn.html('rt');

  }

  function enlargeGraph(iname) {

    var graphbox = $('#visualize-draw[linked-asset=' + iname + ']').parent().parent();
    var graphlarge = $('#graphlarge');

    graphlarge.append(graphbox.html());

    var exframe = $('#visualize-draw[linked-asset='+ iname + ']', graphlarge).parent();
    exframe.css({'margin-bottom':'25px'});


    $('#rbtn', exframe).removeClass('btn-primary');
    $('#rbtn', exframe).addClass('btn-danger');
    $('#rbtn', exframe).html('<i class="icon icon-remove-sign"></i>');
    
    $('#rbtn', exframe).attr('onclick', null);
    $('#rbtn', exframe).off('click');
    $('#rbtn', exframe).click(function() {
      exframe.remove();
    });


    displayGraph(iname);

  }


  function disableAutoUpdate() {
    $('#btn-autoupdate').removeClass('btn-primary');
    $('#btn-autoupdate').html('Autoupdate: false');

    <?php foreach($vals as $v) { ?>
    clearInterval(au<?= str_replace('_','', $v->name) ?>);
    <?php } ?>
  }


  function enableAutoUpdate() {
    $('#btn-autoupdate').addClass('btn-primary');
    $('#btn-autoupdate').html('Autoupdate: true');

    <?php foreach($vals as $v) { ?>
      au<?= str_replace('_','', $v->name) ?> = setInterval("displayGraph('<?= $v->name ?>',plot<?= str_replace('_','', $v->name) ?>)",20000);
    <?php } ?>
  }

  

  function disableVisualize() {

    $('#btn-visualize').addClass('disabled');
    $('#btn-visualize').off('click');
  }

  function enableVisualize() {
    $('#btn-visualize').removeClass('disabled');
    $('#btn-visualize').click(function() {  displayAllGraph(true) });

  }

  function toggleAutoUpdate() {

    //disable
    if( $('#btn-autoupdate').hasClass('btn-primary') ) {
      disableAutoUpdate();
      enableVisualize();
    }

    //enable
    else {
      enableAutoUpdate();
      disableVisualize();
    }
  }

  $('#visualize-datepicker-tinf').datetimepicker({
      language: 'fr-FR'
    });

    $('#visualize-datepicker-tsup').datetimepicker({
      language: 'fr-FR'
    });



  function showDelta(iname, delta) {

    var deltadiv = $('.deltapopup[linked-asset=' +  iname + ']');
    
    if ( delta < 0 ) deltadiv.css('color','#FF0000');
    else deltadiv.css('color','#00FF00');

    deltadiv.html(delta);
  }


  function displayGraph(iname, existing_plot, use_dates) {

    var existing_plot = (typeof existing_plot != 'undefined') ? existing_plot : null;
    var use_dates = (typeof use_dates != 'undefined') ? use_dates : null;
    
    var is_filled = true;

    var resolution = $('#visualize-resbtn[linked-asset=' + iname + ']').html();
    //if realtime, resolution switches to 0
    if (resolution == 'rt') resolution = 0;
    
    var default_time_range = 9000;

    if (resolution == 0) default_time_range = 300;
    else if (resolution == '5s') default_time_range = 5 * 300;
    else if (resolution == '30s') default_time_range = 30 * 300;
    else if (resolution == '1m') default_time_range = 60 * 300;
    else if (resolution == '5m') default_time_range = 300 * 300;
    else if (resolution == '20m') default_time_range = 1200 * 300;
    else if (resolution == '1h') default_time_range = 3600 * 300;
    else if (resolution == '4h') default_time_range =  14400 * 300;
    else if (resolution == '1d') default_time_range = 86400 * 300;

    var tinf = "";
    var tsup = "";

    if (use_dates != null) {
      tinf = $('#visualize-input-tinf').val();
      tsup = $('#visualize-input-tsup').val();
    }

    if (tinf == "") {

      var pdate = new Date(Date.now() - tzOffset() * 3600000 - default_time_range * 1000 ); 

      //pdate.setHours(pdate.getHours()-3);

      var h = pdate.getHours();
      if (h<10) h = "0" + h;

      var m = pdate.getMinutes();
      if (m<10) m = "0" + m;

      var month = pdate.getMonth() + 1 ;
      if (month<10) month = "0" + month;

      var day = pdate.getDate();
      if (day<10) day = "0" + day;

      var secs = pdate.getSeconds();
      if (secs<10) secs = "0" +secs;

      tinf = pdate.getFullYear() + 
            "-" + 
            month +
            "-" + 
            day + 
            " " + 
            h + 
            ":" +
            m +
            ":" +
            secs;

    }

    if (tsup == "") {

      //we substract timzzone offset and add 30secs (to be sure we have the latest data)
      var cdate = new Date(Date.now() - tzOffset() * 3600000 + 30000);

      var h = cdate.getHours();
      if (h<10) h = "0" + h;

      var m = cdate.getMinutes();
      if (m<10) m = "0" + m;

      var secs = cdate.getSeconds();
      if (secs<10) secs = "0" +secs;
     
      var month = cdate.getMonth() + 1 ;
      if (month<10) month = "0" + month;

      var day = cdate.getDate();
      if (day<10) day = "0" + day;

      tsup = cdate.getFullYear() + 
            "-" + 
            month + 
            "-" +
            day + 
            " " + 
            h + 
            ":" +
            m +
            ":" +
            secs; 

    }

    var placeholder = $('#visualize-draw[linked-asset=' + iname + ']');

  
    var options = {

            xaxis: {
              mode: "time",
              axisLabel: 'Time'
            },   

            grid: {
                   show: true,
                   borderWidth: 0,
                   hoverable: true,
                   clickable: true,
             },
             legend: {
                      show: false
                    },

             selection: {
                    mode: "x"
             },

    };

    var data = [{ data: null,
                 lines: { 
                          fill: is_filled,
                          lineWidth: 2,
                          zero: false },
                  color: '#38b7e5',
                  label: iname,
                 
                  }, ];

    var plot = null;

    var rdata = $.ajax({'url': '/async/vhmodules/visualize/stats?tinf=' + tinf + "&tsup=" + tsup + "&indice=" + iname + "&resolution=" + resolution + "&time_offset=" + tzOffset(),
                       'type': 'GET',
                       'cache': false,
                       'async': true,
                       'success': function() {

                          data[0].data = $.parseJSON(rdata.responseText);
          
                          var delta = 0 ;                
                          if ( data[0].data.length >= 2 ) {
                            delta = data[0].data[data[0].data.length -1 ][1] - data[0].data[data[0].data.length - 2 ][1];

                            if ( data[0].data[data[0].data.length -1 ][1] < 2 ) {
                              delta *= 1000;  
                            }

                            delta = delta.toFixed(4);

                            if (resolution == 0 || resolution == '5s') showDelta(iname, delta);
                          }



                          if (existing_plot == null) {
 
                            plot = $.plot(placeholder, data , options);

                            placeholder.bind("plotclick", function (event, pos, item) {
                              if (item) {
                                $("#clickdata").text(" - click point " + item.dataIndex + " in " + item.series.label);
                                plot.highlight(item.series, item.datapoint);
                              }
                            });

                            placeholder.bind("plotselected", function (event, ranges) {

                                    $.each(plot.getXAxes(), function(_, axis) {
                                      var opts = axis.options;
                                      opts.min = ranges.xaxis.from;
                                      opts.max = ranges.xaxis.to;
                                    });
                                    plot.setupGrid();
                                    plot.draw();
                                    plot.clearSelection();
                                });



                            placeholder.bind("plothover", function (event, pos, item) {

                              if (item) {
                                  var x = item.datapoint[0].toFixed(2),
                                    y = item.datapoint[1].toFixed(2);

                                  //$("#visualize-tooltip").html(item.series.label + " of " + x + " = " + y)
                                  $("#visualize-tooltip").html(item.series.label + ": " + y )
                                    .css({top: item.pageY+5, left: item.pageX+5})
                                    .fadeIn(200);
                                } 

                                else {
                                  $("#visualize-tooltip").hide();
                                }
                              
                            });

                        }

                        //update
                        else {

                          existing_plot.setData(data);
                          existing_plot.draw();
                          plot = existing_plot;

                        }




                       } });
    

  
  return plot;

  }
  
  function displayAllGraph(use_dates) {

    var use_dates = ( typeof use_dates != 'undefined'  ) ? use_dates : null ; 

    <?php foreach($vals as $v) { ?>
      plot<?= str_replace('_','', $v->name) ?> = displayGraph('<?= $v->name ?>', null, use_dates);
    <?php } ?>

  }


  $('#visualize').bind('afterShow',function() {
    displayAllGraph();
    enableAutoUpdate();
  });


  $('#rbtn').tooltip({placement:'bottom',container: 'body'});
  $('#candlebtn').tooltip({placement:'bottom',container: 'body'});

</script>


