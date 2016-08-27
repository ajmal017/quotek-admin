<?php
  include ('classes/strategy.php');
  $strats = getStrategies();
  $smodules = array();

  foreach( $strats as $strat) {
    if ($strat->type == "module") $smodules[] = $strat;
  }


?>

<div class="app-action-bar" id="sctl">

  <div class="btn-group">

    <a id="app-action-toggle" class="btn disabled">
      <i class="icon-white icon-play"></i> <?= $lang_array['act']['activate'] ?>
    </a>
     
    <a id="app-action-edit" class="btn btn-inverse" target="_blank"
       rel="tooltip"
       title="<?= $lang_array['app']['strategy_actions_edit'] ?>">
        <i class="icon-white icon-edit"></i> <?= $lang_array['act']['edit'] ?>
    </a> 

    <a id="app-action-clone" class="btn btn-inverse disabled" rel="tooltip"  title="<?= $lang_array['app']['strategy_actions_clone'] ?>">
      <i class="icon-white icon-leaf"></i> <?= $lang_array['act']['clone'] ?>
    </a>
    <a id="app-action-del" class="btn btn-danger disabled" id="btn-del-strat" rel="tooltip" title="<?= $lang_array['app']['strategy_actions_delete'] ?>">
      <i class="icon-white icon-remove-sign" ></i> <?= $lang_array['act']['del'] ?>
    </a>
  </div>

     <div class="btn-group">
      <a id="app-action-notebook" class="btn disabled" rel="tooltip" title="<?= $lang_array['app']['strategy_actions_notebook'] ?>" target="_blank" href="/app/notebooks/<?= $strat->name ?>">
        <i class="icon icon-book" ></i> Notebook
      </a>
    </div>
</div>

<table class="table table-striped app-table" id="strategies-table">
  <thead>
    <tr>
      <th><?= $lang_array['app']['name'] ?></th>
      <th><?= $lang_array['app']['author'] ?></th>
      <th><?= $lang_array['app']['status'] ?></th>
      <th><?= $lang_array['app']['createdon'] ?></th>
      <th><?= $lang_array['app']['updatedon'] ?></th>
    </tr>
  </thead>
  <tbody>

<?php

foreach ($strats as $strat) {

    if ($strat->type == 'normal') {

      $tdclass = ($strat->active ==1 ) ? 'activated' : '';
      $togglebtn_class = ($strat->active == 1) ? "btn-info" : "btn-success";
      $togglebtn_icon = ($strat->active == 1) ? "icon-stop" : "icon-play";
      $actbtnclick = "qateToggleStrat($(this));" ;
      $delbtnclass = ($strat->active == 1) ? "disabled" : "btn-danger";
      $deltbtnclick = ($strat->active == 1) ? "" :  "qateDelStrat('" . $strat->name . "');" ;    
?>

  <tr id="strategy-line-<?= $strat->name ?>">
    <td class="<?= $tdclass  ?>"><?=  $strat->name ?></td>
    <td class="<?= $tdclass  ?>"><?=  $strat->author ?></td>
    
    <td class="<?= $tdclass  ?>"> <span text-disabled="<?= $lang_array['app']['disabled'] ?>" text-active="<?= $lang_array['app']['active'] ?>" class="label label-<?= ($strat->active == 1) ? "success" : "inverse"  ?>"><?=  ($strat->active == 1) ? $lang_array['app']['active']: $lang_array['app']['disabled'] ?> </div></td>
    <td class="dtime <?= $tdclass  ?>"><?=  $strat->created ?></td>
    <td class="dtime <?= $tdclass  ?>"><?=  $strat->updated ?></td>
  </tr>

<?php } } ?>
</tbody>
</table>

