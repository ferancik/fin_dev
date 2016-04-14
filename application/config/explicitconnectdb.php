<?php

$db_conn = mysql_pconnect($db['default']['hostname'], $db['default']['username'], $db['default']['password']);

if (!$db_conn) {
    die('Not connected (application/core/MY_Router.php): ' . mysql_error());
}

$db_selected = mysql_select_db($db['default']['database'], $db_conn);
if (!$db_selected) {
    die('Can\'t use (application/core/MY_Router.php) ' . $db['default']['hostname'] . ' : ' . mysql_error());
}else{
    mysql_query("set names utf8",$db_conn);
}



