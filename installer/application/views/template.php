<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>KF CMF system - Installer</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="<?php echo base_url();?>assets/js/html5shiv.js"></script>
        <![endif]-->

        <!-- Fav and touch icons -->
       <!-- <link rel="shortcut icon" href="<?php echo base_url();?>assets/img/favicon.png">  -->

        <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/js/scripts.js"></script>
    </head>

    <body>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <div class="navbar navbar-inverse">
                        <div class="navbar-inner">
                            <div class="container-fluid">
                                <a data-target=".navbar-responsive-collapse" data-toggle="collapse" class="btn btn-navbar"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a> <a href="#" class="brand">KF CMS installer</a>
                                <div class="nav-collapse collapse navbar-responsive-collapse">
                                    <ul class="nav">
                                        <li class="active">
                                        </li>


                                    </ul>
                                    <ul class="nav pull-right">
                                    </ul>
                                </div>

                            </div>
                        </div>

                    </div>

                    <?php
                    echo $contents;
                    ?>

                </div>
            </div>
        </div>
    </body>
</html>