<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Purchase_Invoice_Report extends CORE_Controller
	{
		
		function __construct()
		{
			parent::__construct('');
			$this->validate_session();
			$this->load->model(
				array(
					'Delivery_invoice_model',
					'Suppliers_model',
					'Users_model',
					'Company_model'
				)
			);
            $this->load->library('excel');
            $this->load->model('Email_settings_model');
		}

		public function index()
		{	
			$this->Users_model->validate();
		 	$data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
	        $data['title'] = 'Purchase Invoice Report';
        (in_array('8-4',$this->session->user_rights)? 
        $this->load->view('purchase_invoice_report_view',$data)
        :redirect(base_url('dashboard')));
	        
		}

		function transaction($txn=null){
			switch($txn){
				case 'summary':

					$start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
					$end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));
					$m_delivery_invoice=$this->Delivery_invoice_model;

					$response['data']=$m_delivery_invoice->get_report_summary($start_Date,$end_Date);
					echo json_encode($response);

				break;

				case 'detailed':

					$start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
					$end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));
					$m_delivery_invoice=$this->Delivery_invoice_model;

					$response['data']=$m_delivery_invoice->get_report_detailed($start_Date,$end_Date);
					echo json_encode($response);

				break;

	            case 'purchase-invoice':
	                $m_company_info=$this->Company_model;

	                $company_info=$m_company_info->get_list();
	                $data['company_info']=$company_info[0];

	                $m_delivery_invoice=$this->Delivery_invoice_model;

	                $type=$this->input->get('type');
	                $startDate=date('Y-m-d',strtotime($this->input->get('startDate')));
	                $endDate=date('Y-m-d',strtotime($this->input->get('endDate')));


	                if ($type=='summary') {

                        $data['suppliers']=$m_delivery_invoice->get_list(
                            'date_delivered BETWEEN "'.$startDate.'" AND "'.$endDate.'" AND delivery_invoice.is_active=TRUE AND delivery_invoice.is_deleted=FALSE',
                            'DISTINCT(suppliers.supplier_name), delivery_invoice.supplier_id',
                            array(
                                array('suppliers','suppliers.supplier_id=delivery_invoice.supplier_id','left')
                            )
                        );

                        $data['purchase_invoice_summary']=$m_delivery_invoice->get_report_summary($startDate,$endDate);
	                	$this->load->view('template/purchase_invoice_summary',$data);
	                } 

	                if ($type=='detailed') {


                        $data['invoice_numbers']=$m_delivery_invoice->get_list(
                            'date_delivered BETWEEN "'.$startDate.'" AND "'.$endDate.'" AND  delivery_invoice.is_active=TRUE AND delivery_invoice.is_deleted=FALSE',
                            'DISTINCT(delivery_invoice.dr_invoice_no), delivery_invoice.supplier_id,delivery_invoice.dr_invoice_id,delivery_invoice.supplier_id,suppliers.supplier_name',
                            array(
                                array('suppliers','suppliers.supplier_id=delivery_invoice.supplier_id','left')
                            )
                        );



                        $data['purchase_invoice_detailed']=$m_delivery_invoice->get_report_detailed($startDate,$endDate);
	                	$this->load->view('template/purchase_invoice_detailed',$data);
	                }
	            break;

	            case 'purchase-invoice-export':
                    $excel=$this->excel;
	                $m_company_info=$this->Company_model;

	                $company_info=$m_company_info->get_list();
	                $data['company_info']=$company_info[0];

	                $m_delivery_invoice=$this->Delivery_invoice_model;

	                $type=$this->input->get('type');
	                $startDate=date('Y-m-d',strtotime($this->input->get('startDate')));
	                $endDate=date('Y-m-d',strtotime($this->input->get('endDate')));


	                if ($type=='summary') {

                        $suppliers=$m_delivery_invoice->get_list(
                            'date_delivered BETWEEN "'.$startDate.'" AND "'.$endDate.'" AND delivery_invoice.is_active=TRUE AND delivery_invoice.is_deleted=FALSE',
                            'DISTINCT(suppliers.supplier_name), delivery_invoice.supplier_id',
                            array(
                                array('suppliers','suppliers.supplier_id=delivery_invoice.supplier_id','left')
                            )
                        );

                        $purchase_invoice_summary=$m_delivery_invoice->get_report_summary($startDate,$endDate);


                    $excel->setActiveSheetIndex(0);

                    $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A3:B3')->setWidth('50');

                    //name the worksheet
                    $excel->getActiveSheet()->setTitle("Purchase Invoice (Summary)");

                    $excel->getActiveSheet()
                    	  ->getStyle('A1:I1')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel->getActiveSheet()
                    	  ->getStyle('A2:I2')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel->getActiveSheet()
                    	  ->getStyle('A3:I3')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        

                    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)
       										->setSize(16);
                    $excel->getActiveSheet()->mergeCells('A1:I1');
                    $excel->getActiveSheet()->mergeCells('A2:I2');
                    $excel->getActiveSheet()->mergeCells('A3:I3');
                    $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                            ->setCellValue('A2',$company_info[0]->company_address)
                                            ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no);  


                	$border = array(
					        'borders' => array(
					            'bottom' => array(
					                'style' => PHPExcel_Style_Border::BORDER_THICK,
					                'color' => array('rgb' => '92a8d1')
					            )
					        )
					    );
                    $excel->getActiveSheet()->setCellValue('A4')       
                    						->mergeCells('A4:I4');         	
                	$excel->getActiveSheet()->getStyle('A4:I4')->applyFromArray($border);

                    $excel->getActiveSheet()
                    	  ->getStyle('A5:I5')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  

                    $excel->getActiveSheet()
                    	  ->getStyle('A6:I6')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  

                    $excel->getActiveSheet()
                    	  ->getStyle('A7:I7')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  

                    $excel->getActiveSheet()->mergeCells('A5:I5');
                    $excel->getActiveSheet()->mergeCells('A6:I6');
                    $excel->getActiveSheet()->mergeCells('A7:I7');
                							
                    $excel->getActiveSheet()->setCellValue('A5',"PURCHASE INVOICE REPORT")
                    						->setCellValue('A6',"(SUMMARIZED)")
                    						->getStyle('A5:A6')->getFont()->setBold(TRUE)
                    						->setSize(18);

                    $excel->getActiveSheet()->setCellValue('A7','Period '.$startDate.' to '. $endDate);

                    $i = 9;

                    foreach($suppliers as $supplier){

	                	$border = array(
						        'borders' => array(
						            'bottom' => array(
						                'style' => PHPExcel_Style_Border::BORDER_THICK,
						                'color' => array('rgb' => '92a8d1')
						            )
						        )
						    );

               			$excel->getActiveSheet()->mergeCells('A'.$i.':I'.$i);

                    	$excel->getActiveSheet()->setCellValue('A'.$i,$supplier->supplier_name)
                    							->getStyle('A'.$i)->getFont()->setBold(TRUE)
                    							->setSize(14);
                		$excel->getActiveSheet()->getStyle('A'.$i.':I'.$i)->applyFromArray($border);


                    	$i++;

	                    $excel->getActiveSheet()
	                    	  ->getStyle('G'.$i)
	                    	  ->getAlignment()
	                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  


	                    $excel->getActiveSheet()->getColumnDimensionByColumn('A'.$i)->setWidth('50');
	                    $excel->getActiveSheet()->getColumnDimensionByColumn('D'.$i)->setWidth('50');
	                    $excel->getActiveSheet()->getColumnDimensionByColumn('G'.$i)->setWidth('50');

               			$excel->getActiveSheet()->mergeCells('A'.$i.':C'.$i);
               			$excel->getActiveSheet()->mergeCells('D'.$i.':F'.$i);
               			$excel->getActiveSheet()->mergeCells('G'.$i.':I'.$i);

                    	$excel->getActiveSheet()->setCellValue('A'.$i,"Ref #")
                    							->getStyle('A'.$i)->getFont()->setBold(TRUE);
                    	$excel->getActiveSheet()->setCellValue('D'.$i,"Date")
                    							->getStyle('D'.$i)->getFont()->setBold(TRUE);
                    	$excel->getActiveSheet()->setCellValue('G'.$i,"Invoice Amount")
                    							->getStyle('G'.$i)->getFont()->setBold(TRUE);     
                    	$i++;                                    	
                    	$sum = 0;      
                    	foreach($purchase_invoice_summary as $summary){

                    		if ($summary->supplier_id==$supplier->supplier_id) {

	                    $excel->getActiveSheet()
	                    	  ->getStyle('G'.$i)
	                    	  ->getAlignment()
	                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  

	                    $excel->getActiveSheet()->getColumnDimensionByColumn('A'.$i)->setWidth('50');
	                    $excel->getActiveSheet()->getColumnDimensionByColumn('D'.$i)->setWidth('50');
	                    $excel->getActiveSheet()->getColumnDimensionByColumn('G'.$i)->setWidth('50');

               			$excel->getActiveSheet()->mergeCells('A'.$i.':C'.$i);
               			$excel->getActiveSheet()->mergeCells('D'.$i.':F'.$i);
               			$excel->getActiveSheet()->mergeCells('G'.$i.':I'.$i);

                    	$excel->getActiveSheet()->setCellValue('A'.$i,$summary->dr_invoice_no);
                    	$excel->getActiveSheet()->setCellValue('D'.$i,$summary->date_delivered);
                        $excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.0000;(###,##0.0000)');
                    	$excel->getActiveSheet()->setCellValue('G'.$i,number_format($summary->total_after_discount,2))
                    							->getStyle('G'.$i)->getFont()->setBold(FALSE)
                    							->setSize(12);

                    	$i++;
       					$sum+=$summary->total_after_discount;

                    		}
                   	 	}

	                    $excel->getActiveSheet()
	                    	  ->getStyle('G'.$i)
	                    	  ->getAlignment()
	                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  

               			$excel->getActiveSheet()->mergeCells('G'.$i.':I'.$i);

                        $excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.0000;(###,##0.0000)');
                    	$excel->getActiveSheet()->setCellValue('G'.$i,number_format($sum,2))
                    							->getStyle('G'.$i)->getFont()->setBold(TRUE)
                    							->setSize(14);              
                   	 	$i++;
                    }
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename='."Purchase Invoice Report (Summary).xlsx".'');
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
	                
	                } 

	                if ($type=='detailed') {

                        $invoice_numbers=$m_delivery_invoice->get_list(
                            'date_delivered BETWEEN "'.$startDate.'" AND "'.$endDate.'" AND  delivery_invoice.is_active=TRUE AND delivery_invoice.is_deleted=FALSE',
                            'DISTINCT(delivery_invoice.dr_invoice_no), delivery_invoice.supplier_id,delivery_invoice.dr_invoice_id,delivery_invoice.supplier_id,suppliers.supplier_name',
                            array(
                                array('suppliers','suppliers.supplier_id=delivery_invoice.supplier_id','left')
                            )
                        );

                        $purchase_invoice_detailed=$m_delivery_invoice->get_report_detailed($startDate,$endDate);

                    $excel->setActiveSheetIndex(0);

                    $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A3:B3')->setWidth('50');

                    //name the worksheet
                    $excel->getActiveSheet()->setTitle("Purchase Invoice (Summary)");

                    $excel->getActiveSheet()
                    	  ->getStyle('A1:I1')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel->getActiveSheet()
                    	  ->getStyle('A2:I2')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel->getActiveSheet()
                    	  ->getStyle('A3:I3')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        

                    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)
       										->setSize(16);
                    $excel->getActiveSheet()->mergeCells('A1:I1');
                    $excel->getActiveSheet()->mergeCells('A2:I2');
                    $excel->getActiveSheet()->mergeCells('A3:I3');
                    $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                            ->setCellValue('A2',$company_info[0]->company_address)
                                            ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no);  


                	$border = array(
					        'borders' => array(
					            'bottom' => array(
					                'style' => PHPExcel_Style_Border::BORDER_THICK,
					                'color' => array('rgb' => '92a8d1')
					            )
					        )
					    );

                    $excel->getActiveSheet()->setCellValue('A4')       
                    						->mergeCells('A4:I4');         	
                	$excel->getActiveSheet()->getStyle('A4:I4')->applyFromArray($border);

                    $excel->getActiveSheet()
                    	  ->getStyle('A5:I5')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  

                    $excel->getActiveSheet()
                    	  ->getStyle('A6:I6')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  

                    $excel->getActiveSheet()
                    	  ->getStyle('A7:I7')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  

                    $excel->getActiveSheet()->mergeCells('A5:I5');
                    $excel->getActiveSheet()->mergeCells('A6:I6');
                    $excel->getActiveSheet()->mergeCells('A7:I7');
                							
                    $excel->getActiveSheet()->setCellValue('A5',"PURCHASE INVOICE REPORT")
                    						->setCellValue('A6',"(DETAILED)")
                    						->getStyle('A5:A6')->getFont()->setBold(TRUE)
                    						->setSize(18);

                    $excel->getActiveSheet()->setCellValue('A7','Period '.$startDate.' to '. $endDate);

                    $i = 8;

                    foreach ($invoice_numbers as $invoice_number) {

	                	$border = array(
						        'borders' => array(
						            'bottom' => array(
						                'style' => PHPExcel_Style_Border::BORDER_THICK,
						                'color' => array('rgb' => '92a8d1')
						            )
						        )
						    );

               			$excel->getActiveSheet()->mergeCells('A'.$i.':I'.$i);
						$excel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setIndent(0);
                    	$excel->getActiveSheet()->setCellValue('A'.$i,$invoice_number->dr_invoice_no)
                    							->getStyle('A'.$i)->getFont()->setBold(TRUE)
                    							->setSize(12);
                		$excel->getActiveSheet()->getStyle('A'.$i.':I'.$i)->applyFromArray($border);
	                	$i++;

               			$excel->getActiveSheet()->mergeCells('A'.$i.':I'.$i);
						$excel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setIndent(4);
                    	$excel->getActiveSheet()->setCellValue('A'.$i,$invoice_number->supplier_name)
                    							->getStyle('A'.$i)->getFont()->setBold(TRUE)
                    							->setSize(12);   
                		$excel->getActiveSheet()->getStyle('A'.$i.':I'.$i)->applyFromArray($border);                    							
                		$i++;

               			$excel->getActiveSheet()->mergeCells('A'.$i.':I'.$i);                		
                    	$excel->getActiveSheet()->setCellValue('A'.$i);                		
                		$i++;

	                    $excel->getActiveSheet()->getColumnDimensionByColumn('D')->setWidth('50');
	                    $excel->getActiveSheet()->getColumnDimensionByColumn('F')->setWidth('50');
	                    $excel->getActiveSheet()->getColumnDimensionByColumn('H')->setWidth('50');      
	                              		
               			$excel->getActiveSheet()->mergeCells('A'.$i.':C'.$i);                		                		
                		$excel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setIndent(8);
                    	$excel->getActiveSheet()->setCellValue('A'.$i,'PRODUCT')
                    							->getStyle('A'.$i)->getFont()->setBold(TRUE);

	                    $excel->getActiveSheet()
	                    	  ->getStyle('D'.$i)
	                    	  ->getAlignment()
	                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  

	                    $excel->getActiveSheet()
	                    	  ->getStyle('F'.$i)
	                    	  ->getAlignment()
	                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  

	                    $excel->getActiveSheet()
	                    	  ->getStyle('H'.$i)
	                    	  ->getAlignment()
	                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  

               			$excel->getActiveSheet()->mergeCells('D'.$i.':E'.$i);                		                		
                    	$excel->getActiveSheet()->setCellValue('D'.$i,'UNIT COST')
                    							->getStyle('D'.$i)->getFont()->setBold(TRUE);        

               			$excel->getActiveSheet()->mergeCells('F'.$i.':G'.$i);                		                		
                    	$excel->getActiveSheet()->setCellValue('F'.$i,'QTY')
                    							->getStyle('F'.$i)->getFont()->setBold(TRUE);                    							

               			$excel->getActiveSheet()->mergeCells('H'.$i.':I'.$i);                		                		
                    	$excel->getActiveSheet()->setCellValue('H'.$i,'TOTAL NET')
                    							->getStyle('H'.$i)->getFont()->setBold(TRUE);                    							
						$inv_total = 0; 
                  		$i++;

 							foreach ($purchase_invoice_detailed as $detail) {
								if($detail->supplier_id==$invoice_number->supplier_id&&$detail->dr_invoice_id==$invoice_number->dr_invoice_id) {

				                	$border = array(
									        'borders' => array(
									            'bottom' => array(
									                'style' => PHPExcel_Style_Border::BORDER_THICK,
									                'color' => array('rgb' => '92a8d1')
									            )
									        )
									    );

				                    $excel->getActiveSheet()
				                    	  ->getStyle('D'.$i)
				                    	  ->getAlignment()
				                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  

				                    $excel->getActiveSheet()
				                    	  ->getStyle('F'.$i)
				                    	  ->getAlignment()
				                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  

				                    $excel->getActiveSheet()
				                    	  ->getStyle('H'.$i)
				                    	  ->getAlignment()
				                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  

			               			$excel->getActiveSheet()->mergeCells('A'.$i.':C'.$i);
			               			$excel->getActiveSheet()->mergeCells('D'.$i.':E'.$i);
			               			$excel->getActiveSheet()->mergeCells('F'.$i.':G'.$i);		
			               			$excel->getActiveSheet()->mergeCells('H'.$i.':I'.$i);		
			               										
			                    	$excel->getActiveSheet()->setCellValue('A'.$i,$detail->product_desc)
															->getStyle('A'.$i)->getAlignment()->setIndent(8);			                    	
                        			$excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.0000;(###,##0.0000)');			               			            		                		
			                    	$excel->getActiveSheet()->setCellValue('D'.$i,number_format($detail->dr_price,2));

			                    	$excel->getActiveSheet()->setCellValue('F'.$i,number_format($detail->dr_qty,2));

                        			$excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.0000;(###,##0.0000)');			               			   		                		
			                    	$excel->getActiveSheet()->setCellValue('H'.$i,number_format(($detail->dr_qty*$detail->dr_price),2));
                					$excel->getActiveSheet()->getStyle('A'.$i.':I'.$i)->applyFromArray($border);                    							

									$inv_total+= $detail->dr_qty*$detail->dr_price;	
			                    	$i++;

								}
 							}
				                    $excel->getActiveSheet()
				                    	  ->getStyle('A'.$i)
				                    	  ->getAlignment()
				                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 

			               			$excel->getActiveSheet()->mergeCells('A'.$i.':I'.$i);
                        			$excel->getActiveSheet()->getStyle('A'.$i)->getNumberFormat()->setFormatCode('###,##0.0000;(###,##0.0000)');			               			   		                					               			
			                    	$excel->getActiveSheet()->setCellValue('A'.$i,number_format($inv_total,2))
			                    							->getStyle('A'.$i)->getFont()->setBold(TRUE)
			                    							->setSize(14);
			                    	$i++;
                    }
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename='."Purchase Invoice Report (Detailed).xlsx".'');
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

	                }
	            break;

	            case 'purchase-invoice-email':
                    $excel=$this->excel;
	                $m_email=$this->Email_settings_model;
	                $email=$m_email->get_list(2);                          
	                $m_company_info=$this->Company_model;

	                $company_info=$m_company_info->get_list();
	                $data['company_info']=$company_info[0];

	                $m_delivery_invoice=$this->Delivery_invoice_model;

	                $type=$this->input->get('type');
	                $startDate=date('Y-m-d',strtotime($this->input->get('startDate')));
	                $endDate=date('Y-m-d',strtotime($this->input->get('endDate')));


	                if ($type=='summary') {

                        $suppliers=$m_delivery_invoice->get_list(
                            'date_delivered BETWEEN "'.$startDate.'" AND "'.$endDate.'" AND delivery_invoice.is_active=TRUE AND delivery_invoice.is_deleted=FALSE',
                            'DISTINCT(suppliers.supplier_name), delivery_invoice.supplier_id',
                            array(
                                array('suppliers','suppliers.supplier_id=delivery_invoice.supplier_id','left')
                            )
                        );

                        $purchase_invoice_summary=$m_delivery_invoice->get_report_summary($startDate,$endDate);

                    ob_start();
                    $excel->setActiveSheetIndex(0);

                    $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A3:B3')->setWidth('50');

                    //name the worksheet
                    $excel->getActiveSheet()->setTitle("Purchase Invoice (Summary)");

                    $excel->getActiveSheet()
                    	  ->getStyle('A1:I1')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel->getActiveSheet()
                    	  ->getStyle('A2:I2')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel->getActiveSheet()
                    	  ->getStyle('A3:I3')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        

                    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)
       										->setSize(16);
                    $excel->getActiveSheet()->mergeCells('A1:I1');
                    $excel->getActiveSheet()->mergeCells('A2:I2');
                    $excel->getActiveSheet()->mergeCells('A3:I3');
                    $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                            ->setCellValue('A2',$company_info[0]->company_address)
                                            ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no);  


                	$border = array(
					        'borders' => array(
					            'bottom' => array(
					                'style' => PHPExcel_Style_Border::BORDER_THICK,
					                'color' => array('rgb' => '92a8d1')
					            )
					        )
					    );
                    $excel->getActiveSheet()->setCellValue('A4')       
                    						->mergeCells('A4:I4');         	
                	$excel->getActiveSheet()->getStyle('A4:I4')->applyFromArray($border);

                    $excel->getActiveSheet()
                    	  ->getStyle('A5:I5')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  

                    $excel->getActiveSheet()
                    	  ->getStyle('A6:I6')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  

                    $excel->getActiveSheet()
                    	  ->getStyle('A7:I7')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  

                    $excel->getActiveSheet()->mergeCells('A5:I5');
                    $excel->getActiveSheet()->mergeCells('A6:I6');
                    $excel->getActiveSheet()->mergeCells('A7:I7');
                							
                    $excel->getActiveSheet()->setCellValue('A5',"PURCHASE INVOICE REPORT")
                    						->setCellValue('A6',"(SUMMARIZED)")
                    						->getStyle('A5:A6')->getFont()->setBold(TRUE)
                    						->setSize(18);

                    $excel->getActiveSheet()->setCellValue('A7','Period '.$startDate.' to '. $endDate);

                    $i = 9;

                    foreach($suppliers as $supplier){

	                	$border = array(
						        'borders' => array(
						            'bottom' => array(
						                'style' => PHPExcel_Style_Border::BORDER_THICK,
						                'color' => array('rgb' => '92a8d1')
						            )
						        )
						    );

               			$excel->getActiveSheet()->mergeCells('A'.$i.':I'.$i);

                    	$excel->getActiveSheet()->setCellValue('A'.$i,$supplier->supplier_name)
                    							->getStyle('A'.$i)->getFont()->setBold(TRUE)
                    							->setSize(14);
                		$excel->getActiveSheet()->getStyle('A'.$i.':I'.$i)->applyFromArray($border);


                    	$i++;

	                    $excel->getActiveSheet()
	                    	  ->getStyle('G'.$i)
	                    	  ->getAlignment()
	                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  


	                    $excel->getActiveSheet()->getColumnDimensionByColumn('A'.$i)->setWidth('50');
	                    $excel->getActiveSheet()->getColumnDimensionByColumn('D'.$i)->setWidth('50');
	                    $excel->getActiveSheet()->getColumnDimensionByColumn('G'.$i)->setWidth('50');

               			$excel->getActiveSheet()->mergeCells('A'.$i.':C'.$i);
               			$excel->getActiveSheet()->mergeCells('D'.$i.':F'.$i);
               			$excel->getActiveSheet()->mergeCells('G'.$i.':I'.$i);

                    	$excel->getActiveSheet()->setCellValue('A'.$i,"Ref #")
                    							->getStyle('A'.$i)->getFont()->setBold(TRUE);
                    	$excel->getActiveSheet()->setCellValue('D'.$i,"Date")
                    							->getStyle('D'.$i)->getFont()->setBold(TRUE);
                    	$excel->getActiveSheet()->setCellValue('G'.$i,"Invoice Amount")
                    							->getStyle('G'.$i)->getFont()->setBold(TRUE);     
                    	$i++;                                    	
                    	$sum = 0;      
                    	foreach($purchase_invoice_summary as $summary){

                    		if ($summary->supplier_id==$supplier->supplier_id) {

	                    $excel->getActiveSheet()
	                    	  ->getStyle('G'.$i)
	                    	  ->getAlignment()
	                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  

	                    $excel->getActiveSheet()->getColumnDimensionByColumn('A'.$i)->setWidth('50');
	                    $excel->getActiveSheet()->getColumnDimensionByColumn('D'.$i)->setWidth('50');
	                    $excel->getActiveSheet()->getColumnDimensionByColumn('G'.$i)->setWidth('50');

               			$excel->getActiveSheet()->mergeCells('A'.$i.':C'.$i);
               			$excel->getActiveSheet()->mergeCells('D'.$i.':F'.$i);
               			$excel->getActiveSheet()->mergeCells('G'.$i.':I'.$i);

                    	$excel->getActiveSheet()->setCellValue('A'.$i,$summary->dr_invoice_no);
                    	$excel->getActiveSheet()->setCellValue('D'.$i,$summary->date_delivered);
                        $excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.0000;(###,##0.0000)');
                    	$excel->getActiveSheet()->setCellValue('G'.$i,number_format($summary->total_after_discount,2))
                    							->getStyle('G'.$i)->getFont()->setBold(FALSE)
                    							->setSize(12);

                    	$i++;
       					$sum+=$summary->total_after_discount;

                    		}
                   	 	}

	                    $excel->getActiveSheet()
	                    	  ->getStyle('G'.$i)
	                    	  ->getAlignment()
	                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  

               			$excel->getActiveSheet()->mergeCells('G'.$i.':I'.$i);

                        $excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.0000;(###,##0.0000)');
                    	$excel->getActiveSheet()->setCellValue('G'.$i,number_format($sum,2))
                    							->getStyle('G'.$i)->getFont()->setBold(TRUE)
                    							->setSize(14);              
                   	 	$i++;
                    }
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename='."Purchase Invoice Report (Summary).xlsx".'');
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
                    $data = ob_get_clean();

                            $file_name='Purchase Invoice Report Summary '.date('Y-m-d h:i:A', now());
                            $excelFilePath = $file_name.".xlsx"; //generate filename base on id
                            //download it.
                            // Set SMTP Configuration
                            $emailConfig = array(
                                'protocol' => 'smtp', 
                                'smtp_host' => 'ssl://smtp.googlemail.com', 
                                'smtp_port' => 465, 
                                'smtp_user' => $email[0]->email_address, 
                                'smtp_pass' => $email[0]->password, 
                                'mailtype' => 'html', 
                                'charset' => 'iso-8859-1'
                            );

                            // Set your email information
                            
                            $from = array(
                                'email' => $email[0]->email_address,
                                'name' => $email[0]->name_from
                            );

                            $to = array($email[0]->email_to);
                            $subject = 'Purchase Invoice Report Summary';
                          //  $message = 'Type your gmail message here';
                            $message = '<p>To: ' .$email[0]->email_to. '</p></ br>' .$email[0]->default_message.'</ br><p>Sent By: '. '<b>'.$this->session->user_fullname.'</b>'. '</p></ br>' .date('Y-m-d h:i:A', now());

                            // Load CodeIgniter Email library
                            $this->load->library('email', $emailConfig);
                            // Sometimes you have to set the new line character for better result
                            $this->email->set_newline("\r\n");
                            // Set email preferences
                            $this->email->from($from['email'], $from['name']);
                            $this->email->to($to);
                            $this->email->subject($subject);
                            $this->email->message($message);
                            $this->email->attach($data, 'attachment', $excelFilePath , 'application/ms-excel');
                            $this->email->set_mailtype("html");
                            // Ready to send email and check whether the email was successfully sent
                            if (!$this->email->send()) {
                                // Raise error message
                            $response['title']='Try Again!';
                            $response['stat']='error';
                            $response['msg']='Please check the Email Address of your Supplier or your Internet Connection.';

                            echo json_encode($response);
                            } else {
                                // Show success notification or other things here
                            $response['title']='Success!';
                            $response['stat']='success';
                            $response['msg']='Email Sent successfully.';

                            echo json_encode($response);
                            }	                
	                } 

	                if ($type=='detailed') {

                        $invoice_numbers=$m_delivery_invoice->get_list(
                            'date_delivered BETWEEN "'.$startDate.'" AND "'.$endDate.'" AND  delivery_invoice.is_active=TRUE AND delivery_invoice.is_deleted=FALSE',
                            'DISTINCT(delivery_invoice.dr_invoice_no), delivery_invoice.supplier_id,delivery_invoice.dr_invoice_id,delivery_invoice.supplier_id,suppliers.supplier_name',
                            array(
                                array('suppliers','suppliers.supplier_id=delivery_invoice.supplier_id','left')
                            )
                        );

                        $purchase_invoice_detailed=$m_delivery_invoice->get_report_detailed($startDate,$endDate);

                    ob_start();
                    $excel->setActiveSheetIndex(0);

                    $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A3:B3')->setWidth('50');

                    //name the worksheet
                    $excel->getActiveSheet()->setTitle("Purchase Invoice (Summary)");

                    $excel->getActiveSheet()
                    	  ->getStyle('A1:I1')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel->getActiveSheet()
                    	  ->getStyle('A2:I2')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel->getActiveSheet()
                    	  ->getStyle('A3:I3')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        

                    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)
       										->setSize(16);
                    $excel->getActiveSheet()->mergeCells('A1:I1');
                    $excel->getActiveSheet()->mergeCells('A2:I2');
                    $excel->getActiveSheet()->mergeCells('A3:I3');
                    $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                            ->setCellValue('A2',$company_info[0]->company_address)
                                            ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no);  


                	$border = array(
					        'borders' => array(
					            'bottom' => array(
					                'style' => PHPExcel_Style_Border::BORDER_THICK,
					                'color' => array('rgb' => '92a8d1')
					            )
					        )
					    );

                    $excel->getActiveSheet()->setCellValue('A4')       
                    						->mergeCells('A4:I4');         	
                	$excel->getActiveSheet()->getStyle('A4:I4')->applyFromArray($border);

                    $excel->getActiveSheet()
                    	  ->getStyle('A5:I5')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  

                    $excel->getActiveSheet()
                    	  ->getStyle('A6:I6')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  

                    $excel->getActiveSheet()
                    	  ->getStyle('A7:I7')
                    	  ->getAlignment()
                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  

                    $excel->getActiveSheet()->mergeCells('A5:I5');
                    $excel->getActiveSheet()->mergeCells('A6:I6');
                    $excel->getActiveSheet()->mergeCells('A7:I7');
                							
                    $excel->getActiveSheet()->setCellValue('A5',"PURCHASE INVOICE REPORT")
                    						->setCellValue('A6',"(DETAILED)")
                    						->getStyle('A5:A6')->getFont()->setBold(TRUE)
                    						->setSize(18);

                    $excel->getActiveSheet()->setCellValue('A7','Period '.$startDate.' to '. $endDate);

                    $i = 8;

                    foreach ($invoice_numbers as $invoice_number) {

	                	$border = array(
						        'borders' => array(
						            'bottom' => array(
						                'style' => PHPExcel_Style_Border::BORDER_THICK,
						                'color' => array('rgb' => '92a8d1')
						            )
						        )
						    );

               			$excel->getActiveSheet()->mergeCells('A'.$i.':I'.$i);
						$excel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setIndent(0);
                    	$excel->getActiveSheet()->setCellValue('A'.$i,$invoice_number->dr_invoice_no)
                    							->getStyle('A'.$i)->getFont()->setBold(TRUE)
                    							->setSize(12);
                		$excel->getActiveSheet()->getStyle('A'.$i.':I'.$i)->applyFromArray($border);
	                	$i++;

               			$excel->getActiveSheet()->mergeCells('A'.$i.':I'.$i);
						$excel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setIndent(4);
                    	$excel->getActiveSheet()->setCellValue('A'.$i,$invoice_number->supplier_name)
                    							->getStyle('A'.$i)->getFont()->setBold(TRUE)
                    							->setSize(12);   
                		$excel->getActiveSheet()->getStyle('A'.$i.':I'.$i)->applyFromArray($border);                    							
                		$i++;

               			$excel->getActiveSheet()->mergeCells('A'.$i.':I'.$i);                		
                    	$excel->getActiveSheet()->setCellValue('A'.$i);                		
                		$i++;

	                    $excel->getActiveSheet()->getColumnDimensionByColumn('D')->setWidth('50');
	                    $excel->getActiveSheet()->getColumnDimensionByColumn('F')->setWidth('50');
	                    $excel->getActiveSheet()->getColumnDimensionByColumn('H')->setWidth('50');      
	                              		
               			$excel->getActiveSheet()->mergeCells('A'.$i.':C'.$i);                		                		
                		$excel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setIndent(8);
                    	$excel->getActiveSheet()->setCellValue('A'.$i,'PRODUCT')
                    							->getStyle('A'.$i)->getFont()->setBold(TRUE);

	                    $excel->getActiveSheet()
	                    	  ->getStyle('D'.$i)
	                    	  ->getAlignment()
	                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  

	                    $excel->getActiveSheet()
	                    	  ->getStyle('F'.$i)
	                    	  ->getAlignment()
	                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  

	                    $excel->getActiveSheet()
	                    	  ->getStyle('H'.$i)
	                    	  ->getAlignment()
	                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  

               			$excel->getActiveSheet()->mergeCells('D'.$i.':E'.$i);                		                		
                    	$excel->getActiveSheet()->setCellValue('D'.$i,'UNIT COST')
                    							->getStyle('D'.$i)->getFont()->setBold(TRUE);        

               			$excel->getActiveSheet()->mergeCells('F'.$i.':G'.$i);                		                		
                    	$excel->getActiveSheet()->setCellValue('F'.$i,'QTY')
                    							->getStyle('F'.$i)->getFont()->setBold(TRUE);                    							

               			$excel->getActiveSheet()->mergeCells('H'.$i.':I'.$i);                		                		
                    	$excel->getActiveSheet()->setCellValue('H'.$i,'TOTAL NET')
                    							->getStyle('H'.$i)->getFont()->setBold(TRUE);                    							
						$inv_total = 0; 
                  		$i++;

 							foreach ($purchase_invoice_detailed as $detail) {
								if($detail->supplier_id==$invoice_number->supplier_id&&$detail->dr_invoice_id==$invoice_number->dr_invoice_id) {

				                	$border = array(
									        'borders' => array(
									            'bottom' => array(
									                'style' => PHPExcel_Style_Border::BORDER_THICK,
									                'color' => array('rgb' => '92a8d1')
									            )
									        )
									    );

				                    $excel->getActiveSheet()
				                    	  ->getStyle('D'.$i)
				                    	  ->getAlignment()
				                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  

				                    $excel->getActiveSheet()
				                    	  ->getStyle('F'.$i)
				                    	  ->getAlignment()
				                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  

				                    $excel->getActiveSheet()
				                    	  ->getStyle('H'.$i)
				                    	  ->getAlignment()
				                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  

			               			$excel->getActiveSheet()->mergeCells('A'.$i.':C'.$i);
			               			$excel->getActiveSheet()->mergeCells('D'.$i.':E'.$i);
			               			$excel->getActiveSheet()->mergeCells('F'.$i.':G'.$i);		
			               			$excel->getActiveSheet()->mergeCells('H'.$i.':I'.$i);		
			               										
			                    	$excel->getActiveSheet()->setCellValue('A'.$i,$detail->product_desc)
															->getStyle('A'.$i)->getAlignment()->setIndent(8);			                    	
                        			$excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.0000;(###,##0.0000)');			               			            		                		
			                    	$excel->getActiveSheet()->setCellValue('D'.$i,number_format($detail->dr_price,2));

			                    	$excel->getActiveSheet()->setCellValue('F'.$i,number_format($detail->dr_qty,2));

                        			$excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.0000;(###,##0.0000)');			               			   		                		
			                    	$excel->getActiveSheet()->setCellValue('H'.$i,number_format(($detail->dr_price*$detail->dr_qty),2));
                					$excel->getActiveSheet()->getStyle('A'.$i.':I'.$i)->applyFromArray($border);                    							

									$inv_total+=$detail->dr_price*$detail->dr_qty;	
			                    	$i++;

								}
 							}
				                    $excel->getActiveSheet()
				                    	  ->getStyle('A'.$i)
				                    	  ->getAlignment()
				                    	  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 

			               			$excel->getActiveSheet()->mergeCells('A'.$i.':I'.$i);
                        			$excel->getActiveSheet()->getStyle('A'.$i)->getNumberFormat()->setFormatCode('###,##0.0000;(###,##0.0000)');			               			   		                					               			
			                    	$excel->getActiveSheet()->setCellValue('A'.$i,number_format($inv_total,2))
			                    							->getStyle('A'.$i)->getFont()->setBold(TRUE)
			                    							->setSize(14);
			                    	$i++;
                    }
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename='."Purchase Invoice Report (Detailed).xlsx".'');
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
                    $data = ob_get_clean();

                            $file_name='Purchase Invoice Report Detailed '.date('Y-m-d h:i:A', now());
                            $excelFilePath = $file_name.".xlsx"; //generate filename base on id
                            //download it.
                            // Set SMTP Configuration
                            $emailConfig = array(
                                'protocol' => 'smtp', 
                                'smtp_host' => 'ssl://smtp.googlemail.com', 
                                'smtp_port' => 465, 
                                'smtp_user' => $email[0]->email_address, 
                                'smtp_pass' => $email[0]->password, 
                                'mailtype' => 'html', 
                                'charset' => 'iso-8859-1'
                            );

                            // Set your email information
                            
                            $from = array(
                                'email' => $email[0]->email_address,
                                'name' => $email[0]->name_from
                            );

                            $to = array($email[0]->email_to);
                            $subject = 'Purchase Invoice Report Detailed';
                          //  $message = 'Type your gmail message here';
                            $message = '<p>To: ' .$email[0]->email_to. '</p></ br>' .$email[0]->default_message.'</ br><p>Sent By: '. '<b>'.$this->session->user_fullname.'</b>'. '</p></ br>' .date('Y-m-d h:i:A', now());

                            // Load CodeIgniter Email library
                            $this->load->library('email', $emailConfig);
                            // Sometimes you have to set the new line character for better result
                            $this->email->set_newline("\r\n");
                            // Set email preferences
                            $this->email->from($from['email'], $from['name']);
                            $this->email->to($to);
                            $this->email->subject($subject);
                            $this->email->message($message);
                            $this->email->attach($data, 'attachment', $excelFilePath , 'application/ms-excel');
                            $this->email->set_mailtype("html");
                            // Ready to send email and check whether the email was successfully sent
                            if (!$this->email->send()) {
                                // Raise error message
                            $response['title']='Try Again!';
                            $response['stat']='error';
                            $response['msg']='Please check the Email Address of your Supplier or your Internet Connection.';

                            echo json_encode($response);
                            } else {
                                // Show success notification or other things here
                            $response['title']='Success!';
                            $response['stat']='success';
                            $response['msg']='Email Sent successfully.';

                            echo json_encode($response);
                            }	              
	                }
	            break;

			}
		}
	}
?>