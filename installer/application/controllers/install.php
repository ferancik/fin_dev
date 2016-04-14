<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Install extends CI_Controller {

    private $writable_dir = array(
        'application/config/',
        'uploads/',
        'uploads/cmsUploads/',
        'uploads/gallery/',
        'uploads/gallery/tumbs',
        'uploads/images/slider/img/',
        'uploads/images/slider/img/thumb',
        'uploads/images/partner/',
        'uploads/images/navbloky/',
        'uploads/dokumenty/'
    );
    private $writable_files = array(
        'application/config/admin/admin.php',
        '.htaccess'
    );

    public function __construct() {
        parent::__construct();
        $this->load->library('template');
        $this->load->helper('url');
        $this->load->helper('tools');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function index() {
        if (empty($_GET['t'])) {
            $this->load->helper('file');
            $fileT = dirname(__FILE__);
            // $realPath = $fileT . '../../../../';
            $realPath = '../';
            $permissions = array();
            foreach ($this->writable_dir as $dir) {
                @chmod($realPath . $dir, 0777);
                $permissions['directories'][$dir] = is_really_writable($realPath . $dir);
            }

            foreach ($this->writable_files as $file) {
                @chmod($realPath . $file, 0666);
                $permissions['files'][$file] = is_really_writable($realPath . $file);
            }





            $this->template->load('template', 'welcome', array('permissions' => $permissions));
        } else {
            switch ($_GET['t']) {
                case 'checkDBConnect':
                    $this->checkDBConnect();
                    break;
                case 'step1':
                    $this->step_1();
                    break;
                case 'step2':
                    $this->step_2();
                    break;
                case 'step3':
                    $this->step_3();
                    break;
                case 'completed':
                    $this->completed();
                    break;
                default:
                    redirect('install/index');
                    break;
            }
        }
    }

    private function checkDBConnect($ajax = true, $zdroj = false) {
        if (!$zdroj) {
            $mysql_host = $_POST['mysql_host'];
            $mysql_user = $_POST['mysql_user'];
            $mysql_pass = $_POST['mysql_pass'];
            $mysql_db_name = $_POST['mysql_db_name'];
        } else {
            $mysql_host = $zdroj['mysql_host'];
            $mysql_user = $zdroj['mysql_user'];
            $mysql_pass = $zdroj['mysql_pass'];
            $mysql_db_name = $zdroj['mysql_db_name'];
        }

        $this->session->set_userdata(array(
            'mysql_host' => $mysql_host,
            'mysql_user' => $mysql_user,
            'mysql_pass' => $mysql_pass,
            'mysql_db_name' => $mysql_db_name
        ));

        $conn = @mysql_connect($mysql_host, $mysql_user, $mysql_pass, true);
        if (!$conn || !mysql_select_db($mysql_db_name, $conn)) {
            @mysql_close($conn);
            if ($ajax) {
                echo json_encode(array(
                    'success' => false,
                    'message' => '<b>Error !</b> Database connection error could not connect to mysql'
                ));
            }
            return false;
        } else {
            @mysql_close($conn);
            if ($ajax) {
                echo json_encode(array(
                    'success' => true,
                    'message' => '<b>Success !</b> Database connection OK'
                ));
            }
            return true;
        }
    }

    public function check_rewrite() {

        if (!function_exists('apache_get_modules')) {
            return print('fail');
        }

        if (in_array('mod_rewrite', apache_get_modules())) {
            return print('enabled');
        }

        return print('mod_rewrite');
    }

    private function step_1() {
        $dataS = $this->session->all_userdata();
        if (isset($dataS['installCompleted']) && $dataS['installCompleted'] == 'true') {
            $this->session->set_userdata('installCompleted', 'true');
            redirect('install/?t=completed');
        } else {

            $this->template->load('template', 'step_1');
        }
    }

    private function step_2() {

        $dataS = $this->session->all_userdata();
        if (isset($dataS['installCompleted']) && $dataS['installCompleted'] == 'true') {
            $this->session->set_userdata('installCompleted', 'true');
            redirect('install/?t=completed');
        } else {

            if (isset($_POST['akyKrok']) && $_POST['akyKrok'] == 'step3') {
                if (!$this->checkDBConnect(false)) {
                    $this->session->set_flashdata('message', '<b>Error !</b> Database connection error could not connect to mysql');
                    redirect('install/?t=step1');
                }
            }
            $this->template->load('template', 'step_2');
        }
    }

    private function step_3() {

        $dataS = $this->session->all_userdata();
        if (isset($dataS['installCompleted']) && $dataS['installCompleted'] == 'true') {
            $this->session->set_userdata('installCompleted', 'true');
            redirect('install/?t=completed');
        } else {


            if (isset($_POST['akyKrok']) && $_POST['akyKrok'] == 'step3') {
                if (!$this->checkDBConnect(false, $this->session->all_userdata())) {
                    $this->session->set_flashdata('message', '<b>Error !</b> Database connection error could not connect to mysql');
                    redirect('install/?t=step1');
                }
            }


            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[password2]');
            $this->form_validation->set_rules('password2', 'Confirm Password', 'trim|required');

            if ($this->form_validation->run()) {
                $db = $this->session->all_userdata();
                $user = $this->form_validation->set_value('username');
                $email = $this->form_validation->set_value('email');
                $pass = $this->form_validation->set_value('password');

                $obj = new stdClass();
                $obj->mysql_host = $db['mysql_host'];
                $obj->mysql_user = $db['mysql_user'];
                $obj->mysql_pass = $db['mysql_pass'];
                $obj->mysql_db_name = $db['mysql_db_name'];
                $obj->user = $user;
                $obj->email = $email;
                $obj->pass = $pass;

                $this->installProsess($obj);
            } else {
                $this->session->set_flashdata('message', validation_errors());
                redirect('install/?t=step2');
            }

            $this->template->load('template', 'step_3');
        }
    }

    private function completed() {

        $this->template->load('template', 'step_3');
    }

    public function installProsess($obj) {
        $file = dirname(__FILE__);
        $sql = file_get_contents(APPPATH . 'sql/kfcmssystem.sql');
//
//        $obj = new stdClass();
//        $obj->mysql_host = 'localhost';
//        $obj->mysql_user = 'root';
//        $obj->mysql_pass = 'root';
//        $obj->mysql_db_name = 'testx';
//        $obj->user = 'admin';
//        $obj->email = 'admin@admin.sk';
//        $obj->pass = 'admin';

        $conn = @mysql_connect($obj->mysql_host, $obj->mysql_user, $obj->mysql_pass, true);
        if ($conn) {
            if (mysql_select_db($obj->mysql_db_name, $conn)) {

                mysql_query('set names utf8', $conn);

                // insert sql 

                if ($this->installDB($sql, $conn)) {


                    $this->load->library('tank_auth');
                    // create user
                    $hasher = new PasswordHash(8, false);
                    // Hash new password using phpass
                    $hashed_password = $hasher->HashPassword($obj->pass);

                    $sqlq = "INSERT INTO `admin_users` (
`id` ,
`username` ,
`password` ,
`email` ,
`activated` ,
`banned` ,
`ban_reason` ,
`new_password_key` ,
`new_password_requested` ,
`new_email` ,
`new_email_key` ,
`last_ip` ,
`last_login` ,
`created` ,
`modified` ,
`admin_permission`
)
VALUES (
NULL , '" . $obj->user . "', '" . $hashed_password . "', '" . $obj->email . "', '1', '0', NULL , NULL , NULL , NULL , NULL , '', '0000-00-00 00:00:00', '" . date('Y-m-d H:m:s', time()) . "',
CURRENT_TIMESTAMP , '1'
);";
                    mysql_query($sqlq, $conn);
                    @mysql_close($conn);
                    // create config file
                    $configFile = '../application/config/database.php';
                    $adminconfigFile = '../application/config/admin/admin.php';
                    $htaccessFile = '../.htaccess';

                    @chmod('../application/config/', 0777);

                    $handle = fopen($configFile, 'w') or die('Cannot create file:  ' . $configFile);
                    @fclose($handle);
                    @chmod($configFile, 0777);


                    $realPath = substr(BASEPATH, 0, -8);


                    $utlT = explode('/', $_SERVER['REQUEST_URI']);
                    $pathstep = -1;
                    $pathHtaccess = '';
                    foreach ($utlT as $oneURL) {
                        if ($oneURL == 'installer') {
                            break;
                        } else {
                            $pathstep++;
                            $pathHtaccess .= $oneURL.'/';
                        }
                    }

                    $this->load->helper('string');
                    
                    $admintextConfig = '<?php

// install on ' . date('d.m.Y, H:i', time()) . '
// http://www.site.com/ = 0,  http://www.site.com/site = 1, http://www.site.com/dir/site = 2
$config[\'PATH_STEP\'] = ' . $pathstep . ';
$config[\'PROFILER_ENABLE\'] = false;  
$config[\'encryption_key\'] = \''.random_string('alnum', 35).'\';

$config[\'PATH_SLIDER_FOLDER\'] = \'' . $realPath . '/uploads/images/slider/img/\';
$config[\'PATH_PARTNER_FOLDER\'] = \'' . $realPath . '/uploads/images/partner/\';
$config[\'PATH_NAVBLKY_FOLDER\'] = \'' . $realPath . '/uploads/images/navbloky/\';
$config[\'PATH_DOKUMENTY_FOLDER\'] = \'' . $realPath . '/uploads/dokumenty/\';


$config[\'CONTROLER_PRE_OBSLUHU_UZIVATELSKYCH_STRANOK\'] = \'page/index/\';

$config[\'ADMIN_FOOTER\'] = \'<hr>
    <footer>
        <p>KF CMS System 2013. | Verzia 1.0 |
        Page rendered in <strong>{elapsed_time}</strong> seconds </p>	
    </footer>\';


$config[\'STRANKY_NA_KTORYCH_NEZOBRAZIT_BREADCRUMB\'] = array(\'pages/browser-filemanager\',\'auth/change_password\', \'dashboard\',\'auth/change_email\',\'notauthorized\',\'filemanager\');
$config[\'STRANKY_VYRADENE_Z_OPRAVNENI\'] = array(\'auth/logout\',\'auth/login\',\'auth\',\'\', \'auth/change_password\', \'dashboard\', \'auth/change_email\', \'notauthorized\');

$config[\'admin_language_array\'] = array(
        \'cs\' => \'czech\',
        \'da\' => \'danish\',
        \'nl\' => \'dutch\',
        \'en\' => \'english\',
        \'fi\' => \'finnish\',
        \'fr\' => \'french\',
        \'de\' => \'german\',
        \'el\' => \'greek\',
        \'hu\' => \'hungarian\',
        \'zh\' => \'chinese_simplified\',
        \'id\' => \'indonesian\',
        \'it\' => \'italian\',
        \'pl\' => \'polish\',
        \'pt\' => \'portuguese\',
        \'ru\' => \'russian\',
        \'sk\' => \'slovak\',
        \'sl\' => \'slovenian\',
        \'es\' => \'spanish\',
        \'sv\' => \'swedish\',
    );

';


                    //------------------------------------  
                    //
                    
$textHtaccess = '#install on ' . date('d.m.Y, H:i', time()) . '
RewriteEngine on
RewriteBase '.$pathHtaccess.'

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule .* index.php/$0 [PT,L] ';

                    //
                    //------------------------------------  
                    $textConfig = '<?php  if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\');';
                    $textConfig .= '
                        
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the \'Database Connection\'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	[\'hostname\'] The hostname of your database server.
|	[\'username\'] The username used to connect to the database
|	[\'password\'] The password used to connect to the database
|	[\'database\'] The name of the database you want to connect to
|	[\'dbdriver\'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	[\'dbprefix\'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	[\'pconnect\'] TRUE/FALSE - Whether to use a persistent connection
|	[\'db_debug\'] TRUE/FALSE - Whether database errors should be displayed.
|	[\'cache_on\'] TRUE/FALSE - Enables/disables query caching
|	[\'cachedir\'] The path to the folder where cache files should be stored
|	[\'char_set\'] The character set used in communicating with the database
|	[\'dbcollat\'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	[\'swap_pre\'] A default table prefix that should be swapped with the dbprefix
|	[\'autoinit\'] Whether or not to automatically initialize the database.
|	[\'stricton\'] TRUE/FALSE - forces \'Strict Mode\' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the \'default\' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = \'default\';
$active_record = TRUE;

//KF CMS system db config
// install ' . date('Y-m-d H:i:s', time()) . '
            
$db[\'default\'][\'hostname\'] = \'' . $obj->mysql_host . '\';
$db[\'default\'][\'username\'] = \'' . $obj->mysql_user . '\';
$db[\'default\'][\'password\'] = \'' . $obj->mysql_pass . '\';
$db[\'default\'][\'database\'] = \'' . $obj->mysql_db_name . '\';
$db[\'default\'][\'dbdriver\'] = \'mysql\';
$db[\'default\'][\'dbprefix\'] = \'\';
$db[\'default\'][\'pconnect\'] = TRUE;
$db[\'default\'][\'db_debug\'] = TRUE;
$db[\'default\'][\'cache_on\'] = FALSE;
$db[\'default\'][\'cachedir\'] = \'\';
$db[\'default\'][\'char_set\'] = \'utf8\';
$db[\'default\'][\'dbcollat\'] = \'utf8_general_ci\';
$db[\'default\'][\'swap_pre\'] = \'\';
$db[\'default\'][\'autoinit\'] = TRUE;
$db[\'default\'][\'stricton\'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */
';
                    if (!file_put_contents($configFile, $textConfig) || !file_put_contents($adminconfigFile, $admintextConfig) || !file_put_contents($htaccessFile, $textHtaccess)) {
                        die('Config file write error !');
                    } else {
                        $this->session->set_userdata('installCompleted', 'true');
                    }
                } else {
                    die('Database Import error !');
                }
                @mysql_close($conn);
            } else {
                die('Select Database error !');
            }
        } else {
            die('Connect to Database error !');
        }
    }

    private function installDB($schema, $conn) {
        $queries = explode('----odelovac---', $schema);

        foreach ($queries as $query) {
            $query = rtrim(trim($query), "\n;");
            @mysql_query($query, $conn);
            if (mysql_errno($conn) > 0) {
                return false;
            }
        }
        return true;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */