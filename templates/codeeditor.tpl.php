<div id="codeeditor">

<div class="navbar-inner" id="codeeditor_nav">

         <div class="row-fluid">
        <div class="span3" style="margin-top:4px">
          <div style="float:left;width:50px;margin-top:5px">  
              <img style="height:23px" src="/img/vhlogo2.png"> 
          </div>
          <div style="float:left;width:200px;margin-top:7px">  
              <b style="margin-top:1px">{code* editor("0.1");}</b>
          </div>

        </div>

        
        <div class="span8" style="text-align:right;margin-top:4px">
          <div id="codehelp" class="btn-group">
          <a class="btn" title="<?= $lang_array['app']['opendoc'] ?>" target="__new" href="/doc/" rel="tooltip">
            <i class="icon icon-question-sign"></i> <?= $lang_array['app']['doc_small'] ?></a>
          <a class="btn dropdown-toggle" data-toggle="dropdown">
             &nbsp;<span class="caret"></span>
          </a>
           <ul class="dropdown-menu" style="text-align:left">
              <li><a target="__new" href="/doc/#main"><?= $lang_array['app']['doc_fctmain']  ?></a> </li>
              <li><a target="__new" href="/doc/#math"><?= $lang_array['app']['doc_fctmath']  ?></a> </li>
              <li><a target="__new" href="/doc/#broker"><?= $lang_array['app']['doc_fctbroker']  ?></a> </li>
              <li><a target="__new" href="/doc/#store"><?= $lang_array['app']['doc_fctstore']  ?></a> </li>
          </ul>
          </div>
          <a class="btn" title="<?= $lang_array['app']['editor_resize_small']  ?>" onclick="adamCodeEditorSwitchBackFS();" rel="tooltip">
          <i class="icon icon-resize-small"></i>&nbsp;</a>
         </div>
       </div>      
  </div>

  <div id="codeeditor_area">
  </div>
</div>

<script type="text/javascript">
  $('#codehelp').dropdown();
</script>