<form action="<?php echo site_url('admin/partnery/ulozit'); ?>" id="novy_partner" class="form-horizontal" method="post" enctype="multipart/form-data">
    <fieldset>
        <div id="legend">
            <legend class="">Pridať partnera</legend>
        </div>
        <input type="hidden" name="id_partner" id="id_slider" value="<?php echo ($partner == FALSE) ? "novy" : $partner['id']; ?>" />

        <div class="control-group">
            <label class="control-label" >Názov <em class="formee-req">*</em></label>
            <div class="controls">
                <input type="text" name="nazov" id="nazov" value="<?php echo ($partner == FALSE) ? "" : $partner['nazov']; ?>" class="span6 validate[required,maxSize[50]]" />
                <p class="help-block">Názov partnera.</p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >Url</label>
            <div class="controls">
                <input type="text" name="url" id="url" value="<?php echo ($partner == FALSE) ? "" : $partner['url']; ?>"  class="span6"/>
                <p class="help-block">Url ktorá bude odkazovať na partnera. Musí byť v tvare http://www.partner.sk</p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >Popis</label>
            <div class="controls">
                <div class="grid-9-12"><input type="text" value="<?php echo ($partner == FALSE) ? "" : $partner['popis']; ?>" name="popis" id="popis" class="span6 validate[maxSize[250]]" /></div>
                <p class="help-block"></p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >Logo</label>
            <div class="controls">
                <input type="file" name="logo" class="span6"/>
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
    jQuery(document).ready(function(){
        jQuery("#novy_partner").validationEngine('attach', {promptPosition : "bottomRight", autoPositionUpdate : true});
    });
</script>