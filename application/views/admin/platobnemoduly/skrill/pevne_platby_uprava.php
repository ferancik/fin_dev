<?php
$this->load->view('admin/spravy', null);
?>


<div class="btn-toolbar">
    <a href="<?php echo base_url() . 'admin/platobnemoduly/skrill_pevne_platby' ?>" > <button class="btn ">Spat na zoznam pevnych platieb </button></a> 
</div>

<?php
$action = 'admin/platobnemoduly/skrill_pevne_platby_uprava/' . (($data) ? $data->id : "");

echo form_open($action, 'id="skrillpevneplatby" class="form-horizontal" method="post"');
?>
<fieldset>
    <div id="legend">
        <legend class=""><?= $text['nazov'] ?> <?php echo ($data) ? " : " . $data->identifikator : ""; ?></legend>
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
            <input type="text" name="detail1_description" id="detail1_description" value="<?php echo ($data) ? $data->detail1_description  : ""; ?>" class="span6 validate[required,maxSize[240]]" />

            <p class="help-block">Zobrazuje sa vo formulary skrill-u</p>
        </div>
    </div>
    
      <div class="control-group">
        <label class="control-label" >Popis polozky <em class="formee-req">*</em></label>
        <div class="controls">

            <input type="text" name="detail1_text" id="detail1_text" value="<?php echo ($data) ? $data->detail1_text  : ""; ?>" class="span6 validate[required,maxSize[240]]" />

            <p class="help-block">Zobrazuje sa vo formulary skrill-u</p>
        </div>
    </div>

     
    
      <div class="control-group">
        <label class="control-label" >Cena <em class="formee-req">*</em></label>
        <div class="controls">

            <input type="text" name="amount" id="amount" value="<?php echo ($data) ? $data->amount  : ""; ?>" class="span2 validate[required,maxSize[10]]" />

            <p class="help-block">Zobrazuje sa vo formulary Skrill-u</p>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" >Kod meny </label>
        <div class="controls">

            <input type="text" name="currency" id="currency" value="<?php echo ($data) ? $data->currency : ""; ?>" class="span2 validate[maxSize[15]]" />

            <p class="help-block">Mena ktora sa pouzije. napr.: EUR, USD.  Ak nebude zadana pouzije sa defaultna mena z nastaveni Skrill-u</p>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" >Poznamka pre potvrdenie </label>
        <div class="controls">

            <input type="text" name="confirmation_note" id="confirmation_note" value="<?php echo ($data) ? $data->confirmation_note : ""; ?>" class="span6 validate[maxSize[240]]" />

            <p class="help-block">Zobrazuje sa vo formulary Skrill-u</p>
        </div>
    </div>
    

     <div class="control-group">
        <label class="control-label" >Url pre validaciu platby <em class="formee-req">*</em></label>
        <div class="controls">

            <input type="text" name="status_url" id="status_url" value="<?php echo ($data) ? $data->status_url : ""; ?>" class="span6 validate[required,maxSize[240]]" />

            <p class="help-block">a logovanie platby</p>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" >Url ak je platba OK <em class="formee-req">*</em></label>
        <div class="controls">

            <input type="text" name="return_url" id="return_url" value="<?php echo ($data) ? $data->return_url : ""; ?>" class="span6 validate[required,maxSize[240]]" />

            <p class="help-block"></p>
        </div>
    </div>
    
      <div class="control-group">
        <label class="control-label" >Url ak je platba Zrusena <em class="formee-req">*</em></label>
        <div class="controls">

            <input type="text" name="cancel_url" id="cancel_url" value="<?php echo ($data) ? $data->cancel_url : ""; ?>" class="span6 validate[required,maxSize[240]]" />

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
        jQuery("#skrillpevneplatby").validationEngine('attach', {promptPosition: "bottomRight", autoPositionUpdate: true});
    });
</script>
