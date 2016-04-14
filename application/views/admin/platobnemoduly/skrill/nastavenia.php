<?php
$this->load->view('admin/spravy', null);
?>
<div class="btn-toolbar">
    <a href="<?php echo site_url('admin/platobnemoduly/skrill_pevne_platby')  ?>" > <button class="btn ">Spat na pevne platby </button></a> 
</div>

<?php
$action = 'admin/platobnemoduly/skrill_nastavenia/';

echo form_open($action, 'id="skrillnastavenia" class="form-horizontal" method="post"');
?>
<fieldset>
    <div id="legend">
        <legend class="">Skrill Hlavne Nastavenia</legend>
    </div>
    <div class="control-group">
        <label class="control-label" >Skrill ucet <em class="formee-req">*</em></label>
        <div class="controls">

            <input type="text" name="pay_to_email" id="pay_to_email" value="<?php echo ($data) ? $data->pay_to_email : ""; ?>" class="span6 validate[required,maxSize[50]]" />

            <p class="help-block"></p>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" >Hashovacie Slovo <em class="formee-req">*</em></label>
        <div class="controls">

            <input type="password" name="hashovacieSlovo" id="hashovacieSlovo" value="<?php echo ($data) ? $data->hashovacieSlovo : ""; ?>" class="span6 validate[required,maxSize[50]]" />

            <p class="help-block">Vygenerujete v sprave uctu skrill</p>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" >Popis prijemcu </label>
        <div class="controls">
            <input type="text" name="recipient_description" id="recipient_description" value="<?php echo ($data) ? $data->recipient_description : ""; ?>" class="span6 validate[maxSize[30]]" />
            <p class="help-block">Zobrazi sa v prostredi skrillu, ak nebude zadany zobrazi sa Skrill ucet</p>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" >Kod meny <em class="formee-req">*</em></label>
        <div class="controls">
            <input type="text" name="currency" id="currency" value="<?php echo ($data) ? $data->currency : ""; ?>" class="span2 validate[required,maxSize[3]]" />
            <p class="help-block">Defaultny kod, ktory sa pouzije ak nebude zadana mena. napr.: EUR, USD, GBP, (podla ISO-4217)</p>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" >Jazyk prostredia <em class="formee-req">*</em></label>
        <div class="controls">
            <input type="text" name="language" id="language" value="<?php echo ($data) ? $data->language : ""; ?>" class="span2 validate[required,maxSize[2]]" />
            <p class="help-block">Dustupne jazyky: EN, DE, ES, FR, IT, PL, GR RO, RU, TR, CN, CZ, NL, DA, SV, FI
</p>
        </div>
    </div>
    
    
    <div class="control-group">
        <label class="control-label" >URL Loga prostredia</label>
        <div class="controls">
            <input type="text" name="logo_url" id="logo_url" value="<?php echo ($data) ? $data->logo_url : ""; ?>" class="span6 validate[maxSize[240]]" />
            <p class="help-block">v tvare http://stranka/logo.png
</p>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" >Povolit logovanie <em class="formee-req">*</em></label>
        <div class="controls">

            <?php echo form_dropdown("logovanie", array('0' => 'Nie', '1' => 'Ano'), $data->logovanie, ' id="logovanie" class="span2 validate[required]" '); ?>

            <p class="help-block"></p>
        </div>
    </div>

    <fieldset>
        <div id="legend">
            <legend class="">Nastavenie stranky pre presmerovanie</legend>
        </div>
        <div class="control-group">
            <label class="control-label" >Nazov stranky  <em class="formee-req">*</em></label>
            <div class="controls">

                <input type="text" name="form_title" id="form_title" value="<?php echo ($data) ? $data->form_title : ""; ?>" class="span6 validate[required,maxSize[200]]" />

                <p class="help-block"></p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >Tlacidlo pre manualne odoslanie  <em class="formee-req">*</em></label>
            <div class="controls">

                <input type="text" name="form_submit" id="form_submit" value="<?php echo ($data) ? $data->form_submit : ""; ?>" class="span6 validate[required,maxSize[200]]" />

                <p class="help-block"></p>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" >Text pri presmerovanie  <em class="formee-req">*</em></label>
            <div class="controls">

                <textarea type="text" name="form_text" id="form_text" class="span6 validate[required]" ><?php echo ($data) ? $data->form_text : ""; ?></textarea>

                <p class="help-block"></p>
            </div>
        </div>

    </fieldset>
    <div class="control-group">

        <div class="controls">
            <button class="btn btn-success" data-loading-text="Loading...">Uložiť</button>
        </div>
    </div>

</fieldset>
Viac informacii na: <a href="https://www.moneybookers.com/merchant/cz/moneybookers_gateway_manual.pdf"  target="_blank">https://www.moneybookers.com/merchant/cz/moneybookers_gateway_manual.pdf</a>
</form>

<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#skrillnastavenia").validationEngine('attach', {promptPosition: "bottomRight", autoPositionUpdate: true});
    });
</script>
