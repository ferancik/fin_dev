<?php
$this->load->view('admin/spravy', null);

?>
<form action="<?php echo site_url('admin/stranky/uprava/' . (($data) ? $data->id : ""))?>" id="nova_stranka" class="form-horizontal" method="post">
<fieldset>
    <div id="legend">
        <legend class=""><?php echo $texty['nazov'] ?> <?php echo ($data) ? " : " . $data->nazov : ""; ?></legend>
    </div>
    <div class="control-group">
        <label class="control-label" >Názov <em class="formee-req">*</em></label>
        <div class="controls">

            <input type="text" name="nazov" id="nazov" value="<?php echo ($data) ? $data->nazov : ""; ?>" class="span6 validate[required,maxSize[200]]" />

            <p class="help-block"></p>
        </div>
    </div>


    <ul id="myTab" class="nav nav-tabs">
        <?php foreach ($alljazyky as $value) { ?>
            <li><a href="#jazyk_<?php echo $value->id; ?>"  data-toggle="tab" ><img src="<?php echo base_url().'admin_assets/flag/'.$value->icon; ?>" alt="<? echo $value->iso_code; ?>" /> <?php echo ucfirst($value->name); ?> <?php echo (($value->default == 1) ? '<em class="formee-req">*</em>' : ''); ?></a></li>
        <?php } ?>

    </ul>

    <div id="myTabContent" class="tab-content">
        <?php foreach ($alljazyky as $value) { ?>
            <div id="jazyk_<?= $value->id; ?>" class="tab-pane fade" >
                <?php
                if ($data) {
                    $dataJazykov = $this->admin_web_menu_langs_m->getStrankyLanguage($data->id, $value->id);
                } else {
                    $dataJazykov = "";
                }
                ?>


                <div class="control-group">
                    <label class="control-label" >Obsah <?php echo (($value->default == 1) ? '<em class="formee-req">*</em>' : ''); ?></label>
                    <div class="controls">
                        <textarea type="text" name="obsah_<?php echo $value->id; ?>"   class="tinymceEditor span6 <?php echo (($value->default == 1) ? ' validate[required] ' : ''); ?>" id="obsah_<?php echo $value->id; ?>"  ><?php echo ($data) ? $dataJazykov->obsah : ""; ?> </textarea>

                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" >Meta Description</label>
                    <div class="controls">


                        <textarea type="text" name="seo_popis_<?php echo $value->id; ?>"   class="span6 validate[maxSize[155]]" id="seo_popis_<?php echo $value->id; ?>"  ><?php echo ($data) ? $dataJazykov->seo_popis : ""; ?></textarea>

                        <p class="help-block"><span id="countdownwrap_<?php echo $value->id; ?>"><strong id="countdown_<?php echo $value->id; ?>" ></strong> Ostava</span></p>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" >Tags & Keywords</label>
                    <div class="controls">

                        <input type="text" name="seo_tagy_<?php echo $value->id; ?>" id="seo_tagy_<?php echo $value->id; ?>" value="<?php echo ($data) ? $dataJazykov->seo_tagy : ""; ?>" class="span6 validate[maxSize[200]]" />


                    </div>
                </div>
            </div>

            <script type="text/javascript">
                function updateMetaDescriptionCounter() {
                    var remaining = 155 - jQuery('#seo_popis_<?php echo $value->id; ?>').val().length;
                    jQuery('#countdown_<?php echo $value->id; ?>').text(remaining);
                }
                if ($('#seo_popis_<?php echo $value->id; ?>').length) {
                    updateMetaDescriptionCounter();
                    $('#seo_popis_<?php echo $value->id; ?>').change(updateMetaDescriptionCounter);
                    $('#seo_popis_<?php echo $value->id; ?>').keyup(updateMetaDescriptionCounter);
                }

            </script>
        <? } ?>
    </div>
    <hr>





    <? if ($prihlaseny_user->admin_permission == 1) { ?>

        <div class="control-group">
            <label class="control-label" >Typ stranky <em class="formee-req">*</em></label>
            <div class="controls">

                <?
                $selected = ($data->pevna == 1 || $data->pevna == 0) ? $data->pevna : '';
                echo form_dropdown('typ_Stranky', array('' => '- Vyberte typ stranky -', '0' => 'Uzivatelska', '1' => 'Systemova'), $selected, 'class="span6 validate[required]" id="typStranky_sel"');
                ?>
                <p class="help-block"></p>
            </div>
        </div>


        <?
    }
    //  if ($data->pevna != 1) {

    if ($prihlaseny_user->admin_permission == 1) {
        $styles = 'display: none;';

        if (isset($data)) {
            $styles = '';
            switch ($data->pevna) {
                case 1:
                    $nazov_s = 'Kontroler stranky <em class="formee-req">*</em>';
                    $help_s = 'Zadajte kontroler pre volanie stranky';
                    $vauleSeo = $data->kod_pre_zavolanie;
                    break;
                case 0:
                    $nazov_s = 'URL pre zobrazenie stránky <em class="formee-req">*</em>';
                    $help_s = base_url() . $this->config->item('CONTROLER_PRE_OBSLUHU_UZIVATELSKYCH_STRANOK'). ' vasa URL pre zobrazenie stránky';
                    $vauleSeo = $data->seo_url;
                    break;
                default :
                    break;
            }
        }
    } else {
        $nazov_s = 'URL pre zobrazenie stránky <em class="formee-req">*</em>';
        $help_s = base_url() . $this->config->item('CONTROLER_PRE_OBSLUHU_UZIVATELSKYCH_STRANOK'). ' vasa URL pre zobrazenie stránky';
    }

    if ($prihlaseny_user->admin_permission == 1) {
        ?>

        <div id="control_group_UrlStranky" style="<?= $styles ?>" class="control-group">
            <label class="control-label" id="labelUrlStranky" ><?= $nazov_s ?></label>
            <div class="controls">

                <input type="text" name="seo_url" id="seo_url" value="<?php echo ($data) ? $vauleSeo : ""; ?>" class="span6 validate[required,maxSize[200]]" />

                <p class="help-block" id="labelHelpStranky"><?= $help_s ?></p>
            </div>
        </div>

    <? } else if ($data->pevna != 1) { ?>
        <div id="control_group_UrlStranky" style="<?= $styles ?>" class="control-group">
            <label class="control-label" id="labelUrlStranky" ><?= $nazov_s ?></label>
            <div class="controls">

                <input type="text" name="seo_url" id="seo_url" value="<?php echo ($data) ? $vauleSeo : ""; ?>" class="span6 validate[required,maxSize[200]]" />

                <p class="help-block" id="labelHelpStranky"><?= $help_s ?></p>
            </div>
        </div>
    <? } ?>

    <!-- <div class="control-group">
    
                <div class="controls">
                    <button class="btn btn-success" data-loading-text="Loading...">Uložiť</button>
                </div>
            </div>-->
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Uložiť</button>

    </div>


