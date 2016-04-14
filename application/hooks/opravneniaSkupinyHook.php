<?php

class opravneniaSkupinyHook {

    function auth() {
        $CI = &get_instance();
        global $RTR;

        if ($RTR->is_admin()) {
            if (!isset($CI->tank_auth)) {
                $CI->load->library('admin/tank_auth_groups', '', 'tank_auth');
                $CI->lang->load('tank_auth');
            }

            if ($CI->tank_auth->is_logged_in()) {

                if (!isset($CI->admin_menu)) {
                    $CI->load->library('admin/admin_menu');
                }

                $menuKdeSom = $CI->admin_menu->getOneMenuKontroler($RTR->getActiveMenu());



                if (!isset($CI->spravapouzivatelov_m)) {
                    $CI->load->model('admin/spravapouzivatelov_m', '', TRUE);
                }
                if (!isset($CI->opravneniaskupiny_m)) {
                    $CI->load->model('admin/opravneniaskupiny_m', '', TRUE);
                }
                if (!isset($CI->admin_menu_m)) {
                    $CI->load->model('admin/admin_menu_m', '', TRUE);
                }
                $user_login = $CI->spravapouzivatelov_m->getOneUser($CI->tank_auth->get_user_id());

                $dmin_permission_id = $user_login->admin_permission_id;
                $opravneniaMenu = $CI->opravneniaskupiny_m->getOpravneniaMenu($dmin_permission_id);
                $root_admin_menu = $CI->admin_menu_m->getRootMenu(true);

                $root_admin_menuTemp = $RTR->generateAdminMenu($root_admin_menu, $dmin_permission_id, $opravneniaMenu);


                $povolene = false;
                $povolene = $this->_in_array_r($menuKdeSom->kontroler,$root_admin_menuTemp);

                $povoleneP = $CI->config->item('STRANKY_VYRADENE_Z_OPRAVNENI');

                $poskladanaUrl = '';
                $segs = $CI->uri->segment_array();

                for ($i = 3; $i <= count($segs); $i++) {
                    $poskladanaUrl .=$segs[$i] . '/';
                }
                $poskladanaUrl = substr($poskladanaUrl, 0, -1);

                if (in_array($poskladanaUrl, $povoleneP) || $dmin_permission_id == 1) {
                    $povolene = true;
                }


                if (!$povolene) {
                    redirect('admin/notauthorized');
                }
            }
        }
    }
    
    /**
	 * Recursively search an array
	 * This method was copied and pasted from this URL (http://stackoverflow.com/questions/4128323/in-array-and-multidimensional-array)
	 * Real credit goes to (http://stackoverflow.com/users/427328/elusive)
	 *
	 * @author Elusive / Brennon Loveless
	 * @param string $needle the term being recursively searched for
	 * @param array $haystack multidimensional array to search
	 * @param boolean $strict use strict comparison or not
	 */
	function _in_array_r($needle, $haystack, $strict = false) {
		foreach ($haystack as $item) {
			if (($strict ? $item->kontroler === $needle : $item->kontroler == $needle) || (is_array($item->parrents) && $this->_in_array_r($needle, $item->parrents, $strict))) {
				return true;
			}
		}
		return false;
	}
    

}

