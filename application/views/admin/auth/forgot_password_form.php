<?php
$login = array(
    'name' => 'login',
    'id' => 'login',
    'value' => set_value('login'),
    'maxlength' => 80,
    'size' => 30,
    'class' => "input-block-level",
    'placeholder' => "Email address"
);
if ($this->config->item('use_username', 'admin/tank_auth')) {
    $login_label = 'Email alebo login';
} else {
    $login_label = 'Email';
}
?>
<!DOCTYPE html>    
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>KF CMS - Admin Forgot password</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link href="<?php echo base_url() ?>admin_assets/bootstrap/css/bootstrap.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }

            .form-signin {
                max-width: 300px;
                padding: 19px 29px 29px;
                margin: 0 auto 20px;
                background-color: #fff;
                border: 1px solid #e5e5e5;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
                -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
            }
            .form-signin .form-signin-heading,
            .form-signin .checkbox {
                margin-bottom: 10px;
            }
            .form-signin input[type="text"],
            .form-signin input[type="password"] {
                font-size: 16px;
                height: auto;
                margin-bottom: 15px;
                padding: 7px 9px;
            }

        </style>

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="<?php echo base_url() ?>admin_assets/js/html5shiv.js"></script>
        <![endif]-->

    </head>
    <body>

        <div class="container">

            <?php echo form_open($this->uri->uri_string(), 'accept-charset="utf-8" class="form-signin"'); ?>

             <h3 class="form-signin-heading">KF CMS</h3>
             <h4 class="form-signin-heading">Forgot Password</h4>
            <?php echo form_input($login); ?>
            <span style="color:red; margin-left: 9px;"><?php echo form_error($login['name'], ' ', ' '); ?><?php echo isset($errors[$login['name']]) ? $errors[$login['name']] : ''; ?></span>

            <p>
                <button class="btn btn-large btn-primary" type="submit">Reset password</button>
                <div  style=" float: right; margin-top: -39px;"><a href="<?php echo base_url(); ?>admin/auth/login/"> Go back login</a></div>
            </p>
        </form>
    </div>
    <script src="<?php echo base_url() ?>admin_assets/js/jquery-1.9.1.min.js"></script>
    <script src="<?php echo base_url() ?>admin_assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
