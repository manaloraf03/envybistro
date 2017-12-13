<?php
	defined('BASEPATH') OR die('direct script access is not allowed');

	class Pos_control_panel extends CORE_Controller
	{
		
		function __construct()
		{
			parent::__construct();
			$this->validate_session();
			$this->load->model(
				array(
					'Journal_info_model',
					'Users_model',
					'Pos_integration_items_model',
					'Pos_integration_model',
					'Company_model',
					'Journal_account_model',
					'Customers_model',
					'Departments_model'


				)
			);
	        $this->load->library('excel');
	        $this->load->model('Email_settings_model');
		}

		public function index() {
			$this->Users_model->validate();
			$data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
	        $data['title'] = 'POS Integration Control Panel';
        (in_array('16-2',$this->session->user_rights)? 
        $this->load->view('pos_control_panel_view',$data)
        :redirect(base_url('dashboard')));
	        
		}

		function transaction($txn=null){
			switch ($txn) {
				case 'list':
					$m_items = $this->Pos_integration_items_model;

					$aod=date('Y-m-d',strtotime($this->input->get('aod',TRUE)));
					$items=$m_items->get_pos_list_front_end($aod);
					$response['data']=$items;

					$i = 0;
					foreach ($items as $item) {
						if($item->is_equal == 0){
							$i++;
						}

					}
					if($i > 0){

                $response['stat']="error";
                $response['title']="Unequal Transaction Detected!";
                $response['msg']="There is an unequal distribution of amount.";
					}


					echo json_encode($response);
				break;

				case 'finalize':
					$m_items = $this->Pos_integration_items_model;
					$m_pos = $this->Pos_integration_model;
					$pos_accounts = $m_pos->get_list();
					$department_id = $pos_accounts[0]->department_id;
					$customer_id = $pos_accounts[0]->customer_id;

					$aod=date('Y-m-d',strtotime($this->input->post('txt_date',TRUE)));
					$items_finalize=$m_items->get_pos_list_balanced($aod);

					$m_journal = $this->Journal_info_model;
					$m_journal_accounts=$this->Journal_account_model;

					$is_not_equal = 0;
					foreach ($items_finalize as $item) {

						$m_journal->book_type = 'SJE';
						$m_journal->is_sales = 1;
						$m_journal->department_id = $department_id;
						$m_journal->customer_id = $customer_id;
						$m_journal->ref_no=$item->ref_no;
						$m_journal->remarks = $item->ref_no;
						$m_journal->pos_integration_id=$item->pos_integration_items_id;


						$m_journal->set('date_created','NOW()');
						$m_journal->date_txn=date('Y-m-d',now());
						$m_journal->created_by_user=$this->session->user_id;
						$m_journal->save();
						$journal_id=$m_journal->last_insert_id();

			            $entries = $m_items->get_pos_entries_journal($item->pos_integration_items_id);

			                foreach ($entries as $entry) {
			                    $m_journal_accounts->journal_id=$journal_id;
			                    $m_journal_accounts->account_id=$entry->account_id;
			                    $m_journal_accounts->memo='';
			                    $m_journal_accounts->dr_amount=$this->get_numeric_value($entry->dr_amount);
			                    $m_journal_accounts->cr_amount=$this->get_numeric_value($entry->cr_amount);
			                    $m_journal_accounts->save();
			                }

		                $m_journal->txn_no='TXN-'.date('Ymd').'-'.$journal_id;
		                $m_journal->modify($journal_id);
		                $m_items->is_posted = 1;
		                $m_items->journal_id = $journal_id;
		                $m_items->posted_by=$this->session->user_id;
		                $m_items->set('posted_date','NOW()');
		                $m_items->modify($item->pos_integration_items_id);

					}


						

                $response['stat']="success";
                $response['title']="Success!";
                $response['msg']="Point of Sales System Successfully Integrated.";

					echo json_encode($response);
				break;



			}
		}
	}
?>