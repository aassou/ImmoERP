<?php 
for ( $i=1; $i<11; $i++ ) {
?>
<div class="row cas-libre-padding">
    <div class="col-md-3">
        <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
            <input name="cas-libre-date<?= $i ?>" id="cas-libre-date<?= $i ?>" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
            <span class="add-on"><i class="icon-calendar"></i></span>
         </div>
        <input type="text" value="" name="cas-libre-montant<?= $i ?>" class="m-wrap" placeholder="Montant" />
        <input type="text" value="" name="cas-libre-observation<?= $i ?>" class="m-wrap" placeholder="Observation" />
     </div>
</div>
<?php  
}
?>