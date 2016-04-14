<?
$this->load->view('admin/spravy', null);
?>
<?php
$old_password = array(
    'name' => 'old_password',
    'id' => 'old_password',
    'value' => set_value('old_password'),
    'size' => 30,
    'class' => 'span6'
);
$new_password = array(
    'name' => 'new_password',
    'id' => 'new_password',
    'maxlength' => $this->config->item('password_max_length', 'admin/tank_auth'),
    'size' => 30,
    'class' => 'span6'
);
$confirm_new_password = array(
    'name' => 'confirm_new_password',
    'id' => 'confirm_new_password',
    'maxlength' => $this->config->item('password_max_length', 'admin/tank_auth'),
    'size' => 30,
    'class' => 'span6'
);
?>


<form action="<?php echo base_url().$this->uri->uri_string() ?>"  class="form-horizontal" method="post">
    <fieldset>
        <div id="legend">
            <legend class="">Change password</legend>
        </div>
        
         <div class="control-group">
            <label class="control-label" >Old Password <em class="formee-req">*</em></label>
            <div class="controls">

               <?php echo form_password($old_password); ?>
                <span style="color:red; margin-left: 9px;"><?php echo form_error($old_password['name']); ?><?php echo isset($errors[$old_password['name']]) ? $errors[$old_password['name']] : ''; ?></span>
            </div>
        </div>
        
         <div class="control-group">
            <label class="control-label" >New Password <em class="formee-req">*</em></label>
            <div class="controls">

               <?php echo form_password($new_password); ?>
                <span style="color:red; margin-left: 9px;"><?php echo form_error($new_password['name']); ?><?php echo isset($errors[$new_password['name']]) ? $errors[$new_password['name']] : ''; ?></span>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" >Confirm New Password <em class="formee-req">*</em></label>
            <div class="controls">

               <?php echo form_password($confirm_new_password); ?>
                <span style="color:red; margin-left: 9px;"><?php echo form_error($confirm_new_password['name']); ?><?php echo isset($errors[$confirm_new_password['name']]) ? $errors[$confirm_new_password['name']] : ''; ?></span>
            </div>
        </div>
         <div class="control-group">

            <div class="controls">
                <button class="btn btn-success" name="change" data-loading-text="Loading...">Change Password</button>
            </div>
        </div>
    </fieldset>
</form> 
