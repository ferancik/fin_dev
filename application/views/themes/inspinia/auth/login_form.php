<?php
$login = array(
    'name' => 'login',
    'id' => 'login',
    'value' => set_value('login'),
    'maxlength' => 80,
    'size' => 30,
    'class' => 'form-control',
    'placeholder' => "Email address",
    'required' => '',
);
if ($login_by_username AND $login_by_email) {
    $login_label = 'Email or login';
} else if ($login_by_username) {
    $login_label = 'Login';
} else {
    $login_label = 'Email';
}
$password = array(
    'name' => 'password',
    'id' => 'password',
    'size' => 30,
    'class' => 'form-control',
    'placeholder' => "Password",
    'required' => '',
);
$remember = array(
    'name' => 'remember',
    'id' => 'remember',
    'value' => 1,
    'checked' => set_value('remember'),
    'style' => 'float:left'
);
$captcha = array(
    'name' => 'captcha',
    'id' => 'captcha',
    'maxlength' => 8,
);
?>


<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>EMU SCADA | login</title>

        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>assets/css/animate.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">

    </head>

    <body class="gray-bg">

        <div class="middle-box text-center loginscreen  animated fadeInDown">
            <div>
                <div>

                    <h1 class="logo-name"></h1>

                </div>
                <h3><img src="<?php echo base_url(); ?>assets/img/logo_login.png" alt="EMU SCADA" /></h3>
                <?php echo form_open($this->uri->uri_string(), array('class' => 'm-t', 'role' => 'form')); ?>
                <div class="form-group">
                    <?php echo form_input($login); ?>
                </div>
                <div class="form-group">
                    <?php echo form_password($password); ?>
                </div>
                <div style="color: red;"><?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']]) ? $errors[$login['name']] : ''; ?></div>

                <label class="checkbox">
                    <?php echo form_checkbox($remember); ?>  <?php echo lang('remember_me'); ?> 
                </label>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                <a href="<?php echo site_url('/auth/forgot_password/'); ?>"><small>Forgot password?</small></a>
                </form>
                
            </div>
        </div>
        <!-- Mainly scripts -->
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    </body>

</html>




