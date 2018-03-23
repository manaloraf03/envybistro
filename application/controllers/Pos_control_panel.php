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
					'Departments_model',
					'Accounting_period_model',
					'Account_title_model'
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
	        $data['accounts']=$this->Account_title_model->get_list('is_active=TRUE AND is_deleted=FALSE');
	        $data['title'] = 'POS Integration Control Panel';
        (in_array('16-2',$this->session->user_rights)? 
        $this->load->view('pos_control_panel_view',$data)
        :redirect(base_url('dashboard')));
	        
		}

		function transaction($txn=null,$filter_value=null){
			switch ($txn) {
            case 'pos_control':
                $item_id=$filter_value;
                $m_pos = $this->Pos_integration_items_model;
                $m_customers = $this->Customers_model;
                $data['departments']=$this->Departments_model->get_list(array('is_active'=>TRUE,'is_deleted'=>FALSE));
                $m_pos_int = $this->Pos_integration_model;
                $int_data = $m_pos_int->get_list(null,
                    'pos_integration.*,
                    c.customer_name,
                    d.department_name',
                    array(
                        array('customers c','c.customer_id = pos_integration.customer_id', 'left'),
                        array('departments d','d.department_id = pos_integration.department_id','left'))
                    );
                // IF TRANSACTION IS CS -- CUSTOMER WILL BE VARIOUS 
               // IF AR -- Check if Customer Exists in DB - IF NOT - ADD NEW
                $pos_data = $m_pos->get_list($item_id);
                $transaction_type = $pos_data[0]->item_type;
                // if transaction type is Closing Shift -- use POS Integration Various Customers ID from POS Integration Settings
                // if 
                if($transaction_type == 'CS'){ 
                	$customer_id = $int_data;
                }else if ($transaction_type == 'AR'){
                	$temp_customer_id = $pos_data[0]->customer_id;
                	$verify = $m_customers->get_list('pos_customer_id='.$temp_customer_id); // verify if there is already a record with pos id 

                	if(count($verify) > 0){ 
                		//set customer id from existing customer and update the name
                		$customer_id = $verify[0]->customer_id;
                		$m_customers->customer_name = $pos_data[0]->customer_name;
                		$m_customers->modify($customer_id);

                	}else{
                		// create a new customer and set id
                		$m_customers->pos_customer_id = $pos_data[0]->customer_id;
                		$m_customers->customer_name = $pos_data[0]->customer_name;
                		$m_customers->save();
                		$customer_id = $m_customers->last_insert_id();
                	}
                }
                $data['int'] = $int_data[0]; // integration details
                $data['item'] = $pos_data[0]; // pos items 
                $data['item_id'] =$item_id; // id of pos item
                $data['customer_id'] = $customer_id; // customer id 
                $data['customers']=$this->Customers_model->get_list(array('is_active'=>TRUE, 'is_deleted'=>FALSE));
                $data['entries'] = $m_pos->get_pos_entries_journal($item_id);
                $m_accounts=$this->Account_title_model;
                $data['accounts']=$m_accounts->get_list(
                    array(
                        'account_titles.is_active'=>TRUE,
                        'account_titles.is_deleted'=>FALSE
                    )
                );
                $content=$this->load->view('template/pos_control_content',$data,TRUE);

                echo $content;
                break;


				case 'list':
					$m_items = $this->Pos_integration_items_model;

					$aod=date('Y-m-d',strtotime($this->input->get('aod',TRUE)));
					$items=$m_items->get_pos_list_front_end($aod);
					$response['data']=$items;
					echo json_encode($response);
				break;

				case 'create-pos':
				$m_items=$this->Pos_integration_items_model;
				$m_pos=$this->Pos_integration_model;
				$m_journal=$this->Journal_info_model;
                $m_journal_accounts=$this->Journal_account_model;
                $valid_range=$this->Accounting_period_model->get_list("'".date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)))."'<=period_end");
                if(count($valid_range)>0){
                    $response['stat']='error';
                    $response['title']='<b>Accounting Period is Closed!</b>';
                    $response['msg']='Please make sure transaction date is valid!<br /> ';
                    die(json_encode($response));
                }
               $pos_validation_id=$this->input->post('pos_integration_items_id',TRUE);
               $validate=$m_items->get_list(array('is_posted'=>TRUE, 'pos_integration_items_id'=>$pos_validation_id));
               if(count($validate)>0){
               	    $journal_info = $m_journal->get_list($validate[0]->journal_id,'txn_no');
               	    $response['stat']='error';
                    $response['title']='<b>Already Posted to Accounting!</b>';
                    $response['msg']='Please Check Sales Journal Transaction '.$journal_info[0]->txn_no;
                    $response['aa']= json_encode($validate);
                    die(json_encode($response));
               }
                $m_journal->customer_id=$this->input->post('customer_id',TRUE);
                $m_journal->department_id=$this->input->post('department_id',TRUE);
                $m_journal->remarks=$this->input->post('remarks',TRUE);
                $m_journal->date_txn=date('Y-m-d',strtotime($this->input->post('date_txn',TRUE)));
                $m_journal->book_type='SJE';
                $m_journal->ref_no=$this->input->post('ref_no',TRUE);
                $m_journal->is_sales=1;
                $m_journal->pos_integration_id=$this->input->post('pos_integration_items_id',TRUE);
				$m_journal->set('date_created','NOW()');
				$m_journal->date_txn=date('Y-m-d',now());
				$m_journal->created_by_user=$this->session->user_id;
				$m_journal->save();
				$journal_id=$m_journal->last_insert_id();
				$accounts=$this->input->post('accounts',TRUE);
				$memo=$this->input->post('memo',TRUE);
				$dr_amount=$this->input->post('dr_amount',TRUE);
				$cr_amount=$this->input->post('cr_amount',TRUE);
				$department_id_line=$this->input->post('department_id_line',TRUE);

				for($i=0;$i<=count($accounts)-1;$i++){
					$m_journal_accounts->journal_id=$journal_id;
					$m_journal_accounts->account_id=$accounts[$i];
					$m_journal_accounts->dr_amount=$this->get_numeric_value($dr_amount[$i]);
					$m_journal_accounts->cr_amount=$this->get_numeric_value($cr_amount[$i]);
					$m_journal_accounts->department_id=$this->get_numeric_value($department_id_line[$i]);
					$m_journal_accounts->save();
				}
                $m_journal->txn_no='TXN-'.date('Ymd').'-'.$journal_id;
                $m_journal->modify($journal_id);
                //mark pos integration item as posted
                $pos_integration_items_id =$this->input->post('pos_integration_items_id',TRUE);	
				$m_items->is_posted = 1;
				$m_items->journal_id = $journal_id;
				$m_items->posted_by=$this->session->user_id;
				$m_items->set('posted_date','NOW()');
				$m_items->modify($pos_integration_items_id);
				$response['stat']='success';
                $response['title']='Success!';
                $response['msg']='Journal successfully posted';
                echo json_encode($response);
				break;

				case 'finalize':  //  NOT IN USE
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
					$item_count = 0;
					foreach ($items_finalize as $item) {
						if($item->is_equal == '0'){
							$is_not_equal++;
						}else{

								$item_count++;
								$m_journal->book_type = 'SJE';
								$m_journal->is_sales = 1;
								$m_journal->department_id = $department_id;
								$m_journal->customer_id = $customer_id;
								// $m_journal->ref_no=$item->ref_no; // in sales journal will return as a receivable collection in the collection entry
								$m_journal->remarks ='X Reading Identifier: '.$item->ref_no.', Sales Date: '.$item->sales_date.', Cashier: '.$item->cashier;
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

						}
						
						if($item_count > 0 && $is_not_equal > 0){
			                $response['stat']="info";
			                $response['title']=$item_count." Record(s) Successfully saved!";
			                $response['msg']="Other ".$is_not_equal." Transactions were not posted due to imbalanced debit and credit amounts";
						}
						else if($item_count == 0 && $is_not_equal > 0){
			                $response['stat']="error";
			                $response['title']="No Record(s) saved!";
			                $response['msg']=$is_not_equal." Transaction(s) not posted due to imbalanced debit and credit amounts";
						}
						else if($item_count > 0 && $is_not_equal == 0){
			                $response['stat']="success";
			                $response['title']=$item_count." Record(s) Successfully saved!";
			                $response['msg']="Transactions were posted to Accounting";
						}else{
		                $response['stat']="error";
		                $response['title']="No Transaction Saved !";
		                $response['msg']="No POS transaction record was found .";	
						}


					echo json_encode($response);
				break;



			}
		}
	}
?>