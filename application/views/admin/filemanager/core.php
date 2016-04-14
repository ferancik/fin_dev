<div id="msgbox"></div>
<div id="progress" class="progress progress-striped active hide">
    <div class="bar"></div>
</div>
<?php
$this->load->view('admin/spravy', null);


?>

<ul class="breadcrumb">
    <li <?php echo (count($priecinky) == 0) ? 'class="active"' : '' ?> ><a href="<?php echo createLink('', array('elem' => $idelem, 'type' => $kdezobrazit)); ?>"><?php echo $this->config->item('upload_dir_name');?></a><span class="divider">/</span></li>


    <?
    $urlPath = "";
    $i = 0;
    $kolkoCelko = count($priecinky);
    foreach ($priecinky as $value) {


        if ($value != '') {
            $urlPath.=$value . "/";
            ?>
            <li><a href="<?php echo createLink($urlPath, array('elem' => $idelem, 'type' => $kdezobrazit)); ?>"><?php echo rawurldecode($value) ?></a> <?php echo (($i == $kolkoCelko) ? '' : '<span class="divider">/</span>'); ?></li>
        <?php }
        ?>




        <?php
        $i++;
    }
    ?>



</ul>


<?php
if ($kdezobrazit!='index'){ ?>
<p>
<a href="#nahrat_subor" data-toggle="modal"><button class="btn btn-primary" type="button"><i class="icon-arrow-up icon-white"></i> Nahrat Subor</button></a>
<a href="#vytvorit_priecinok" data-toggle="modal"><button class="btn btn-primary" type="button"><i class="icon-folder-close icon-white"></i> Vytvorit Priecinok</button></a>
<a href="<?php echo createLink($urlPath,array('elem'=>$idelem,'type'=>$kdezobrazit));  ?>" ><button class="btn btn-primary" type="button"><i class="icon-refresh icon-white"></i> Refresh</button></a>
</p>
<?php }
?>

<table class="table table-striped table-hover" style="border-collapse: separate " >
    <thead>
        <tr>
            <th>Názov súboru</th>
            <th style="width: 98px;">Veľkosť</th>
            <th style="width: 150px;">Datum</th>
            <th style="width: 20px;"></th>
        </tr>
    </thead>
    <tbody>
        <?

        // preVarDump($subory);

        function cmp($a, $b) {
            if ($a->dir == $b->dir) {
                return strcmp($a->name, $b->name);
                //return 0;
            }
            return ($a->dir < $b->dir) ? 1 : -1;
        }

        usort($subory, 'cmp');
        $kolkoSuborov = 0;
        $spoluVelkost = 0;
        if (is_array($subory) && count($subory)>0 ){
        foreach ($subory as $row) {
            $kolkoSuborov++;

            if ($row->dir) {
                ?>
                <tr>
                    <td><i class="icon-folder-close"></i> <a href="<?php echo createLink($urlPath . $row->name, array('elem' => $idelem, 'type' => $kdezobrazit)); ?>"><?php echo rawurldecode($row->name); ?></a></td>
                    <td ><?php echo '<b>' . $row->coutFiles . '</b> ' . (($row->coutFiles > 1) ? 'Files' : 'File') ?></td>
                    <td><?php echo formatCasu($row->date); ?></td>
                    <td><a  id="del_subor" title="<?php echo rawurldecode($row->name); ?>" rel="<?= $urlPath . $row->name ?>" href="#" ><i class="icon-trash"></i></a></td>
                </tr> 
                <?
            } else {
                $spoluVelkost = $spoluVelkost + $row->size;
                $image_T = "";
                if (is_array($row->image)) {
                    $image_T = ' <img src="' . base_url() . $this->config->item('upload_dir_relative_path') . $urlPath . $row->name . '" height="90"  class="img-polaroid" width="90"  alt=""/> ';
                }
                ?>


                <tr>
                    <td> <?php echo $image_T; ?> <a href="javascript:void(0)" onclick="submitLink('<?= base_url() . $this->config->item('upload_dir_relative_path') . $urlPath . $row->name ?>');" ><?= rawurldecode($row->name); ?></a></td>
                    <td><?php echo byte_format($row->size, 2); ?></td>
                    <td><?php echo formatCasu($row->date); ?></td>
                    <td><a id="del_subor" title="<?php echo rawurldecode($row->name); ?>" rel="<?php echo $urlPath . $row->name ?>" href="#" ><i class="icon-trash"></i></a></td>
                </tr>

                <?
            }
        }
         }else{ ?>
                <tr><td colspan="4" style="text-align: center;"><i><?php echo lang('a_empty_table'); ?></i></td></tr>
          <?php  } ?>

    </tbody>
</table>
<em>  Spolu suborov: <b><?php echo $kolkoSuborov; ?></b>, Velkost: <b><?php echo byte_format($spoluVelkost, 2); ?></b></em>




