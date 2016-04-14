<div id="modadalEdit_<?=(($data) ? $data->id : "")?>" class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3><?= $texty; ?></h3>
</div>
<div class="modal-body">
    <?
    $action = 'admin/adminwebmenu/saveForm/' .$idTypMenu.'/'. (($data) ? $data->id : "");
    echo form_open($action, 'id="editMenu" class="form-horizontal" method="post"');
    ?>

<p>
    <ul id="myTab_<?=(($data) ? $data->id : "")?>" class="nav nav-tabs">
        <? foreach ($alljazyky as $value) { ?>
        <li><a href="#jazyk_<?=(($data) ? $data->id : "")?>_<?= $value->id; ?>"  data-toggle="tab" title="<?= ucfirst($value->name); ?>" ><img src="<?php echo base_url().'admin_assets/flag/'.$value->icon; ?>" alt="<? echo $value->iso_code; ?>" /></a></li>
        <? } ?>
    </ul>

    <div id="myTabContent_<?=(($data) ? $data->id : "")?>" class="tab-content">
        <? foreach ($alljazyky as $value) { ?>
            <div id="jazyk_<?=(($data) ? $data->id : "")?>_<?= $value->id; ?>" class="tab-pane fade" >
                <?
                if ($data){
                $tempJ = $this->admin_web_menu_m->getMenuLanguage($data->id, $value->id);
                $valueJazyk = $tempJ->nazov;
                }else{
                    $valueJazyk =  "";
                }
                ?>
                <input type="text" name="jazyk_<?= $value->id; ?>" id="jazyk_<?= $value->id; ?>" class="span4" placeholder="<?= ucfirst($value->name); ?>" value="<?=$valueJazyk;?>"  />

            </div>
        <? } ?>
    </div>
    <hr>
</p>
<p>
    <?
    if (isset($data) && $data->type=='0'){
      $valueT =  $data->kontroler ;
    }else{
        $valueT = '';
    }
    ?>
    Kontroler:
    <input type="text" name="kontroler" id="kontroler" class="span4" placeholder="Kontroler" value="<?php echo $valueT; ?>"  />
</p>

<p>
    Alebo vyberte: 
    <?php
    $js = 'id="stranky" class="span4 validate[required]"';
    
    if (isset($data) && $data->type=='1'){
      $oznacene =  $data->kontroler ;
    }else{
      $oznacene = '';
      
    }
    echo "".form_dropdown('stranky', $stranky, $oznacene, $js);
    ?>
</p>

<hr>

<p>
   Prarrent:
   <?php 
    $js = 'id="parrent" class="span4 validate[required]"';
    if (isset($data->id_parrent)){
        $selParrent = $data->id_parrent;
    }else{
        $selParrent = 0;
    }
     echo form_dropdown('parrent', $parrentsSelect, $selParrent, $js);
   
   ?>  
</p>
<div class="input-append">
    <input type="text" name="icon" id="icon" class="span4" placeholder="Icon" value="<?php echo ($data == FALSE) ? "" : $data->icon; ?>"  />

    <a class="btn" href="#chooseIcon" data-toggle="modal"> Choose icon</a>

</div>

<hr>
<p>
    <input type="text" name="options" id="options" class="span4" placeholder="More Options" value="<?php echo ($data == FALSE) ? "" : strip_quotes($data->options); ?>"  />
</p>
</form>
</div>
<div class="modal-footer">
    <a class="btn btn-primary" onclick="$('.modal-body > form').submit();">Save Changes</a>
    <a class="btn " id="menueditclose" data-dismiss="modal" >Close</a>
