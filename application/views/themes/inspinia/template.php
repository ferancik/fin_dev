<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>| EMU MONITORING</title>

        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/plugins/chosen/chosen.css" rel="stylesheet">
        <!-- Morris -->
        <link href="<?php echo base_url(); ?>assets/css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">

        <!-- Gritter -->
        <link href="<?php echo base_url(); ?>assets/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

        <link href="<?php echo base_url(); ?>assets/css/animate.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/style.css?<?php echo time(); ?> " rel="stylesheet">
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.js"></script>

        <link href="<?php echo base_url(); ?>assets/css/bootstrap-datetimepicker.css" rel="stylesheet">
        
        



    </head>

    <body>
        <div id="wrapper">
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">

                    <ul class="nav" id="side-menu">

                        <li class="nav-header">

                            <div class="dropdown profile-element"> <span></span>
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span>
                                        <img  src="<?php echo base_url(); ?>assets/img/logo.png" alt="Emu scada" />
                                    </span>
                                    <span class="clear"> 
                                        <span class="block m-t-xs"> 
                                            <strong class="font-bold"><?php echo $user_profile->meno; ?></strong>
                                        </span> 
                                    </span> 
                                </a>
                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                    <li><a href="<?php echo site_url('auth/logout'); ?>"><span class="hidden-xs hidden-phone"><?php echo lang("Logout"); ?></span></a></li>
                                </ul>
                            </div>
                            <div class="logo-element">
                                <img src="<?php echo base_url(); ?>assets/img/logo_min.png" alt="logo" height="22"/>
                            </div>

                        </li>
                        <?php if (count($left_menu) > 1) { ?>
                            <li>
                                <a href="<?php echo site_url('home'); ?>"><i class="fa fa-home"></i> <span class="nav-label"><?php echo lang("Home"); ?></span></a>
                            </li>

                        <?php } ?>
                        <!--                        <li>
                                                    <a href="<?php echo site_url('elektromer'); ?>"><i class="fa fa-th-large"></i> <span class="nav-label">Elektromery </span></a>
                                                </li>-->
                        <?php foreach ($left_menu as $key => $root_menu) { ?>
                            <li <?php echo ($current_con == $root_menu['controler']) ? 'class="active"' : ''; ?>>
                                <a href="<?php echo $root_menu['url']; ?>" target="<?php echo $root_menu['target']; ?>">
                                    <i class="fa fa-sitemap"></i> <span class="nav-label"><?php echo $root_menu['title']; ?> </span><span class="fa arrow"></span>
                                </a>
                                <?php if (count($root_menu['children']) > 0) { ?>
                                    <ul class="nav nav-second-level">
                                        <?php foreach ($root_menu['children'] as $key => $level_2) { ?>
                                            <li <?php echo ($current_con == $level_2['controler']) ? 'class="active"' : ''; ?>>

                                                <a href="<?php echo $level_2['url']; ?>" target="<?php echo $level_2['target']; ?>">
                                                    <?php echo lang($level_2['title']); ?>
                                                    <?php echo (count($level_2['children']) > 0) ? '<span class="fa arrow"></span>' : ''; ?>
                                                </a>

                                                <?php if (count($level_2['children']) > 0) { ?>
                                                    <ul class="nav nav-third-level">
                                                        <?php foreach ($level_2['children'] as $key => $level_3) { ?>
                                                            <li <?php echo ($current_con == $level_3['controler']) ? 'class="active"' : ''; ?>>
                                                                <a target="<?php echo $level_3['target']; ?>" href="<?php echo $level_3['url']; ?>"><?php echo lang($level_3['title']); ?></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                <?php } ?>
                                            </li>

                                        <?php } ?>
                                    </ul>

                                <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>

                </div>
            </nav>

            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

                        </div>

                        <ul class="nav navbar-top-links navbar-right">
                            <li>
                                <span class="m-r-sm text-muted welcome-message" id="actual-time"><?php echo date("d.m.Y H:i:s"); ?></span>
                            </li>

                            <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    <img src="<?php echo base_url(); ?>admin_assets/flag/<?php echo $this->uri->segment(1); ?>.png" /> <b class="caret"></b>
<!--                                    <i class="fa fa-bell"></i>  -->
                                </a>
                                <ul class="dropdown-menu">
                                    <?php foreach ($languages as $key => $row) { ?>
                                        <li><?php echo anchor($this->lang->switch_uri($row->code), '<img src="' . base_url() . 'admin_assets/flag/' . $row->icon . '" /> ' . $row->name); ?></li>
                                        <?php if ((count($languages) - 1) != ($key)) { ?>
                                            <li class="divider"></li>
                                        <?php } ?>
                                    <?php } ?>

                                </ul>
                            </li>


                            <li>
                                <a href="<?php echo site_url('auth/logout'); ?>">
                                    <i class="fa fa-sign-out"></i> <span class="hidden-phone hidden-xs"><?php echo lang("Logout"); ?></span>
                                </a>
                            </li>
                        </ul>

                    </nav>
                </div>


                <?php echo $contents; ?>


            </div>
        </div>

        <!-- Mainly scripts -->

        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>





        <!--Custom and plugin javascript--> 
        <script src="<?php echo base_url(); ?>assets/js/inspinia.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/plugins/pace/pace.min.js"></script>

        <!--jQuery UI--> 
        <script src="<?php echo base_url(); ?>assets/js/plugins/jquery-ui/jquery-ui.min.js"></script>

        <!--GITTER--> 
        <script src="<?php echo base_url(); ?>assets/js/plugins/gritter/jquery.gritter.min.js"></script>

        <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-ui.custom.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url(); ?>assets/js/plugins/iCheck/icheck.min.js"></script>

        <!-- Full Calendar -->
        <script src="<?php echo base_url(); ?>assets/js/plugins/fullcalendar/fullcalendar.min.js"></script>
        <!--<script src="<?php echo base_url(); ?>assets/js/plugins/fullcalendar/lang-all.js"></script>-->
        <script src="<?php echo base_url(); ?>assets/js/plugins/iCheck/icheck.min.js"></script>


        <!-- Data picker -->
        <script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>

        <!-- DROPZONE -->
        <script src="<?php echo base_url(); ?>assets/js/plugins/dropzone/dropzone.js"></script>
    </body>
</html>
