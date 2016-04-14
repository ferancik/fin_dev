<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3>Edit foto</h3>
</div>
<div class="modal-body">
    <form action="<?php echo site_url('admin/sliders/ulozitfoto'); ?>" id="pridajfoto"  method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_foto" id="id_foto" value="<?php echo ($foto == FALSE) ? "novy" : $foto['id']; ?>" />
        <input type="hidden" name="id_slider" id="id_slider" value="<?php echo ($foto == FALSE) ? "" : $foto['id_mod_sliders']; ?>" />
        <p>
            <input type="text" name="napdis" id="nadpis" placeholder="Nadpis" value="<?php echo ($foto == FALSE) ? "" : $foto['name']; ?>" class="span4 validate[required,maxSize[30]]" />
        </p>
        <p>
            <input type="text" name="kratky_popis" id="kratky_popis" placeholder="Krátky popis" value="<?php echo ($foto == FALSE) ? "" : $foto['popis']; ?>" class="span4 validate[required, maxSize[100]]" />
        </p>
        <p>
            <input type="text" name="url" id="umiestnenie" placeholder="Url odkaz" value="<?php echo ($foto == FALSE) ? "" : $foto['umiestnenie']; ?>" class=" span4 validate[maxSize[100]]" />
        </p>
        <p>
            <input type="file" name="image" placeholder="Obrazok" class="validate[required]"/>
        </p>
    </form>
</div>
<div class="modal-footer">
    <a class="btn btn-primary" onclick="$('.modal-body > form').submit();">Save Changes</a>
    <a class="btn" data-dismiss="modal">Close</a>
</div>