</div>
<div id="chooseIcon" class="modal hide fade">
    <div class="modal-header">
        <h3>Choose Icon</h3>
    </div>
    <div class="modal-body">
        <ul class="the-icons">
            <li><a href="#"><i class="icon-glass"></i><span> icon-glass</span></a></li>
            <li><a href="#"><i class="icon-music"></i><span> icon-music</span></a></li>
            <li><a href="#"><i class="icon-search"></i><span> icon-search</span></a></li>
            <li><a href="#"><i class="icon-envelope"></i><span> icon-envelope</span></a></li>
            <li><a href="#" class="active"><i class="icon-heart"></i><span> icon-heart</span></a></li>
            <li><a href="#"><i class="icon-star"></i><span> icon-star</span></a></li>
            <li><a href="#"><i class="icon-star-empty"></i><span> icon-star-empty</span></a></li>
            <li><a href="#"><i class="icon-user"></i><span> icon-user</span></a></li>
            <li><a href="#"><i class="icon-film"></i><span> icon-film</span></a></li>
            <li><a href="#"><i class="icon-th-large"></i><span> icon-th-large</span></a></li>
            <li><a href="#"><i class="icon-th"></i><span> icon-th</span></a></li>
            <li><a href="#"><i class="icon-th-list"></i><span> icon-th-list</span></a></li>
            <li><a href="#"><i class="icon-ok"></i><span> icon-ok</span></a></li>
            <li><a href="#"><i class="icon-remove"></i><span> icon-remove</span></a></li>
            <li><a href="#"><i class="icon-zoom-in"></i><span> icon-zoom-in</span></a></li>
            <li><a href="#"><i class="icon-zoom-out"></i><span> icon-zoom-out</span></a></li>
            <li><a href="#"><i class="icon-off"></i><span> icon-off</span></a></li>
            <li><a href="#"><i class="icon-signal"></i><span> icon-signal</span></a></li>
            <li><a href="#"><i class="icon-cog"></i><span> icon-cog</span></a></li>
            <li><a href="#"><i class="icon-trash"></i><span> icon-trash</span></a></li>
            <li><a href="#"><i class="icon-home"></i><span> icon-home</span></a></li>
            <li><a href="#"><i class="icon-file"></i><span> icon-file</span></a></li>
            <li><a href="#"><i class="icon-time"></i><span> icon-time</span></a></li>
            <li><a href="#"><i class="icon-road"></i><span> icon-road</span></a></li>
            <li><a href="#"><i class="icon-download-alt"></i><span> icon-download-alt</span></a></li>
            <li><a href="#"><i class="icon-download"></i><span> icon-download</span></a></li>
            <li><a href="#"><i class="icon-upload"></i><span> icon-upload</span></a></li>
            <li><a href="#"><i class="icon-inbox"></i><span> icon-inbox</span></a></li>
            <li><a href="#"><i class="icon-play-circle"></i><span> icon-play-circle</span></a></li>
            <li><a href="#"><i class="icon-repeat"></i><span> icon-repeat</span></a></li>
            <li><a href="#"><i class="icon-refresh"></i><span> icon-refresh</span></a></li>
            <li><a href="#"><i class="icon-list-alt"></i><span> icon-list-alt</span></a></li>
            <li><a href="#"><i class="icon-lock"></i><span> icon-lock</span></a></li>
            <li><a href="#"><i class="icon-flag"></i><span> icon-flag</span></a></li>
            <li><a href="#"><i class="icon-headphones"></i><span> icon-headphones</span></a></li>
            <li><a href="#"><i class="icon-volume-off"></i><span> icon-volume-off</span></a></li>
            <li><a href="#"><i class="icon-volume-down"></i><span> icon-volume-down</span></a></li>
            <li><a href="#"><i class="icon-volume-up"></i><span> icon-volume-up</span></a></li>
            <li><a href="#"><i class="icon-qrcode"></i><span> icon-qrcode</span></a></li>
            <li><a href="#"><i class="icon-barcode"></i><span> icon-barcode</span></a></li>
            <li><a href="#"><i class="icon-tag"></i><span> icon-tag</span></a></li>
            <li><a href="#"><i class="icon-tags"></i><span> icon-tags</span></a></li>
            <li><a href="#"><i class="icon-book"></i><span> icon-book</span></a></li>
            <li><a href="#"><i class="icon-bookmark"></i><span> icon-bookmark</span></a></li>
            <li><a href="#"><i class="icon-print"></i><span> icon-print</span></a></li>
            <li><a href="#"><i class="icon-camera"></i><span> icon-camera</span></a></li>
            <li><a href="#"><i class="icon-font"></i><span> icon-font</span></a></li>
            <li><a href="#"><i class="icon-bold"></i><span> icon-bold</span></a></li>
            <li><a href="#"><i class="icon-italic"></i><span> icon-italic</span></a></li>
            <li><a href="#"><i class="icon-text-height"></i><span> icon-text-height</span></a></li>
            <li><a href="#"><i class="icon-text-width"></i><span> icon-text-width</span></a></li>
            <li><a href="#"><i class="icon-align-left"></i><span> icon-align-left</span></a></li>
            <li><a href="#"><i class="icon-align-center"></i><span> icon-align-center</span></a></li>
            <li><a href="#"><i class="icon-align-right"></i><span> icon-align-right</span></a></li>
            <li><a href="#"><i class="icon-align-justify"></i><span> icon-align-justify</span></a></li>
            <li><a href="#"><i class="icon-list"></i><span> icon-list</span></a></li>
            <li><a href="#"><i class="icon-indent-left"></i><span> icon-indent-left</span></a></li>
            <li><a href="#"><i class="icon-indent-right"></i><span> icon-indent-right</span></a></li>
            <li><a href="#"><i class="icon-facetime-video"></i><span> icon-facetime-video</span></a></li>
            <li><a href="#"><i class="icon-picture"></i><span> icon-picture</span></a></li>
            <li><a href="#"><i class="icon-pencil"></i><span> icon-pencil</span></a></li>
            <li><a href="#"><i class="icon-map-marker"></i><span> icon-map-marker</span></a></li>
            <li><a href="#"><i class="icon-adjust"></i><span> icon-adjust</span></a></li>
            <li><a href="#"><i class="icon-tint"></i><span> icon-tint</span></a></li>
            <li><a href="#"><i class="icon-edit"></i><span> icon-edit</span></a></li>
            <li><a href="#"><i class="icon-share"></i><span> icon-share</span></a></li>
            <li><a href="#"><i class="icon-check"></i><span> icon-check</span></a></li>
            <li><a href="#"><i class="icon-move"></i><span> icon-move</span></a></li>
            <li><a href="#"><i class="icon-step-backward"></i><span> icon-step-backward</span></a></li>
            <li><a href="#"><i class="icon-fast-backward"></i><span> icon-fast-backward</span></a></li>
            <li><a href="#"><i class="icon-backward"></i><span> icon-backward</span></a></li>
            <li><a href="#"><i class="icon-play"></i><span> icon-play</span></a></li>
            <li><a href="#"><i class="icon-pause"></i><span> icon-pause</span></a></li>
            <li><a href="#"><i class="icon-stop"></i><span> icon-stop</span></a></li>
            <li><a href="#"><i class="icon-forward"></i><span> icon-forward</span></a></li>
            <li><a href="#"><i class="icon-fast-forward"></i><span> icon-fast-forward</span></a></li>
            <li><a href="#"><i class="icon-step-forward"></i><span> icon-step-forward</span></a></li>
            <li><a href="#"><i class="icon-eject"></i><span> icon-eject</span></a></li>
            <li><a href="#"><i class="icon-chevron-left"></i><span> icon-chevron-left</span></a></li>
            <li><a href="#"><i class="icon-chevron-right"></i><span> icon-chevron-right</span></a></li>
            <li><a href="#"><i class="icon-plus-sign"></i><span> icon-plus-sign</span></a></li>
            <li><a href="#"><i class="icon-minus-sign"></i><span> icon-minus-sign</span></a></li>
            <li><a href="#"><i class="icon-remove-sign"></i><span> icon-remove-sign</span></a></li>
            <li><a href="#"><i class="icon-ok-sign"></i><span> icon-ok-sign</span></a></li>
            <li><a href="#"><i class="icon-question-sign"></i><span> icon-question-sign</span></a></li>
            <li><a href="#"><i class="icon-info-sign"></i><span> icon-info-sign</span></a></li>
            <li><a href="#"><i class="icon-screenshot"></i><span> icon-screenshot</span></a></li>
            <li><a href="#"><i class="icon-remove-circle"></i><span> icon-remove-circle</span></a></li>
            <li><a href="#"><i class="icon-ok-circle"></i><span> icon-ok-circle</span></a></li>
            <li><a href="#"><i class="icon-ban-circle"></i><span> icon-ban-circle</span></a></li>
            <li><a href="#"><i class="icon-arrow-left"></i><span> icon-arrow-left</span></a></li>
            <li><a href="#"><i class="icon-arrow-right"></i><span> icon-arrow-right</span></a></li>
            <li><a href="#"><i class="icon-arrow-up"></i><span> icon-arrow-up</span></a></li>
            <li><a href="#"><i class="icon-arrow-down"></i><span> icon-arrow-down</span></a></li>
            <li><a href="#"><i class="icon-share-alt"></i><span> icon-share-alt</span></a></li>
            <li><a href="#"><i class="icon-resize-full"></i><span> icon-resize-full</span></a></li>
            <li><a href="#"><i class="icon-resize-small"></i><span> icon-resize-small</span></a></li>
            <li><a href="#"><i class="icon-plus"></i><span> icon-plus</span></a></li>
            <li><a href="#"><i class="icon-minus"></i><span> icon-minus</span></a></li>
            <li><a href="#"><i class="icon-asterisk"></i><span> icon-asterisk</span></a></li>
            <li><a href="#"><i class="icon-exclamation-sign"></i><span> icon-exclamation-sign</span></a></li>
            <li><a href="#"><i class="icon-gift"></i><span> icon-gift</span></a></li>
            <li><a href="#"><i class="icon-leaf"></i><span> icon-leaf</span></a></li>
            <li><a href="#"><i class="icon-fire"></i><span> icon-fire</span></a></li>
            <li><a href="#"><i class="icon-eye-open"></i><span> icon-eye-open</span></a></li>
            <li><a href="#"><i class="icon-eye-close"></i><span> icon-eye-close</span></a></li>
            <li><a href="#"><i class="icon-warning-sign"></i><span> icon-warning-sign</span></a></li>
            <li><a href="#"><i class="icon-plane"></i><span> icon-plane</span></a></li>
            <li><a href="#"><i class="icon-calendar"></i><span> icon-calendar</span></a></li>
            <li><a href="#"><i class="icon-random"></i><span> icon-random</span></a></li>
            <li><a href="#"><i class="icon-comment"></i><span> icon-comment</span></a></li>
            <li><a href="#"><i class="icon-magnet"></i><span> icon-magnet</span></a></li>
            <li><a href="#"><i class="icon-chevron-up"></i><span> icon-chevron-up</span></a></li>
            <li><a href="#"><i class="icon-chevron-down"></i><span> icon-chevron-down</span></a></li>
            <li><a href="#"><i class="icon-retweet"></i><span> icon-retweet</span></a></li>
            <li><a href="#"><i class="icon-shopping-cart"></i><span> icon-shopping-cart</span></a></li>
            <li><a href="#"><i class="icon-folder-close"></i><span> icon-folder-close</span></a></li>
            <li><a href="#"><i class="icon-folder-open"></i><span> icon-folder-open</span></a></li>
            <li><a href="#"><i class="icon-resize-vertical"></i><span> icon-resize-vertical</span></a></li>
            <li><a href="#"><i class="icon-resize-horizontal"></i><span> icon-resize-horizontal</span></a></li>
            <li><a href="#"><i class="icon-hdd"></i><span> icon-hdd</span></a></li>
            <li><a href="#"><i class="icon-bullhorn"></i><span> icon-bullhorn</span></a></li>
            <li><a href="#"><i class="icon-bell"></i><span> icon-bell</span></a></li>
            <li><a href="#"><i class="icon-certificate"></i><span> icon-certificate</span></a></li>
            <li><a href="#"><i class="icon-thumbs-up"></i><span> icon-thumbs-up</span></a></li>
            <li><a href="#"><i class="icon-thumbs-down"></i><span> icon-thumbs-down</span></a></li>
            <li><a href="#"><i class="icon-hand-right"></i><span> icon-hand-right</span></a></li>
            <li><a href="#"><i class="icon-hand-left"></i><span> icon-hand-left</span></a></li>
            <li><a href="#"><i class="icon-hand-up"></i><span> icon-hand-up</span></a></li>
            <li><a href="#"><i class="icon-hand-down"></i><span> icon-hand-down</span></a></li>
            <li><a href="#"><i class="icon-circle-arrow-right"></i><span> icon-circle-arrow-right</span></a></li>
            <li><a href="#"><i class="icon-circle-arrow-left"></i><span> icon-circle-arrow-left</span></a></li>
            <li><a href="#"><i class="icon-circle-arrow-up"></i><span> icon-circle-arrow-up</span></a></li>
            <li><a href="#"><i class="icon-circle-arrow-down"></i><span> icon-circle-arrow-down</span></a></li>
            <li><a href="#"><i class="icon-globe"></i><span> icon-globe</span></a></li>
            <li><a href="#"><i class="icon-wrench"></i><span> icon-wrench</span></a></li>
            <li><a href="#"><i class="icon-tasks"></i><span> icon-tasks</span></a></li>
            <li><a href="#"><i class="icon-filter"></i><span> icon-filter</span></a></li>
            <li><a href="#"><i class="icon-briefcase"></i><span> icon-briefcase</span></a></li>
            <li><a href="#"><i class="icon-fullscreen"></i><span> icon-fullscreen</span></a></li>
        </ul>
    </div>
    <div class="modal-footer">
        <a class="submit btn btn-primary" id="choosemodal" >Choose</a>
        <a class="btn" id="choosemodalclose" >Cancel</a>
    </div>
</div>

<script type="text/javascript">
        $("#choosemodal, #choosemodalclose").click(function() {
            $('#chooseIcon').modal('hide');
            var icon = $('.the-icons .active i').attr('class');

            $('#icon').val(icon);
            $('#modadalEdit').modal('show');
        });

//        $(".close").click(function() {
//            $('#chooseIcon').modal('hide');
//            $('#modadalEdit').modal('hide');
//        });


        $('.the-icons a').click(function() {
            $('.the-icons a').removeClass('active');
            $(this).addClass('active');
            spocti();
            return false;
        });

        $('#myTab_<?=(($data) ? $data->id : "")?> a:first').tab('show');

        $('#myTab_<?=(($data) ? $data->id : "")?> a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        });
</script>

