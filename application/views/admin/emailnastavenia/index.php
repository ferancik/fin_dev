<?
$this->load->view('admin/spravy', null);

$action = 'admin/emailnastavenia/upravit';
echo form_open($action, 'id="emailNastavenia" class="form-horizontal" method="post"');
?>
<fieldset>
    <div id="legend">
        <legend class="">Email nastavenia</legend>
    </div>
    <div class="control-group">
        <label class="control-label" >Email pre odosielanie <em class="formee-req">*</em></label>
        <div class="controls">
            <input type="text"  class="span6 validate[required,maxSize[80]]" id="email_odosielania" name="email_odosielania" value="<?= ($data) ? $data->email_odosielania : ""; ?>" />
            <p class="help-block"></p>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" >Text Email pre odosielanie <em class="formee-req">*</em></label>
        <div class="controls">
            <input type="text"  class="span6 validate[required,maxSize[200]]" id="email_odosielania_meno" name="email_odosielania_meno" value="<?= ($data) ? $data->email_odosielania_meno : ""; ?>" />
            <p class="help-block"></p>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" >Email pre odpoved <em class="formee-req">*</em></label>
        <div class="controls">
            <input type="text"  class="span6 validate[required,maxSize[80]]" id="email_pre_odpoved" name="email_pre_odpoved" value="<?= ($data) ? $data->email_pre_odpoved : ""; ?>" />
            <p class="help-block"></p>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" >Funkcia pre odosielanie <em class="formee-req">*</em></label>
        <div class="controls">

            <?php echo form_dropdown("protocol", array('mail' => 'Funkcia mail()', 'smtp' => 'protokol SMTP'), $data->protocol, ' id="protocolSelect" class="span6 validate[required]" '); ?>
            <p class="help-block"> protokol SMPT vyzaduje dalsie nastavenia</p>
        </div>
    </div>

    <div id="smtp_settnigs" style="<?php echo (($data->protocol == 'smtp') ? '' : 'display: none;'); ?>">
        <div class="control-group">
            <label class="control-label" >SMTP server <em class="formee-req">*</em></label>
            <div class="controls">
                <input type="text"  class="span6 validate[required,maxSize[200]]" id="smtp_server" name="smtp_server" value="<?= ($data) ? $data->smtp_server : ""; ?>" />
                <p class="help-block"></p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >SMTP port <em class="formee-req">*</em></label>
            <div class="controls">
                <input type="text"  class="span2 validate[required,maxSize[10]]" id="smtp_port" name="smtp_port" value="<?= ($data) ? $data->smtp_port : ""; ?>" />
                <p class="help-block"></p>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" >SMTP username <em class="formee-req">*</em></label>
            <div class="controls">
                <input type="text"  class="span6 validate[required,maxSize[200]]" id="smtp_user" name="smtp_user" value="<?= ($data) ? $data->smtp_user : ""; ?>" />
                <p class="help-block"></p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >SMTP password <em class="formee-req">*</em></label>
            <div class="controls">
                <input type="password"  class="span6 validate[required,maxSize[200]]" id="smtp_pass" name="smtp_pass" value="<?= ($data) ? $data->smtp_pass : ""; ?>" />
                <p class="help-block"></p>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" >SMTP Secure</label>
            <div class="controls">
                <input type="text"  class="span2 validate[maxSize[10]]" id="smtp_secure" name="smtp_secure" value="<?= ($data) ? $data->smtp_secure : ""; ?>" />
                <p class="help-block">SMTP Encryption. Can be null, tls or ssl</p>
            </div>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" >Email type <em class="formee-req">*</em></label>
        <div class="controls">
            <?php echo form_dropdown("mailtype", array('text' => 'txt', 'html' => 'HTML'), $data->mailtype, ' id="mailtype" class="span2 validate[required]" '); ?>
            <p class="help-block"></p>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" >Email priority <em class="formee-req">*</em></label>
        <div class="controls">
            <?php echo form_dropdown("priority", array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'), $data->priority, ' id="priority" class="span2 validate[required]" '); ?>
            <p class="help-block">1 = highest, 5 = lowest, 3 = normal </p>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" >Email Charset <em class="formee-req">*</em></label>
        <div class="controls">
            <input type="text"  class="span2 validate[required,maxSize[10]]" id="charset" name="charset" value="<?= ($data) ? $data->charset : ""; ?>" />
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
        jQuery("#emailNastavenia").validationEngine('attach', {promptPosition: "bottomRight", autoPositionUpdate: true});
    });


    $("#protocolSelect").change(function() {
        var coJeVybrate = $(this).val();

        if (coJeVybrate == 'smtp') {
            $("#smtp_settnigs").show();
        }else{
            $("#smtp_settnigs").hide();
        }
    });
</script>