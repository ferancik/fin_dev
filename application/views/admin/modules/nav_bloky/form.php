<?php $this->load->view('admin/spravy', null); ?>
<form action="<?php echo site_url('admin/navbloky/ulozit'); ?>" id="novy_partner" class="form-horizontal" method="post" enctype="multipart/form-data">
    <fieldset>
        <input type="hidden" name="id_navblok" id="id_slider" value="<?php echo ($navBlok == FALSE) ? "novy" : $navBlok['id']; ?>" />
        <div id="legend">
            <legend class="">Novy navigacny blok</legend>
        </div>
        <div class="control-group">
            <label class="control-label" >Nadpis <em class="formee-req">*</em></label>
            <div class="controls">
                <input type="text" name="nadpis" id="nadpis" value="<?php echo ($navBlok == FALSE) ? "" : $navBlok['nadpis']; ?>" class="span6 validate[required,maxSize[45]]" />
                <p class="help-block"></p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >Stránka </label>
            <div class="controls">
                <input type="text" class="span6" name="url" id="url" value="<?php echo ($navBlok == FALSE) ? "" : $navBlok['odkaz_na_stranku']; ?>" />
                <p class="help-block"></p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >Icon </label>
            <div class="controls">
                <input type="file" name="icon" class="span6" />
                <p class="help-block"></p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >Text </label>
            <div class="controls">
                <textarea  name="text" id="text" class="span6 validate[maxSize[250]]" rows="4"><?php echo ($navBlok == FALSE) ? "" : $navBlok['text']; ?></textarea>
                <p class="help-block">Maximálne 250 znakov. zostáva <span class="subtip" id="zostava_znakov"></span></p>
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
        
        $('#text').keypress(function(e) {
            var tval = $('#text').val(),
            tlength = tval.length,
            set = 250,
            remain = parseInt(set - tlength);
            $('#zostava_znakov').text(remain);
            if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
                $('textarea').val((tval).substring(0, tlength - 1));
            }
        });
    });
    
    
</script>