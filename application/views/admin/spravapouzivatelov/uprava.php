<?php
$this->load->view('admin/spravy', null);
?>
<?php
$action =  'admin/spravapouzivatelov/uprava/'.(($data) ? $data->id : ""); 
echo form_open($action, 'id="nova_stranka" class="form-horizontal" method="post"');
?>
    <fieldset>
        <div id="legend">
            <legend class=""><?php echo $text['nazov'] ?> <?php echo ($data) ? " : " . $data->username : ""; ?></legend>
        </div>
        <div class="control-group">
            <label class="control-label" >Username <em class="formee-req">*</em></label>
            <div class="controls">
                <input type="text" name="username" id="username" value="<?php echo ($data) ? $data->username : ""; ?>" class="span6 validate[required,maxSize[200]]" />

                <p class="help-block"></p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >Email <em class="formee-req">*</em></label>
            <div class="controls">
                <input type="text" name="email" id="email" value="<?php echo ($data) ? $data->email : ""; ?>" class="span6 validate[required,maxSize[200],email]" />
                <p class="help-block"></p>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" >Password <?php echo ($data) ? "" : '<em class=\'formee-req\'>*</em>'; ?></label>
            <div class="controls">
                <input type="password" name="password" id="password"  class="span6 <?php echo ($data) ? "" : 'validate[required]'; ?> " />
                <p class="help-block"><?php echo ($data) ? "Zadajte heslo ak ho chcete zmenit" : ''; ?></p>
                
            </div>
        </div>
        
         <div class="control-group">
            <label class="control-label" >Opravnenia <em class="formee-req">*</em></label>
            <div class="controls">
              <?php
              $js = 'id="opravnenia" class="span6 validate[required]"';
             echo  form_dropdown('opravnenia', $data_opravnenia, $data->admin_permission_id,$js); 
             
             ?>
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
        jQuery("#nova_stranka").validationEngine('attach', {promptPosition: "bottomRight", autoPositionUpdate: true});
    });
</script>