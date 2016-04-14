<?PHP

IF (!defined('BASEPATH'))
    exit('No direct script access allowed');
# REMOVED EllisLab Comments to save space, to view comments
# open /system/libraries/router.php

class MY_Router extends CI_Router {

    private $aktivneMenu = null;
    public $db_conn = null;
    public $admin = false;

    public function __construct() {
        parent::__construct();
        $this->admin = false;
    }


    function is_admin() {
        return $this->admin;
    }

    function getActiveMenu() {
        return $this->aktivneMenu;
    }

    function _validate_request($segments) {
        //  print_r($segments);
        if (count($segments) == 0) {
            $this->admin = false;
            return $segments;
        }
        $this->admin = false;


        if ($segments[0] == 'admin') {
            $this->admin = true;
            // prehladava databazu pre nacitanie kontrolera START
            // 
            require_once (APPPATH . 'config/database.php');
            require_once (APPPATH . 'config/explicitconnectdb.php');

            $cestaOjb = array();
            $mamCislo = null;

           

            for ($i = count($segments) - 1; $i > 0; $i--) {
                $elm = $segments[$i];

                if (!is_numeric($elm)) { // ak neni cislo
                    $sql = "SELECT kontroler,id,id_parrent, url FROM admin_menu WHERE url='" . mysql_real_escape_string($elm) . "'";
                    $query = mysql_query($sql, $db_conn);
                    while ($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
                        $sql2 = "SELECT kontroler,id,id_parrent, url FROM admin_menu WHERE id='" . $row['id_parrent'] . "'";
                        $query2 = mysql_query($sql2, $db_conn);
                        $row2 = mysql_fetch_array($query2, MYSQL_ASSOC);

                        //   echo $segments[$i] . ' sg-1:' . $segments[($i - 1)] . ' - ' . $row2['url'] . '<br />';
                        if ($segments[($i - 1)] == $row2['url']) {
                            $tempObj = new stdClass();
                            $tempObj->kontroler = $row['kontroler'];
                            $tempObj->id = $row['id'];
                            $tempObj->url = $row['url'];
                            $tempObj->id_parrent = $row['id_parrent'];
                            $cestaOjb[] = $tempObj;
                        }
                    }


                    mysql_free_result($query);
                } else {
                    $mamCislo[] = $elm;
                }
            }
            mysql_close($db_conn);



            $OKcesta = $cestaOjb[0]->kontroler;


            $this->aktivneMenu = $OKcesta;

            if ($OKcesta !== FALSE && $OKcesta != null) {
                if (is_array($mamCislo)) {
                    krsort($mamCislo);
                }
                $segments = explode('/', $OKcesta . ((is_array($mamCislo) ? '/' . implode('/', $mamCislo) : '')));
                $mamCislo = null;
                // vlozim admin pred vsetko
                array_splice($segments, 0, 0, array("admin"));
            }
        } else {
            $this->admin = false;
        }
      
        
        
//        if ($segments[0] == 'event' && count($segments)==2) {
//            $return_array[] = 'event';
//            $return_array[] = 'detail';
//            $return_array[] = $segments[count($segments) - 1];
//
//            return $return_array;
//        }
//        
//        if ($segments[0] == 'event' && $segments[2] == 'registracia') {
//            $return_array[] = 'event';
//            $return_array[] = 'registration';
//            $return_array[] = $segments[1];
//
//            return $return_array;
//        }
//        
//        if ($segments[0] == 'event' && count($segments) == 3) {
//            $return_array[] = 'event';
//            $return_array[] = $segments[2];
//            $return_array[] = $segments[1];
//            
//            return $return_array;
//        }
        
        
        


        // Does the requested controller exist in the root folder?
        if (file_exists(APPPATH . 'controllers/' . ucfirst($segments[0]) . '.php')) {
            return $segments;
        }

        // Is the controller in a sub-folder?
        if (is_dir(APPPATH . 'controllers/' . $segments[0])) {
            // Set the directory and remove it from the segment array
            $this->set_directory($segments[0]);
            $segments = array_slice($segments, 1);

            if (count($segments) > 0) {
                // Does the requested controller exist in the sub-folder?
                if (!file_exists(APPPATH . 'controllers/' . $this->fetch_directory() . ucfirst($segments[0]) . '.php')) {

                    if (!empty($this->routes['404_override_admin']) && $this->admin) {
                        $x = explode('/', $this->routes['404_override_admin']);
                        $this->set_directory('admin');
                        $this->set_class($x[0]);
                        $this->set_method(isset($x[1]) ? $x[1] : 'index');
                        return $x;
                    }

                    if (!empty($this->routes['404_override_web'])) {
                        $x = explode('/', $this->routes['404_override_web']);

                        $this->set_class($x[0]);
                        $this->set_method(isset($x[1]) ? $x[1] : 'index');

                        return $x;
                    } else {
                        show_404($this->fetch_directory() . $segments[0]);
                    }
                }
            } else {

                // Is the method being specified in the route?
                if (strpos($this->default_controller, '/') !== FALSE) {
                    $x = explode('/', $this->default_controller);

                    $this->set_class($x[0]);
                    $this->set_method($x[1]);
                } else {
                    $this->set_class($this->default_controller);
                    $this->set_method('index');
                }

                // Does the default controller exist in the sub-folder?
                if (!file_exists(APPPATH . 'controllers/' . $this->fetch_directory() . $this->default_controller . '.php')) {
                    $this->directory = '';
                    return array();
                }
            }

            return $segments;
        }


        // If we've gotten this far it means that the URI does not correlate to a valid
        // controller class.  We will now see if there is an override
        if ($this->admin) {
            if (!empty($this->routes['404_override_admin'])) {
                $x = explode('/', $this->routes['404_override_admin']);
                $this->set_directory('admin');
                $this->set_class($x[0]);
                $this->set_method(isset($x[1]) ? $x[1] : 'index');

                return $x;
            }
        }

        if (!empty($this->routes['404_override_web'])) {
            $x = explode('/', $this->routes['404_override_web']);

            $this->set_class($x[0]);
            $this->set_method(isset($x[1]) ? $x[1] : 'index');

            return $x;
        }

        // Nothing else to do at this point but show a 404
        show_404($segments[0]);
    }

