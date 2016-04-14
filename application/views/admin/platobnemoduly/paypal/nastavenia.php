<?php
$this->load->view('admin/spravy', null);
?>


<div class="btn-toolbar">
    <a href="<?php echo site_url('admin/platobnemoduly/paypal_pevne_platby')  ?>" > <button class="btn ">Spat na pevne platby </button></a> 
</div>

<?php
$action = 'admin/platobnemoduly/paypal_nastavenia/';

echo form_open($action, 'id="paypalnastavenia" class="form-horizontal" method="post"');
?>
<fieldset>
    <div id="legend">
        <legend class="">PayPal Hlavne Nastavenia</legend>
    </div>
    <div class="control-group">
        <label class="control-label" >PayPal ucet <em class="formee-req">*</em></label>
        <div class="controls">

            <input type="text" name="paypal_email" id="paypal_email" value="<?php echo ($data) ? $data->paypal_email : ""; ?>" class="span6 validate[required,maxSize[200]]" />

            <p class="help-block"></p>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" >Kod meny <em class="formee-req">*</em></label>
        <div class="controls">

            <input type="text" name="paypal_currency_code" id="paypal_currency_code" value="<?php echo ($data) ? $data->paypal_currency_code : ""; ?>" class="span2 validate[required,maxSize[200]]" />

            <p class="help-block">Defaultny kod, ktory sa pouzije ak nebude zadana mena. napr.: EUR, USD, GBP, ...</p>
        </div>
    </div>
    
        <div class="control-group">
        <label class="control-label" >Lokalizacia prostredia </label>
        <div class="controls">
            <input type="text" name="language" id="language" value="<?php echo ($data) ? $data->language : ""; ?>" class="span2 validate[maxSize[5]]" />
            <p class="help-block">Dustupne jazyky: AU, AT, BE, BR, CA, CH, CN, DE, ES, GB, FR, IT, NL, PL, PT, RU, US je default
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
        <label class="control-label" >PayPal Live <em class="formee-req">*</em></label>
        <div class="controls">

            <?php echo form_dropdown("paypal_live", array('1' => 'Ano', '0' => 'Pouzit sandbox'), $data->paypal_live, ' id="paypallive" class="span2 validate[required]" '); ?>

            <p class="help-block">aku metodu pre platenie bude system vyuzivat</p>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" >Povolit logovanie <em class="formee-req">*</em></label>
        <div class="controls">

            <?php echo form_dropdown("ipn_log", array('0' => 'Nie', '1' => 'Ano'), $data->ipn_log, ' id="paypallogovanie" class="span2 validate[required]" '); ?>

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
</form>

<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#paypalnastavenia").validationEngine('attach', {promptPosition: "bottomRight", autoPositionUpdate: true});
    });
</script>
