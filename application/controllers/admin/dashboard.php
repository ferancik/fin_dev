<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('admin/tank_auth_groups', '', 'tank_auth');
    }

    public function index() {

        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {

            $data = array();

            if ($cached = $this->cache->get('google_analytics')) {
                $data['analytic_visits'] = $cached['analytic_visits'];
                $data['analytic_views'] = $cached['analytic_views'];
                //preVarDump($cached);
                //exit;
            } else {
                $this->load->library('admin/nastavenia_lib');
                $setting = $this->nastavenia_lib->getNastavenia();

                if (!empty($setting->ga_user) && !empty($setting->ga_pass) && !empty($setting->ga_profil)) {

                    try {
                        $this->load->library('admin/google_analytics', array(
                            'username' => $setting->ga_user,
                            'password' => $setting->ga_pass));

                        $this->google_analytics->setProfileById('ga:' . $setting->ga_profil);

                        $end_date = date('Y-m-d');
                        $start_date = date('Y-m-d', strtotime('-1 month'));

                        $this->google_analytics->setDateRange($start_date, $end_date);

                        $visits = $this->google_analytics->getVisitors();
                        $views = $this->google_analytics->getPageviews();

                        if (count($visits)) {
                            foreach ($visits as $date => $visit) {
                                $year = substr($date, 0, 4);
                                $month = substr($date, 4, 2);
                                $day = substr($date, 6, 2);

                                $utc = mktime(date('h') + 1, null, null, $month, $day, $year) * 1000;

                                $flot_datas_visits[] = '[' . $utc . ',' . $visit . ']';
                                $flot_datas_views[] = '[' . $utc . ',' . $views[$date] . ']';
                            }

                            $flot_data_visits = '[' . implode(',', $flot_datas_visits) . ']';
                            $flot_data_views = '[' . implode(',', $flot_datas_views) . ']';
                        }

                        $data['analytic_visits'] = $flot_data_visits;
                        $data['analytic_views'] = $flot_data_views;

                        $this->cache->write(array('analytic_visits' => $flot_data_visits, 'analytic_views' => $flot_data_views), 'google_analytics', 60 * 60 * 4);
                    } catch (Exception $e) {
                        
                    }
                }
            }


            $this->template_admin->load('admin/template', 'admin/dashboard/index', array('data' => $data));
        }
    }

}

