<form action="<?php echo site_url('admin/sliders/ulozit'); ?>" id="novy_slider" class="form-horizontal" method="post">

    <fieldset>
        <div id="legend">
            <legend class="">Pridať nový slider</legend>
        </div>

        <input type="hidden" name="id_slider" id="id_slider" value="<?php echo ($slider == FALSE) ? "novy" : $slider['id']; ?>" />

        <div class="control-group">
            <label class="control-label" >Názov<em class="formee-req">*</em></label>
            <div class="controls">


                <input type="text" name="nazov" id="nazov" value="<?php echo ($slider == FALSE) ? "" : $slider['nazov']; ?>" class="span6 validate[required,maxSize[50]]" />
                <p class="help-block"></p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >Umiestnenie<em class="formee-req">*</em></label>
            <div class="controls">
                <input type="text" name="umiestnenie" id="umiestnenie" value="<?php echo ($slider == FALSE) ? "" : $slider['umiestnenie']; ?>" class="span6 validate[required, maxSize[50]]" />
                <p class="help-block">Kde sa má zobrazovať daný slider</p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >Popis<em class="formee-req">*</em></label>
            <div class="controls">
                <input type="text" value="<?php echo ($slider == FALSE) ? "" : $slider['popis']; ?>" name="popis" id="popis" class="span6"/>
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
        jQuery("#novy_slider").validationEngine('attach', {promptPosition : "bottomRight", autoPositionUpdate : true});
    });
</script>