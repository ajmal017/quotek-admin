     <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalDest();" >&times;</button>
     <h4 id="editor-title" ><?= $lang_array['app']['git_newbranch_title'] ?></h4>
     </div>
     <div class="modal-body" style="padding-bottom:10px">
         <div id="modal-alert-enveloppe" class="alert alert-error" style="display:none">
           <div id="modal-alert"></div>
      </div>

        <form style="padding-bottom:0px;margin-bottom:0px">
          <div class="row-fluid">
            <div class="span12">
               <label><b><?= $lang_array['app']['name'] ?></b></label>
               <input id="input-git-newbranch" style="height:27px;width:350px" type="text" value="">
               <span class="help-block"><?= $lang_array['app']['git_branch_hint'] ?></span>
            </div>
          </div>
        </form>
    
     </div>
     <div class="modal-footer2">
            <a id="btn-git-createb" class="btn btn-warning"><?= $lang_array['app']['create'] ?></a>
     </div>

     <script type="text/javascript">

     $('#btn-git-createb').click(function() {
       qateCreateGitBranch();
     });