var progress = 0;
var tcontrol;

function updateProgress() {
  $('#app-loader-bar').css('width',progress + '%');
  if ($('#app-loader-bar').width()  == $('#app-loader-ct').width()) {
    endLoad();
  }
}

function endLoad() {

  $('#lang-popover').popover({html: true, content: $('#lang-ct').html(),title: $('#lang-title').html()});

  $(window).resize(function(){
           var dispwidth = $(window).width() - $('#app-left').width();
            $('#app-display').width(dispwidth);

            $('#modal_bg').width($(window).width());
            $('#modal_bg').height($(window).height());

            $('#codeeditor').width($(window).width());
            $('#codeeditor').height($(window).height());
            
            $('#codeeditor_area').width($(window).width());
            $('#codeeditor_area').height($(window).height()-42);

          });


  $('#app-loader').hide();
  $('#app-top').fadeIn(1000);
  $('#app-left').fadeIn(1000);
  $('#app-display').fadeIn(1000);

  var dispwidth = $(window).width() - $('#app-left').width();
  $('#app-display').width(dispwidth);

  clearInterval(tcontrol);

  adamUpdateAll();
  setInterval('adamUpdateAll()',3000);

  //setInterval('adamUpdateStatus()',10000);
  //setInterval('adamUpdateCorestats()',5000);
  
  adamUpdateDBPNLGraph();
  adamUpdateDBNBPOSGraph();
  setInterval('adamUpdateDBPNLGraph()',10000);
  setInterval('adamUpdateDBNBPOSGraph()',20000);

  var ce = ace.edit("codeeditor_area");
  ce.setTheme("ace/theme/xcode");
  ce.getSession().setMode("ace/mode/c_cpp");
  
  //adamUpdateStatus();
}

/* loading of app js + css */
function loadApp() {

  tcontrol = setInterval('updateProgress()',500);
  
  /* JQUERY-UI-SLIDER */  
  $("head").append($("<script type='text/javaScript' src='/js/jquery-ui-1.10.0.custom.min.js'></script>"));
  $("head").append($("<link rel='stylesheet' href='/css/ui-lightness/jquery-ui-1.8.23.custom.css' type='text/css'>"));

  /* BOOTSTRAP JS */
  $("head").append($("<script type='text/javascript' src='/js/bootstrap.js'></script>"));

  /* FLOT */
  $("head").append($("<script type='text/javascript' src='/js/flot/jquery.flot.js'></script>"));
  $("head").append($("<script type='text/javascript' src='/js/flot/jquery.flot.time.js'></script>"));
  $("head").append($("<script type='text/javascript' src='/js/flot/jquery.flot.pie.js'></script>"));

  /* DATETIME-PICKER */
  $("head").append($("<script type='text/javascript' src='/js/bootstrap-datetimepicker.min.js' charset='utf-8'></script>"));
  $("head").append($("<link rel='stylesheet' href='/css/bootstrap-datetimepicker.min.css' type='text/css'>"));

  //$("head").append($("<script type='text/javascript' src='/lib/ace/theme-xcode.js' charset='utf-8'></script>"));
  //$("head").append($("<script type='text/javascript' src='/lib/ace/mode-c_cpp.js' charset='utf-8'></script>"));

  /* APP */
  $("head").append($("<script type='text/javascript' src='/js/vh.js'></script>"));
  $("head").append($("<link rel='stylesheet' href='/css/app.css' type='text/css'>"));
  
  progress += 40;
 
  $('#app-top').load('/async/app/getapp?part=top',function() { progress+=20; } );
  $('#app-left').load('/async/app/getapp?part=left',function() { progress+=0; } );
  $('#app-display').load('/async/app/getapp?part=disp',function() { progress+=40; } );

  
}

function closeApp() {

  $('#modal_bg').show();
  var gt = $.ajax({
        url:            '/async/getTemplate',
        type:           'POST',
        data:           {tpl: 'confirm',ctype: 'closeapp'},
        cache:          false,
        async:          false
        });

  modalInst(400,'auto',gt.responseText);

}
