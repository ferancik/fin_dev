<?
$this->load->view('admin/spravy', null);

$action =  'admin/fotogaleria/novy/'.(($data) ? $data->id : ""); 
echo form_open($action, 'id="nova_galeria" class="form-horizontal" method="post"');
?>

  <fieldset>
        <div id="legend">
            <legend class=""></span><?php echo $text['nazov'] ?><?php echo ($data) ? " : " . $data->nazov : ""; ?></legend>
        </div>

        <div class="control-group">
            <label class="control-label" >Stručný nazov  <em class="formee-req">*</em></label>
            <div class="controls">

                <input type="text" name="small_nazov" id="small_nazov" value="<?php echo ($data) ? $data->small_nazov : ""; ?>" class="span6 validate[required,maxSize[200]]" />

                <p class="help-block"></p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >Stručný popis  <em class="formee-req">*</em></label>
            <div class="controls">

                <input type="text" name="small_popis" id="small_popis" value="<?php echo ($data) ? $data->small_popis : ""; ?>" class="span6 validate[required,maxSize[200]]" />

                <p class="help-block"></p>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" >Názov  <em class="formee-req">*</em></label>
            <div class="controls">

                <input type="text" name="nazov" id="nazov" value="<?php echo ($data) ? $data->nazov : ""; ?>" class="span6 validate[required,maxSize[200]]" />

                <p class="help-block"></p>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" >Popis  <em class="formee-req">*</em></label>
            <div class="controls">

                <textarea type="text" name="popis"  class="tinymceEditor validate[required]" id="popis"  ><?php echo ($data) ? $data->popis : ""; ?> </textarea>

                <p class="help-block"></p>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label" >SEO popis </label>
            <div class="controls">

                <input type="text" name="meta_desc" id="meta_desc" value="<?php echo ($data) ? $data->meta_desc : ""; ?>" class="span6 " />

                <p class="help-block"></p>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" >SEO tags </label>
            <div class="controls">

                <input type="text" name="meta_tags" id="meta_tags" value="<?php echo ($data) ? $data->meta_tags : ""; ?>" class="span6 " />

                <p class="help-block"></p>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" >SEO url </label>
            <div class="controls">

                <input type="text" name="url_adresa" id="url_adresa" value="<?php echo ($data) ? $data->url_adresa : ""; ?>" class="span6" />

                <p class="help-block"></p>
            </div>
        </div>

        <div class="control-group">

            <div class="controls">
                <button class="btn btn-success" data-loading-text="Loading...">Uložiť</button>
            </div>
        </div>

    </fieldset>
</form>
 
 
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#nova_galeria").validationEngine('attach', {promptPosition: "bottomRight", autoPositionUpdate: true});
    });
</script>
<script src="<?php echo base_url() ?>admin_assets/js/editor.js"></script>