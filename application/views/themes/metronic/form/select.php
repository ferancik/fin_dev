<div class="form-group">
    <label class="col-md-3 control-label"><?php echo $field->field_label; ?>
        <?php if ($field->validation->required == 1) { ?>
            <span class="required" aria-required="true"> * </span>
        <?php } ?>
    </label>
    <div class="col-md-9">
        <select name="<?php echo $field->field_name; ?>" class="form-control" <?php  echo ($field->validation->required == 1)?'required':''; ?> >
            <?php foreach ($field->options as $key => $option) { ?>
                <option value="<?php echo $option->option_value; ?>"><?php echo $option->option_name; ?></option>
            <?php } ?>
        </select>
    </div>
</div>

