<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <?php
        $title = ((isset($menu_Kde_Som) && $menu_Kde_Som->nazov != "" ) ? ' - ' . $menu_Kde_Som->nazov : '');
        ?>
        <title>KF CMS Admin<?php echo $title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="KF CMS system">

        <link href="<?php echo base_url() ?>admin_assets/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>admin_assets/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>admin_assets/plugins/asmselect/jquery.asmselect.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>admin_assets/css/validationEngine.jquery.css" rel="stylesheet">
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
            var base_url_original = '<?= base_url(); ?>';
            var base_url = '<?= site_url('/'); ?>/';
            var URL_FILE_MANAGER = '<?= site_url('admin/filemanager/zobraz'); ?>/';
        </script>

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="<?php echo base_url() ?>admin_assets/js/html5shiv.js"></script>
        <![endif]-->

    </head>
    <body>

        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="<?php echo site_url('/'); ?>">KF CMS</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li>   
                                <?php
                                $flag_araay = $this->config->item('admin_language_array');
                                $flag_araay = array_flip($flag_araay);
                                ?>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo base_url(); ?>admin_assets/flag/<?php echo $flag_araay[$this->uri->segment(1)]; ?>.png" /> <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <?php foreach ($langs as $row) { ?>
                                        <li><?php echo anchor($this->lang->switch_uri($row->dir), '<img src="' . base_url() . 'admin_assets/flag/' . $row->icon . '" /> ' . $row->name); ?></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home icon-white"></i> Dashboard</a></li>
                            <?
                            // preVarDump($root_admin_menu);
                            foreach ($root_admin_menu as $root_menu) {
                                if (count($root_menu->parrents) > 0) {
                                    ?>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo getMenuIcon($root_menu, true) . $root_menu->nazov; ?> <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <?
                                            foreach ($root_menu->parrents as $root_menu_parrents) {

                                                if (count($root_menu_parrents->parrents) > 0) {
                                                    //echo preVarDump($root_menu_parrents);
                                                    $prvy = $root_menu_parrents;
                                                    ?>
                                                    <li class="dropdown-submenu">
                                                        <?
                                                        ?>    
                                                        <a href="<?php echo site_url('admin/' . $prvy->kontroler); ?>"><?php echo getMenuIcon($prvy) . $prvy->nazov; ?></a>
                                                        <ul class="dropdown-menu">
                                                            <?
                                                            foreach ($root_menu_parrents->parrents as $rowMenu) {
                                                                ?>
                                                                <li><a href="<?php echo site_url('admin/' . $rowMenu->kontroler); ?>"><?php echo getMenuIcon($rowMenu) . $rowMenu->nazov; ?></a></li>

                                                            <? } ?>
                                                        </ul>
                                                    </li>
                                                    <?
                                                } else {
                                                    ?>
                                                    <li><a href="<?php echo site_url('admin/' . $root_menu_parrents->kontroler); ?>"><?php echo getMenuIcon($root_menu_parrents) . $root_menu_parrents->nazov; ?></a></li>
                                                    <?
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </li> 
                                    <?
                                } else {
                                    ?>
                                    <li><a href="<?php echo site_url('admin/' . $root_menu->kontroler); ?>"><?php echo getMenuIcon($root_menu) . $root_menu->nazov; ?></a></li>
                                    <?
                                }
                            }
                            ?>
                        </ul>
                        <!--  user menu   -->
                        <div class=" btn-group pull-right">

                            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="icon-user"></i> <?php echo $root_username; ?>	<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url(); ?>admin/auth/change_password"><i class="icon-cog"></i> Change password</a></li>
                                <li><a href="<?php echo base_url(); ?>admin/auth/change_email"><i class="icon-cog"></i> Change email</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo base_url(); ?>admin/auth/logout"><i class="icon-off"></i> Logout</a></li>

                            </ul>
                        </div>



                    </div>  
                </div>
            </div>
        </div>   
        <div class="container">


            <div class="row">
                <div class="span12 main_span12">
                    <?php echo $breadcrumb; ?>

                    <div id="loading-indicator" style="display: none" >Loading <img src="<?php echo base_url(); ?>admin_assets/css/13.gif" />      </div>    
                    <?php echo $contents; ?>
                    <?php echo $this->config->item('ADMIN_FOOTER'); ?>
                    
                    <?php
                    if ($this->config->item('PROFILER_ENABLE')){
                     $this->output->enable_profiler(TRUE);
                    }
                    ?>
                </div>
            </div>


        </div> 

        <a id="backToTop" href="#top" style="display: none;"><i class="icon-chevron-up"></i></a>

        <script src="<?php echo base_url() ?>admin_assets/js/tools.js"></script>
        <script src="<?php echo base_url() ?>admin_assets/plugins/asmselect/jquery.asmselect.js"></script>
        <script src="<?php echo base_url() ?>admin_assets/plugins/tinymce/tinymce.min.js"></script>

        <script src="<?php echo base_url() ?>admin_assets/plugins/validationengine/jquery.validationEngine.js"></script>
        <script src="<?php echo base_url() ?>admin_assets/plugins/validationengine/languages/jquery.validationEngine-en.js"></script>
    </body>
</html>
