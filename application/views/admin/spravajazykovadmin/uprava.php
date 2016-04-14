<?php
$this->load->view('admin/spravy', null);
if ($jazyk == 'english'){
?>
<div class="btn-toolbar">
    <a href="#pridat_nove_pole" data-toggle="modal" > <button class="btn btn-primary"><i class="icon-plus"></i> Pridat do jazyka novu hodnotu</button></a> 
</div>
<?php
}
$urlT = site_url('admin/spravajazykovadmin/uprava/').'/?jazyk='.$jazyk.'/'.substr($subor, 0,-4).'';
echo form_open($urlT, array('id'=>"nova_stranka" ));
?>
   <fieldset>  
        <div id="legend">
            <legend class="">Uprava: <?php echo  ucfirst($jazyk)  ?>, Subor:  <?php echo  ($subor)  ?> </legend>
        </div>
        <?php
     
        foreach ($lang as $key => $value) {
            ?>
         
       <div class="row">
           <div class="span6">
                <label>Original (English) <b><?php echo $key;?></b></label>
                <textarea name="old_text_<?= $key;?>"  class="span6" ><?php echo $langen[$key]; ?></textarea>
           </div>
           <div class="span6">
                <label >Preklad (<?php echo  ucfirst($jazyk)  ?>) <b><?php echo $key;?></b></label>
                <textarea name="text_<?php echo $key;?>"  class="span6" ><?php echo $value; ?></textarea>
           </div>
 
       </div>
       <?php }
        ?>
        <input type="hidden" name="ulozit" value="true" />
        
        <div class="control-group">

            <div class="controls">
                
                <button class="btn btn-success btn-large pull-right" data-loading-text="Loading...">Uložiť</button> 
                <a href="<?php echo site_url('admin/spravajazykovadmin')?>" class="btn btn-large " >Spat</a>
            
            </div>
        </div>

    </fieldset>
</form>

<?php 
if ($jazyk == 'english'){
?>
<div id="pridat_nove_pole" class="modal hide fade">
    <div class="modal-header">
        <h3>Pridat novu hodnotu do jazyka</h3>
    </div>
    <div class="modal-body">
        <form method="post" >
            <input type="hidden" name="jazyk"  value="<?php echo $jazyk ?>" />
            <input type="hidden" name="subor"  value="<?php echo $subor ?>" />
            <p>
                <input type="text" name="nova_polozka"  value="" placeholder="Zadajte nazov volania pre jazyk" class="span5" id="new-target" />
            </p>
              <p>
                  <textarea type="text" name="nova_polozka_text" placeholder="Zadajte text v English" class="span5" id="new-target2" ></textarea>
            </p>
        </form>
    </div>
    <div class="modal-footer">
        <a class="submit btn btn-primary"  onclick="$('.modal-body > form').submit();" data-dismiss="modal">Vytvoriť</a>
        <a class="btn" data-dismiss="modal">Zrusiť</a>
    </div>
</div>
<?php } ?>

<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#nova_stranka").validationEngine('attach', {promptPosition: "bottomRight", autoPositionUpdate: true});
    });
</script>