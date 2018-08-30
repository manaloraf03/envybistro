<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doc_types extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Doc_types_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Document Type Management';
        (in_array('4-8',$this->session->user_rights)? 
        $this->load->view('doc_types_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $response['data'] = $this->Doc_types_model->get_list('is_active = 1 AND is_deleted = 0');
                echo json_encode($response);
                break;

            case 'create':
                $m_docs = $this->Doc_types_model;

                $m_docs->doc_type_name = $this->input->post('doc_type_name', TRUE);
                $m_docs->doc_type_description = $this->input->post('doc_type_description', TRUE);
                $m_docs->save();

                $doc_type_id = $m_docs->last_insert_id();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Document Type Information Successfully Created.';
                $response['row_added'] = $m_docs->get_list($doc_type_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=100; // TRANS TYPE
                $m_trans->trans_log='Created  Document Type: '.$this->input->post('doc_type_name', TRUE);
                $m_trans->save();
                echo json_encode($response);

                break;

            case 'delete':
                $m_docs=$this->Doc_types_model;

                $doc_type_id=$this->input->post('doc_type_id',TRUE);

                $m_docs->is_deleted=1;
                if($m_docs->modify($doc_type_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Document Type Information Successfully  deleted.';

                    $doc_type_name = $m_docs->get_list($doc_type_id,'doc_type_name');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=100; // TRANS TYPE
                    $m_trans->trans_log='Deleted Document Type: '.$doc_type_name[0]->doc_type_name;
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_docs=$this->Doc_types_model;

                $doc_type_id=$this->input->post('doc_type_id',TRUE);
                $m_docs->doc_type_name=$this->input->post('doc_type_name',TRUE);
                $m_docs->doc_type_description=$this->input->post('doc_type_description',TRUE);

                $m_docs->modify($doc_type_id);

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Document Type information successfully updated.';
                $response['row_updated']=$m_docs->get_list($doc_type_id);


                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=100; // TRANS TYPE
                $m_trans->trans_log='Updated Document Type: '.$this->input->post('doc_type_name',TRUE).' ID('.$doc_type_id.')';
                $m_trans->save();
                
                echo json_encode($response);

                break;
        }
    }
}
