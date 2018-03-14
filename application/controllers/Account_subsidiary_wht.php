<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Account_subsidiary_wht extends CORE_Controller 
	{
		function __construct()
		{
			parent::__construct('');
			$this->validate_session();
			$this->load->model(
				array
				(
					'Journal_account_model',
					'Journal_info_model',
					'Customers_model',
					'Suppliers_model',
					'Account_title_model',
					'Account_class_model',
					'Account_type_model',
					'Users_model',
					'Commercial_invoice_model',
					'Company_model'
				)
			);
			        $this->load->library('excel');	
		}

		public function index() {
			$this->Users_model->validate();
	        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
	        $data['title'] = 'Per Account Subsidiary';
	        $data['account_titles'] = $this->Account_title_model->get_list('account_titles.is_deleted=FALSE AND account_titles.is_active=TRUE AND account_titles.account_id > 87 AND account_titles.account_id < 98',null,null,'account_id ASC');
        (in_array('9-8',$this->session->user_rights)? 
        $this->load->view('account_subsidiary_wht_view',$data)
        :redirect(base_url('dashboard')));
		}

		function transaction($txn=null){
			switch($txn){
				case 'get-account-subsidiary':

					$account_Id=$this->input->get('accountId',TRUE);
					$start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
					$end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));
                    $includeChild=$this->input->get('includeChild',TRUE);

					$m_journal_info=$this->Journal_info_model;

					$response['data']=$m_journal_info->get_account_subsidiary($account_Id,$start_Date,$end_Date,$includeChild);
					echo json_encode($response);

				break;

				case 'get-account-subsidiary-wht':

					$account_Id=$this->input->get('accountId',TRUE);
					$start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
					$end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));
                    $includeChild=$this->input->get('includeChild',TRUE);

					$journals= $this->Account_title_model->get_journal_id_with_account_no($account_Id,$includeChild);

					if((count($journals)==0) ){
					$response['data']='';
					}else{
					$loop_filter = array();
					foreach ($journals as $key) { $loop_filter[] = $key->journal_id; }
					$id_filter = implode(',',$loop_filter);
					$response['data'] = $this->Account_title_model->get_account_subsidiary_wht($id_filter,$account_Id,$start_Date,$end_Date,$includeChild);
					}

					

					echo json_encode($response);


				break;

            case 'export-account-subsidiary':
	                $excel=$this->excel;
	                $type=$this->input->get('type',TRUE);
	                $account_Id=$this->input->get('accountId',TRUE);
	                $start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
	                $end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));
                    $includeChild=$this->input->get('includeChild',TRUE);


	                $m_journal_info=$this->Journal_info_model;
	                $m_company_info=$this->Company_model;

	                $company_info=$m_company_info->get_list();

	                $data['company_info']=$company_info[0];
					$journals= $this->Account_title_model->get_journal_id_with_account_no($account_Id,$includeChild);

					if((count($journals)==0) ){
					$response['data']='';
					}else{
					$loop_filter = array();
					foreach ($journals as $key) { $loop_filter[] = $key->journal_id; }
					$id_filter = implode(',',$loop_filter);
					$subsidiary = $this->Account_title_model->get_account_subsidiary_wht($id_filter,$account_Id,$start_Date,$end_Date,$includeChild);
					}

	                $excel->setActiveSheetIndex(0);

	                $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
	                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('50');
	                //name the worksheet
	                $excel->getActiveSheet()->setTitle("ACCOUNT SUBSIDIARY REPORT");
	                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->mergeCells('A2:C2');
	                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
	                                        ->setCellValue('A2',$company_info[0]->company_address)
	                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
	                                        ->setCellValue('A4',$company_info[0]->email_address);

	                $excel->getActiveSheet()->setCellValue('A6','PERIOD: '.$start_Date.' to '.$end_Date)
	                                        ->getStyle('A6')->getFont()->setBold(TRUE);

	                $excel->getActiveSheet()->setCellValue('A8','ACCOUNT SUBSIDIARY REPORT')
	                                        ->getStyle('A8')->getFont()->setBold(TRUE);

	                $excel->getActiveSheet()->setCellValue('A10','ACCOUNT: ');

	                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('I')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('J')->setWidth('20');
	                $excel->getActiveSheet()->getColumnDimension('K')->setWidth('20');
	                $excel->getActiveSheet()
	                        ->getStyle('F')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	                $excel->getActiveSheet()
	                        ->getStyle('G')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                $excel->getActiveSheet()
	                        ->getStyle('H')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                $excel->getActiveSheet()
	                        ->getStyle('I')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	                $excel->getActiveSheet()
	                        ->getStyle('J')
	                        ->getAlignment()
	                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	                $excel->getActiveSheet()->setCellValue('A12','Date')
	                                        ->getStyle('A12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('B12','Supplier')
	                                        ->getStyle('B12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('C12','Address')
	                                        ->getStyle('C12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('D12','Transaction')
	                                        ->getStyle('D12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('E12','Reference #')
	                                        ->getStyle('E12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('F12','Gross')
	                                        ->getStyle('F12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('G12','Non Vatable')
	                                        ->getStyle('G12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('H12','Vatable')
	                                        ->getStyle('H12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('I12','VAT Input')
	                                        ->getStyle('I12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('J12','Net of Vat')
	                                        ->getStyle('J12')->getFont()->setBold(TRUE);
	                $excel->getActiveSheet()->setCellValue('K12','Tin No')
	                                        ->getStyle('K12')->getFont()->setBold(TRUE);	
	                $i=13;


	                foreach ($subsidiary as $sub) {
	                	$excel->getActiveSheet()->setCellValue('A'.$i,$sub->date_txn);
	                	$excel->getActiveSheet()->setCellValue('B'.$i,$sub->supplier_name);
	                	$excel->getActiveSheet()->setCellValue('C'.$i,$sub->address);
	                	$excel->getActiveSheet()->setCellValue('D'.$i,$sub->txn_no);
	                	$excel->getActiveSheet()->setCellValue('E'.$i,$sub->cv_no);
	                	$excel->getActiveSheet()->setCellValue('F'.$i,number_format($sub->gross,2));
	                	$excel->getActiveSheet()->setCellValue('G'.$i,number_format($sub->gross,2));
	                	$excel->getActiveSheet()->setCellValue('H'.$i,number_format(0,2));
	                	$excel->getActiveSheet()->setCellValue('I'.$i,number_format(0,2));
	                	$excel->getActiveSheet()->setCellValue('J'.$i,number_format($sub->gross,2));
	                	$excel->getActiveSheet()->setCellValue('K'.$i,$sub->tin_no);





	                $i++;
	                }


	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	                header('Content-Disposition: attachment;filename='."ACCOUNT SUBSIDIARY REPORT.xlsx".'');
	                header('Cache-Control: max-age=0');
	                // If you're serving to IE 9, then the following may be needed
	                header('Cache-Control: max-age=1');

	                // If you're serving to IE over SSL, then the following may be needed
	                header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	                header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	                header ('Pragma: public'); // HTTP/1.0

	                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
	                $objWriter->save('php://output');   
	            break;

			}
		}
	}
?>
