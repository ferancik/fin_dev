<?php
$this->load->view('admin/spravy', null);
?>
<link href="<?php echo base_url() ?>admin_assets/plugins/plupload/jquery.plupload.queue/css/jquery.plupload.queue.css" rel="stylesheet">


<ul id="myTab" class="nav nav-tabs">
    <li><a href="#tabs-1" >Fotogaléria k : <?php echo $text['nazov'] ?></a></li>
    <li><a href="#tabs-2" >Pridaj fotky</a></li>

</ul>


<div id="myTabContent" class="tab-content">
    <div id="tabs-1" class="tab-pane fade" >								

        <ul id="fotogallery" class="fotogallery">
            <?php
            if ($obr) {
                $kolkata = 0;
                $nastavenia_gal = $this->fotogaleria->getNastavenia();
                foreach ($obr as $key => $value) {
                    ?>
                    <li id="foto_<?php echo $value->id ?>">
                        <img src="<?php echo base_url(); ?><?php echo $nastavenia_gal->cesta_k_obrazkom_tumbs . '/' . $value->adresa ?>" width="140" height="140" alt="" />
                        <a href="#" class="ui-icon ui-icon-trash"></a>

                        <a href="<?php echo base_url(); ?><?php echo $nastavenia_gal->cesta_k_obrazkom . '/' . $value->adresa ?>" target="_blank" class=" ui-icon ui-icon-zoomin "></a>
                        <?php
                        if ($kolkata == 0) {
                            $zobrazit = "";
                        } else {
                            $zobrazit = "display:none;";
                        }
                        echo'<div class="is_main_foto" style="color:black; ' . $zobrazit . '">MAIN</div>';
                        ?>
                        <a href="<?php echo site_url('admin/fotogaleria/editFoto/'.$value->id); ?>" data-toggle="modal" class="ui-icon ui-icon-pencil" ></a>

                    </li>

                    <?
                    $kolkata++;
                }
            } else {
                $this->load->view('admin/spravy', array('sprava' => 'info|Neni sú pridané žiadne fotky'));
            }
            ?>
        </ul>
        <div class="clear"></div>

        <div style="display:none;" title="Odstrániť fotografiu" class="dialog_confirm"><p>Naozaj chcete odstrániť túto fotografiu?</p><p>Kliknite na <strong>OK</strong> pre potvrdenie alebo <strong>Cancel</strong> pre zrušenie. </p></div>


    </div>

    <div id="tabs-2"  class="tab-pane fade">								

        <form class="formee" action="#">

            <div id="nahravanieFotiek" class="uploader_fullwidth">
                <p style="color:#000; " >Váš Prehliadač nema podporu pre Flash, Silverlight, Gears, BrowserPlus, kontaktuje administrátora stránky</p>
            </div>
            <div class="clear"></div>
        </form>

        <div class="clear"></div>

    </div>

</div>



<script type="text/javascript">
     
        $('#myTab a:first').tab('show');
        $('#myTab a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        });
        jQuery(document).ready(function() {
            jQuery("#pridajfoto").validationEngine('attach', {promptPosition: "bottomRight", autoPositionUpdate: true});
        });
        jQuery(function() {
            jQuery("#nahravanieFotiek").pluploadQueue({
                runtimes: "html5,gears,flash,silverlight,browserplus",
                url: "<?php echo  site_url('admin/fotogaleria/ajaxUpload/'.$data->id); ?>",
                max_file_size: "5mb",
                chunk_size: "1mb",
                unique_names: true,
//            resize: {
//                width: 1000,
//                height: 800,
//                quality: 95
//            },
                filters: [{
                        title: "Obrázky",
                        extensions: "jpg,gif,png,jpeg"
                    }],
                flash_swf_url: "<?php echo base_url() ?>admin_assets/plugins/plupload/plupload.flash.swf",
                silverlight_xap_url: "<?php echo base_url() ?>admin_assets/plugins/plupload/plupload.silverlight.xap"
            })

            var uploader = $('#nahravanieFotiek').pluploadQueue();
            uploader.bind('FileUploaded', function(up, file, res) {
                if (this.total.queued == 0) {
                    window.location = "<?php echo site_url('admin/fotogaleria/pridajobrazky/'.$data->id) ?>";
                }

            });
        });
        $(function()
        {
            var nameIsCustom = false;
            $("#fotogallery").sortable({
                update: function() {
                    var FotoItems = $(this).sortable('toArray').toString();
                    $.ajax({
                        url: "<?php echo site_url('admin/fotogaleria/ajaxPoradie/'.$data->id) ?>",
                        type: "post",
                        data: "fotky=" + FotoItems,
                        error: function() {
                            alert("Vyskytla sa neznáma chyba");
                        }
                    });
                },
                stop: function(event, ui) {
                    $("#fotogallery li").each(function(i, el) {

                        var p = $(el).find("div");
                        p.attr("style", "display:none");
                    });
                    $("#fotogallery li:first").find("div").attr("style", "display:inline; color:#000;");
                }
            });
        });
        $(function()
        {
            $("#fotogallery li img").hover(function()
            {
                $(this).animate(
                        {
                            opacity: "0.6"
                        }, {
                    queue: true,
                    duration: 200
                });
            }, function()
            {
                $(this).animate(
                        {
                            opacity: "1"
                        }, {
                    queue: true,
                    duration: 300
                });
            });
        });
        $(function()
        {
            var a = "<p></p><p>Naozaj chcete odstrániť túto fotografiu?</p><p>Kliknite na <strong>OK</strong> pre potvrdenie alebo <strong>Cancel</strong> pre zrušenie. </p>";
            $(".dialog_confirm").html(a);
            $("#fotogallery .ui-icon-trash").click(function()
            {
                var b = $(this).parent("#fotogallery li");
                $(".dialog_confirm").dialog(
                        {
                            modal: true,
                            show: "fade",
                            hide: "fade",
                            buttons: {
                                OK: function()
                                {
                                    $(this).dialog("close");
                                    $.ajax({
                                        url: "<?php echo site_url('admin/fotogaleria/ajaxZmazFotku/'.$data->id) ?>",
                                        type: "post",
                                        data: "foto=" + b.attr('id'),
                                        error: function() {
                                            alert("Vyskytla sa neznáma chyba");
                                        }
                                    });
                                    //alert(b.attr('id'));

                                    $(b).hide("fold", 500)
                                },
                                Cancel: function()
                                {
                                    $(this).dialog("close")
                                }
                            }
                        });
                return false;
            });
        });
        $(function()
        {
            $("#dialog").dialog(
                    {
                        autoOpen: false,
                        show: "blind",
                        hide: "explode",
                        buttons: {
                            OK: function()
                            {
                                $(this).dialog("close");
                            }
                        }
                    });
            $("#opener").click(function()
            {
                $("#dialog").dialog("open");
                return false;
            });
        });
</script>


<script type="text/javascript" src="<?php echo base_url() ?>admin_assets/plugins/plupload/plupload.full.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>admin_assets/plugins/plupload/plupload.browserplus.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>admin_assets/plugins/plupload/jquery.plupload.queue/jquery.plupload.queue.js"></script>

