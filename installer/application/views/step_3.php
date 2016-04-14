<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <div class="span2">
                <ul class="nav nav-list well">

                    <li>
                        Step 1
                    </li>
                    <li class="divider"></li>
                    <li>
                        Step 2
                    </li>
                    <li class="divider"></li>
                    <li class="active">
                        <a href="#">Completed</a>
                    </li>



                </ul>
            </div>
            <div class="span8 ">

                <div class="hero-unit">
                    <h1>
                        KF CMS Installation completed!
                    </h1>
     
                    <h3>Thank you for choosing KF CMS.</h3>
                    
                    <p>Now you MUST completely remove 'installer' directory from your server.</p>
                    <p>&nbsp;</p> <p>&nbsp;</p>
                    <p>

                        <?php
                        $pageURL = 'http';
                        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
                            $pageURL .= "s";
                        }
                        $pageURL .= "://";
                        if ($_SERVER["SERVER_PORT"] != "80") {
                            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"];
                        } else {
                            $pageURL .= $_SERVER["SERVER_NAME"] ;
                        }
                        
                        $utlT = explode('/', $_SERVER['REQUEST_URI']);
                        $urlPridat = '';
                        foreach ($utlT as $one){
                            if ($one == 'installer'){
                                break;
                            }else{
                              $urlPridat .= $one.'/'; 
                            }
                        }
                        
                        $pageURL .=substr($urlPridat, 0,-1);
                        ?>
                        <a class="btn btn-primary btn-large" target="_blank" href="<?php echo $pageURL.'/admin'; ?>">GO to Admin</a>
                        <a class="btn btn-primary btn-large" target="_blank" style="margin-left: 15px;" href="<?php echo $pageURL.'/'; ?>">GO to Page</a>
                    </p>
                </div>
            </div>
            <div class="span2">
            </div>
        </div>
    </div>
</div>