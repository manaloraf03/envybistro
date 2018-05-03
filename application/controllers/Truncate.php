<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Truncate extends CORE_Controller {

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Suppliers_model');
        $this->load->model('Supplier_photos_model');
        $this->load->model('Tax_types_model');
        $this->load->model('Users_model');
        $this->load->model('Truncate_model');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files']=$this->load->view('template/assets/css_files','',TRUE);
        $data['_def_js_files']=$this->load->view('template/assets/js_files','',TRUE);
        $data['_switcher_settings']=$this->load->view('template/elements/switcher','',TRUE);
        $data['_side_bar_navigation']=$this->load->view('template/elements/side_bar_navigation','',TRUE);
        $data['_top_navigation']=$this->load->view('template/elements/top_navigation','',TRUE);
        $data['title']='Truncate Tables';
        $data['tax_type']=$this->Tax_types_model->get_list();
        $truncate = $this->Truncate_model->get_current_counts();
        $data['current_count'] = $truncate[0];       
        (in_array('6-1',$this->session->user_rights)? 
        $this->load->view('truncate_view',$data)
        :redirect(base_url('dashboard')));
        
    }

    function validate_truncation(){
        $login =$this->input->post('username');
        $password =$this->input->post('password');
        if(sha1($login) == '70b210b445dd7efa2a9a751f6fc56a84ca5535e9' && $password == '2018'){
            $response['title']='Success!';
            $response['stat']='success';                
            $response['msg']='Authorization Success.'; 
        }else{                
            $response['title']='Success!';
            $response['stat'] = 'error';               
            $response['msg']='Invalid Details.'; 

        }
            echo json_encode($response);
    }

    function transaction($txn=null) {
        switch($txn) {

            case 'truncate-journal':
                $journal=$this->input->post('journal',TRUE);
                for($i=0;$i<count($journal);$i++) { $this->db->truncate($journal[$i]); }    

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Journal Tables Successfully Truncated.'; 
                echo json_encode($response);
            break;

            case 'truncate-invoices':
                $invoice=$this->input->post('invoice',TRUE);
                for($i=0;$i<count($invoice);$i++) { $this->db->truncate($invoice[$i]); }    

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Invoice Tables Successfully Truncated.'; 
                echo json_encode($response);
            break;

            case 'truncate-payments':
                $payment=$this->input->post('payment',TRUE);
                for($i=0;$i<count($payment);$i++) { $this->db->truncate($payment[$i]); }    

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Payment Tables Successfully Truncated.'; 
                echo json_encode($response);
            break;

            case 'truncate-masterfiles':
                $masterfiles=$this->input->post('masterfiles',TRUE);
                for($i=0;$i<count($masterfiles);$i++) { $this->db->truncate($masterfiles[$i]); }    

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Masterfiles Tables Successfully Truncated.'; 
                echo json_encode($response);
            break;

            case 'truncate-references':
                $references=$this->input->post('references',TRUE);
                for($i=0;$i<count($references);$i++) { $this->db->truncate($references[$i]); }    

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='References Tables Successfully Truncated.'; 
                echo json_encode($response);
            break;

            case 'truncate-accounting':
                $accounting=$this->input->post('accounting',TRUE);
                for($i=0;$i<count($accounting);$i++) { $this->db->truncate($accounting[$i]); }    

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Accounting Tables Successfully Truncated.'; 
                echo json_encode($response);
            break;

            case 'truncate-users':
                $users=$this->input->post('users',TRUE);
                for($i=0;$i<count($users);$i++) { $this->db->truncate($users[$i]); }    

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Users Tables Successfully Truncated.'; 
                echo json_encode($response);
            break;

        }
    }
}
