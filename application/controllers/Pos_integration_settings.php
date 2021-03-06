<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pos_integration_settings extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(array(
                'Account_title_model',
                'Account_integration_model',
                'Pos_integration_model',
                'Users_model',
                'Sched_expense_integration',
                'Departments_model',
                'Customers_model'
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
        $data['title'] = 'POS Integration';

        $data['accounts'] = $this->Account_title_model->get_list(array('is_deleted'=>FALSE));
        $current_accounts= $this->Pos_integration_model->get_list();
        $data['current_accounts'] =$current_accounts[0];
        $data['departments'] = $this->Departments_model->get_list(array('is_active'=>TRUE, 'is_deleted'=>FALSE));
        $data['customers']=$this->Customers_model->get_list('is_active=TRUE AND is_deleted=FALSE');
        (in_array('15-2',$this->session->user_rights)? 
        $this->load->view('pos_integration_settings_view', $data)
        :redirect(base_url('dashboard')));
        

    }


    public function transaction($txn=null){
        switch($txn){


            case 'save':
                $m_integration=$this->Pos_integration_model;

                $m_integration->delete(1); //delete it first

                $m_integration->pos_integration_id=1;
                $m_integration->department_id =$this->input->post('department_id',TRUE);
                $m_integration->customer_id =$this->input->post('customer_id',TRUE);
                $m_integration->cash_id =$this->input->post('cash_id',TRUE);
                $m_integration->check_id =$this->input->post('check_id',TRUE);
                $m_integration->card_id =$this->input->post('card_id',TRUE);
                $m_integration->gc_id =$this->input->post('gc_id',TRUE);
                $m_integration->ar_id =$this->input->post('ar_id',TRUE);
                $m_integration->regular_discount_id =$this->input->post('regular_discount_id',TRUE);
                $m_integration->sc_discount_id =$this->input->post('sc_discount_id',TRUE);
                $m_integration->oth_discount_id =$this->input->post('oth_discount_id',TRUE);
                $m_integration->kitchen_id =$this->input->post('kitchen_id',TRUE);
                $m_integration->bar_id =$this->input->post('bar_id',TRUE);
                $m_integration->recreational_id =$this->input->post('recreational_id',TRUE);
                $m_integration->merchandise_id =$this->input->post('merchandise_id',TRUE);
                $m_integration->tax_id =$this->input->post('tax_id',TRUE);
                $m_integration->save();

                $response['stat']="success";
                $response['title']="Success!";
                $response['msg']="Pos Accounts successfully integrated.";

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
