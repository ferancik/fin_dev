<?
$this->load->view('admin/spravy', null);
?>

<?php
$password = array(
    'name' => 'password',
    'id' => 'password',
    'size' => 30,
    'class' => 'span6'
);
$email = array(
    'name' => 'email',
    'id' => 'email',
    'value' => set_value('email'),
    'maxlength' => 80,
    'size' => 30,
    'class' => 'span6'
);
?>

<form action="<?php echo base_url().$this->uri->uri_string() ?>"  class="form-horizontal" method="post">
    <fieldset>
        <div id="legend">
            <legend class="">Change email</legend>
        </div>
        <div class="control-group">
            <label class="control-label" >Password <em class="formee-req">*</em></label>
            <div class="controls">

                <?php echo form_password($password); ?>
                <span style="color:red; margin-left: 9px;"><?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']]) ? $errors[$password['name']] : ''; ?></span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" >New email address <em class="formee-req">*</em></label>
            <div class="controls">

                <?php echo form_input($email); ?>
               <span style="color:red; margin-left: 9px;"> <?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']]) ? $errors[$email['name']] : ''; ?></span>
            </div>
        </div>

        <div class="control-group">

            <div class="controls">
                <button class="btn btn-success" name="change" data-loading-text="Loading...">Send confirmation email</button>
            </div>
        </div>
    </fieldset>
</form> 
 

