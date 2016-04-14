<?php
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Administrácia - Znova Odoslať aktivačný email</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/admin_data/css/login_reset.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/admin_data/css/login_structure.css">
    </head>
    <body>
        <?php echo form_open($this->uri->uri_string(), 'accept-charset="utf-8" class="box login"'); ?>

        <fieldset class="boxBody">

            <label>Email-ová adresa</label>
           <?php echo form_input($email); ?>
            
            <span style="color:red; margin-left: 9px;"> <?php echo form_error($email['name'], '',''); ?><?php echo isset($errors[$email['name']]) ? $errors[$email['name']] : ''; ?></span>
        </fieldset>
        <footer>
            
            <input type="submit" class="btnLogin" name="send" value="Znova odoslať aktivačný email" tabindex="4">
        </footer>
    </form>
</body>
</html>