<div id="vytvorit_priecinok" class="modal hide fade">
    <div class="modal-header">
        <h3>Vytvoriť nový priečinok</h3>
    </div>
    <div class="modal-body">
        <form method="post" >
            <input type="hidden" name="path" id="upload-path" value="<?php echo $urlPath ?>" />
            <input type="hidden" name="elem"  value="<?php echo (($idelem != '') ? $idelem : '') ?>" />
            <input type="hidden" name="type"  value="<?php echo (($kdezobrazit != '') ? $kdezobrazit : '') ?>" />
            <p>
                <input type="text" name="new_priecinok"  value="" placeholder="Nazov piecinku" class="span4" id="new-target" />
            </p>
        </form>
    </div>
    <div class="modal-footer">
        <a class="submit btn btn-primary" data-dismiss="modal">Vytvoriť</a>
        <a class="btn" data-dismiss="modal">Zrusiť</a>
    </div>
</div>


<div id="nahrat_subor" class="modal hide fade">
    <div class="modal-header">
        <h3>Nahrať súbor</h3>
    </div>
    <div class="modal-body">
        <form method="post" enctype="multipart/form-data">

            <input type="hidden" name="path" id="upload-path" value="<?php echo $urlPath ?>" />
            <input type="hidden" name="elem"  value="<?php echo (($idelem != '') ? $idelem : '') ?>" />

            <input type="hidden" name="type"  value="<?php echo (($kdezobrazit != '') ? $kdezobrazit : '') ?>" />
            <p>
                <input type="file" class="span4" name="files[]" multiple="multiple"/><br />
                <small>Mozete vybrat aj viac suborov naraz.</small>
            </p>
        </form>
    </div>
    <div class="modal-footer">
        <a class="submit btn btn-primary" data-dismiss="modal">Nahrat</a>
        <a class="btn" data-dismiss="modal">Zrusiť</a>
    </div>
</div>



<script type="text/javascript">

                        function progressBar(event) {
                            var done = event.position || event.loaded;
                            var total = event.totalSize || event.total;
                            var per = (Math.floor(done / total * 1000) / 10) + '%';
                            $('div#progress > div.bar').css('width', per).text(per);
                        }

                        function request(data, success, isFormData, url) {
                            // set default options
                            var options = {
                                url: url,
                                type: 'POST',
                                data: data,
                                cache: false,
                                dataType: 'json',
                                success: success,
                                error: function(jqXHR, status) {
                                    alert(status);
                                }
                            };

                            // set options for formdata
                            if (isFormData === true) {
                                options.contentType = false;
                                options.processData = false;

                                // progressbar on upload
                                options.xhr = function() {
                                    var x = $.ajaxSettings.xhr();
                                    if (x.upload)
                                        x.upload.addEventListener('progress', progressBar, false);
                                    return x;
                                };
                            }

                            // do request
                            $.ajax(options);
                        }

                        $('a#del_subor').click(function(event) {
                            if (ozaj('Naozaj chcete odstrániť subor:\n' + $(this).attr('title') + ' ?')) {

                                request(
                                        {
                                            'del': $(this).attr('rel'),
                                            'elem': '<?= (($idelem != '') ? $idelem : '') ?>',
                                            'type': '<?= (($kdezobrazit != '') ? $kdezobrazit : '') ?>'

                                        },
                                add_result, false, '<?php echo site_url('admin/filemanager/del')?>'
                                        );
                            }
                        });

                        $('a#del_dir').click(function(event) {
                            if (ozaj('Naozaj chcete odstrániť priecinok:\n' + $(this).attr('title') + ' ?')) {

                                request(
                                        {
                                            'del': $(this).attr('rel'),
                                            'elem': '<?= (($idelem != '') ? $idelem : '') ?>',
                                            'type': '<?= (($kdezobrazit != '') ? $kdezobrazit : '') ?>'

                                        },
                                add_result, false, '<?php echo site_url('admin/filemanager/del')?>'
                                        );
                            }
                        });



                        $('div#nahrat_subor a.submit').click(function(event) {

                            request(
                                    new FormData($('div#nahrat_subor form')[0]),
                                    add_result,
                                    true, '<?php echo site_url('admin/filemanager/manage')?>'
                                    );


                            $('div#progress div.bar').css('width', 0);
                            $('div#progress').show();
                        });

                        $('div#vytvorit_priecinok a.submit').click(function(event) {

                            request(
                                    $('div#vytvorit_priecinok form').serialize(),
                                    add_result,
                                    false, '<?php echo site_url('admin/filemanager/createnewfolder')?>'
                                    );


                        });


                        function add_result(result) {
                            // add msg
                            show_ajaxMsq(result.msg, (result.status == 'ok') ? 'alert-success' : 'alert-error');

                            // hide progressbar
                            $('div#progress').hide();

                        }

                     

                        function err_msg(msg, context) {
                            add_msg('<strong>' + context + ' error:</strong> ' + msg, 'alert-error');
                        }


                        function submitLink(url) {
                            if (window.opener) {

                                window.opener.document.getElementById('<?= $idelem ?>').focus();
                                window.opener.document.getElementById('<?= $idelem ?>').value = url;
                            }
                            window.close();
                        }

</script>