<?php
  if ( count($smodules) > 0  ) {
?>

<h3><?= $lang_array['app']['modules'] ?></h3>

<div class="app-action-bar" id="smctl">

  <div class="btn-group">

    <a id="app-action-edit" class="btn btn-inverse disabled" target="_blank"
       rel="tooltip"
       title="<?= $lang_array['app']['strategy_actions_edit'] ?>">
      <i class="icon-white icon-edit"></i> <?= $lang_array['act']['edit'] ?>
    </a>
    <a id="app-action-clone" class="btn btn-inverse disabled" rel="tooltip"  title="<?= $lang_array['app']['strategy_actions_clone'] ?>">
      <i class="icon-white icon-leaf"></i> <?= $lang_array['act']['clone'] ?>
    </a>
    <a id="app-action-del" class="btn btn-danger disabled" rel="tooltip" title="<?= $lang_array['app']['strategy_actions_delete'] ?>">
      <i class="icon-white icon-remove-sign" ></i> <?= $lang_array['act']['del'] ?>
    </a>
  </div>

  <div class="btn-group">
    <a id="app-action-notebook" class="btn disabled" rel="tooltip" title="<?= $lang_array['app']['strategy_actions_notebook'] ?>" target="_blank" href="/app/notebooks/<?= $smodule->name ?>">
      <i class="icon icon-book" ></i> Notebook
    </a>
  </div>

</div>


<table class="table table-striped app-table" id="modules-table">
  <thead>
  <tr>
    <th><?= $lang_array['app']['name'] ?></th>
    <th><?= $lang_array['app']['type'] ?></th>
    <th><?= $lang_array['app']['author'] ?></th>
    <th><?= $lang_array['app']['createdon'] ?></th>
    <th><?= $lang_array['app']['updatedon'] ?></th>
  </tr>
  </thead>

  <tbody>

  <?php foreach($smodules as $smodule)  { 

    $delbtnclass = "btn-danger";
    $deltbtnclick = "qateDelStrat('" . $smodule->name . "');" ;   
  
    ?>

    <tr id="strategy-line-<?= $smodule->name ?>">
      <td id="msname"><?=  $smodule->name ?></td>
      <td><?=  $smodule->type ?></td>
      <td><?=  $smodule->author ?></td>
      
      <td class="dtime"><?=  $smodule->created ?></td>
      <td class="dtime"><?=  $smodule->updated ?></td>
    </tr>

  <?php } ?>
   </tbody>
 </table>

<?php } ?>


<script type="text/javascript">

$(document).ready(function() {

  strats_table = $('#strategies-table').DataTable( {
    "paging":   true,
    "ordering": true,
    "info":     false,
    "select":   true,
    "bFilter":  false,
    "bLengthChange": false
    } );


  mstrats_table = $('#modules-table').DataTable( {
    "paging":   true,
    "ordering": true,
    "info":     false,
    "select":   true,
    "bFilter":  false,
    "bLengthChange": false
    } );

   strats_table.on( 'select', function ( e, dt, type, indexes ) {

   
       if ( type === 'row' ) {
           var sname = strats_table.row( indexes ).id().replace(/strategy-line-/g,"");
           bindStratActions(sname);
       }
   } );


   mstrats_table.on( 'select', function ( e, dt, type, indexes ) {

       if ( type === 'row' ) {
           var smname = mstrats_table.row( indexes ).id().replace(/strategy-line-/g,"");
           bindMStratActions(smname);
       }
   } );

});


function bindStratActions(sname,active) {

  var sctl = $('#sctl');

  //We unbind all
  $('#app-action-clone', sctl).off('click').removeClass('disabled');
  $('#app-action-del', sctl).off('click').removeClass('disabled');
  $('#app-action-edit', sctl).off('click').removeClass('disabled');
  $('#app-action-notebook', sctl).off('click').removeClass('disabled');

  //We rebind all

  $('#app-action-toggle') {
    
  }

  $('#app-action-edit', sctl).attr('href','/app/editor?strat=' + sname );

  $('#app-action-clone',sctl).click(function() {
    qateCloneStrat(sname);
  });

  $('#app-action-del',sctl).click(function() {
    qateDelStrat(sname);
  });

  $('#app-action-notebook',sctl).attr('href','/app/notebooks/' + sname);

}

function bindMStratActions(smname) {

  var smctl = $('#smctl');

  //We unbind all
  $('#app-action-clone', smctl).off('click').removeClass('disabled');
  $('#app-action-del', smctl).off('click').removeClass('disabled');
  $('#app-action-edit', smctl).off('click').removeClass('disabled');
  $('#app-action-notebook', smctl).off('click').removeClass('disabled');

  //We rebind all
  $('#app-action-edit', smctl).attr('href','/app/editor?strat=' + smname );

  $('#app-action-clone',smctl).click(function() {
    qateCloneStrat(smname);
  });

  $('#app-action-del',smctl).click(function() {

    qateDelStrat(smname);

  });

  $('#app-action-notebook',smctl).attr('href','/app/notebooks/' + smname);


}



</script>