    function generateAdminMenu($root_admin_menu, $dmin_permission_id, $opravneniaMenu) {

        if ($dmin_permission_id != 1) {
            $rootMenuAllRow = array();

            foreach ($root_admin_menu as $value) {

                foreach ($opravneniaMenu as $valueOpravneniaMenu) {
                    if ($value->id == $valueOpravneniaMenu->admin_menu) {
                        $rootMenuAllRow[] = $value;
                    }
                }

                if (count($value->parrents) > 0) {

                    foreach ($value->parrents as $valueParrents) {

                        foreach ($opravneniaMenu as $valueOpravneniaMenu) {
                            if ($valueParrents->id == $valueOpravneniaMenu->admin_menu) {
                                $rootMenuAllRow[] = $valueParrents;
                            }
                        }
                        if (count($valueParrents->parrents) > 0) {
                            for ($i = 0; $i < count($valueParrents->parrents); $i++) {
                                foreach ($opravneniaMenu as $valueOpravneniaMenu) {
                                    if ($valueParrents->parrents[$i]->id == $valueOpravneniaMenu->admin_menu) {
                                        $rootMenuAllRow[] = $valueParrents->parrents[$i];
                                    }
                                }
                                if (count($valueParrents->parrents[$i]->parrents) > 0) {

                                    for ($ii = 0; $ii < count($valueParrents->parrents[$i]->parrents); $ii++) {

                                        foreach ($opravneniaMenu as $valueOpravneniaMenu) {
                                            if ($valueParrents->parrents[$i]->parrents[$ii]->id == $valueOpravneniaMenu->admin_menu) {
                                                $rootMenuAllRow[] = $valueParrents->parrents[$i]->parrents[$ii];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            foreach ($rootMenuAllRow as $row) {
                $row->parrents = array();
            }
            $root_admin_menuTemp = $this->buildTreeR($rootMenuAllRow, 0);
            return $root_admin_menuTemp;
        } else {
            $root_admin_menuTemp = $root_admin_menu;
        }

        return $root_admin_menuTemp;
    }

    function buildTreeR($ar, $pid = null) {
        $op = array();
        foreach ($ar as $item) {
            if ($item->id_parrent == $pid) {
                $op[$item->id] = $item;

                // recursion
                $children = $this->buildTreeR($ar, $item->id);
                if ($children) {
                    $op[$item->id]->parrents = $children;
                }
            }
        }
        return $op;
    }

}
