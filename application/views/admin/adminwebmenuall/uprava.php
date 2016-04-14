<?
$this->load->view('admin/spravy', null);

$action = 'admin/adminwebmenuall/uprava/' . (($data) ? $data->id : "");
echo form_open($action, 'id="novy_typ_menu" class="form-horizontal" method="post"');
?>
<fieldset>
    <div id="legend">
        <legend class=""><?php echo $text['nazov'] ?> <?php echo ($data) ? " : " . $data->identifikator : ""; ?></legend>
    </div>
    <div class="control-group">
        <label class="control-label" >Identifikator <em class="formee-req">*</em></label>
        <div class="controls">
            <input type="text" name="identifikator" id="identifikator" value="<?php echo ($data) ? $data->identifikator : ""; ?>" class="span6 validate[required,maxSize[100]]" />

            <p class="help-block"></p>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" >Popis <em class="formee-req">*</em></label>
        <div class="controls">
            <input type="text" name="popis" id="popis" value="<?php echo ($data) ? $data->popis : ""; ?>" class="span6 validate[required,]" />

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
        jQuery("#novy_typ_menu").validationEngine('attach', {promptPosition: "bottomRight", autoPositionUpdate: true});
    });
</script>