<?php
$this->load->view('admin/spravy', null);


$action = 'admin/nastavenia/upravitObecne';
echo form_open($action, 'id="obecneNastavenia" class="form-horizontal" method="post"');
?>      
<fieldset>
    <div id="legend">
        <legend class="">Obecné nastavenia</legend>
    </div>
    <div class="control-group">
        <label class="control-label" >Názov webu <em class="formee-req">*</em></label>
        <div class="controls">


            <input type="text"  class="span6 validate[required,maxSize[200]]" id="nazov_webu" name="nazov_webu" value="<?php echo ($data) ? $data->nazov_webu : ""; ?>" />
            <p class="help-block"></p>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" >Default Language <em class="formee-req">*</em></label>
        <div class="controls">

  <?php 
            echo form_dropdown('default_language', $activeLanguage, $defaultLanguage,'class="span4 validate[required] " id="default_language"');
            ?>
            
            <p class="help-block"></p>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" >Meta desc <em class="formee-req">*</em></label>
        <div class="controls">
            <textarea  class="span6 validate[required,maxSize[200]]" id="meta_desc" name="meta_desc" rows="3"><?php echo ($data) ? $data->meta_desc : ""; ?></textarea>

            <p class="help-block"></p>
        </div>
    </div>


    <div class="control-group">
        <label class="control-label" >Meta tags <em class="formee-req">*</em></label>
        <div class="controls">


            <input type="text"  class="span6 validate[required,maxSize[200]]" id="meta_tags" name="meta_tags" value="<?php echo ($data) ? $data->meta_tags : ""; ?>" />
            <p class="help-block"></p>
        </div>
    </div>



    <div class="control-group">
        <label class="control-label" >Záhlavie webu</label>
        <div class="controls">
            <textarea  class="span6 validate[required,maxSize[200]]" id="zahlavie_webu" name="zahlavie_webu" rows="3"><?php echo ($data) ? $data->zahlavie_webu : ""; ?></textarea>

            <p class="help-block"></p>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" >Footer webu</label>
        <div class="controls">
            <textarea  class="span6 validate[required,maxSize[200]]" id="footer_webu" name="footer_webu" rows="3"><?php echo ($data) ? $data->footer_webu : ""; ?></textarea>

            <p class="help-block"></p>
        </div>
    </div>

    <hr/>
     <div class="control-group">
        <label class="control-label" >Format casu <em class="formee-req">*</em></label>
        <div class="controls">
            <input  type="text"  class="span4 validate[required,maxSize[200]] " id="date_format" name="date_format"  value="<?php echo ($data) ? $data->date_format : ""; ?>"/>

            <p class="help-block"></p>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" >Casove pasmo <em class="formee-req">*</em></label>
        <div class="controls">
            <?php 
            echo form_dropdown('time_zone', $time_zones, $data->time_zone,'class="span6 validate[required] " id="time_zone"');
            ?>
            <p class="help-block"></p>
        </div>
    </div>
    <hr/>
    
     <div class="control-group">
        <label class="control-label" >Google Tracking Code </label>
        <div class="controls">
            <textarea  class="span6 " id="google_gode" name="google_gode" rows="4"><?php echo ($data) ? $data->google_gode : ""; ?></textarea>

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

<?php

$action = 'admin/nastavenia/upravitKontakt';
echo form_open($action, 'id="kontaktneInformacie" class="form-horizontal" method="post"');

?>
<fieldset>
    <div id="legend">
        <legend class="">Kontaktné informácie</legend>
    </div>

    <div class="control-group">
        <label class="control-label" >Email <em class="formee-req">*</em></label>
        <div class="controls">


            <input type="text"  class="span6 validate[required,maxSize[200]]" id="email_pre_kontakt" name="email_pre_kontakt" value="<?php echo ($data) ? $data->email_pre_kontakt : ""; ?>" />
            <p class="help-block">email na ktory bude odosielany kontaktny email zo stranky</p>
        </div>
    </div>


    <div class="control-group">

        <div class="controls">
            <button class="btn btn-success" data-loading-text="Loading...">Uložiť</button>
        </div>
    </div>
</fieldset>
</form>
<div class="clear"></div>


<?php

$action = 'admin/nastavenia/upravitga';
echo form_open($action, 'id="googlea" class="form-horizontal" method="post"');

?>
<fieldset>
    <div id="legend">
        <legend class="">Pre zobrazenie statistik na DashBoarde</legend>
    </div>

    <div class="control-group">
        <label class="control-label" >Google Analytic profil ID</label>
        <div class="controls">
            <input type="text"  class="span6 validate[maxSize[200]]" id="ga_profil" name="ga_profil" value="<?php echo ($data) ? $data->ga_profil : ""; ?>" />
            <p class="help-block"></p>
        </div>
    </div>
  
     <div class="control-group">
        <label class="control-label" >Google Analytic E-mail </label>
        <div class="controls">

            <input type="text"  class="span6 validate[maxSize[200]]" id="ga_user" name="ga_user" value="<?php echo ($data) ? $data->ga_user : ""; ?>" />
            <p class="help-block"></p>
        </div>
    </div>
     <div class="control-group">
        <label class="control-label" >Google Analytic heslo</label>
        <div class="controls">


            <input type="password"  class="span6 validate[maxSize[200]]" id="ga_pass" name="ga_pass" value="<?php echo ($data) ? $data->ga_pass : ""; ?>" />
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
<div class="clear"></div>


<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#obecneNastavenia").validationEngine('attach', {promptPosition: "bottomRight", autoPositionUpdate: true});
    });
    jQuery(document).ready(function() {
        jQuery("#kontaktneInformacie").validationEngine('attach', {promptPosition: "bottomRight", autoPositionUpdate: true});
    });
     jQuery(document).ready(function() {
        jQuery("#googlea").validationEngine('attach', {promptPosition: "bottomRight", autoPositionUpdate: true});
    });
    
</script>