</fieldset>
</form>


<script type="text/javascript">
    $('#myTab a:first').tab('show');

    $('#myTab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });

    jQuery(document).ready(function() {


<? if ($prihlaseny_user->admin_permission == 1) { ?>

            $("#typStranky_sel").change(function() {
                var coJeVybrate = $(this).val();

                if (coJeVybrate == 0) {
                    $("#labelUrlStranky").html('URL pre zobrazenie stránky <em class="formee-req">*</em>');
                    $("#labelHelpStranky").html('<?= base_url().$this->config->item('CONTROLER_PRE_OBSLUHU_UZIVATELSKYCH_STRANOK') ?> vasa URL pre zobrazenie stránky');

                    $("#control_group_UrlStranky").show();
                } else if (coJeVybrate == 1) {
                    $("#labelUrlStranky").html('Kontroler stranky <em class="formee-req">*</em>');
                    $("#labelHelpStranky").html('Zadajte kontroler pre volanie stranky');
                    $("#control_group_UrlStranky").show();
                } else {
                    $("#control_group_UrlStranky").hide();
                    $("#labelHelpStranky").html('');
                }

            });

<? } ?>


        jQuery("#nova_stranka").validationEngine('attach', {promptPosition: "bottomRight", autoPositionUpdate: true});
    });
</script>
<script src="<?php echo base_url() ?>admin_assets/js/editor.js"></script>