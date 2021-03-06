<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hotel_integration extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(array(
                'Account_title_model',
                'Account_integration_model',
                'Hotel_integration_model',
                'Users_model',
                'Sched_expense_integration',
                'Departments_model'

            )

        );
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Hotel Integration';

        $data['accounts'] = $this->Account_title_model->get_list(array('is_deleted'=>FALSE));
        $current_accounts= $this->Hotel_integration_model->get_list();
        $data['current_accounts'] =$current_accounts[0];
        $data['departments'] = $this->Departments_model->get_list(array('is_active'=>TRUE, 'is_deleted'=>FALSE));


        (in_array('15-2',$this->session->user_rights)? 
        $this->load->view('hotel_integration_view', $data)
        :redirect(base_url('dashboard')));
        

    }


    public function transaction($txn=null){
        switch($txn){


            case 'save':
                $m_integration=$this->Hotel_integration_model;

                $m_integration->delete(1); //delete it first

                $m_integration->hotel_integration_id=1;

                //suppliers
                $m_integration->income_rs=$this->input->post('income_rs',TRUE);
                $m_integration->income_bs=$this->input->post('income_bs',TRUE);
                $m_integration->income_os=$this->input->post('income_os',TRUE);
                $m_integration->liability_apd=$this->input->post('liability_apd',TRUE);
                $m_integration->liability_sd=$this->input->post('liability_sd',TRUE);
                $m_integration->liability_ud=$this->input->post('liability_ud',TRUE);
                $m_integration->asset_cash=$this->input->post('asset_cash',TRUE);
                $m_integration->asset_check=$this->input->post('asset_check',TRUE);
                $m_integration->asset_card=$this->input->post('asset_card',TRUE);
                $m_integration->asset_charge=$this->input->post('asset_charge',TRUE);
                $m_integration->withhold_tax=$this->input->post('withhold_tax',TRUE);
                $m_integration->department_id=$this->input->post('department_id',TRUE);
                $m_integration->save();

                $response['stat']="success";
                $response['title']="Success!";
                $response['msg']="Hotel Accounts successfully integrated.";

                echo json_encode($response);

                break;


         
        }





    }


    function get_response_rows($filter){
        $m_acc_period=$this->Accounting_period_model;

        return $m_acc_period->get_list(
            $filter,
            array(
                'CONCAT(DATE_FORMAT(period_start,"%M %d, %Y")," to ",DATE_FORMAT(period_end,"%M %d, %Y")) as date_covered',
                'accounting_period.*',
                'CONCAT_WS(" ",ua.user_fname,ua.user_lname) as user'

            ),
            array(
                array('user_accounts as ua','ua.user_id=accounting_period.closed_by_user','left')
            ),

            'accounting_period.accounting_period_id DESC'
        );
    }




}
