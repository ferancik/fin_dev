<div class="col-sm-4">
    <select data-placeholder="Vybrat ucet" class="form-control chosen-select" name="ucet" id="ucet" required>
        <option value="">Vybrat ucet</option>
        <?php foreach ($ucty as $key => $ucet) { ?>
            <option value="<?php echo $ucet->ucet_id; ?>"><?php echo $ucet->name; ?></option>
        <?php } ?>
    </select>
</div>
<div class="col-sm-4">
    <select data-placeholder="Vybrat projekt" class="form-control chosen-select" name="projekt" id="projekt" >
        <option value="">Vybrat projekt</option>
        <?php foreach ($projekty as $key => $projekt) { ?>
            <option value="<?php echo $projekt->projekt_id; ?>"><?php echo $projekt->nazov; ?></option>
        <?php } ?>
    </select>
</div>