<?php
$this->load->view('admin/spravy', null);

 echo form_open('admin/dokumenty/ulozit', array('id'=>'novy_dokument', 'class'=>'form-horizontal', 'enctype'=>'multipart/form-data')); ?>
    <fieldset>
        <div id="legend">
            <legend class=""><?php echo lang('new_document'); ?></legend>
        </div>
        <input type="hidden" name="id_dokument" id="id_dokument" value="<?php echo ($dokument == FALSE) ? "novy" : $dokument['id']; ?>" />

        <div class="control-group">
            <label class="control-label" ><?php echo  lang('title'); ?><em class="formee-req">*</em></label>
            <div class="controls">
                <input type="text" name="nazov" id="nazov" value="<?php echo ($dokument == FALSE) ? "" : $dokument['nazov']; ?>" class="span6 validate[required,maxSize[45]]" />
                <p class="help-block"></p>
            </div>
        </div>
        
        
        <div class="control-group">
            <label class="control-label" ><?php echo  lang('document'); ?> <em class="formee-req">*</em></label>
            <div class="controls">
                <input type="file" name="dokument"  <?php echo ($dokument == FALSE) ? ' class="span6 validate[required] "' : 'class="span6" '; ?> />
                <p class="help-block"><?php echo ($dokument == FALSE) ? "" : $dokument['dokument']; ?></p>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" ><?php echo  lang('description'); ?> </label>
            <div class="controls">
                <textarea  name="popis" id="popis" class="span6 validate[maxSize[250]]" rows="4"><?php echo ($dokument == FALSE) ? "" : $dokument['popis']; ?></textarea>
                <p class="help-block"></p>
            </div>
        </div>
        
        
        <div class="control-group">

            <div class="controls">
                <button class="btn btn-success" data-loading-text="Loading..."><?php echo  lang('save'); ?></button>
            </div>
        </div>
        
    </fieldset>
</form>



<script type="text/javascript"> 
    jQuery(document).ready(function(){
        jQuery("#vovy_dokument").validationEngine('attach', {promptPosition : "bottomRight", autoPositionUpdate : true});
    });
</script>