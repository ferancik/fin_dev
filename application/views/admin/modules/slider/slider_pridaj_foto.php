<ul id="myTab" class="nav nav-tabs">
    <li><a href="#tabs-1" ><?php echo $slider['nazov']; ?></a></li>
    <li><a href="#tabs-2" >Pridaj nové fotky</a></li>

</ul>
<div id="myTabContent" class="tab-content">
    <div id="tabs-1" class="tab-pane fade" >	
        <ul id="gallery2" class="fotogallery">

            <?php if ($foto) { ?>
                <?php foreach ($foto as $row) { ?>
                    <li id="foto_<?php echo $row['id']; ?>">
                        <img src="<?php echo base_url(); ?>uploads/images/slider/img/thumb/<?php echo $row['image']; ?>" width="140" height="140" alt="" />
                        <a href="<?php echo site_url('admin/sliders/editfotoslider/'.$row['id']); ?>" data-toggle="modal" class="icon-pencil"></a>
                        <a onclick="return ozaj('Naozaj chcete odstrániť túto fotku <?php echo $row['image']; ?>'); " href="<?php echo site_url('admin/sliders/odstranfoto/'.$row['id_mod_sliders'] . '/' . $row['id']); ?>" class="ui-icon ui-icon-trash"></a>
                    </li>
                <?php } ?>
                <?php
            } else {
                $this->load->view('admin/spravy', array('sprava' => 'info|Neni sú pridané žiadne fotky'));
            }
            ?>

        </ul>
        <div class="clear"></div>

        <div style="display:none;" title="Odstrániť fotografiu" class="dialog_confirm"><p>Naozaj chcete odstrániť túto fotografiu?</p><p>Kliknite na <strong>OK</strong> pre potvrdenie alebo <strong>Cancel</strong> pre zrušenie. </p></div>


    </div>

    <div id="tabs-2"  class="tab-pane fade">								

        <form action="<?php echo site_url('admin/sliders/ulozitfoto'); ?>" id="pridajfoto" class="form-horizontal" method="post" enctype="multipart/form-data">

            <input type="hidden" name="id_foto" id="id_foto" value="novy" />
            <input type="hidden" name="id_slider" id="id_slider" value="<?php echo ($slider == FALSE) ? "" : $slider['id']; ?>" />

            <div class="control-group">
                <label class="control-label" >Nadpis <em class="formee-req">*</em></label>
                <div class="controls">
                    <input type="text" name="napdis" id="nadpis" value="" class="span6 validate[required,maxSize[30]]" />
                    <p class="help-block"></p>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" >Krátky popis <em class="formee-req">*</em></label>
                <div class="controls">
                    <input type="text" name="kratky_popis" id="kratky_popis" value="" class="span6 validate[required, maxSize[100]]" />
                    <p class="help-block">Krátky popis k fotke</p>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" >Url odkaz<em class="formee-req">*</em></label>
                <div class="controls">
                    <input type="text" name="url" id="umiestnenie" value="" class="span6 validate[maxSize[100]]" />
                    <p class="help-block">Url odkazu zadavajte v tvare htt://www.nieco.sk</p>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" >Obrázok<em class="formee-req">*</em></label>
                <div class="controls">
                    <input type="file" name="image" class="span6 validate[required]"/>
                    <p class="help-block"></p>
                </div>
            </div>
            <div class="control-group">

                <div class="controls">
                    <button class="btn btn-success" data-loading-text="Loading...">Uložiť</button>
                </div>
            </div>    

        </form>

    </div>


    <div class="clear"></div>

</div>




<script type="text/javascript"> 
    jQuery(document).ready(function(){
        $('#myTab a:first').tab('show');
        $('#myTab a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        });
        jQuery("#pridajfoto").validationEngine('attach', {promptPosition : "bottomRight", autoPositionUpdate : true});
    });
    
    $(function()
       {
               var nameIsCustom = false;
               $("#gallery2").sortable({
                       update: function() {
                               var FotoItems = $(this).sortable('toArray').toString();
                               $.ajax({
                                       url: "<?php echo site_url('admin/sliders/ajaxPoradie') ?>",
                                       type: "post",
                                       data: "fotky=" + FotoItems,
                                       error: function() {
                                               alert("Vyskytla sa neznáma chyba");
                                       }
                               });
                       }
               })

       });
</script>