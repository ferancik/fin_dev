<?php
$this->load->view('admin/spravy', null);
?>
<div class="btn-toolbar">
    <a href="<?php echo site_url('admin/platobnemoduly/paypal_pevne_platby');  ?>" > <button class="btn ">Spat na zoznam pevnych platieb </button></a> 
</div>

<?php
$action = 'admin/platobnemoduly/paypal_pevne_platby_uprava/' . (($data) ? $data->id : "");

echo form_open($action, 'id="paypalpevneplatby" class="form-horizontal" method="post"');
?>
<fieldset>
    <div id="legend">
        <legend class=""><?php echo $text['nazov'] ?> <?php echo ($data) ? " : " . $data->identifikator : ""; ?></legend>
    </div>
    <div class="control-group">
        <label class="control-label" >Identifikator <em class="formee-req">*</em></label>
        <div class="controls">

            <input type="text" name="identifikator" id="identifikator" value="<?php echo ($data) ? $data->identifikator : ""; ?>" class="span6 validate[required,maxSize[100]]" />

            <p class="help-block">pouziva sa pri volani platby</p>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" >Popis  <em class="formee-req">*</em></label>
        <div class="controls">

            <textarea type="text" name="popis" id="popis" class="span6 validate[required]" ><?php echo ($data) ? $data->popis : ""; ?></textarea>

            <p class="help-block"></p>
        </div>
    </div>
    
      <div class="control-group">
        <label class="control-label" >Nazov polozky <em class="formee-req">*</em></label>
        <div class="controls">

            <input type="text" name="item_name" id="item_name" value="<?php echo ($data) ? $data->item_name  : ""; ?>" class="span6 validate[required,maxSize[100]]" />

            <p class="help-block">Zobrazuje sa vo formulary paypal-u</p>
        </div>
    </div>

      <div class="control-group">
        <label class="control-label" >Cena <em class="formee-req">*</em></label>
        <div class="controls">

            <input type="text" name="amount" id="amount" value="<?php echo ($data) ? $data->amount  : ""; ?>" class="span2 validate[required,maxSize[100]]" />

            <p class="help-block">Zobrazuje sa vo formulary paypal-u</p>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" >Kod meny </label>
        <div class="controls">

            <input type="text" name="mena" id="mena" value="<?php echo ($data) ? $data->mena : ""; ?>" class="span2 validate[maxSize[15]]" />

            <p class="help-block">Mena ktora sa pouzije. napr.: EUR, USD.  Ak nebude zadana pouzije sa defaultna mena z nastaveni paypal-u</p>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" >Pocet jednotiek <em class="formee-req">*</em></label>
        <div class="controls">

            <input type="text" name="quantity" id="quantity" value="<?php echo ($data) ? $data->quantity : ""; ?>" class="span2 validate[required,maxSize[200]]" />

            <p class="help-block">Defaultna hodnota je: 1ks</p>
        </div>
    </div>
    
     <div class="control-group">
        <label class="control-label" >Url pre validaciu platby <em class="formee-req">*</em></label>
        <div class="controls">

            <input type="text" name="notify_url" id="notify_url" value="<?php echo ($data) ? $data->notify_url : ""; ?>" class="span6 validate[required,maxSize[200]]" />

            <p class="help-block">a logovanie platby</p>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" >Url ak je platba OK <em class="formee-req">*</em></label>
        <div class="controls">

            <input type="text" name="return" id="return" value="<?php echo ($data) ? $data->return : ""; ?>" class="span6 validate[required,maxSize[200]]" />

            <p class="help-block"></p>
        </div>
    </div>
    
      <div class="control-group">
        <label class="control-label" >Url ak je platba Zrusena <em class="formee-req">*</em></label>
        <div class="controls">

            <input type="text" name="cancel_return" id="cancel_return" value="<?php echo ($data) ? $data->cancel_return : ""; ?>" class="span6 validate[required,maxSize[200]]" />

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
        jQuery("#paypalpevneplatby").validationEngine('attach', {promptPosition: "bottomRight", autoPositionUpdate: true});
    });
</script>
