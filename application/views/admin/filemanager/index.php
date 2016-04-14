<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>KF CMS - FileBrowser</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link href="<?php echo base_url() ?>admin_assets/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>admin_assets/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>admin_assets/ui/themes/base/jquery.ui.all.css" rel="stylesheet">

        <script src="<?php echo base_url() ?>admin_assets/js/jquery-1.9.1.min.js"></script>
        <script src="<?php echo base_url() ?>admin_assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url() ?>admin_assets/ui/jquery-ui.js"></script>

        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>

        <script type="text/javascript">
            var base_url = '<?php echo site_url('/') . '/'; ?>';
        </script>

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="<?php echo base_url() ?>admin_assets/js/html5shiv.js"></script>
        <![endif]-->

    </head>

    <body>
        <?
        $urlPath = "";
        foreach ($priecinky as $value) {


            if ($value != '') {
                $urlPath.=$value . "/";
            }
        }
        ?>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">

                    <a class="brand" href="<?php echo site_url('/'); ?>">KF CMS - File Browser</a>

                    <ul class="nav">
                        <li><a href="#nahrat_subor" data-toggle="modal"><i class="icon-arrow-up icon-white"></i> Nahrat Subor</a></li>
                        <li><a href="#vytvorit_priecinok" data-toggle="modal"><i class="icon-folder-close icon-white"></i> Vytvorit Priecinok</a></li>
                        <li><a href="<?php echo createLink($urlPath, array('elem' => $idelem, 'type' => $kdezobrazit)); ?>" ><i class=" icon-refresh icon-white"></i> Refresh</a></li>
                    </ul>
                </div>
            </div>
        </div>   
        <div class="container">
            <div class="row">
                <div class="span12">
                    <?php
                    $this->load->view('admin/filemanager/core');
                    ?>
                    <?php echo $this->config->item('ADMIN_FOOTER'); ?>
                </div>
            </div>
        </div> 





        <script src="<?php echo base_url() ?>admin_assets/js/tools.js"></script>

    </body>
</html>
