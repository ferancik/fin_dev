<div class="hero-unit" style="font-size: 14px;">
    <h1>
        Welcome to the KF CMS Installation.!
    </h1>
    <p>&nbsp;</p>
    <h4>Check system status: </h4>
    <hr>

    <?php
    
    $error = array();
    ?>
    
    <table class="table">
        <thead>
            <tr>
                <th>Check Requirements</th>
                <th style="width: 45px">Status</th>
            </tr>
        </thead>
        <tbody>
           
                <tr>
                    <td>PHP Settings</td>
                    <td style="text-align: center"><?php echo ($error[] = version_compare(PHP_VERSION, '5.2', '>=')) ? '<span style="color:green;">OK</span>' : '<span style="color:red;">EROOR</span>'; ?></td>
                </tr>
                  <tr>
                    <td>MySQL Settings</td>
                    <td style="text-align: center"><?php echo ($error[] = function_exists('mysql_connect')) ? '<span style="color:green;">OK</span>' : '<span style="color:red;">EROOR</span>'; ?></td>
                </tr>
                <tr>
                    <td>Mod Rewrite Settings</td>
                    <td style="text-align: center"><?php echo ($error[] = in_array('mod_rewrite',apache_get_modules())) ? '<span style="color:green;">OK</span>' : '<span style="color:red;">EROOR</span>'; ?></td>
                </tr>
               
                 <tr>
                    <td>GD Settings</td>
                    <td style="text-align: center"><?php echo ($error[] = GD_ok()) ? '<span style="color:green;">OK</span>' : '<span style="color:red;">EROOR</span>'; ?></td>
                </tr>
                 <tr>
                    <td>Curl </td>
                    <td style="text-align: center"><?php echo ( $error[] = function_exists('curl_init')) ? '<span style="color:green;">OK</span>' : '<span style="color:red;">EROOR</span>'; ?></td>
                </tr>
                
        </tbody>
    </table>
    <p>&nbsp;</p>
    <h4>Check Permissions: </h4>
    <hr>
    <table class="table">
        <thead>
            <tr>
                <th>DIR</th>
                <th style="width: 85px">Permissions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($permissions['directories'] as $key => $value) {
                $error[] = $value;
                ?>
                <tr>
                    <td><?php echo $key; ?></td>
                    <td style="text-align: center"><?php echo ($value) ? '<span style="color:green;">OK</span>' : '<span style="color:red;">EROOR</span>'; ?></td>
                </tr>
<?php } ?>

        </tbody>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>File</th>
                <th style="width: 85px">Permissions</th>
            </tr>
        </thead>
        <tbody>
<?php foreach ($permissions['files'] as $key => $value) { 
     $error[] = $value;
    ?>
                <tr>
                    <td><?php echo $key; ?></td>
                    <td style="text-align: center" ><?php echo ($value) ? '<span style="color:green;">OK</span>' : '<span style="color:red;">EROOR</span>'; ?></td>
                </tr>
<?php } ?>

    </tbody>
    </table>
    <p>&nbsp;</p>
    <?php if (in_array(false, $error)){ ?>
    <h4 class="text-error">It seems that your server failed to meet the requirements to run KF CMS System.
    Please contact your server administrator or hosting company to get this resolved.
    </h4>
    <p>&nbsp;</p>
    <p>
        <a class="btn btn-danger btn-large" href="<?php site_url('installer'); ?>">Try again</a>
    </p>
    <?php } else{?>
    <p>&nbsp;</p>
    <p>
        <a class="btn btn-primary btn-large" href="<?php site_url('installer'); ?>?t=step1">Next step »</a>
    </p>
    <?php }?>
   
</div>