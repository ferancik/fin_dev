<!DOCTYPE html>    
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>KF CMS - Admin</title>
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

            .main_block {
                width: 500px;
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
            
        </style>

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="<?php echo base_url() ?>admin_assets/js/html5shiv.js"></script>
        <![endif]-->

    </head>
    <body>

        <div class="container">
            <div class="main_block">
<?php echo $message; ?>
    <br /><br /><br />
    <a href='<?=  base_url()?>admin/auth'>Go back login</a>
           </div>
    </div>
    <script src="<?php echo base_url() ?>admin_assets/js/jquery-1.9.1.min.js"></script>
    <script src="<?php echo base_url() ?>admin_assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>