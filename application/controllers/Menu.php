<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Refmenu_model');
        $this->load->model('Users_model');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Menu Management';
        (in_array('4-6',$this->session->user_rights)? 
        $this->load->view('menu_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_menu = $this->Refmenu_model;
                $response['data'] = $m_menu->get_list(array('refmenu.is_deleted'=>0));
                echo json_encode($response);
                break;

            case 'create':
                $m_menu = $this->Refmenu_model;

                $m_menu->menu_code = $this->input->post('menu_code', TRUE);
                $m_menu->menu_name = $this->input->post('menu_name', TRUE);
                $m_menu->menu_desc = $this->input->post('menu_desc', TRUE);
                $m_menu->sort_key = $this->input->post('sort_key', TRUE);
                $m_menu->save();

                $menu_id = $m_menu->last_insert_id();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Menu information successfully created.';
                $response['row_added'] = $m_menu->get_list($menu_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_menu=$this->Refmenu_model;

                $menu_id=$this->input->post('menu_id',TRUE);

                $m_menu->is_deleted=1;
                if($m_menu->modify($menu_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Menu information successfully deleted.';

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_menu=$this->Refmenu_model;

                $menu_id=$this->input->post('menu_id',TRUE);
                $m_menu->menu_code = $this->input->post('menu_code', TRUE);
                $m_menu->menu_name = $this->input->post('menu_name', TRUE);
                $m_menu->menu_desc = $this->input->post('menu_desc', TRUE);
                $m_menu->sort_key = $this->input->post('sort_key', TRUE);
                $m_menu->modify($menu_id);

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Menu information successfully updated.';
                $response['row_updated']=$m_menu->get_list($menu_id);
                echo json_encode($response);

                break;
        }
    }
}
