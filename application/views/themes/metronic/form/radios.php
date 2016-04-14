
<div class="form-group">
    <label class="col-md-3 control-label"><?php echo $field->field_label; ?>
        <?php if ($field->validation->required == 1) { ?>
            <span class="required" aria-required="true"> * </span>
        <?php } ?>
    </label>
    <div class="col-md-9">
        <div class="radio-list">
            <?php foreach ($field->options as $key => $option) { ?>
                <label <?php echo ($field->inline_fields == 0) ? '' : 'class="radio-inline"' ?>>
                    <input 
                        type="radio" name="<?php echo $field->field_name; ?>" 
                        id="<?php echo $field->field_name; ?>" 
                        value="<?php echo $option->option_value; ?>"
                        <?php  echo ($field->validation->required == 1)?'required':''; ?> 
                        > <?php echo $option->option_name; ?>
                </label>
            <?php } ?>
        </div>
    </div>
</div>


