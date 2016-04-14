<?php
$this->load->view('admin/spravy', null);
?>
<?php
$action =  'admin/fotogalerianastavenia/rozlisenie/'.(($data) ? $data->id : ""); 
echo form_open($action, 'id="rozlisenie_edit" class="form-horizontal" method="post"');
?>
    <fieldset>
        <div id="legend">
            <legend class=""><?php echo $text['nazov'] ?> <?php echo ($data) ? " : " . $data->username : ""; ?></legend>
        </div>
        <div class="control-group">
            <label class="control-label" >Názov <em class="formee-req">*</em></label>
            <div class="controls">
                <input type="text" name="nazov" id="nazov" value="<?php echo ($data) ? $data->nazov : ""; ?>" class="span6 validate[required,maxSize[200]]" />

                <p class="help-block"></p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >Šírka (X) <em class="formee-req">*</em></label>
            <div class="controls">
                <input type="text" name="sirka" id="sirka" value="<?php echo ($data) ? $data->sirka : ""; ?>" class="span4 validate[required,maxSize[15]]" />
                <p class="help-block"></p>
            </div>
        </div>
        
         <div class="control-group">
            <label class="control-label" >Výška (Y) <em class="formee-req">*</em></label>
            <div class="controls">
                <input type="text" name="vyska" id="vyska" value="<?php echo ($data) ? $data->vyska : ""; ?>" class="span4 validate[required,maxSize[15]]" />
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
        jQuery("#rozlisenie_edit").validationEngine('attach', {promptPosition: "bottomRight", autoPositionUpdate: true});
    });
</script>