
<div class="form-group">
    <label class="col-md-3 control-label"><?php echo $field->field_label; ?>
        <?php if ($field->validation->required == 1) { ?>
            <span class="required" aria-required="true"> * </span>
        <?php } ?>
    </label>
    <div class="col-md-3">
        <input class="form-control form-control-inline  date-picker" name="<?php echo $field->field_name; ?>"  type="text" />
       
    </div>
</div>

