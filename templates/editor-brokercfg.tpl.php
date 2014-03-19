<?php
  include('brokercfg.php');
  $brokermodules = getBrokerModules();
?>


     <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalDest();" >&times;</button>
     <h3 id="editor-title" ></h3>
     </div>
     <div class="modal-body" style="padding-bottom:0px">
         <div id="modal-alert-enveloppe" class="alert alert-error" style="display:none">
           <div id="modal-alert"></div>
      </div>
          
      <div class="valuecfg-editor-frame well" id="brokercfg-editor-general"> 
      <form style="padding-bottom:0px;margin-bottom:0px">
       
           <label><b><?= $lang_array['app']['name'] ?></b></label>
           <input id="input-brokercfg-name" style="height:27px;width:170px" type="text" value="">
           <span class="help-block">Donnez un nom à cette configuration courtier pour l'identifier.</span>

           <label><b><?= $lang_array['app']['brokermodule'] ?></b></label>
           <select id="input-brokercfg-broker_id" style="height:27px;width:150px">
            <?php foreach($brokermodules as $bmodule) { ?>
               <option value="<?= $bmodule['id'] ?>"><?= $bmodule['name'] ?></option>
            <?php } ?>
           </select>
           <span class="help-block">Choissiez le module courtier qui doit être utilisé par Adam.</span>

           <label><b><?= $lang_array['app']['username'] ?></b></label>
           <input id="input-brokercfg-username" style="height:27px;width:150px" type="text" value="">
           <span class="help-block">Entrez l'identifiant de votre compte courtier.</span>

           <label><b><?= $lang_array['app']['password'] ?></b></label>
           <input id="input-brokercfg-password" style="height:27px;width:150px" type="password" value="">
           <span class="help-block">Indiquez le Mot de passe du compte courtier.</span>

          
          </form>
          </div>

          <a class="btn btn-large btn-success" style="float:right" id="editor-action"></a>

     </div>