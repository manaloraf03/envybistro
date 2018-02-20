<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_history extends CORE_Controller {
    public $token_id;
    function __construct()
    {
        parent::__construct('');

        $this->load->model('Users_model');
        $this->load->model('User_groups_model');
        $this->load->model('Tax_types_model');
        $this->load->model('Approval_status_model');
        $this->load->model('Order_status_model');
        $this->load->model('Account_type_model');
        $this->load->model('Departments_model');
        $this->load->model('Item_type_model');
        $this->load->model('Payment_method_model');
        $this->load->model('Account_class_model');
        $this->load->model('Account_title_model');
        $this->load->model('Rights_link_model');
        $this->load->model('User_group_right_model');
        $this->load->model('Refproduct_model');
        $this->load->model('Journal_account_model');
        $this->load->model('Journal_info_model');
        $this->load->model('Asset_property_status_model');
        $this->load->model('Company_model');
        $this->load->model('Suppliers_model');
        $this->load->model('Email_settings_model');
        $this->load->model('Trans_model');

    }


    public function index()
    {
        $data['company_info']=$this->Company_model->get_list(array('company_info'));


        $data['_def_css_files']=$this->load->view('template/assets/css_files','',TRUE);
        $data['_def_js_files']=$this->load->view('template/assets/js_files','',TRUE);


            $this->load->view('update_history_view',$data); 
        }

    function transaction($txn=null){

        switch($txn){

               


        }




    }

}
