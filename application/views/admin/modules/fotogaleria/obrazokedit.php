<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3>Edit Foto</h3>
</div>
<div class="modal-body">
    <?
    
    $action = 'admin/fotogaleria/ulozitObrazok/' . (($foto) ? $foto->id : "");
    echo form_open($action, 'id="editFoto" class="form-horizontal" method="post"');
    
    ?>
    <p>
        <input type="text" name="nazov" id="nadpis" class="span4" placeholder="Nazov" value="<?php echo ($foto == FALSE) ? "" : $foto->nazov; ?>"  />
    </p>
    <p>
        <input type="text" name="popis" id="kratky_popis" class="span4" placeholder="popis" value="<?php echo ($foto == FALSE) ? "" : $foto->popis; ?>"  />
    </p>

</form>
</div>
<div class="modal-footer">
    <a class="btn btn-primary" onclick="$('.modal-body > form').submit();">Save Changes</a>
    <a class="btn" data-dismiss="modal">Close</a>
</div>
