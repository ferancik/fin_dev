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
if ($login_by_username AND $login_by_email) {
    $login_label = lang('auth_email_or_login');
} else if ($login_by_username) {
    $login_label = lang('auth_login');
} else {
    $login_label = lang('auth_email_address');
}

$login['placeholder'] = $login_label;

$password = array(
    'name' => 'password',
    'id' => 'password',
    'size' => 30,
    'class' => "input-block-level",
    'placeholder' => lang('auth_password')
);
$remember = array(
    'name' => 'remember',
    'id' => 'remember',
    'value' => 1,
    'checked' => set_value('remember'),
);
$captcha = array(
    'name' => 'captcha',
    'id' => 'captcha',
    'class' => "input-block-level",
    'maxlength' => 30,
    'placeholder' => lang('auth_confirmation_code')
);
?>
<!DOCTYPE html>    
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>KF CMS - Admin Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="itomnia@gmail.com">
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

            <?php
            $flag_araay = $this->config->item('admin_language_array');
            $flag_araay = array_flip($flag_araay);

            $langs = $this->admin_language_m->getActiveLanguage();
            ?>
            <h3 class="form-signin-heading">KF CMS</h3>
            <h4 class="form-signin-heading"><?php echo lang('auth_please_login_in');?></h4>

            <?php echo form_input($login); ?>
            <span style="color:red; margin-left: 9px;"><?php echo form_error($login['name'], ' ', ' '); ?><?php echo isset($errors[$login['name']]) ? $errors[$login['name']] : ''; ?></span>


            <?php echo form_password($password); ?>
            <span style="color:red; margin-left: 9px;"><?php echo form_error($password['name'], ' ', ' '); ?><?php echo isset($errors[$password['name']]) ? $errors[$password['name']] : ''; ?></span>

            <?php
            if ($show_captcha) {
                if ($use_recaptcha) {
                    ?>

                    <div id="recaptcha_image"></div>

                    <a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
                    <div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
                    <div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>


                    <div class="recaptcha_only_if_image">Enter the words above</div>
                    <div class="recaptcha_only_if_audio">Enter the numbers you hear</div>

                    <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
                    <?php echo form_error('recaptcha_response_field', '<span style="color:red; margin-left: 9px;"> ', '</span>'); ?>
                    <?php echo $recaptcha_html; ?>

                <?php } else { ?>

                    <p>Enter the code exactly as it appears:</p>
                    <?php echo $captcha_html; ?>


                    <?php echo form_input($captcha); ?>
                    <?php echo form_error($captcha['name'], '<span style="color:red; margin-left: 9px;"> ', '</span>'); ?>

                    <?php
                }
            }
            ?>
            <label class="checkbox">
                <?php echo form_checkbox($remember); ?>  <?php echo lang('auth_remember_me');?>
            </label>
            <p>
            <button class="btn btn-large btn-primary" type="submit"><?php echo lang('auth_login_btn');?></button>
            <div  style=" float: right; margin-top: -39px;"><a href="<?php echo base_url(); ?>admin/auth/forgot_password/" > <?php echo lang('auth_forgot_password');?></a></div>
            </p>
          <div class="dropdown" style=" float: right; margin-top: 5px;  margin-right: -24px;" >
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo base_url(); ?>admin_assets/flag/<?php echo $flag_araay[$this->uri->segment(1)]; ?>.png" /> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php foreach ($langs as $row) { ?>
                        <li><?php echo anchor($this->lang->switch_uri($row->dir), '<img src="' . base_url() . 'admin_assets/flag/' . $row->icon . '" /> ' . $row->name); ?></li>
                    <?php } ?>
                </ul>
         </div>
        
    </form>

</div>
<script src="<?php echo base_url() ?>admin_assets/js/jquery-1.9.1.min.js"></script>
<script src="<?php echo base_url() ?>admin_assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
