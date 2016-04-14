<?php
$this->load->view('admin/spravy', null);

$action =  'admin/opravneniaskupiny/uprava/'.(($data) ? $data->id : ""); 
echo form_open($action, 'id="nova_stranka" class="form-horizontal" method="post"');
?>
   <fieldset>
        <div id="legend">
            <legend class=""><?php echo $text['nazov'] ?> <?php echo ($data) ? " : " . $data->nazov : ""; ?></legend>
        </div>
        <div class="control-group">
            <label class="control-label" >Názov <em class="formee-req">*</em></label>
            <div class="controls">

                <input type="text" name="nazov" id="nazov" value="<?php echo ($data) ? $data->nazov : ""; ?>" class="span6 validate[required,maxSize[200]]" />

                <p class="help-block"></p>
            </div>
        </div>
   <div class="control-group">
            <label class="control-label" >Opravnenia <em class="formee-req">*</em></label>
            <div class="controls">
              <?php
              $js = 'id="menu_povolene" class="validate[required] span6 " title="Vyberte povolene sekcie" ';
             echo  form_multiselect('menu_povolene[]', $menu_data, $oznacene_menu,$js); 
             
             ?>
                  <p class="help-block" ></p>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" >Popis </label>
            <div class="controls">
                <textarea type="text" name="popis"   class="span6" id="popis"  ><?php echo ($data) ? $data->popis : ""; ?> </textarea>

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
        jQuery("#nova_stranka").validationEngine('attach', {promptPosition: "bottomRight", autoPositionUpdate: true});
    });
    $(document).ready(function() {
			$("select[multiple]").asmSelect({
				addItemTarget: 'bottom',
				animate: true,
				highlight: true,
				sortable: false
			});
			
		}); 

    
</script>