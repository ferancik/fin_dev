<?php 
//Last update 26.04.2014, 13:17

/** 

* @property CI_DB_active_record $db
* @property CI_DB_forge $dbforge
* @property CI_Benchmark $benchmark
* @property CI_Calendar $calendar
* @property CI_Cart $cart
* @property CI_Config $config
* @property CI_Controller $controller
* @property CI_Email $email
* @property CI_Encrypt $encrypt
* @property CI_Exceptions $exceptions
* @property CI_Form_validation $form_validation
* @property CI_Ftp $ftp
* @property CI_Hooks $hooks
* @property CI_Image_lib $image_lib
* @property CI_Input $input
* @property CI_Language $language
* @property CI_Loader $load
* @property CI_Log $log
* @property CI_Model $model
* @property CI_Output $output
* @property CI_Pagination $pagination
* @property CI_Parser $parser
* @property CI_Profiler $profiler
* @property CI_Router $router
* @property CI_Session $session
* @property CI_Sha1 $sha1
* @property CI_Table $table
* @property CI_Trackback $trackbackv
* @property CI_Typography $typography
* @property CI_Unit_test $unit_test
* @property CI_Upload $upload
* @property CI_URI $uri
* @property CI_User_agent $user_agent
* @property CI_Validation $validation
* @property CI_Xmlrpc $xmlrpc
* @property CI_Xmlrpcs $xmlrpcs
* @property CI_Zip $zip
* @property Cenove_hladiny_tlaciarne_m $cenove_hladiny_tlaciarne_m
* @property Cenove_hladiny_m $cenove_hladiny_m
* @property Masiny_m $masiny_m
* @property Nastavenia_m $nastavenia_m
* @property Nastavenia_tlace_m $nastavenia_tlace_m
* @property New_users_m $new_users_m
* @property Pomoc_masina_m $pomoc_masina_m
* @property Send_email_model $send_email_model
* @property Subory_model $subory_model
* @property Tlacene_subory_m $tlacene_subory_m
* @property Tlaciarne_m $tlaciarne_m
* @property Tlacove_ulohy_data_m $tlacove_ulohy_data_m
* @property User_login_masina_m $user_login_masina_m
* @property User_priatelia_m $user_priatelia_m
* @property User_profiles_m $user_profiles_m
* @property User_subory_m $user_subory_m
* @property Vlozeny_papier_m $vlozeny_papier_m
* @property Users_m $users_m
* @property Zdielanie_mail_m $zdielanie_mail_m
* @property Send_email_m $send_email_m
* @property User_autologin $user_autologin
* @property Login_attempts $login_attempts
* @property Users $users
* @property New_users_subory_cm $new_users_subory_cm
* @property Subory_cm $subory_cm
* @property New_users_cm $new_users_cm
* @property User_subory_cm $user_subory_cm
* @property User_profiles_cm $user_profiles_cm
* @property Users_cm $users_cm
* @property Zdielanie_mail_cm $zdielanie_mail_cm
* @property Users_uim $users_uim
* @property Subory_m $subory_m
* @property New_users_subory_m $new_users_subory_m
* @property New_users_m $new_users_m
* @property User_subory_m $user_subory_m
* @property Decode $decode
* @property Cenove_hladiny $cenove_hladiny
* @property Elfinder_lib $elfinder_lib
* @property Email $email
* @property Masina $masina
* @property Mcrypt $mcrypt
* @property Menu $menu
* @property Newemail $newemail
* @property Odosielanie_mailu $odosielanie_mailu
* @property Phpmailer $phpmailer
* @property Send_email $send_email
* @property Stiahni $stiahni
* @property Tank_auth $tank_auth
* @property Template $template
* @property Tlaciaren $tlaciaren
* @property User_files $user_files
* @property User_info $user_info
* @property ElFinder.class $elfinder.class
* @property Connector $connector
* @property ElFinderVolumeDriver.class $elfindervolumedriver.class
* @property ElFinderConnector.class $elfinderconnector.class
* @property ElFinderVolumeLocalFileSystem.class $elfindervolumelocalfilesystem.class
* @property ElFinderVolumeMySQL.class $elfindervolumemysql.class
* @property MySQLStorage.sql $mysqlstorage.sql
* @property Mime.types.new $mime.types.new
* @property Mime.types $mime.types
* @property Bacic.html $bacic.html
* @property PasswordHash $passwordhash
* @property Test $test
* @property Makefile $makefile
* @property Crypt_private.c $crypt_private.c
* @property Subory $subory
* @property Zdielanie $zdielanie
*/
class CI_Controller { 
                
 /**
 * @access public
 * @return CI_Controller
 * 
 */
function get_instance() {}

};


class CI_DB_Driver {
 /**
  * Execute the query
  *
  * Accepts an SQL string as input and returns a result object upon
  * successful execution of a "read" type query.  Returns boolean TRUE
  * upon successful execution of a "write" type query. Returns boolean
  * FALSE upon failure, and if the $db_debug variable is set to TRUE
  * will raise an error.
  *
  * @access public
  * @param string An SQL query string
  * @param array An array of binding data
  * @return CI_DB_mysql_result
  */
 function query() {}
};
/** 

* @property Cenove_hladiny_tlaciarne_m $cenove_hladiny_tlaciarne_m
* @property Cenove_hladiny_m $cenove_hladiny_m
* @property Masiny_m $masiny_m
* @property Nastavenia_m $nastavenia_m
* @property Nastavenia_tlace_m $nastavenia_tlace_m
* @property New_users_m $new_users_m
* @property Pomoc_masina_m $pomoc_masina_m
* @property Send_email_model $send_email_model
* @property Subory_model $subory_model
* @property Tlacene_subory_m $tlacene_subory_m
* @property Tlaciarne_m $tlaciarne_m
* @property Tlacove_ulohy_data_m $tlacove_ulohy_data_m
* @property User_login_masina_m $user_login_masina_m
* @property User_priatelia_m $user_priatelia_m
* @property User_profiles_m $user_profiles_m
* @property User_subory_m $user_subory_m
* @property Vlozeny_papier_m $vlozeny_papier_m
* @property Users_m $users_m
* @property Zdielanie_mail_m $zdielanie_mail_m
* @property Send_email_m $send_email_m
* @property User_autologin $user_autologin
* @property Login_attempts $login_attempts
* @property Users $users
* @property New_users_subory_cm $new_users_subory_cm
* @property Subory_cm $subory_cm
* @property New_users_cm $new_users_cm
* @property User_subory_cm $user_subory_cm
* @property User_profiles_cm $user_profiles_cm
* @property Users_cm $users_cm
* @property Zdielanie_mail_cm $zdielanie_mail_cm
* @property Users_uim $users_uim
* @property Subory_m $subory_m
* @property New_users_subory_m $new_users_subory_m
* @property New_users_m $new_users_m
* @property User_subory_m $user_subory_
* @property CI_DB_active_record $db
* @property CI_DB_forge $dbforge
* @property CI_Config $config
* @property CI_Loader $load
* @property CI_Session $session
*/

class CI_Model {}; 
/**
 * @return CI_Controller
 */
function get_instance() {}