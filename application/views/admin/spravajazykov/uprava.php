<?php
$this->load->view('admin/spravy', null);

$action =  'admin/spravajazykov/uprava/'.(($data) ? $data->id : ""); 
echo form_open($action, 'id="nova_stranka" class="form-horizontal" method="post"');
?>
   <fieldset>
        <div id="legend">
            <legend class=""><?php echo $text['nazov'] ?> <?php echo ($data) ? " : " . $data->name : ""; ?></legend>
        </div>
        <div class="control-group">
            <label class="control-label" >Názov <em class="formee-req">*</em></label>
            <div class="controls">

                <input type="text" name="name" id="name" value="<?php echo ($data) ? $data->name : ""; ?>" class="span6 validate[required,maxSize[100]]" />

                <p class="help-block"></p>
            </div>
        </div>
  
        <div class="control-group">
            <label class="control-label" >Status <em class="formee-req">*</em></label>
            <div class="controls">

               <?php echo form_dropdown("active", array('1'=>'Active', '2'=>'Deactive'), $data->active, ' id="active" class="span6 validate[required]" '); ?>
                <p class="help-block"></p>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" >ISO code <em class="formee-req">*</em></label>
            <div class="controls">

                <input type="text" name="iso_code" id="iso_code" value="<?php echo ($data) ? $data->iso_code : ""; ?>" class="span6 validate[required,maxSize[15]]" />

                <p class="help-block"></p>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" >Icon <em class="formee-req">*</em></label>
            <div class="controls">

                <input type="text" name="icon" id="icon" value="<?php echo ($data) ? $data->icon : ""; ?>" class="span6 validate[required,maxSize[100]]" />

                <p class="help-block">Ikony su tu: <?php echo base_url().'admin_assets/flag/';?></p>
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