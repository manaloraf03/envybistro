<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Templates extends CORE_Controller {
    function __construct() {
        parent::__construct('');

        $this->validate_session();

        $this->load->model('Purchases_model');
        $this->load->model('Purchase_items_model');

        $this->load->model('Delivery_invoice_model');
        $this->load->model('Delivery_invoice_item_model');

        $this->load->model('Issuance_model');
        $this->load->model('Issuance_item_model');

        $this->load->model('Adjustment_model');
        $this->load->model('Adjustment_item_model');

        $this->load->model('Sales_invoice_model');
        $this->load->model('Sales_invoice_item_model');

        $this->load->model('Payment_method_model');


        $this->load->model('Sales_order_model');
        $this->load->model('Sales_order_item_model');

        $this->load->model('Suppliers_model');

        $this->load->model('Customers_model');

        $this->load->model('Payable_payment_model');

        $this->load->model('Receivable_payment_model');

        $this->load->model('Journal_info_model');

        $this->load->model('Journal_account_model');

        $this->load->model('Customer_subsidiary_model');

        $this->load->model('Account_title_model');

        $this->load->model('User_group_right_model');

        $this->load->model('Company_model');

        $this->load->model('Products_model');

        $this->load->model('Refproduct_model');

        $this->load->model('Departments_model');

        $this->load->model('Receivable_payment_list_model');

        $this->load->model('Payable_payment_list_model');

        $this->load->model('Check_layout_model');

        $this->load->model('Service_invoice_model');

        $this->load->model('Service_invoice_item_model');

        $this->load->model('Depreciation_expense_model');

        $this->load->model('Delivery_receipt_model');

        $this->load->model('Delivery_receipt_item_model');

        $this->load->model('Proforma_invoice_model');

        $this->load->model('Proforma_invoice_items_model');

        $this->load->model('Commercial_invoice_model');

        $this->load->model('Commercial_invoice_items_model');

        $this->load->model('Cash_invoice_model');

        $this->load->model('Cash_invoice_items_model');

        $this->load->model('Hotel_integration_items_model');

        $this->load->model('Pos_integration_items_model');
        $this->load->model('Doc_types_model');

        $this->load->model('Pos_integration_model');
        $this->load->model('Purchasing_integration_model');




        $this->load->library('M_pdf');
        $this->load->library('excel');
        $this->load->model('Email_settings_model');

    }

    public function index() {

    }


    function layout($layout=null,$filter_value=null,$type=null){
        switch($layout){
              case 'services-journal-for-review':

                $service_invoice_id = $this->input->get('id',TRUE);
                $m_service_invoice=$this->Service_invoice_model;
                $m_service_invoice_items=$this->Service_invoice_item_model;
                $m_accounts=$this->Account_title_model;
                $m_customers=$this->Customers_model;
                $m_departments=$this->Departments_model;

                $service_info=$m_service_invoice->get_list(
                    array(
                        'service_invoice.is_deleted'=>FALSE,
                        'service_invoice.is_active'=>TRUE,
                        'service_invoice.service_invoice_id'=>$service_invoice_id),
                    array(
                        'service_invoice.service_invoice_id',
                        'service_invoice.service_invoice_no',
                        'service_invoice.customer_id',
                        'service_invoice.department_id',
                        'service_invoice.salesperson_id',
                        'service_invoice.total_amount',
                        'service_invoice.total_overall_discount_amount',
                        'service_invoice.total_amount_after_discount',
                        'DATE_FORMAT(service_invoice.date_invoice,"%m/%d/%Y")as date_invoice',
                        'DATE_FORMAT(service_invoice.date_created,"%m/%d/%Y %r")as date_created',
                        'service_invoice.posted_by_user',
                        'service_invoice.date_due',
                        'service_invoice.remarks',
                        'customers.customer_name',
                        'customers.address',
                        'customers.email_address',
                        'customers.contact_no',
                        'CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by'

                        ),
                        array(
                            array('customers', 'customers.customer_id=service_invoice.customer_id','left'),
                            array('user_accounts','user_accounts.user_id=service_invoice.posted_by_user','left')

                            )    
                );

                $data['service_invoice']=$service_info[0];

                $data['departments']=$m_departments->get_list(
                    array('is_active'=> TRUE, 
                          'is_deleted'=>FALSE
                        ),
                    array(
                        'departments.department_id',
                        'departments.department_name'
                        )
                );

                $data['customers']=$m_customers->get_list(
                    array('is_active'=>TRUE,
                          'is_deleted'=> FALSE
                        ),
                    array(
                        'customers.customer_id',
                        'customers.customer_name'
                        )
                );

                $data['accounts']=$m_accounts->get_list(
                    array(
                        'account_titles.is_active'=>TRUE,
                        'account_titles.is_deleted'=>FALSE
                    )
                );

                $data['entries']=$m_service_invoice->get_journal_entries_2($service_invoice_id);

                $data['items']=$m_service_invoice_items->get_list(
                    array('service_invoice_items.service_invoice_id'=>$service_invoice_id),
                    array(
                        'service_invoice_items.*',
                        'services.service_desc',
                        'service_unit.service_unit_id',
                        'service_unit.service_unit_name'
                        ),
                    array(
                        array('services','services.service_id=service_invoice_items.service_id','left'),
                        array('service_unit','service_unit.service_unit_id=service_invoice_items.service_unit','left')
                        )
                    );

                
                //validate if customer is not deleted
                $valid_customer=$m_customers->get_list(
                    array(
                        'customer_id'=>$service_info[0]->customer_id,
                        'is_active'=>TRUE,
                        'is_deleted'=>FALSE
                    )
                );
                $data['valid_particular']=(count($valid_customer)>0);          

                  echo $this->load->view('template/service_journal_for_review',$data,TRUE); //details of the journal


                break;

            case 'journal-ar-services':
                $m_journal_info=$this->Journal_info_model;
                $m_company=$this->Company_model;
                $journal_id=$this->input->get('id',TRUE);
                $type=$this->input->get('type',TRUE);

                $journal_info=$m_journal_info->get_list(
                    $journal_id,

                    array(
                        'journal_info.*',
                        'customers.customer_name',
                        'customers.address',
                        'customers.email_address',
                        'customers.contact_no'
                    ),

                    array(
                        array('customers','customers.customer_id=journal_info.customer_id','left')
                    )

                );

                $company_info = $m_company->get_list();

                $data['company_info']=$company_info[0];

                $data['journal_info']=$journal_info[0];

                $m_journal_accounts=$this->Journal_account_model;
                $data['journal_accounts']=$m_journal_accounts->get_list(

                    array(
                        'journal_accounts.journal_id'=>$journal_id
                    ),

                    array(
                        'journal_accounts.*',
                        'account_titles.account_no',
                        'account_titles.account_title'
                    ),

                    array(
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','left')
                    )

                );


                //show only inside grid with menu button
                if($type=='fullview'||$type==null){
                    echo $this->load->view('template/sales_journal_entries_content',$data,TRUE);
                    echo $this->load->view('template/sales_journal_entries_content_menus',$data,TRUE);
                }

                //download pdf
                if($type=='pdf'){
                    $file_name=$journal_info[0]->txn_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/sales_journal_entries_content',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output($pdfFilePath,"D");

                }

                //preview on browser
                if($type=='preview'){
                    $file_name=$journal_info[0]->txn_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/sales_journal_entries_content',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                }

                break;
            case 'po': //purchase order
                        $m_purchases=$this->Purchases_model;
                        $m_po_items=$this->Purchase_items_model;
                        $m_company=$this->Company_model;
                        $type=$this->input->get('type',TRUE);

                        $info=$m_purchases->get_list(
                                $filter_value,
                                'purchase_order.*,CONCAT_WS(" ",purchase_order.terms,purchase_order.duration)as term_description,suppliers.supplier_name,suppliers.address,suppliers.email_address,suppliers.contact_no',
                                array(
                                    array('suppliers','suppliers.supplier_id=purchase_order.supplier_id','left')
                                )
                            );

                        $company=$m_company->get_list();

                        $data['purchase_info']=$info[0];
                        $data['company_info']=$company[0];
                        $data['po_items']=$m_po_items->get_list(
                                array('purchase_order_id'=>$filter_value),
                                'purchase_order_items.*,products.product_desc,units.unit_name',

                                array(
                                    array('products','products.product_id=purchase_order_items.product_id','left'),
                                    array('units','units.unit_id=purchase_order_items.unit_id','left')
                                )
                                
                            );


                        //show only inside grid with menu buttons
                        if($type=='fullview'||$type==null){
                            echo $this->load->view('template/po_content_new',$data,TRUE);
                            echo $this->load->view('template/po_content_menus',$data,TRUE);
                        }

                        //for approval view on DASHBOARD
                        if($type=='approval'){

                            //echo '<br /><hr /><center><strong>Purchase Order for Approval</strong></center><hr />';
                            echo '<br />';
                            echo $this->load->view('template/po_content_new',$data,TRUE);
                            echo $this->load->view('template/po_content_approval_menus',$data,TRUE);
                        }

                        //show only inside grid
                        if($type=='contentview'){
                            echo $this->load->view('template/po_content_new',$data,TRUE);
                        }

                        //download pdf
                        if($type=='pdf'){
                            $file_name=$info[0]->po_no;
                            $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                            $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                            $content=$this->load->view('template/po_content_new',$data,TRUE); //load the template
                            $pdf->setFooter('{PAGENO}');
                            $pdf->WriteHTML($content);
                            //download it.
                            $pdf->Output($pdfFilePath,"D");

                        }

                        //preview on browser
                        if($type=='preview'){
                            $file_name=$info[0]->po_no;
                            $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                            $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                            $content=$this->load->view('template/po_content_new',$data,TRUE); //load the template
                            $pdf->setFooter('{PAGENO}');
                            $pdf->WriteHTML($content);
                            //download it.
                            $pdf->Output();

                        }


                        break;


            //****************************************************
            case 'dr': //delivery invoice
                        $m_delivery=$this->Delivery_invoice_model;
                        $m_dr_items=$this->Delivery_invoice_item_model;
                        $m_company=$this->Company_model;
                        $type=$this->input->get('type',TRUE);


                        $info=$m_delivery->get_list(
                            $filter_value,

                            'delivery_invoice.*,purchase_order.po_no,CONCAT_WS(" ",delivery_invoice.terms,delivery_invoice.duration)as term_description,
                            suppliers.supplier_name,suppliers.address,suppliers.email_address,suppliers.contact_no',

                            array(
                                array('suppliers','suppliers.supplier_id=delivery_invoice.supplier_id','left'),
                                array('purchase_order','purchase_order.purchase_order_id=delivery_invoice.purchase_order_id','left')
                            )
                        );

                        $company=$m_company->get_list();

                        $data['delivery_info']=$info[0];
                        $data['company_info']=$company[0];
                        $data['dr_items']=$m_dr_items->get_list(
                            array('dr_invoice_id'=>$filter_value),
                            'delivery_invoice_items.*,products.product_desc,units.unit_name',
                            array(
                                array('products','products.product_id=delivery_invoice_items.product_id','left'),
                                array('units','units.unit_id=delivery_invoice_items.unit_id','left')
                            )
                        );

                        //show only inside grid with menu button
                        if($type=='fullview'||$type==null){
                            echo $this->load->view('template/dr_content',$data,TRUE);
                            echo $this->load->view('template/dr_content_menus',$data,TRUE);
                        }

                        //show only inside grid without menu button
                        if($type=='contentview'){
                            echo $this->load->view('template/dr_content',$data,TRUE);
                        }


                        //download pdf
                        if($type=='pdf'){
                            $file_name=$info[0]->dr_invoice_no;
                            $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                            $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                            $content=$this->load->view('template/dr_content',$data,TRUE); //load the template
                            $pdf->setFooter('{PAGENO}');
                            $pdf->WriteHTML($content);
                            //download it.
                            $pdf->Output($pdfFilePath,"D");

                        }

                        //preview on browser
                        if($type=='preview'){
                            $file_name=$info[0]->dr_invoice_no;
                            $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                            $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                            $content=$this->load->view('template/dr_content',$data,TRUE); //load the template
                            $pdf->setFooter('{PAGENO}');
                            $pdf->WriteHTML($content);
                            //download it.
                            $pdf->Output();
                        }

                        break;
                break;


            //****************************************************


            case 'service-invoice-dropdown': //delivery invoice
                $m_info=$this->Service_invoice_model;
                $m_items=$this->Service_invoice_item_model;
                $type=$this->input->get('type',TRUE);
                $info=$m_info->get_list($filter_value,
                    'service_invoice.*, 
                     departments.department_name,
                     customers.customer_name,
                     salesperson.firstname,
                     salesperson.lastname',
                    array(
                        array('departments', 'departments.department_id=service_invoice.department_id','left'),
                        array('customers', 'customers.customer_id=service_invoice.customer_id','left'),
                        array('salesperson','salesperson.salesperson_id=service_invoice.salesperson_id', 'left')
                        )
                    );

                $data['item_info']=$m_items->get_list(array('service_invoice_items.service_invoice_id'=>$filter_value),
                    array('service_invoice_items.*',
                     'services.service_desc',
                     'service_unit.service_unit_name'),
                    array(
                        array('services','services.service_id=service_invoice_items.service_id','left'),
                        array('service_unit','service_unit.service_unit_id=service_invoice_items.service_unit','left')
                        )
                    );
                $data['service']=$info[0];
                $m_company=$this->Company_model;
                $company=$m_company->get_list();
                $data['company_info']=$company[0];


                    
                    
                            
                if($type=='fullview'||$type==null){
                    echo $this->load->view('template/service_invoice_content',$data,TRUE);
                    echo $this->load->view('template/service_invoice_content_menus',$data,TRUE);
                        }
                if($type=='html'){
                    $file_name=$info[0]->service_invoice_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/service_invoice_content',$data,TRUE);//load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                    // echo $this->load->view('template/service_invoice_content',$data,TRUE);
                }

                break;

            case 'depreciation_expense': //delivery invoice
                $m_depreciation_expense=$this->Depreciation_expense_model;
                $m_company=$this->Company_model;
                $m_accounts=$this->Account_title_model;
                $m_suppliers=$this->Suppliers_model;
                $m_departments=$this->Departments_model;

                $type=$this->input->get('type',TRUE);
                $de_id = $this->input->get('id',TRUE);

                $data['accounts']=$m_accounts->get_list(
                    array(
                        'account_titles.is_active'=>TRUE,
                        'account_titles.is_deleted'=>FALSE
                    )
                );
                $data['departments']=$m_departments->get_list('is_active=TRUE AND is_deleted=FALSE');
                $data['suppliers']=$m_suppliers->get_list(
                    array(
                        'suppliers.is_active'=>TRUE,
                        'suppliers.is_deleted'=>FALSE),
                    array(
                        'suppliers.supplier_id',
                        'suppliers.supplier_name'
                    )
                );
                
                $data['entries']=$m_depreciation_expense->get_journal_entries($de_id);
                $data['id']=$de_id[0];
                $data['customers']=$this->Customers_model->get_list('is_active=TRUE AND is_deleted=FALSE');
                $info=$m_depreciation_expense->get_list($de_id);
                $data['info']=$info[0];
                //show only inside grid with menu button
                if($type=='fullview'||$type==null){
                    echo $this->load->view('template/depreciation_expense_for_review',$data,TRUE);
                }
                break;

                //***********************************************88
            case 'issuance': //delivery invoice
                $m_issuance=$this->Issuance_model;
                $m_dr_items=$this->Issuance_item_model;
                $m_company=$this->Company_model;
                $type=$this->input->get('type',TRUE);

                $info=$m_issuance->get_list(
                    $filter_value,
                    'issuance_info.*,departments.department_name,customers.customer_name',
                    array(
                        array('departments','departments.department_id=issuance_info.issued_department_id','left'),
                        array('customers','customers.customer_id=issuance_info.issued_to_person','left')
                    )
                );

                $company=$m_company->get_list();

                $data['issuance_info']=$info[0];
                $data['company_info']=$company[0];
                $data['issue_items']=$m_dr_items->get_list(
                    array('issuance_items.issuance_id'=>$filter_value),
                    'issuance_items.*,products.product_desc,units.unit_name',
                    array(
                        array('products','products.product_id=issuance_items.product_id','left'),
                        array('units','units.unit_id=issuance_items.unit_id','left')
                    )
                );



                //show only inside grid with menu button
                if($type=='fullview'||$type==null){
                    echo $this->load->view('template/issue_content',$data,TRUE);
                    echo $this->load->view('template/issue_content_menus',$data,TRUE);
                }

                //show only inside grid without menu button
                if($type=='contentview'){
                    echo $this->load->view('template/issue_content',$data,TRUE);
                }


                //download pdf
                if($type=='pdf'){
                    $file_name=$info[0]->slip_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/issue_content',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output($pdfFilePath,"D");

                }

                //preview on browser
                if($type=='preview'){
                    $file_name=$info[0]->slip_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/issue_content',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                }

                break;


            //****************************************************
            case 'adjustments': //delivery invoice
                $m_adjustment=$this->Adjustment_model;
                $m_adjustment_items=$this->Adjustment_item_model;
                $m_company=$this->Company_model;
                $type=$this->input->get('type',TRUE);

                $info=$m_adjustment->get_list(
                    $filter_value,
                    'adjustment_info.*,departments.department_name',
                    array(
                        array('departments','departments.department_id=adjustment_info.department_id','left')
                    )
                );

                $company=$m_company->get_list();

                $data['adjustment_info']=$info[0];
                $data['company_info']=$company[0];
                $data['adjustment_items']=$m_adjustment_items->get_list(
                    array('adjustment_items.adjustment_id'=>$filter_value),
                    'adjustment_items.*,products.product_desc,units.unit_name',
                    array(
                        array('products','products.product_id=adjustment_items.product_id','left'),
                        array('units','units.unit_id=adjustment_items.unit_id','left')
                    )
                );



                //show only inside grid with menu button
                if($type=='fullview'||$type==null){
                    echo $this->load->view('template/adjustment_content',$data,TRUE);
                    echo $this->load->view('template/adjustment_content_menus',$data,TRUE);
                }

                //show only inside grid without menu button
                if($type=='contentview'){
                    echo $this->load->view('template/adjustment_content',$data,TRUE);
                }


                //download pdf
                if($type=='pdf'){
                    $file_name=$info[0]->adjustment_code;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/adjustment_content',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output($pdfFilePath,"D");

                }

                //preview on browser
                if($type=='preview'){
                    $file_name=$info[0]->adjustment_code;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/adjustment_content',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                }

                break;


            //****************************************************
            case 'sales-invoice': //delivery invoice
                $m_sales_invoice=$this->Sales_invoice_model;
                $m_sales_invoice_items=$this->Sales_invoice_item_model;
                $m_company_info=$this->Company_model;
                $type=$this->input->get('type',TRUE);

                // $info=$m_sales_invoice->get_list(
                //     $filter_value,
                //     'sales_invoice.*,departments.department_name,customers.customer_name, sales_invoice.address,sales_order.so_no,salesperson.*',
                //     array(
                //         array('departments','departments.department_id=sales_invoice.issue_to_department','left'),
                //         array('customers','customers.customer_id=sales_invoice.customer_id','left'),
                //         array('sales_order','sales_order.sales_order_id=sales_invoice.sales_order_id','left'),
                //         array('salesperson','salesperson.salesperson_id=sales_invoice.salesperson_id','left')
                //     )
                // );

                // $data['sales_info']=$info[0];
                // $data['sales_invoice_items']=$m_sales_invoice_items->get_list(
                //     array('sales_invoice_items.sales_invoice_id'=>$filter_value),
                //     'sales_invoice_items.*,products.product_desc,products.size,units.unit_name',
                //     array(
                //         array('products','products.product_id=sales_invoice_items.product_id','left'),
                //         array('units','units.unit_id=sales_invoice_items.unit_id','left')
                //     )
                // );
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $info=$m_sales_invoice->get_list(
                    $filter_value,
                    array(
                        'sales_invoice.sales_invoice_id',
                        'sales_invoice.sales_inv_no',
                        'sales_invoice.remarks', 
                        'sales_invoice.date_created',
                        'sales_invoice.customer_id',
                        'sales_invoice.inv_type',
                        'sales_invoice.*',
                        'DATE_FORMAT(sales_invoice.date_invoice,"%m/%d/%Y") as date_invoice',
                        'DATE_FORMAT(sales_invoice.date_due,"%m/%d/%Y") as date_due',
                        'departments.department_id',
                        'departments.department_name',
                        'customers.customer_name',
                        'sales_invoice.salesperson_id',
                        'sales_invoice.address',
                        'sales_order.so_no',
                        'CONCAT(salesperson.firstname," ",salesperson.lastname) AS salesperson_name'
                    ),
                    array(
                        array('departments','departments.department_id=sales_invoice.department_id','left'),
                        array('salesperson','salesperson.salesperson_id=sales_invoice.salesperson_id','left'),
                        array('customers','customers.customer_id=sales_invoice.customer_id','left'),
                        array('sales_order','sales_order.sales_order_id=sales_invoice.sales_order_id','left'),
                    )
                );

                $data['sales_info']=$info[0];
                $data['sales_invoice_items']=$m_sales_invoice_items->get_list(
                    array('sales_invoice_items.sales_invoice_id'=>$filter_value),
                    'sales_invoice_items.*,products.product_desc,products.size,units.unit_name',
                    array(
                        array('products','products.product_id=sales_invoice_items.product_id','left'),
                        array('units','units.unit_id=sales_invoice_items.unit_id','left')
                    )
                );

                //show only inside grid with menu button
                // if($type=='fullview'||$type==null){
                //     echo $this->load->view('template/sales_invoice_content',$data,TRUE);
                //     echo $this->load->view('template/sales_invoice_content_menus',$data,TRUE);
                // }

                //show only inside grid with menu button
                if($type=='html'){
                    echo $this->load->view('template/sales_invoice_content_standard',$data);
                }

                //show only inside grid without menu button
                // if($type=='contentview'){
                //     echo $this->load->view('template/sales_invoice_content_standard',$data,TRUE);
                // }

                if($type=='dr'){
                    echo $this->load->view('template/sales_invoice_content_dr',$data,TRUE);
                }

                if($type=='drview'){
                    echo $this->load->view('template/sales_invoice_content_dr_view',$data,TRUE);
                    echo $this->load->view('template/delivery_receipt_menus',$data,TRUE);
                }

                //download pdf
                if($type=='pdf'){
                    $file_name=$info[0]->sales_inv_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/sales_invoice_content',$data,TRUE); //load the template
                    //$pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output($pdfFilePath,"D");

                }
                if($type=='dropdown'){
                      echo  $this->load->view('template/sales_invoice_content_standard',$data,TRUE); //load the template

                }
                //preview on browser
                if($type=='contentview'){
                    $file_name=$info[0]->sales_inv_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/sales_invoice_content_standard',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                }

                break;

            case 'proforma-invoice': //proforma invoice
                $m_proforma_invoice=$this->Proforma_invoice_model;
                $m_proforma_invoice_items=$this->Proforma_invoice_items_model;
                $m_company_info=$this->Company_model;
                $type=$this->input->get('type',TRUE);
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $info=$m_proforma_invoice->get_list(
                $filter_value,
                array(
                    'proforma_invoice.*',
                    'DATE_FORMAT(proforma_invoice.date_invoice,"%m/%d/%Y") as date_invoice',
                    'DATE_FORMAT(proforma_invoice.date_due,"%m/%d/%Y") as date_due',
                    'departments.department_id',
                    'departments.department_name',
                    'proforma_invoice.salesperson_id',
                    'proforma_invoice.address',
                    'sales_order.so_no'
                ),
                array(
                    array('departments','departments.department_id=proforma_invoice.department_id','left'),
                    array('customers','customers.customer_id=proforma_invoice.customer_id','left'),
                    array('sales_order','sales_order.sales_order_id=proforma_invoice.sales_order_id','left'),
                ),
                'proforma_invoice.proforma_invoice_id DESC'
            );

                $data['proforma_info']=$info[0];
                $data['items']=$m_proforma_invoice_items->get_list(
                    array('proforma_invoice_items.proforma_invoice_id'=>$filter_value),
                    'proforma_invoice_items.*,products.product_desc,products.size,units.unit_name,products.product_code',
                    array(
                        array('products','products.product_id=proforma_invoice_items.product_id','left'),
                        array('units','units.unit_id=proforma_invoice_items.unit_id','left')
                    )
                );

                //preview on browser
                if($type=='contentview'){
                    $file_name=$info[0]->sales_inv_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/proforma_invoice_standard',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                }

                break;

            case 'cash-invoice': //cash invoice
                $m_cash_invoice=$this->Cash_invoice_model;
                $m_cash_invoice_items=$this->Cash_invoice_items_model;
                $m_company_info=$this->Company_model;
                $type=$this->input->get('type',TRUE);
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $info=$m_cash_invoice->get_list(
                $filter_value,
                array(
                    'cash_invoice.*',
                    'DATE_FORMAT(cash_invoice.date_invoice,"%m/%d/%Y") as date_invoice',
                    'DATE_FORMAT(cash_invoice.date_due,"%m/%d/%Y") as date_due',
                    'departments.department_id',
                    'departments.department_name',
                    'cash_invoice.salesperson_id',
                    'cash_invoice.address',
                    'sales_order.so_no',
                    'customers.customer_name'

                ),
                array(
                    array('departments','departments.department_id=cash_invoice.department_id','left'),
                    array('customers','customers.customer_id=cash_invoice.customer_id','left'),
                    array('sales_order','sales_order.sales_order_id=cash_invoice.sales_order_id','left'),
                ),
                'cash_invoice.cash_invoice_id DESC'
            );

                $data['info']=$info[0];
                $data['items']=$m_cash_invoice_items->get_list(
                    array('cash_invoice_items.cash_invoice_id'=>$filter_value),
                    'cash_invoice_items.*,products.product_desc,products.size,units.unit_name,products.product_code',
                    array(
                        array('products','products.product_id=cash_invoice_items.product_id','left'),
                        array('units','units.unit_id=cash_invoice_items.unit_id','left')
                    )
                );

                //preview on browser
                if($type=='contentview'){
                    $file_name=$info[0]->cash_inv_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/cash_invoice_entries',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                }

                break;

            case 'commercial-invoice': //Commercial Invoice
                $m_commercial_invoice=$this->Commercial_invoice_model;
                $m_commercial_invoice_items=$this->Commercial_invoice_items_model;
                $m_company_info=$this->Company_model;
                $type=$this->input->get('type',TRUE);
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $info=$m_commercial_invoice->get_list(
                $filter_value,
                array(
                    'commercial_invoice.*',
                    'DATE_FORMAT(commercial_invoice.date_invoice,"%m/%d/%Y") as date_invoice',
                    'DATE_FORMAT(commercial_invoice.date_due,"%m/%d/%Y") as date_due'
                ),
                array(
                ),
                'commercial_invoice.commercial_invoice_id DESC'
            );

                $data['info']=$info[0];
                $data['items']=$m_commercial_invoice_items->get_list(
                    array('commercial_invoice_items.commercial_invoice_id'=>$filter_value),
                    'commercial_invoice_items.*,products.product_desc,products.size,units.unit_name,products.product_code',
                    array(
                        array('products','products.product_id=commercial_invoice_items.product_id','left'),
                        array('units','units.unit_id=commercial_invoice_items.unit_id','left')
                    )
                );

                //preview on browser
                if($type=='contentview'){
                    $file_name=$info[0]->sales_inv_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/commercial_invoice_standard',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                }

                break;


            case 'delivery-receipt': 
                $m_dr_invoice=$this->Delivery_receipt_model;
                $m_dr_invoice_items=$this->Delivery_receipt_item_model;
                $m_company_info=$this->Company_model;
                $type=$this->input->get('type',TRUE);


                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $info=$m_dr_invoice->get_list(
                    $filter_value,
                    array(
                        'delivery_receipt.delivery_receipt_id',
                        'delivery_receipt.delivery_inv_no',
                        'delivery_receipt.remarks', 
                        'delivery_receipt.date_created',
                        'delivery_receipt.customer_id',
                        'delivery_receipt.inv_type',
                        'delivery_receipt.*',
                        'DATE_FORMAT(delivery_receipt.date_invoice,"%m/%d/%Y") as date_invoice',
                        'DATE_FORMAT(delivery_receipt.date_due,"%m/%d/%Y") as date_due',
                        'departments.department_id',
                        'departments.department_name',
                        'customers.customer_name',
                        'delivery_receipt.salesperson_id',
                        'delivery_receipt.address',
                        'sales_invoice.sales_inv_no',
                        'CONCAT(salesperson.firstname," ",salesperson.lastname) AS salesperson_name'
                    ),
                    array(
                        array('departments','departments.department_id=delivery_receipt.department_id','left'),
                        array('salesperson','salesperson.salesperson_id=delivery_receipt.salesperson_id','left'),
                        array('customers','customers.customer_id=delivery_receipt.customer_id','left'),
                        array('sales_invoice','sales_invoice.sales_invoice_id=delivery_receipt.sales_invoice_id','left'),
                    )
                );

                $data['delivery_receipt_info']=$info[0];
                $data['delivery_receipt_items']=$m_dr_invoice_items->get_list(
                    array('delivery_receipt_items.delivery_receipt_id'=>$filter_value),
                    'delivery_receipt_items.*,products.product_desc,products.product_code,products.size,units.unit_name',
                    array(
                        array('products','products.product_id=delivery_receipt_items.product_id','left'),
                        array('units','units.unit_id=delivery_receipt_items.unit_id','left')
                    )
                );

                //show only inside grid with menu button
                // if($type=='fullview'||$type==null){
                //     echo $this->load->view('template/sales_invoice_content',$data,TRUE);
                //     echo $this->load->view('template/sales_invoice_content_menus',$data,TRUE);
                // }

                //show only inside grid with menu button
                if($type=='html'){
                    echo $this->load->view('template/sales_invoice_content_standard',$data);
                }

                //show only inside grid without menu button
                // if($type=='contentview'){
                //     echo $this->load->view('template/sales_invoice_content_standard',$data,TRUE);
                // }

                if($type=='dr'){
                    echo $this->load->view('template/sales_invoice_content_dr',$data,TRUE);
                }

                if($type=='drview'){
                    echo $this->load->view('template/sales_invoice_content_dr_view',$data,TRUE);
                    echo $this->load->view('template/delivery_receipt_menus',$data,TRUE);
                }

                //download pdf
                if($type=='pdf'){
                    $file_name=$info[0]->sales_inv_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/sales_invoice_content',$data,TRUE); //load the template
                    //$pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output($pdfFilePath,"D");

                }
                if($type=='dropdown'){
                      echo  $this->load->view('template/sales_invoice_content_standard',$data,TRUE); //load the template

                }
                //preview on browser
                if($type=='contentview'){
                    $file_name=$info[0]->sales_inv_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/delivery_receipt_content_standard',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                }

                break;





















            //****************************************************
            case 'sales-order': //sales order
            $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];
                $m_sales_order=$this->Sales_order_model;
                $m_sales_order_items=$this->Sales_order_item_model;
                $type=$this->input->get('type',TRUE);

                $info=$m_sales_order->get_list(
                    $filter_value,
                    'sales_order.*,departments.department_name,customers.customer_name',
                    array(
                        array('departments','departments.department_id=sales_order.department_id','left'),
                        array('customers','customers.customer_id=sales_order.customer_id','left')
                    )
                );


                $data['sales_order']=$info[0];
                $data['sales_order_items']=$m_sales_order_items->get_list(
                    array('sales_order_items.sales_order_id'=>$filter_value),
                    'sales_order_items.*,products.product_desc,units.unit_name',
                    array(
                        array('products','products.product_id=sales_order_items.product_id','left'),
                        array('units','units.unit_id=sales_order_items.unit_id','left')
                    )
                );



                //show only inside grid with menu button
                if($type=='fullview'||$type==null){
                    echo $this->load->view('template/so_content',$data,TRUE);
                    echo $this->load->view('template/so_content_menus',$data,TRUE);
                }

                //show only inside grid without menu button
                if($type=='contentview'){
                    echo $this->load->view('template/so_content',$data,TRUE);
                }


                //download pdf
                if($type=='pdf'){
                    $file_name=$info[0]->so_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/so_content',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output($pdfFilePath,"D");

                }

                //preview on browser
                if($type=='preview'){
                    $file_name=$info[0]->so_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/so_content',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                }

                break;


            case 'supplier':
                $supplier_id=$filter_value;
                $m_suppliers=$this->Suppliers_model;
                $m_purchases=$this->Purchases_model;

                //supplier info
                $supplier_info=$m_suppliers->get_list(
                    $supplier_id,
                    array(
                        'suppliers.*',
                        /*'supplier_photos.photo_path',*/
                        'tax_types.tax_type',
                        'CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as user',
                        'DATE_FORMAT(suppliers.date_created,"%m/%d/%Y %r")as date_added',
                    ),
                    array(
                        /*array('supplier_photos','supplier_photos.supplier_id=suppliers.supplier_id','left'),*/
                        array('user_accounts','user_accounts.user_id=suppliers.posted_by_user','left'),
                        array('tax_types','tax_types.tax_type_id=suppliers.tax_type_id','left')
                    )
                );
                $data['supplier_info']=$supplier_info[0];
                //**********************************************************************

                //list of purchase order that are not closed
                $purchases=$m_purchases->get_list(
                    'purchase_order.supplier_id='.$supplier_id.' AND purchase_order.is_deleted=FALSE AND purchase_order.is_active=TRUE AND (purchase_order.order_status_id=1 OR purchase_order.order_status_id=3)',

                    array(
                        'purchase_order.*',
                        'CONCAT_WS(" ",purchase_order.terms,purchase_order.duration)as term_description',
                        'order_status.order_status',
                        'approval_status.approval_status'
                    ),

                    array(
                        array('order_status','order_status.order_status_id=purchase_order.order_status_id','left'),
                        array('approval_status','approval_status.approval_id=purchase_order.approval_id','left')
                    )

                );
                $data['purchases']=$purchases;

                //get details of last active payment
                $m_payment=$this->Payable_payment_model;
                $recent_payment=$m_payment->get_list(

                    array(
                        'payable_payments.supplier_id'=>$supplier_id,
                        'payable_payments.is_active'=>TRUE,
                        'payable_payments.is_deleted'=>FALSE
                    )
                    ,

                    'payable_payments.receipt_no,DATE_FORMAT(payable_payments.date_paid,"%m/%d/%Y")as date_paid,payable_payments.total_paid_amount',
                    null,'payable_payments.payment_id DESC',null,TRUE,1

                );

                $data['recent_payment']=(count($recent_payment)>0?$recent_payment:'');
                //shows when Expand Icon is click on Supplier Management


                $data['invoice']=$m_suppliers->get_list_supplier_invoice($supplier_id);
                $data['payment']= $m_suppliers->get_supplier_payment($supplier_id);
                $content=$this->load->view('template/supplier_expandable_details',$data,TRUE);
                echo $content;

                break;



            case 'hotel_control':
                $item_id=$filter_value;
                $m_hotel = $this->Hotel_integration_items_model;
                $hotel_data = $m_hotel->get_list($item_id);
                $data['item'] = $hotel_data[0];

                //shows when Expand Icon is click on Customer Management
                $data['item_id'] =$item_id;
                if($hotel_data[0]->item_type == "COUT"){
                    $data['entries'] = $m_hotel->get_hotel_entries_journal_cout($item_id);
                }
                $content=$this->load->view('template/hotel_control_content',$data,TRUE);

                echo $content;

                break;

            case 'pos_control':
                $item_id=$filter_value;
                $m_pos = $this->Pos_integration_items_model;
                $data['departments']=$this->Departments_model->get_list(array('is_active'=>TRUE,'is_deleted'=>FALSE));
                $data['customers']=$this->Customers_model->get_list(array('is_active'=>TRUE, 'is_deleted'=>FALSE));
                $m_pos_int = $this->Pos_integration_model;
                $int_data = $m_pos_int->get_list(null,
                    'pos_integration.*,
                    c.customer_name,
                    d.department_name',
                    array(
                        array('customers c','c.customer_id = pos_integration.customer_id', 'left'),
                        array('departments d','d.department_id = pos_integration.department_id','left'))
                    );
                $data['int'] = $int_data[0];

                $pos_data = $m_pos->get_list($item_id);
                $data['item'] = $pos_data[0];
                $data['item_id'] =$item_id;
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


            case 'customer':
                $customer_id=$filter_value;
                $m_customers=$this->Customers_model;
                $m_sales_order=$this->Sales_order_model;

                //customer info
                $customer_info=$m_customers->get_list(
                    $customer_id,
                    array(
                        'customers.*',
                        'customer_photos.photo_path',
                        'CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as user',
                        'DATE_FORMAT(customers.date_created,"%m/%d/%Y %r")as date_added',
                    ),
                    array(
                        array('customer_photos','customer_photos.customer_id=customers.customer_id','left'),
                        array('user_accounts','user_accounts.user_id=customers.posted_by_user','left')
                    )
                );
                $data['customer_info']=$customer_info[0];
                //**********************************************************************

                //list of purchase order that are not closed
                $sales=$m_sales_order->get_list(

                    'sales_order.customer_id='.$customer_id.' AND sales_order.is_deleted=FALSE AND sales_order.is_active=TRUE AND (sales_order.order_status_id=1 OR sales_order.order_status_id=3)',

                    array(
                        'sales_order.*',
                        'order_status.order_status'
                    ),

                    array(
                        array('order_status','order_status.order_status_id=sales_order.order_status_id','left')
                    )

                );
                $data['sales']=$sales;

                //get details of last active payment
                $m_payment=$this->Receivable_payment_model;
                $recent_payment=$m_payment->get_list(

                    array(
                        'receivable_payments.customer_id'=>$customer_id,
                        'receivable_payments.is_active'=>TRUE,
                        'receivable_payments.is_deleted'=>FALSE
                    )
                    ,

                    'receivable_payments.receipt_no,DATE_FORMAT(receivable_payments.date_paid,"%m/%d/%Y")as date_paid,receivable_payments.total_paid_amount',
                    null,'receivable_payments.payment_id DESC',null,TRUE,1

                );

                $data['recent_payment']=(count($recent_payment)>0?$recent_payment:'');

                $data['invoice']=$m_customers->get_customer_invoice($customer_id);
                $data['payment']=$m_customers->get_customer_payment($customer_id);


                //shows when Expand Icon is click on Customer Management
                $content=$this->load->view('template/customer_expandable_details',$data,TRUE);

                echo $content;

                break;

            case 'journal-ap':
                $m_journal_info=$this->Journal_info_model;
                $m_company=$this->Company_model;
                $journal_id=$this->input->get('id',TRUE);
                $type=$this->input->get('type',TRUE);

                $journal_info=$m_journal_info->get_list(
                    $journal_id,

                    array(
                        'journal_info.*',
                        'suppliers.supplier_name',
                        'suppliers.address',
                        'suppliers.email_address',
                        'suppliers.contact_no',
                        'suppliers.contact_name'
                    ),

                    array(
                        array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left')
                    )

                );

                $company_info = $m_company->get_list();

                $data['company_info']=$company_info[0];
                $data['journal_info']=$journal_info[0];

                $m_journal_accounts=$this->Journal_account_model;
                $data['journal_accounts']=$m_journal_accounts->get_list(

                    array(
                        'journal_accounts.journal_id'=>$journal_id
                    ),

                    array(
                        'journal_accounts.*',
                        'account_titles.account_no',
                        'account_titles.account_title',
                        'departments.department_name'
                    ),

                    array(
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','left'),
                        array('departments','departments.department_id=journal_accounts.department_id','left')

                    )

                );


                //show only inside grid with menu button
                if($type=='fullview'||$type==null){
                    echo $this->load->view('template/journal_entries_content',$data,TRUE);
                    echo $this->load->view('template/journal_entries_content_menus',$data,TRUE);
                }

                //download pdf
                if($type=='pdf'){
                    $file_name=$journal_info[0]->txn_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/journal_entries_content',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output($pdfFilePath,"D");

                }

                //preview on browser
                if($type=='preview'){
                    $file_name=$journal_info[0]->txn_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/journal_entries_content',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                }

                break;


            case 'journal-cdj':
                $m_journal_info=$this->Journal_info_model;
                $m_company=$this->Company_model;
                $journal_id=$this->input->get('id',TRUE);
                $type=$this->input->get('type',TRUE);

                $journal_info=$m_journal_info->get_list(
                    array('journal_id'=>$journal_id),

                    array(
                        'journal_info.*',
                        'journal_info.is_active as cancelled',
                        'suppliers.supplier_name',
                        'suppliers.address',
                        'suppliers.email_address',
                        'suppliers.contact_no',
                        'suppliers.contact_name',
                        'departments.department_name',
                        'doc_types.doc_type_name',
                        'payment_methods.*'
                    ),

                    array(
                        array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
                        array('departments','departments.department_id=journal_info.department_id','left'),
                        array('payment_methods','payment_methods.payment_method_id=journal_info.payment_method_id','left'),
                        array('doc_types','doc_types.doc_type_id=journal_info.doc_type_id','left')
                    )

                );

                $company=$m_company->get_list();
                $data['company_info']=$company[0];

                $data['journal_info']=$journal_info[0];

                $m_journal_accounts=$this->Journal_account_model;
                $data['journal_accounts']=$m_journal_accounts->get_list(

                    array(
                        'journal_accounts.journal_id'=>$journal_id
                    ),

                    array(
                        'journal_accounts.*',
                        'account_titles.account_no',
                        'account_titles.account_title',
                        'departments.department_name'
                    ),

                    array(
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','left'),
                        array('departments','departments.department_id=journal_accounts.department_id','left')

                    )

                );


                //show only inside grid with menu button
                if($type=='fullview'||$type==null){
                    echo $this->load->view('template/cdj_journal_entries_content',$data,TRUE);
                    echo $this->load->view('template/cdj_journal_entries_content_menus',$data,TRUE);
                }

                //download pdf
                if($type=='pdf'){
                    $file_name=$journal_info[0]->txn_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/cdj_journal_entries_content',$data,TRUE); //load the template
                    echo $content;
                    //$pdf->setFooter('{PAGENO}');
                    //$pdf->WriteHTML($content);
                    //download it.
                    //$pdf->Output($pdfFilePath,"D");

                }

                //preview on browser
                if($type=='preview'){
                    $file_name=$journal_info[0]->txn_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/cdj_journal_entries_content',$data,TRUE); //load the template
                    // $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                }

                break;



            case 'journal-cdj-version-2':
                $m_journal_info=$this->Journal_info_model;
                $m_company=$this->Company_model;
                $journal_id=$this->input->get('id',TRUE);
                $type=$this->input->get('type',TRUE);

                $journal_info=$m_journal_info->get_list(
                    array('journal_id'=>$journal_id),

                    array(
                        'journal_info.*',
                        'journal_info.is_active as cancelled',
                        'suppliers.supplier_name',
                        'suppliers.address',
                        'suppliers.email_address',
                        'suppliers.contact_no',
                        'suppliers.contact_name',
                        'departments.department_name',
                        'payment_methods.*'
                    ),

                    array(
                        array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
                        array('departments','departments.department_id=journal_info.department_id','left'),
                        array('payment_methods','payment_methods.payment_method_id=journal_info.payment_method_id','left')
                    )

                );

                $company=$m_company->get_list();
                $data['company_info']=$company[0];

                $data['journal_info']=$journal_info[0];

                $m_journal_accounts=$this->Journal_account_model;
                $data['journal_accounts']=$m_journal_accounts->get_list(

                    array(
                        'journal_accounts.journal_id'=>$journal_id
                    ),

                    array(
                        'journal_accounts.*',
                        'account_titles.account_no',
                        'account_titles.account_title'
                    ),

                    array(
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','left')
                    )

                );

                $data['num_words']=$this->convertDecimalToWords($journal_info[0]->amount);

                //preview on browser
                if($type=='preview'){
                    $file_name=$journal_info[0]->txn_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/cdj_journal_entries_content_version_2',$data,TRUE); //load the template

                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                }

                break;

            case 'journal-ar':
                $m_journal_info=$this->Journal_info_model;
                $m_company=$this->Company_model;
                $journal_id=$this->input->get('id',TRUE);
                $type=$this->input->get('type',TRUE);

                $journal_info=$m_journal_info->get_list(
                    $journal_id,

                    array(
                        'journal_info.*',
                        'customers.customer_name',
                        'customers.address',
                        'customers.email_address',
                        'customers.contact_no'
                    ),

                    array(
                        array('customers','customers.customer_id=journal_info.customer_id','left')
                    )

                );

                $company_info = $m_company->get_list();

                $data['company_info']=$company_info[0];

                $data['journal_info']=$journal_info[0];

                $m_journal_accounts=$this->Journal_account_model;
                $data['journal_accounts']=$m_journal_accounts->get_list(

                    array(
                        'journal_accounts.journal_id'=>$journal_id
                    ),

                    array(
                        'journal_accounts.*',
                        'account_titles.account_no',
                        'account_titles.account_title',
                        'departments.department_name'
                    ),

                    array(
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','left'),
                        array('departments','departments.department_id=journal_accounts.department_id','left')
                    )

                );


                //show only inside grid with menu button
                if($type=='fullview'||$type==null){
                    echo $this->load->view('template/sales_journal_entries_content',$data,TRUE);
                    echo $this->load->view('template/sales_journal_entries_content_menus',$data,TRUE);
                }

                //download pdf
                if($type=='pdf'){
                    $file_name=$journal_info[0]->txn_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/sales_journal_entries_content',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output($pdfFilePath,"D");

                }

                //preview on browser
                if($type=='preview'){
                    $file_name=$journal_info[0]->txn_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/sales_journal_entries_content',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                }

                break;

            case 'journal-crj':
                $m_journal_info=$this->Journal_info_model;
                $m_company_info=$this->Company_model;
                $journal_id=$this->input->get('id',TRUE);
                $type=$this->input->get('type',TRUE);

                $journal_info=$m_journal_info->get_list(
                    $journal_id,

                    array(
                        'journal_info.*',
                        'journal_info.is_active as cancelled',
                        'customers.customer_name',
                        'customers.address',
                        'customers.email_address',
                        'customers.contact_no',
                        'payment_methods.*'
                    ),

                    array(
                        array('customers','customers.customer_id=journal_info.customer_id','left'),
                        array('payment_methods','payment_methods.payment_method_id=journal_info.payment_method_id','left')
                    )

                );

                $company_info=$m_company_info->get_list();

                $data['company_info']=$company_info[0];

                $data['journal_info']=$journal_info[0];

                $m_journal_accounts=$this->Journal_account_model;
                $data['journal_accounts']=$m_journal_accounts->get_list(

                    array(
                        'journal_accounts.journal_id'=>$journal_id
                    ),

                    array(
                        'journal_accounts.*',
                        'account_titles.account_no',
                        'account_titles.account_title',
                        'departments.department_name'
                    ),

                    array(
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','left'),
                        array('departments','departments.department_id=journal_accounts.department_id','left')
                    )

                );


                //show only inside grid with menu button
                if($type=='fullview'||$type==null){
                    echo $this->load->view('template/crj_journal_entries_content',$data,TRUE);
                    echo $this->load->view('template/crj_journal_entries_content_menus',$data,TRUE);
                }

                //download pdf
                if($type=='pdf'){
                    $file_name=$journal_info[0]->txn_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/crj_journal_entries_content',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output($pdfFilePath,"D");



                }

                //preview on browser
                if($type=='preview'){
                    $file_name=$journal_info[0]->txn_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/crj_journal_entries_content',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                }

                break;

            case 'journal-gje':
                $m_journal_info=$this->Journal_info_model;
                $m_company=$this->Company_model;
                $journal_id=$this->input->get('id',TRUE);
                $type=$this->input->get('type',TRUE);

                $company_info=$m_company->get_list();
                $journal_info=$m_journal_info->get_list(

                    "journal_info.book_type='GJE' AND journal_info.journal_id=$journal_id",

                    array(
                        'journal_info.journal_id',
                        'journal_info.txn_no',
                        'DATE_FORMAT(journal_info.date_txn,"%m/%d/%Y")as date_txn',
                        'journal_info.is_active',
                        'journal_info.remarks',
                        'journal_info.ref_no',
                        'journal_info.check_no',
                        'journal_info.check_date',
                        'journal_info.amount',
                        'journal_info.cancel_reason',
                        'CONCAT_WS(" ",IFNULL(customers.customer_name,""),IFNULL(suppliers.supplier_name,"")) as particular',
                        'CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by'
                    ),

                    array(
                        array('customers','customers.customer_id=journal_info.customer_id','left'),
                        array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
                        array('user_accounts','user_accounts.user_id=journal_info.created_by_user','left')
                    )

                );

                $data['company_info']=$company_info[0];
                $data['journal_info']=$journal_info[0];

                $m_journal_accounts=$this->Journal_account_model;
                $data['journal_accounts']=$m_journal_accounts->get_list(

                    array(
                        'journal_accounts.journal_id'=>$journal_id
                    ),

                    array(
                        'journal_accounts.*',
                        'account_titles.account_no',
                        'account_titles.account_title',
                        'departments.department_name'

                    ),

                    array(
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','left'),
                        array('departments','departments.department_id=journal_accounts.department_id','left')
                    )

                );


                //show only inside grid with menu button
                if($type=='fullview'||$type==null){
                    echo $this->load->view('template/gje_journal_entries_content',$data,TRUE);
                    echo $this->load->view('template/gje_journal_entries_content_menus',$data,TRUE);
                }

                //download pdf
                if($type=='pdf'){
                    $file_name=$journal_info[0]->txn_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/gje_journal_entries_content',$data,TRUE); //load the template
                    // $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output($pdfFilePath,"D");
                }

                //preview on browser
                if($type=='preview'){
                    $file_name=$journal_info[0]->txn_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/gje_journal_entries_content',$data,TRUE); //load the template
                    // $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                }

                break;


            case 'issuance-gje-for-review':
                $issuance_id=$this->input->get('id',TRUE);
                $m_issuance_model=$this->Issuance_model;
                $m_pur_int_model=$this->Purchasing_integration_model;
                $m_issuance_item_model=$this->Issuance_item_model;
                $m_suppliers=$this->Suppliers_model;
                $m_accounts=$this->Account_title_model;
                $m_departments=$this->Departments_model;



                $issuance_info=$m_issuance_model->get_list($issuance_id,
                    'issuance_info.*,
                    DATE_FORMAT(issuance_info.date_issued,"%m/%d/%Y")as date_issued,
                    CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by
                    ',
                    array(
                        array('user_accounts','user_accounts.user_id=issuance_info.posted_by_user','left')
                    )


                    );
                $supplier_id = $m_pur_int_model->get_list(null,'purchasing_integration.iss_supplier_id,suppliers.*',
                    array(array('suppliers','suppliers.supplier_id=purchasing_integration.iss_supplier_id','left'))
                    );

                $data['issuance_info']=$issuance_info[0];

                $data['departments']=$m_departments->get_list('is_active=TRUE AND is_deleted=FALSE');

                $data['suppliers']=$m_suppliers->get_list(
                    array(
                        'suppliers.is_active'=>TRUE,
                        'suppliers.is_deleted'=>FALSE
                    ),

                    array(
                        'suppliers.supplier_id',
                        'suppliers.supplier_name'
                    )
                );

                $data['entries']=$m_issuance_model->get_journal_entries_2($issuance_id);
                $data['accounts']=$m_accounts->get_list(
                    array(
                        'account_titles.is_active'=>TRUE,
                        'account_titles.is_deleted'=>FALSE
                    )
                );

                $data['customers']=$this->Customers_model->get_list(
                    array(
                        'customers.is_active'=>TRUE,
                        'customers.is_deleted'=>FALSE
                    ),

                    array(
                        'customers.customer_id',
                        'customers.customer_name'
                    )
                );
                $data['items']=$m_issuance_item_model->get_list(array('issuance_items.issuance_id'=>$issuance_id),
                    'issuance_items.*,
                    products.product_desc,
                    units.unit_name
                    ',
                    array(array('products','products.product_id=issuance_items.product_id','left'),
                                     array('units','units.unit_id=issuance_items.unit_id','left')
                        )

                    );

                //validate if customer is not deleted
                $valid_supplier=$m_suppliers->get_list(
                    array(
                        'supplier_id'=>$supplier_id[0]->iss_supplier_id,
                        'is_active'=>TRUE,
                        'is_deleted'=>FALSE
                    )
                );
                $data['valid_particular']=(count($valid_supplier)>0);
                $data['supplier_info']=$supplier_id[0];
                echo $this->load->view('template/issuance_for_review',$data,TRUE); //details of the journal


                break;


            case 'adjustment-gje-for-review':
                $adjustment_id=$this->input->get('id',TRUE);
                $m_adjustment=$this->Adjustment_model;
                $m_pur_int_model=$this->Purchasing_integration_model;
                $m_adjustment_items=$this->Adjustment_item_model;
                $m_suppliers=$this->Suppliers_model;
                $m_accounts=$this->Account_title_model;
                $m_departments=$this->Departments_model;



                $adjustment_info=$m_adjustment->get_list($adjustment_id,
                    'adjustment_info.*,
                     DATE_FORMAT(adjustment_info.date_adjusted,"%m/%d/%Y")as date_adjusted,
                    CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by
                    ',
                    array(
                        array('user_accounts','user_accounts.user_id=adjustment_info.posted_by_user','left')
                    ));
                $supplier_id = $m_pur_int_model->get_list(null,'purchasing_integration.adj_supplier_id,suppliers.*',
                    array(array('suppliers','suppliers.supplier_id=purchasing_integration.iss_supplier_id','left'))
                    );



                $data['adjustment_info']=$adjustment_info[0];

                $data['departments']=$m_departments->get_list('is_active=TRUE AND is_deleted=FALSE');

                $data['suppliers']=$m_suppliers->get_list(
                    array(
                        'suppliers.is_active'=>TRUE,
                        'suppliers.is_deleted'=>FALSE
                    ),

                    array(
                        'suppliers.supplier_id',
                        'suppliers.supplier_name'
                    )
                );

                $adjustment_type=$adjustment_info[0]->adjustment_type;

                if($adjustment_type == 'IN'){
                    $data['entries']=$m_adjustment->get_journal_entries_2_in($adjustment_id);

                }else if ($adjustment_type == 'OUT'){
                    $data['entries']=$m_adjustment->get_journal_entries_2($adjustment_id);

                }
                
                $data['accounts']=$m_accounts->get_list(
                    array(
                        'account_titles.is_active'=>TRUE,
                        'account_titles.is_deleted'=>FALSE
                    )
                );

                $data['items']=$m_adjustment_items->get_list(array('adjustment_items.adjustment_id'=>$adjustment_id),
                    'adjustment_items.*,
                    products.product_desc,
                    units.unit_name
                    ',
                    array(array('products','products.product_id=adjustment_items.product_id','left'),
                                     array('units','units.unit_id=adjustment_items.unit_id','left')
                        )

                    );

                //validate if customer is not deleted
                $valid_supplier=$m_suppliers->get_list(
                    array(
                        'supplier_id'=>$supplier_id[0]->adj_supplier_id,
                        'is_active'=>TRUE,
                        'is_deleted'=>FALSE
                    )
                );
                $data['valid_particular']=(count($valid_supplier)>0);
                $data['supplier_info']=$supplier_id[0];
                echo $this->load->view('template/adjustment_for_review',$data,TRUE); //details of the journal


                break;


            case 'ap-journal-for-review':
                $purchase_invoice_id=$this->input->get('id',TRUE);

                $m_suppliers=$this->Suppliers_model;
                $m_accounts=$this->Account_title_model;
                $m_purchases_items=$this->Delivery_invoice_item_model;
                $m_purchases_info=$this->Delivery_invoice_model;
                $m_departments=$this->Departments_model;

                $purchase_info=$m_purchases_info->get_list(
                    array(
                        'delivery_invoice.is_active'=>TRUE,
                        'delivery_invoice.is_deleted'=>FALSE,
                        'delivery_invoice.dr_invoice_id'=>$purchase_invoice_id
                    ),

                    array(
                        'delivery_invoice.dr_invoice_id',
                        'delivery_invoice.purchase_order_id',
                        'delivery_invoice.dr_invoice_no',
                        'delivery_invoice.supplier_id',
                        'delivery_invoice.department_id',
                        'delivery_invoice.external_ref_no',
                        'delivery_invoice.remarks',
                        'delivery_invoice.total_discount',
                        'delivery_invoice.total_before_tax',
                        'delivery_invoice.total_tax_amount',
                        'delivery_invoice.total_after_tax',
                        'delivery_invoice.total_overall_discount',
                        'delivery_invoice.total_overall_discount_amount',
                        'delivery_invoice.total_after_discount',
                        'CONCAT_WS(" ",delivery_invoice.terms,delivery_invoice.duration)as term_description',
                        'DATE_FORMAT(delivery_invoice.date_delivered,"%m/%d/%Y")as date_delivered',
                        'DATE_FORMAT(delivery_invoice.date_created,"%m/%d/%Y %r")as date_created',
                        'suppliers.supplier_name',
                        'suppliers.address',
                        'suppliers.email_address',
                        'suppliers.contact_no',
                        'purchase_order.po_no',
                        'CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by'
                    ),

                    array(
                        array('suppliers','suppliers.supplier_id=delivery_invoice.supplier_id','left'),
                        array('purchase_order','purchase_order.purchase_order_id=delivery_invoice.purchase_order_id','left'),
                        array('user_accounts','user_accounts.user_id=delivery_invoice.posted_by_user','left')
                    )

                );
                $data['purchase_info']=$purchase_info[0];

                $data['departments']=$m_departments->get_list('is_active=TRUE AND is_deleted=FALSE');

                $data['suppliers']=$m_suppliers->get_list(
                    array(
                        'suppliers.is_active'=>TRUE,
                        'suppliers.is_deleted'=>FALSE
                    ),

                    array(
                        'suppliers.supplier_id',
                        'suppliers.supplier_name'
                    )
                );
                $data['entries']=$m_purchases_info->get_journal_entries_2($purchase_invoice_id);
                $data['accounts']=$m_accounts->get_list(
                    array(
                        'account_titles.is_active'=>TRUE,
                        'account_titles.is_deleted'=>FALSE
                    )
                );
                $data['items']=$m_purchases_items->get_list(
                    array(
                        'delivery_invoice_items.dr_invoice_id'=>$purchase_invoice_id
                    ),

                    array(
                        'delivery_invoice_items.*',
                        'products.product_desc',
                        'products.product_code',
                        'units.unit_name',
                        'IFNULL(m.po_price,0) AS po_price'
                    ),

                    array(
                        array('delivery_invoice','delivery_invoice.dr_invoice_id=delivery_invoice_items.dr_invoice_id','left'),
                        array('products','products.product_id=delivery_invoice_items.product_id','left'),
                        array('units','units.unit_id=delivery_invoice_items.unit_id','left'),
                        array('(SELECT po_price,purchase_order_id,product_id FROM purchase_order_items as poi WHERE purchase_order_id='.$purchase_info[0]->purchase_order_id.' GROUP BY poi.product_id) as m','m.purchase_order_id=delivery_invoice.purchase_order_id AND delivery_invoice_items.product_id=m.product_id','left')
                    )

                );

                //validate if customer is not deleted
                $valid_supplier=$m_suppliers->get_list(
                    array(
                        'supplier_id'=>$purchase_info[0]->supplier_id,
                        'is_active'=>TRUE,
                        'is_deleted'=>FALSE
                    )
                );
                $data['valid_particular']=(count($valid_supplier)>0);



                echo $this->load->view('template/ap_journal_for_review',$data,TRUE); //details of the journal


                break;

            case 'ar-journal-for-review':
                $sales_invoice_id=$this->input->get('id',TRUE);

                $m_customers=$this->Customers_model;
                $m_accounts=$this->Account_title_model;
                $m_sales_items=$this->Sales_invoice_item_model;
                $m_sales_invoice=$this->Sales_invoice_model;
                $m_departments=$this->Departments_model;

                $sales_info=$m_sales_invoice->get_list(
                    array(
                        'sales_invoice.is_active'=>TRUE,
                        'sales_invoice.is_deleted'=>FALSE,
                        'sales_invoice.sales_invoice_id'=>$sales_invoice_id
                    ),

                    array(
                        'sales_invoice.sales_invoice_id',
                        'sales_invoice.sales_inv_no',
                        'sales_invoice.customer_id',
                        'sales_invoice.department_id',
                        'sales_invoice.remarks',
                        'sales_invoice.total_discount',
                        'sales_invoice.total_before_tax',
                        'sales_invoice.total_tax_amount',
                        'sales_invoice.total_after_tax',
                        'sales_invoice.total_overall_discount_amount',
                        'sales_invoice.total_after_discount',
                        'DATE_FORMAT(sales_invoice.date_invoice,"%m/%d/%Y")as date_invoice',
                        'DATE_FORMAT(sales_invoice.date_created,"%m/%d/%Y %r")as date_created',
                        'customers.customer_name',
                        'customers.address',
                        'customers.email_address',
                        'customers.contact_no',
                        'sales_order.so_no',
                        'CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by'
                    ),

                    array(
                        array('customers','customers.customer_id=sales_invoice.customer_id','left'),
                        array('sales_order','sales_order.sales_order_id=sales_invoice.sales_order_id','left'),
                        array('user_accounts','user_accounts.user_id=sales_invoice.posted_by_user','left')
                    )

                );
                $data['sales_info']=$sales_info[0];

                $data['departments']=$m_departments->get_list(array('is_active'=>TRUE,'is_deleted'=>FALSE));

                $data['customers']=$m_customers->get_list(
                    array(
                        'customers.is_active'=>TRUE,
                        'customers.is_deleted'=>FALSE
                    ),

                    array(
                        'customers.customer_id',
                        'customers.customer_name'
                    )
                );
                $data['entries']=$m_sales_invoice->get_journal_entries_2($sales_invoice_id);
                $data['accounts']=$m_accounts->get_list(
                    array(
                        'account_titles.is_active'=>TRUE,
                        'account_titles.is_deleted'=>FALSE
                    )
                );
                $data['items']=$m_sales_items->get_list(
                    array(
                        'sales_invoice_items.sales_invoice_id'=>$sales_invoice_id
                    ),

                    array(
                        'sales_invoice_items.*',
                        'products.product_desc'
                    ),

                    array(
                        array('products','products.product_id=sales_invoice_items.product_id','left')
                    )

                );


                //validate if customer is not deleted
                $valid_customer=$m_customers->get_list(
                    array(
                        'customer_id'=>$sales_info[0]->customer_id,
                        'is_active'=>TRUE,
                        'is_deleted'=>FALSE
                    )
                );
                $data['valid_particular']=(count($valid_customer)>0);





                echo $this->load->view('template/ar_journal_for_review',$data,TRUE); //details of the journal


                break;

            case 'user-rights':
                $m_rights=$this->User_group_right_model;

                $id=$this->input->get('id',TRUE);

                $data['rights']=$m_rights->get_user_group_rights($id);
                $data['user_group_id']=$id;

                $this->load->view('template/user_group_rights',$data);
                break;

            case 'balance-sheet':
                $type=$this->input->get('type',TRUE);
                //asset account
                $data['asset_classes']=$this->Journal_account_model->get_list(
                    array(
                        'account_classes.account_type_id'=>1 //1 is asset
                    ),
                    'journal_accounts.account_id,account_classes.account_class_id,account_classes.account_class,account_classes.account_type_id',
                    array(
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','inner'),
                        array('account_classes','account_classes.account_class_id=account_titles.account_class_id','inner')
                    ),
                    null,
                    'account_classes.account_class_id'
                );
                $data['asset_accounts']=$this->Journal_info_model->get_account_balance(1);



                //liabilities account
                $data['liability_classes']=$this->Journal_account_model->get_list(
                    array(
                        'account_classes.account_type_id'=>2 //1 is asset
                    ),
                    'journal_accounts.account_id,account_classes.account_class_id,account_classes.account_class,account_classes.account_type_id',
                    array(
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','inner'),
                        array('account_classes','account_classes.account_class_id=account_titles.account_class_id','inner')
                    ),
                    null,
                    'account_classes.account_class_id'
                );
                $data['liability_accounts']=$this->Journal_info_model->get_account_balance(2);



                //capital account
                $data['capital_classes']=$this->Journal_account_model->get_list(
                    array(
                        'account_classes.account_type_id'=>3 //1 is asset
                    ),
                    'journal_accounts.account_id,account_classes.account_class_id,account_classes.account_class,account_classes.account_type_id',
                    array(
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','inner'),
                        array('account_classes','account_classes.account_class_id=account_titles.account_class_id','inner')
                    ),
                    null,
                    'account_classes.account_class_id'
                );
                $data['capital_accounts']=$this->Journal_info_model->get_account_balance(3);


                $current_year_income=$this->Journal_account_model->get_list(
                    array(
                        'account_classes.account_type_id'=>4 //1 is asset
                    ),
                    '(SUM(journal_accounts.cr_amount)-SUM(journal_accounts.dr_amount))as current_year_earning',
                    array(
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','inner'),
                        array('account_classes','account_classes.account_class_id=account_titles.account_class_id','inner')
                    )
                );


                $current_year_expense=$this->Journal_account_model->get_list(
                    array(
                        'account_classes.account_type_id'=>5 //1 is asset
                    ),
                    '(SUM(journal_accounts.dr_amount)-SUM(journal_accounts.cr_amount))as current_year_expense',
                    array(
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','inner'),
                        array('account_classes','account_classes.account_class_id=account_titles.account_class_id','inner')
                    )
                );


                $data['current_year_earnings']=$current_year_income[0]->current_year_earning-$current_year_expense[0]->current_year_expense;


                //download pdf
                if($type=='pdf'){
                    $file_name=date('Y-m-d');
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/balance_sheet_report',$data,TRUE);
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output($pdfFilePath,"D");
                }

                //preview on browser
                if($type=='preview'){
                    $file_name=date('Y-m-d');
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/balance_sheet_report',$data,TRUE);
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                }



                break;
            case 'income-statement-per-field':
                $type=$this->input->get('type',TRUE);
                $start=$this->input->get('start',TRUE);
                $end=$this->input->get('end',TRUE);
                $depid=$this->input->get('depid',TRUE);

                if($depid==1){$depid=null;}

                $data['income_accounts']=$this->Journal_info_model->get_account_balance_per_line(4,$depid,date("Y-m-d",strtotime($start)),date("Y-m-d",strtotime($end)));
                $data['expense_accounts']=$this->Journal_info_model->get_account_balance_per_line(5,$depid,date("Y-m-d",strtotime($start)),date("Y-m-d",strtotime($end)));

                $m_company=$this->Company_model;
                $company=$m_company->get_list();

                $data['company_info']=$company[0];

                $m_departments=$this->Departments_model;
                $departments=$m_departments->get_list($depid);

                $data['departments']=$departments[0]->department_name;


                $data['start']=date("m/d/Y",strtotime($start));
                $data['end']=date("m/d/Y",strtotime($end));

                //download pdf
                /*if($type=='pdf'){
                    $file_name=date('Y-m-d');
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/income_statement_report',$data,TRUE);
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output($pdfFilePath,"D");
                }

                //preview on browser
                if($type=='preview'){
                    $file_name=date('Y-m-d');
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/income_statement_report',$data,TRUE);
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                }*/

                if($type==null|$type=='preview'){
                    $this->load->view('template/income_statement_report_per_line',$data);
                }


                break;

            case 'income-statement':
                $type=$this->input->get('type',TRUE);
                $start=$this->input->get('start',TRUE);
                $end=$this->input->get('end',TRUE);
                $depid=$this->input->get('depid',TRUE);

                if($depid==1){$depid=null;}

                $data['income_accounts']=$this->Journal_info_model->get_account_balance(4,$depid,date("Y-m-d",strtotime($start)),date("Y-m-d",strtotime($end)));
                $data['expense_accounts']=$this->Journal_info_model->get_account_balance(5,$depid,date("Y-m-d",strtotime($start)),date("Y-m-d",strtotime($end)));

                $m_company=$this->Company_model;
                $company=$m_company->get_list();

                $data['company_info']=$company[0];

                $m_departments=$this->Departments_model;
                $departments=$m_departments->get_list($depid);

                $data['departments']=$departments[0]->department_name;


                $data['start']=date("m/d/Y",strtotime($start));
                $data['end']=date("m/d/Y",strtotime($end));

                //download pdf
                /*if($type=='pdf'){
                    $file_name=date('Y-m-d');
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/income_statement_report',$data,TRUE);
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output($pdfFilePath,"D");
                }

                //preview on browser
                if($type=='preview'){
                    $file_name=date('Y-m-d');
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/income_statement_report',$data,TRUE);
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                }*/

                if($type==null|$type=='preview'){
                    $this->load->view('template/income_statement_report',$data);
                }




                break;

            case 'sr':
                $m_sales_report=$this->Sales_invoice_model;
                $m_customers=$this->Customers_model;
                $customerid=$this->input->get('customerid',TRUE);
                $type=$this->input->get('type',TRUE);
                $start=$this->input->get('start',TRUE);
                $end=$this->input->get('end',TRUE);
                $data['sales_report']=$m_sales_report->get_list(

                    'sales_invoice.is_deleted=FALSE
                    AND sales_invoice.is_active=TRUE'.
                    
                    ($customerid == 'All' ? '' : ' AND sales_invoice.customer_id='.$customerid)." AND sales_invoice.date_invoice BETWEEN '".$start."' AND '".$end."'",

                    'sales_invoice.date_invoice,sales_invoice.sales_inv_no,sales_invoice.sales_order_no,customers.customer_name,sales_invoice_items.inv_line_total_price',

                    array(
                        array('customers','sales_invoice.customer_id=customers.customer_id','left'),
                        array('sales_invoice_items','sales_invoice.sales_invoice_id=sales_invoice_items.sales_invoice_id','left')
                    )

                );

                if ($type =='All') {
                    echo $this->load->view('template/sales_report_content',$data,TRUE);
                }

                //show only inside grid with menu button
                if ($type=='fullview'||$type==null) {
                    echo $this->load->view('template/sales_report_content',$data,TRUE);
                }

                //show only inside grid without menu button
                if ($type=='contentview') {
                    echo $this->load->view('template/sales_report_content',$data,TRUE);
                }

                //download pdf
                if($type=='pdf') {
                    $file_name=$data['sales_report']->sales_inv_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/sales_report_content_pdf',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output($pdfFilePath,"D");

                }

                //preview on browser
                if($type=='preview') {
                    $file_name=$data['sales_report']->sales_inv_no;
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/sales_report_content_pdf',$data,TRUE); //load the template
                    $pdf->setFooter('{PAGENO}');
                    $pdf->WriteHTML($content);
                    //download it.
                    $pdf->Output();
                }

            break;

            case 'collection-for-review':
                $payment_id=$this->input->get('id',TRUE);

                $m_customers=$this->Customers_model;
                $m_accounts=$this->Account_title_model;
                $m_payments=$this->Receivable_payment_model;
                $m_methods=$this->Payment_method_model;
                $m_departments=$this->Departments_model;
                $m_pay_list=$this->Receivable_payment_list_model;

                $payment_info=$m_payments->get_list(
                    $payment_id,
                    array(
                        'receivable_payments.*',
                        'DATE_FORMAT(receivable_payments.date_paid,"%m/%d/%Y") as payment_date',
                        'DATE_FORMAT(receivable_payments.check_date,"%m/%d/%Y") as date_check',
                        'DATEDIFF(receivable_payments.check_date,NOW()) as rem_day_for_due',
                        'departments.department_name',
                        'customers.customer_name',
                        'payment_methods.payment_method'
                    ),

                    array(
                        array('departments','departments.department_id=receivable_payments.department_id','left'),
                        array('customers','customers.customer_id=receivable_payments.customer_id','left'),
                        array('payment_methods','payment_methods.payment_method_id=receivable_payments.payment_method_id','left')
                    )
                );
                $data['payment_info']=$payment_info[0];



                $data['methods']=$m_methods->get_list();
                $data['departments']=$m_departments->get_list(
                    array(
                        'departments.is_active'=>TRUE,
                        'departments.is_deleted'=>FALSE
                    ));

                $data['customers']=$m_customers->get_list(
                    array(
                        'customers.is_active'=>TRUE,
                        'customers.is_deleted'=>FALSE
                    ),

                    array(
                        'customers.customer_id',
                        'customers.customer_name'
                    )
                );
                $data['entries']=$m_payments->get_journal_entries($payment_id);

                $data['accounts']=$m_accounts->get_list(
                    array(
                        'account_titles.is_active'=>TRUE,
                        'account_titles.is_deleted'=>FALSE
                    )
                );


                $data['payments_list']=$m_pay_list->get_list(

                    array('payment_id'=>$payment_id),

                    array(
                        'receivable_payments_list.*',
                        'journal_info.*'

                    ),
                    array(
                        array('journal_info','journal_info.journal_id=receivable_payments_list.journal_id','left'),
                    )

                );


                //validate if customer is not deleted
                $valid_customer=$m_customers->get_list(
                    array(
                        'customer_id'=>$payment_info[0]->customer_id,
                        'is_active'=>TRUE,
                        'is_deleted'=>FALSE
                    )
                );
                $data['valid_particular']=(count($valid_customer)>0);

                echo $this->load->view('template/collection_journal_for_review',$data,TRUE); //details of the journal


                break;

            case 'cash-for-review':
                $cash_invoice_id=$this->input->get('id',TRUE);

                $m_cash_invoice =  $this->Cash_invoice_model;
                $m_cash_invoice_items =  $this->Cash_invoice_items_model;



                $m_customers=$this->Customers_model;
                $m_accounts=$this->Account_title_model;
                $m_payments=$this->Receivable_payment_model;
                $m_methods=$this->Payment_method_model;
                $m_departments=$this->Departments_model;
                $m_pay_list=$this->Receivable_payment_list_model;

                $info=$m_cash_invoice->get_list($cash_invoice_id,
                array(
                'cash_invoice.*',
                'DATE_FORMAT(cash_invoice.date_invoice,"%m/%d/%Y") as date_invoice',
                'DATE_FORMAT(cash_invoice.date_due,"%m/%d/%Y") as date_due',
                'departments.department_id',
                'departments.department_name',
                'customers.customer_name',
                'cash_invoice.salesperson_id',
                'cash_invoice.address',
                'sales_order.so_no'
            ),
                array(
                    array('departments','departments.department_id=cash_invoice.department_id','left'),
                    array('customers','customers.customer_id=cash_invoice.customer_id','left'),
                    array('sales_order','sales_order.sales_order_id=cash_invoice.sales_order_id','left'),
                ),
                'cash_invoice.cash_invoice_id DESC'
            );
                $data['info']=$info[0];



                $data['methods']=$m_methods->get_list();
                $data['departments']=$m_departments->get_list(array('is_active'=>TRUE,'is_deleted'=>FALSE));

                $data['customers']=$m_customers->get_list(
                    array(
                        'customers.is_active'=>TRUE,
                        'customers.is_deleted'=>FALSE
                    ),

                    array(
                        'customers.customer_id',
                        'customers.customer_name'
                    )
                );
                $data['entries']=$m_cash_invoice->get_journal_entries($cash_invoice_id);

                $data['accounts']=$m_accounts->get_list(
                    array(
                        'account_titles.is_active'=>TRUE,
                        'account_titles.is_deleted'=>FALSE
                    )
                );

                $data['items'] = $m_cash_invoice_items->get_list(
                    array('cash_invoice_id'=>$cash_invoice_id),
                    array(
                        'cash_invoice_items.*',
                        'products.product_code',
                        'products.product_desc',
                        'units.unit_id',
                        'units.unit_name'
                    ),
                    array(
                        array('products','products.product_id=cash_invoice_items.product_id','left'),
                        array('units','units.unit_id=cash_invoice_items.unit_id','left')
                    ),
                    'cash_invoice_items.cash_item_id ASC'
                );

                //validate if customer is not deleted
                $valid_customer=$m_customers->get_list(
                    array(
                        'customer_id'=>$info[0]->customer_id,
                        'is_active'=>TRUE,
                        'is_deleted'=>FALSE
                    )
                );
                $data['valid_particular']=(count($valid_customer)>0);

                echo $this->load->view('template/cash_journal_for_review',$data,TRUE); //details of the journal


                break;


            case 'expense-for-review':
                $payment_id=$this->input->get('id',TRUE);

                $m_suppliers=$this->Suppliers_model;
                $m_accounts=$this->Account_title_model;
                $m_payments=$this->Payable_payment_model;
                $m_methods=$this->Payment_method_model;
                $m_departments=$this->Departments_model;
                $m_pay_list=$this->Payable_payment_list_model;

                $payment_info=$m_payments->get_list(
                    $payment_id,
                    array(
                        'payable_payments.*',
                        'DATE_FORMAT(payable_payments.date_paid,"%m/%d/%Y") as payment_date',
                        'DATE_FORMAT(payable_payments.check_date,"%m/%d/%Y") as date_check',
                        'DATEDIFF(payable_payments.check_date,NOW()) as rem_day_for_due',
                        'departments.department_name',
                        'suppliers.supplier_name',
                        'payment_methods.payment_method'
                    ),

                    array(
                        array('departments','departments.department_id=payable_payments.department_id','left'),
                        array('suppliers','suppliers.supplier_id=payable_payments.supplier_id','left'),
                        array('payment_methods','payment_methods.payment_method_id=payable_payments.payment_method_id','left')
                    )
                );
                $data['payment_info']=$payment_info[0];



                $data['methods']=$m_methods->get_list();
                $data['departments']=$m_departments->get_list();

                $data['suppliers']=$m_suppliers->get_list(
                    array(
                        'is_active'=>TRUE,
                        'is_deleted'=>FALSE
                    ),

                    array(
                        'suppliers.supplier_id',
                        'suppliers.supplier_name'
                    )
                );
                $data['entries']=$m_payments->get_journal_entries($payment_id);

                $data['accounts']=$m_accounts->get_list(
                    array(
                        'account_titles.is_active'=>TRUE,
                        'account_titles.is_deleted'=>FALSE
                    )
                );


                $data['payments_list']=$m_pay_list->get_list(

                    array('payment_id'=>$payment_id),

                    array(
                        'payable_payments_list.*',
                        'delivery_invoice.dr_invoice_no',
                        'IF(delivery_invoice.remarks = "",journal_info.remarks, delivery_invoice.remarks) as remarks',
                        'delivery_invoice.terms',
                        'DATE_FORMAT(delivery_invoice.date_delivered,"%m/%d/%Y") as delivered_date',
                        'DATE_FORMAT(delivery_invoice.date_due,"%m/%d/%Y") as due_date',
                        'IFNULL(journal_info.ref_no, journal_info.txn_no) as dr_invoice_no'
                    ),
                    array(
                        
                        array('journal_info','journal_info.journal_id=payable_payments_list.dr_invoice_id','left'),
                        array('delivery_invoice','delivery_invoice.dr_invoice_no=journal_info.ref_no','left'),
                    )

                );

                //validate if customer is not deleted
                $valid_supplier=$m_suppliers->get_list(
                    array(
                        'supplier_id'=>$payment_info[0]->supplier_id,
                        'is_active'=>TRUE,
                        'is_deleted'=>FALSE
                    )
                );
                $data['valid_particular']=(count($valid_supplier)>0);
                $data['doc_types']=$this->Doc_types_model->get_list('is_deleted=0 AND is_active = 1');
                echo $this->load->view('template/expense_journal_for_review',$data,TRUE); //details of the journal


                break;

            case 'inventory':
                $m_products=$this->Products_model;
                $type=$this->input->get('type',TRUE);
                $date=$this->input->get('date',TRUE);
                $format=$this->input->get('format',TRUE);

                if($type=='preview') {
                   

                    if($format==2){
                        $data['date']=$date;
                        $data['products']=$m_products->get_all_items_inventory(date('Y-m-d',strtotime($date)));
                        $this->load->view('template/batch_inventory_report',$data); //load the template
                    }else{
                        $data['date']=$date;

                        $data['prod_types']=$this->Refproduct_model->get_list('refproduct_id=1 OR refproduct_id=2');
                        $data['products']=$m_products->get_all_items_inventory(date('Y-m-d',strtotime($date)));
                        $this->load->view('template/batch_inventory_per_type_report',$data); //load the template
                    }

                    
                }

                break;

            /*case 'print-check':
                $check_layout_id=$this->input->get('id',TRUE);
                $journal_id=$this->input->get('jid',TRUE);

                $m_layout=$this->Check_layout_model;
                $layout_info=$m_layout->get_list(array('check_layout_id'=>$check_layout_id));
                $layouts=$layout_info[0];

                $data['layouts']=$layouts;
                $data['title']="Print Check";

                $m_journal_info=$this->Journal_info_model;
                $check_info=$m_journal_info->get_list($journal_id,

                    array(
                        'journal_info.*',
                        'suppliers.supplier_name'
                    )

                    ,
                    array(
                        array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left')
                    )
                );

                $data['num_words']=$this->convertDecimalToWords($check_info[0]->amount);
                $data['check_info']=$check_info[0];


                $this->load->view('template/check_view',$data); //load the template




                break;*/

            case 'print-check':
                $check_layout_id=$this->input->get('id',TRUE);
                $journal_id=$this->input->get('jid',TRUE);

                $m_layout=$this->Check_layout_model;
                $layout_info=$m_layout->get_list(array('check_layout_id'=>$check_layout_id));
                $layouts=$layout_info[0];

                $data['layouts']=$layouts;
                $data['title']="Print Check";

                $m_journal_info=$this->Journal_info_model;

                $m_journal_info->check_status=1; //mark as issued
                $m_journal_info->modify($journal_id);

                $check_info=$m_journal_info->get_list($journal_id,

                    array(
                        'journal_info.*',
                        'suppliers.supplier_name'
                    )
                    ,
                    array(
                        array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left')
                    )
                );

                $data['num_words']=$this->convertDecimalToWords($check_info[0]->amount);
                $data['check_info']=$check_info[0];


                $this->load->view('template/check_view',$data); //load the template




                break;

            case 'customer-subsidiary' :
                $type=$this->input->get('type',TRUE);
                $customer_Id=$this->input->get('customerId',TRUE);
                $account_Id=$this->input->get('accountId',TRUE);
                $start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
                $end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));

                $m_customer_subsidiary=$this->Customer_subsidiary_model;
                $m_company_info=$this->Company_model;
                $m_journal_info=$this->Journal_info_model;

                $journal_info=$m_journal_info->get_list(
                    array('journal_info.is_deleted'=>FALSE, 'journal_info.customer_id'=>$customer_Id, 'journal_accounts.account_id'=>$account_Id),
                    'customer_name, account_title',
                    array(
                        array('customers','customers.customer_id=journal_info.customer_id','left'),
                        array('journal_accounts','journal_accounts.journal_id=journal_info.journal_id','left'),
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','left')
                    )
                );

                $company_info=$m_company_info->get_list();

                $data['company_info']=$company_info[0];
                $data['subsidiary_info']=$journal_info[0];
                $data['customer_subsidiary']=$m_customer_subsidiary->get_customer_subsidiary($customer_Id,$account_Id,$start_Date,$end_Date);

                if ($type == 'preview' || $type == null) {
                    $pdf = $this->m_pdf->load("A4-L");
                    $content=$this->load->view('template/customer_subsidiary_report',$data,TRUE);
                }

                $pdf->setFooter('{PAGENO}');
                $pdf->WriteHTML($content);
                $pdf->Output();
                break;

            case 'supplier-subsidiary' :
                $type=$this->input->get('type',TRUE);
                $supplier_Id=$this->input->get('supplierId',TRUE);
                $account_Id=$this->input->get('accountId',TRUE);
                $start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
                $end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));

                $m_journal_info=$this->Journal_info_model;
                $m_company_info=$this->Company_model;

                $journal_info=$m_journal_info->get_list(
                    array('journal_info.is_deleted'=>FALSE, 'journal_info.supplier_id'=>$supplier_Id, 'journal_accounts.account_id'=>$account_Id),
                    'supplier_name, account_title',
                    array(
                        array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
                        array('journal_accounts','journal_accounts.journal_id=journal_info.journal_id','left'),
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','left')
                    )
                );

                $company_info=$m_company_info->get_list();

                $data['company_info']=$company_info[0];
                if (isset($journal_info[0])) 
                {

                    $data['supplier_subsidiary']=$m_journal_info->get_supplier_subsidiary($supplier_Id,$account_Id,$start_Date,$end_Date);
                    $data['company_info']=$company_info[0];
                    $data['subsidiary_info']=$journal_info[0];

                $pdf = $this->m_pdf->load("A4-L");
                $content=$this->load->view('template/supplier_subsidiary_report',$data,TRUE);
                $pdf->setFooter('{PAGENO}');
                $pdf->WriteHTML($content);
                $pdf->Output();


                   # $this->load->view('template/supplier_subsidiary_report',$data);
                } else {
                    echo '<center style="font-family: Arial, sans-serif;"><h1 style="color:#2196f3">Information</h1><hr><h3>No record associated to this supplier.</h3></center>';
                }
               
                    

                
                /*if ($type == 'preview' || $type == null) {
                    $pdf = $this->m_pdf->load("A4-L");
                    $content=$this->load->view('template/supplier_subsidiary_report',$data,TRUE);
                }

                $pdf->setFooter('{PAGENO}');
                $pdf->WriteHTML($content);
                $pdf->Output();*/
                break;

            case 'account-subsidiary' :
                $type=$this->input->get('type',TRUE);
                $account_Id=$this->input->get('accountId',TRUE);
                $start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
                $end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));

                $m_journal_info=$this->Journal_info_model;
                $m_company_info=$this->Company_model;

                $journal_info=$m_journal_info->get_list(
                    array('journal_info.is_deleted'=>FALSE, 'journal_accounts.account_id'=>$account_Id),
                    'supplier_name, customer_name, account_title',
                    array(
                        array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
                        array('customers','customers.customer_id=journal_info.customer_id','left'),
                        array('journal_accounts','journal_accounts.journal_id=journal_info.journal_id','left'),
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','left')
                    )
                );

                $company_info=$m_company_info->get_list();

                $data['company_info']=$company_info[0];
                $data['subsidiary_info']=$journal_info[0];
                $data['supplier_subsidiary']=$m_journal_info->get_account_subsidiary($account_Id,$start_Date,$end_Date);

                if ($type == 'preview' || $type == null) {
                    $pdf = $this->m_pdf->load("A4-L");
                    $content=$this->load->view('template/account_subsidiary_report',$data,TRUE);
                }

                $pdf->setFooter('{PAGENO}');
                $pdf->WriteHTML($content);
                $pdf->Output();


                exit;
                 $this->load->view('template/account_subsidiary_report',$data);
            break;

//EXPORT TO EXCEL 

            case 'account-payable-schedule-export':
     
                $excel=$this->excel;
                $m_company_info=$this->Company_model;

                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $m_journal_accounts=$this->Journal_account_model;

                $account_id=$this->input->get('account_id');
                $date=$this->input->get('date');

                $data['date']=date('m/d/Y',strtotime($date));
                $ar_accounts=$m_journal_accounts->get_account_schedule($account_id,$date,'S');

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');

                //name the worksheet

                $excel->getActiveSheet()
                        ->getStyle('A1:D1')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

                $excel->getActiveSheet()
                        ->getStyle('A2:D2')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

                $excel->getActiveSheet()
                        ->getStyle('A3:D3')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

                $excel->getActiveSheet()->setTitle("AP Schedule Report");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:D1');
                $excel->getActiveSheet()->mergeCells('A2:D2');
                $excel->getActiveSheet()->mergeCells('A3:D3');
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no); 


                $excel->getActiveSheet()
                        ->getStyle('A5:D5')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

                $excel->getActiveSheet()->getColumnDimensionByColumn('A5:D5')->setWidth('40');                                          
                $excel->getActiveSheet()->mergeCells('A5:D5');
                $excel->getActiveSheet()->setCellValue('A5','As of Date '.$date);


                $excel->getActiveSheet()
                        ->getStyle('A7:D7')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

                $excel->getActiveSheet()->getColumnDimensionByColumn('A7:D7')->setWidth('40');                                          
                $excel->getActiveSheet()->mergeCells('A7:D7');
                $excel->getActiveSheet()->setCellValue('A7','Accounts Payable Schedule')
                                        ->getStyle('A7')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');

                $excel->getActiveSheet()
                        ->getStyle('B')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()
                        ->getStyle('C')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()
                        ->getStyle('D')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A9','Customer')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Previous')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','This Month')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Total')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);   

                $i=10;
                $total=0.00; 
                foreach($ar_accounts as $ar){
                    $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
                    $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');

                    $excel->getActiveSheet()
                            ->getStyle('B')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $excel->getActiveSheet()
                            ->getStyle('C')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $excel->getActiveSheet()
                            ->getStyle('D')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 

                    $excel->getActiveSheet()->setCellValue('A'.$i,$ar->supplier_name);
                    $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                    
                    $excel->getActiveSheet()->setCellValue('B'.$i,number_format($ar->previous,2));
                    $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                        
                    $excel->getActiveSheet()->setCellValue('C'.$i,number_format($ar->current,2));
                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                        
                    $excel->getActiveSheet()->setCellValue('D'.$i,number_format($ar->total,2));

                    $i++;
                    $total+=$ar->total;
                }
                    
                    $excel->getActiveSheet()
                            ->getStyle('A')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->mergeCells('A'.$i.':'.'C'.$i);    
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Total:')
                                            ->getStyle('A'.$i)->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                        
                    $excel->getActiveSheet()->setCellValue('D'.$i,number_format($total,2))
                                            ->getStyle('D'.$i)->getFont()->setBold(TRUE);


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Accounts Payable Schedule Report.xlsx".'');
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

            case 'supplier-subsidiary-export' :
                $excel=$this->excel;
                $type=$this->input->get('type',TRUE);
                $supplier_Id=$this->input->get('supplierId',TRUE);
                $account_Id=$this->input->get('accountId',TRUE);
                $start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
                $end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));

                $m_journal_info=$this->Journal_info_model;
                $m_company_info=$this->Company_model;

                $journal_info=$m_journal_info->get_list(
                    array('journal_info.is_deleted'=>FALSE, 'journal_info.supplier_id'=>$supplier_Id, 'journal_accounts.account_id'=>$account_Id),
                    'supplier_name, account_title',
                    array(
                        array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
                        array('journal_accounts','journal_accounts.journal_id=journal_info.journal_id','left'),
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','left')
                    )
                );

                $company_info=$m_company_info->get_list();

                $data['company_info']=$company_info[0];
                if (isset($journal_info[0])) 
                {

                    $supplier_subsidiary=$m_journal_info->get_supplier_subsidiary($supplier_Id,$account_Id,$start_Date,$end_Date);
                    $data['company_info']=$company_info[0];
                    $subsidiary_info=$journal_info[0];

                    $excel->setActiveSheetIndex(0);

                    $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('50');

                    //name the worksheet
                    $excel->getActiveSheet()->setTitle("SUPPLIER SUBSIDIARY REPORT");
                    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->mergeCells('A1:B1');
                    $excel->getActiveSheet()->mergeCells('A2:C2');
                    $excel->getActiveSheet()->mergeCells('A3:B3');
                    $excel->getActiveSheet()->mergeCells('A4:B4');
                    $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                            ->setCellValue('A2',$company_info[0]->company_address)
                                            ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                            ->setCellValue('A4',$company_info[0]->email_address);

                    $excel->getActiveSheet()->setCellValue('A6','PERIOD : '.$start_Date.' to '.$end_Date)
                                            ->getStyle('A6')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->setCellValue('A8','SUPPLIER SUBSIDIARY REPORT')
                                            ->getStyle('A8')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->mergeCells('A10:D10');
                    $excel->getActiveSheet()->setCellValue('A10','Supplier: '.$subsidiary_info->supplier_name)
                                            ->getStyle('A10')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->mergeCells('E10:H10');
                    $excel->getActiveSheet()->setCellValue('E10','Account: '.$subsidiary_info->account_title)
                                            ->getStyle('E10')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->getColumnDimension('A')->setWidth('25');
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');
                    $excel->getActiveSheet()->getColumnDimension('D')->setWidth('40');
                    $excel->getActiveSheet()->getColumnDimension('E')->setWidth('40');
                    $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');

                    $excel->getActiveSheet()
                            ->getStyle('A12')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                   
                     $excel->getActiveSheet()
                            ->getStyle('B12')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                                                           
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

                    $excel->getActiveSheet()->setCellValue('A12','Txn Date')
                                            ->getStyle('A12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('B12','Txn #')
                                            ->getStyle('B12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('C12','Memo')
                                            ->getStyle('C12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('D12','Remarks')
                                            ->getStyle('D12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('E12','Posted by')
                                            ->getStyle('E12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('F12','Debit')
                                            ->getStyle('F12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('G12','Credit')
                                            ->getStyle('G12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('H12','Balance')
                                            ->getStyle('H12')->getFont()->setBold(TRUE);

                    $i=13;

                    foreach($supplier_subsidiary as $items){
                        $excel->getActiveSheet()->setCellValue('A'.$i,$items->date_txn);
                        $excel->getActiveSheet()->setCellValue('B'.$i,$items->txn_no);
                        $excel->getActiveSheet()->setCellValue('C'.$i,$items->memo);
                        $excel->getActiveSheet()->setCellValue('D'.$i,$items->remarks);
                        $excel->getActiveSheet()->setCellValue('E'.$i,$items->posted_by);
                        $excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                        $excel->getActiveSheet()->setCellValue('F'.$i,number_format($items->debit,2));
                        $excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                        $excel->getActiveSheet()->setCellValue('G'.$i,number_format($items->credit,2));
                        $excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                        $excel->getActiveSheet()->setCellValue('H'.$i,number_format($items->balance,2));
                        $i++;
                        }

                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename='."SUPPLIER SUBSIDIARY REPORT.xlsx".'');
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


                } else {
                        
                    echo '<center style="font-family: Arial, sans-serif;"><h1 style="color:#2196f3">Information</h1><hr><h3>No record associated to this supplier.</h3></center>';
                }
               
                break;

            case 'account-receivable-schedule-export':
                $excel=$this->excel;

                $m_company_info=$this->Company_model;

                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $m_journal_accounts=$this->Journal_account_model;

                $account_id=$this->input->get('account_id');
                $date=$this->input->get('date');

                $data['date']=date('m/d/Y',strtotime($date));
                $ar_accounts=$m_journal_accounts->get_account_schedule($account_id,$date);

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A5')->setWidth('50');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("AR SCHEDULE REPORT");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:C2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address)
                                        ->setCellValue('A5','As of Date'.$date);

                $excel->getActiveSheet()->setCellValue('A7','Account Receivable Schedule')
                                        ->getStyle('A7')->getFont()->setBold(TRUE);


                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('50');

                $excel->getActiveSheet()
                        ->getStyle('B')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                        ->getStyle('C')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                        ->getStyle('D')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A9','Customer')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Previous')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','This Month')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Total')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);

                $i=10;
                $total = 0.00;

                foreach($ar_accounts as $ar){
                    $excel->getActiveSheet()
                            ->getStyle('B')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()
                            ->getStyle('C')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()
                            ->getStyle('D')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A'.$i,$ar->customer_name);
                    $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('B'.$i,number_format($ar->previous,2));
                    $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('C'.$i,number_format($ar->current,2));
                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('D'.$i,number_format($ar->total,2));

                    $i++;
                    $total+=$ar->total;                    
                }

                    $excel->getActiveSheet()
                            ->getStyle('A')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->mergeCells('A'.$i.':'.'C'.$i);
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Total:')
                                            ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                            
                    $excel->getActiveSheet()->setCellValue('D'.$i,number_format($total,2))
                                            ->getStyle('D'.$i)->getFont()->setBold(TRUE);

                    $i++;

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Account Receivable Schedule Report.xlsx".'');
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

            case 'customer-subsidiary-export' :
                $excel=$this->excel;
                $type=$this->input->get('type',TRUE);
                $customer_Id=$this->input->get('customerId',TRUE);
                $account_Id=$this->input->get('accountId',TRUE);
                $start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
                $end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));

                $m_customer_subsidiary=$this->Customer_subsidiary_model;
                $m_company_info=$this->Company_model;
                $m_journal_info=$this->Journal_info_model;

                $journal_info=$m_journal_info->get_list(
                    array('journal_info.is_deleted'=>FALSE, 'journal_info.customer_id'=>$customer_Id, 'journal_accounts.account_id'=>$account_Id),
                    'customer_name, account_title',
                    array(
                        array('customers','customers.customer_id=journal_info.customer_id','left'),
                        array('journal_accounts','journal_accounts.journal_id=journal_info.journal_id','left'),
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','left')
                    )
                );

                $company_info=$m_company_info->get_list();

                $data['company_info']=$company_info[0];
                $subsidiary_info=$journal_info[0];
                $customer_subsidiary=$m_customer_subsidiary->get_customer_subsidiary($customer_Id,$account_Id,$start_Date,$end_Date);

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

                $excel->getActiveSheet()->mergeCells('A6:B6');                     
                $excel->getActiveSheet()->setCellValue('A6','PERIOD: '.$start_Date.' to '.$end_Date)
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A8:B8');                     
                $excel->getActiveSheet()->setCellValue('A8','CUSTOMER SUBSIDIARY REPORT')
                                        ->getStyle('A8')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A10','CUSTOMER: '.$subsidiary_info->customer_name)
                                        ->mergeCells('A10:D10');                                         
                $excel->getActiveSheet()->setCellValue('E10','ACCOUNT: '.$subsidiary_info->account_title)
                                        ->mergeCells('E10:H10');

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');

                $excel->getActiveSheet()
                        ->getStyle('G')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                        ->getStyle('H')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                        ->getStyle('F')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A12','Txn Date')
                                        ->getStyle('A12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B12','Txn #')
                                        ->getStyle('B12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C12','Memo')
                                        ->getStyle('C12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D12','Remarks')
                                        ->getStyle('D12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E12','Posted by')
                                        ->getStyle('E12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F12','Debit')
                                        ->getStyle('F12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G12','Credit')
                                        ->getStyle('G12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H12','Balance')
                                        ->getStyle('H12')->getFont()->setBold(TRUE);

                $i=13;

                foreach ($customer_subsidiary as $items){
                    $excel->getActiveSheet()
                            ->getStyle('G')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()
                            ->getStyle('H')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()
                            ->getStyle('F')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A'.$i,$items->date_txn);
                    $excel->getActiveSheet()->setCellValue('B'.$i,$items->txn_no);
                    $excel->getActiveSheet()->setCellValue('C'.$i,$items->memo);
                    $excel->getActiveSheet()->setCellValue('D'.$i,$items->remarks);
                    $excel->getActiveSheet()->setCellValue('E'.$i,$items->posted_by);
                    $excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('F'.$i,number_format($items->debit,2));
                    $excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('G'.$i,number_format($items->credit,2));
                    $excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('H'.$i,number_format($items->balance,2));
    
                    $i++;

                }
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."CUSTOMER SUBSIDIARY REPORT.xlsx".'');
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

            case 'export-account-subsidiary':
                $excel=$this->excel;
                $type=$this->input->get('type',TRUE);
                $account_Id=$this->input->get('accountId',TRUE);
                $start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
                $end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));

                $m_journal_info=$this->Journal_info_model;
                $m_company_info=$this->Company_model;

                $journal_info=$m_journal_info->get_list(
                    array('journal_info.is_deleted'=>FALSE, 'journal_accounts.account_id'=>$account_Id),
                    'supplier_name, customer_name, account_title',
                    array(
                        array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
                        array('customers','customers.customer_id=journal_info.customer_id','left'),
                        array('journal_accounts','journal_accounts.journal_id=journal_info.journal_id','left'),
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','left')
                    )
                );

                $company_info=$m_company_info->get_list();

                $data['company_info']=$company_info[0];
                $subsidiary_info=$journal_info[0];
                $supplier_subsidiary=$m_journal_info->get_account_subsidiary($account_Id,$start_Date,$end_Date);

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

                $excel->getActiveSheet()->setCellValue('A10','ACCOUNT: '.$subsidiary_info->account_title);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('37');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('18');
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('18');
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth('18');

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

                $excel->getActiveSheet()->setCellValue('A12','Txn Date')
                                        ->getStyle('A12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B12','Txn #')
                                        ->getStyle('B12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C12','Particular')
                                        ->getStyle('C12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D12','Memo')
                                        ->getStyle('D12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E12','Remarks')
                                        ->getStyle('E12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F12','Posted by')
                                        ->getStyle('F12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G12','Debit')
                                        ->getStyle('G12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H12','Credit')
                                        ->getStyle('H12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('I12','Balance')
                                        ->getStyle('I12')->getFont()->setBold(TRUE);
                $i=13;
                foreach($supplier_subsidiary as $items) {
                $excel->getActiveSheet()
                        ->getStyle('G'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                        ->getStyle('H'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                        ->getStyle('I'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A'.$i,$items->date_txn);
                $excel->getActiveSheet()->setCellValue('B'.$i,$items->txn_no);
                $excel->getActiveSheet()->setCellValue('C'.$i,$items->particular);
                $excel->getActiveSheet()->setCellValue('D'.$i,$items->memo);
                $excel->getActiveSheet()->setCellValue('E'.$i,$items->remarks);
                $excel->getActiveSheet()->setCellValue('F'.$i,$items->posted_by);
                $excel->getActiveSheet()->setCellValue('G'.$i,number_format($items->debit,2))
                                        ->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                $excel->getActiveSheet()->setCellValue('H'.$i,number_format($items->credit,2))
                                        ->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                $excel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                $excel->getActiveSheet()->setCellValue('I'.$i,number_format($items->balance,2))
                                        ->getStyle('I'.$i)->getFont()->setBold(TRUE);

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

//EXCEL EMAIL

            case 'account-payable-schedule-email':
     
                $excel=$this->excel;
                $m_email=$this->Email_settings_model;
                $email=$m_email->get_list(2);
                $m_company_info=$this->Company_model;

                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $m_journal_accounts=$this->Journal_account_model;

                $account_id=$this->input->get('account_id');
                $date=$this->input->get('date');

                $data['date']=date('m/d/Y',strtotime($date));
                $ar_accounts=$m_journal_accounts->get_account_schedule($account_id,$date,'S');

                ob_start();
                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');

                //name the worksheet

                $excel->getActiveSheet()
                        ->getStyle('A1:D1')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

                $excel->getActiveSheet()
                        ->getStyle('A2:D2')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

                $excel->getActiveSheet()
                        ->getStyle('A3:D3')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

                $excel->getActiveSheet()->setTitle("AP Schedule Report");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:D1');
                $excel->getActiveSheet()->mergeCells('A2:D2');
                $excel->getActiveSheet()->mergeCells('A3:D3');
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no); 


                $excel->getActiveSheet()
                        ->getStyle('A5:D5')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

                $excel->getActiveSheet()->getColumnDimensionByColumn('A5:D5')->setWidth('40');                                          
                $excel->getActiveSheet()->mergeCells('A5:D5');
                $excel->getActiveSheet()->setCellValue('A5','As of Date '.$date);


                $excel->getActiveSheet()
                        ->getStyle('A7:D7')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

                $excel->getActiveSheet()->getColumnDimensionByColumn('A7:D7')->setWidth('40');                                          
                $excel->getActiveSheet()->mergeCells('A7:D7');
                $excel->getActiveSheet()->setCellValue('A7','Accounts Payable Schedule')
                                        ->getStyle('A7')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');

                $excel->getActiveSheet()
                        ->getStyle('B')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()
                        ->getStyle('C')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()
                        ->getStyle('D')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A9','Customer')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Previous')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','This Month')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Total')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);   

                $i=10;
                $total=0.00; 
                foreach($ar_accounts as $ar){
                    $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
                    $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');

                    $excel->getActiveSheet()
                            ->getStyle('B')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $excel->getActiveSheet()
                            ->getStyle('C')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $excel->getActiveSheet()
                            ->getStyle('D')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 

                    $excel->getActiveSheet()->setCellValue('A'.$i,$ar->supplier_name);
                    $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                    
                    $excel->getActiveSheet()->setCellValue('B'.$i,number_format($ar->previous,2));
                    $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                        
                    $excel->getActiveSheet()->setCellValue('C'.$i,number_format($ar->current,2));
                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                        
                    $excel->getActiveSheet()->setCellValue('D'.$i,number_format($ar->total,2));

                    $i++;
                    $total+=$ar->total;
                }
                    
                    $excel->getActiveSheet()
                            ->getStyle('A')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->mergeCells('A'.$i.':'.'C'.$i);    
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Total:')
                                            ->getStyle('A'.$i)->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                        
                    $excel->getActiveSheet()->setCellValue('D'.$i,number_format($total,2))
                                            ->getStyle('D'.$i)->getFont()->setBold(TRUE);


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Accounts Payable Schedule Report.xlsx".'');
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

                            $file_name='Accounts Payable Schedule Report '.date('Y-m-d h:i:A', now());
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
                            $subject = 'Accounts Payable Schedule';
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

            break;

            case 'supplier-subsidiary-email':
                $excel=$this->excel;
                $m_email=$this->Email_settings_model;
                $email=$m_email->get_list(2);
                $type=$this->input->get('type',TRUE);
                $supplier_Id=$this->input->get('supplierId',TRUE);
                $account_Id=$this->input->get('accountId',TRUE);
                $start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
                $end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));

                $m_journal_info=$this->Journal_info_model;
                $m_company_info=$this->Company_model;

                $journal_info=$m_journal_info->get_list(
                    array('journal_info.is_deleted'=>FALSE, 'journal_info.supplier_id'=>$supplier_Id, 'journal_accounts.account_id'=>$account_Id),
                    'supplier_name, account_title',
                    array(
                        array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
                        array('journal_accounts','journal_accounts.journal_id=journal_info.journal_id','left'),
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','left')
                    )
                );

                $company_info=$m_company_info->get_list();

                $data['company_info']=$company_info[0];
                if (isset($journal_info[0])) 
                {

                    $supplier_subsidiary=$m_journal_info->get_supplier_subsidiary($supplier_Id,$account_Id,$start_Date,$end_Date);
                    $data['company_info']=$company_info[0];
                    $subsidiary_info=$journal_info[0];

                    ob_start();
                    $excel->setActiveSheetIndex(0);

                    $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                    $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('50');

                    //name the worksheet
                    $excel->getActiveSheet()->setTitle("SUPPLIER SUBSIDIARY REPORT");
                    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->mergeCells('A1:B1');
                    $excel->getActiveSheet()->mergeCells('A2:C2');
                    $excel->getActiveSheet()->mergeCells('A3:B3');
                    $excel->getActiveSheet()->mergeCells('A4:B4');
                    $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                            ->setCellValue('A2',$company_info[0]->company_address)
                                            ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                            ->setCellValue('A4',$company_info[0]->email_address);

                    $excel->getActiveSheet()->setCellValue('A6','PERIOD : '.$start_Date.' to '.$end_Date)
                                            ->getStyle('A6')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->setCellValue('A8','SUPPLIER SUBSIDIARY REPORT')
                                            ->getStyle('A8')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->mergeCells('A10:D10');
                    $excel->getActiveSheet()->setCellValue('A10','Supplier: '.$subsidiary_info->supplier_name)
                                            ->getStyle('A10')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->mergeCells('E10:H10');
                    $excel->getActiveSheet()->setCellValue('E10','Account: '.$subsidiary_info->account_title)
                                            ->getStyle('E10')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->getColumnDimension('A')->setWidth('25');
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');
                    $excel->getActiveSheet()->getColumnDimension('D')->setWidth('40');
                    $excel->getActiveSheet()->getColumnDimension('E')->setWidth('40');
                    $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');

                    $excel->getActiveSheet()
                            ->getStyle('A12')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                   
                    $excel->getActiveSheet()
                            ->getStyle('B12')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                                                           
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

                    $excel->getActiveSheet()->setCellValue('A12','Txn Date')
                                            ->getStyle('A12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('B12','Txn #')
                                            ->getStyle('B12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('C12','Memo')
                                            ->getStyle('C12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('D12','Remarks')
                                            ->getStyle('D12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('E12','Posted by')
                                            ->getStyle('E12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('F12','Debit')
                                            ->getStyle('F12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('G12','Credit')
                                            ->getStyle('G12')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->setCellValue('H12','Balance')
                                            ->getStyle('H12')->getFont()->setBold(TRUE);

                    $i=13;

                    foreach($supplier_subsidiary as $items){
                        $excel->getActiveSheet()->setCellValue('A'.$i,$items->date_txn);
                        $excel->getActiveSheet()->setCellValue('B'.$i,$items->txn_no);
                        $excel->getActiveSheet()->setCellValue('C'.$i,$items->memo);
                        $excel->getActiveSheet()->setCellValue('D'.$i,$items->remarks);
                        $excel->getActiveSheet()->setCellValue('E'.$i,$items->posted_by);
                        $excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                        $excel->getActiveSheet()->setCellValue('F'.$i,number_format($items->debit,2));
                        $excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                        $excel->getActiveSheet()->setCellValue('G'.$i,number_format($items->credit,2));
                        $excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                        $excel->getActiveSheet()->setCellValue('H'.$i,number_format($items->balance,2));
                        $i++;
                        }

                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename='."SUPPLIER SUBSIDIARY REPORT.xlsx".'');
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

                            $file_name='SUPPLIER SUBSIDIARY REPORT '.date('Y-m-d h:i:A', now());
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
                            $subject = 'SUPPLIER SUBSIDIARY REPORT';
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
               
                } else {
                            $response['title']='Try Again!';
                            $response['stat']='error';
                            $response['msg']='No record associated to this supplier.';

                            echo json_encode($response);                        
                }   

                break;

            case 'account-receivable-schedule-email':
                $excel=$this->excel;
                $m_email=$this->Email_settings_model;
                $email=$m_email->get_list(2);
                $m_company_info=$this->Company_model;

                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $m_journal_accounts=$this->Journal_account_model;

                $account_id=$this->input->get('account_id');
                $date=$this->input->get('date');

                $data['date']=date('m/d/Y',strtotime($date));
                $ar_accounts=$m_journal_accounts->get_account_schedule($account_id,$date);

                ob_start();
                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:B2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A5')->setWidth('50');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("AR SCHEDULE REPORT");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:C2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');
                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address)
                                        ->setCellValue('A5','As of Date'.$date);

                $excel->getActiveSheet()->setCellValue('A7','Account Receivable Schedule')
                                        ->getStyle('A7')->getFont()->setBold(TRUE);


                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('50');

                $excel->getActiveSheet()
                        ->getStyle('B')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                        ->getStyle('C')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                        ->getStyle('D')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A9','Customer')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Previous')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','This Month')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Total')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);

                $i=10;
                $total = 0.00;

                foreach($ar_accounts as $ar){
                    $excel->getActiveSheet()
                            ->getStyle('B')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()
                            ->getStyle('C')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()
                            ->getStyle('D')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A'.$i,$ar->customer_name);
                    $excel->getActiveSheet()->getStyle('B'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('B'.$i,number_format($ar->previous,2));
                    $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('C'.$i,number_format($ar->current,2));
                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('D'.$i,number_format($ar->total,2));

                    $i++;
                    $total+=$ar->total;                    
                }

                    $excel->getActiveSheet()
                            ->getStyle('A')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->mergeCells('A'.$i.':'.'C'.$i);
                    $excel->getActiveSheet()->setCellValue('A'.$i,'Total:')
                                            ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                            
                    $excel->getActiveSheet()->setCellValue('D'.$i,number_format($total,2))
                                            ->getStyle('D'.$i)->getFont()->setBold(TRUE);

                    $i++;

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Account Receivable Schedule Report.xlsx".'');
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

                            $file_name='ACCOUNT RECEIVABLE SCHEDULE REPORT '.date('Y-m-d h:i:A', now());
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
                            $subject = 'AR SCHEDULE REPORT';
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

                break;

            case 'customer-subsidiary-email' :
                $excel=$this->excel;
                $m_email=$this->Email_settings_model;
                $email=$m_email->get_list(2);
                $type=$this->input->get('type',TRUE);
                $customer_Id=$this->input->get('customerId',TRUE);
                $account_Id=$this->input->get('accountId',TRUE);
                $start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
                $end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));

                $m_customer_subsidiary=$this->Customer_subsidiary_model;
                $m_company_info=$this->Company_model;
                $m_journal_info=$this->Journal_info_model;

                $journal_info=$m_journal_info->get_list(
                    array('journal_info.is_deleted'=>FALSE, 'journal_info.customer_id'=>$customer_Id, 'journal_accounts.account_id'=>$account_Id),
                    'customer_name, account_title',
                    array(
                        array('customers','customers.customer_id=journal_info.customer_id','left'),
                        array('journal_accounts','journal_accounts.journal_id=journal_info.journal_id','left'),
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','left')
                    )
                );

                $company_info=$m_company_info->get_list();

                $data['company_info']=$company_info[0];
                $subsidiary_info=$journal_info[0];
                $customer_subsidiary=$m_customer_subsidiary->get_customer_subsidiary($customer_Id,$account_Id,$start_Date,$end_Date);

                ob_start();
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

                $excel->getActiveSheet()->mergeCells('A6:B6');                     
                $excel->getActiveSheet()->setCellValue('A6','PERIOD: '.$start_Date.' to '.$end_Date)
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A8:B8');                     
                $excel->getActiveSheet()->setCellValue('A8','CUSTOMER SUBSIDIARY REPORT')
                                        ->getStyle('A8')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A10','CUSTOMER: '.$subsidiary_info->customer_name)
                                        ->mergeCells('A10:D10');                                         
                $excel->getActiveSheet()->setCellValue('E10','ACCOUNT: '.$subsidiary_info->account_title)
                                        ->mergeCells('E10:H10');

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');

                $excel->getActiveSheet()
                        ->getStyle('G')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                        ->getStyle('H')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                        ->getStyle('F')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A12','Txn Date')
                                        ->getStyle('A12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B12','Txn #')
                                        ->getStyle('B12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C12','Memo')
                                        ->getStyle('C12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D12','Remarks')
                                        ->getStyle('D12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E12','Posted by')
                                        ->getStyle('E12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F12','Debit')
                                        ->getStyle('F12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G12','Credit')
                                        ->getStyle('G12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H12','Balance')
                                        ->getStyle('H12')->getFont()->setBold(TRUE);

                $i=13;

                foreach ($customer_subsidiary as $items){
                    $excel->getActiveSheet()
                            ->getStyle('G')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()
                            ->getStyle('H')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()
                            ->getStyle('F')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A'.$i,$items->date_txn);
                    $excel->getActiveSheet()->setCellValue('B'.$i,$items->txn_no);
                    $excel->getActiveSheet()->setCellValue('C'.$i,$items->memo);
                    $excel->getActiveSheet()->setCellValue('D'.$i,$items->remarks);
                    $excel->getActiveSheet()->setCellValue('E'.$i,$items->posted_by);
                    $excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('F'.$i,number_format($items->debit,2));
                    $excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('G'.$i,number_format($items->credit,2));
                    $excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                    $excel->getActiveSheet()->setCellValue('H'.$i,number_format($items->balance,2));
    
                    $i++;

                }
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."CUSTOMER SUBSIDIARY REPORT.xlsx".'');
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

                            $file_name='CUSTOMER SUBSIDIARY REPORT '.date('Y-m-d h:i:A', now());
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
                            $subject = 'CUSTOMER SUBSIDIARY REPORT';
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

                break;

            case 'email-account-subsidiary':
                $excel=$this->excel;
                $m_email=$this->Email_settings_model;
                $email=$m_email->get_list(2);
                $type=$this->input->get('type',TRUE);
                $account_Id=$this->input->get('accountId',TRUE);
                $start_Date=date('Y-m-d',strtotime($this->input->get('startDate',TRUE)));
                $end_Date=date('Y-m-d',strtotime($this->input->get('endDate',TRUE)));

                $m_journal_info=$this->Journal_info_model;
                $m_company_info=$this->Company_model;

                $journal_info=$m_journal_info->get_list(
                    array('journal_info.is_deleted'=>FALSE, 'journal_accounts.account_id'=>$account_Id),
                    'supplier_name, customer_name, account_title',
                    array(
                        array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
                        array('customers','customers.customer_id=journal_info.customer_id','left'),
                        array('journal_accounts','journal_accounts.journal_id=journal_info.journal_id','left'),
                        array('account_titles','account_titles.account_id=journal_accounts.account_id','left')
                    )
                );

                $company_info=$m_company_info->get_list();

                $data['company_info']=$company_info[0];
                $subsidiary_info=$journal_info[0];
                $supplier_subsidiary=$m_journal_info->get_account_subsidiary($account_Id,$start_Date,$end_Date);

                ob_start();
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

                $excel->getActiveSheet()->setCellValue('A10','ACCOUNT: '.$subsidiary_info->account_title);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('37');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('18');
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('18');
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth('18');

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

                $excel->getActiveSheet()->setCellValue('A12','Txn Date')
                                        ->getStyle('A12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B12','Txn #')
                                        ->getStyle('B12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C12','Particular')
                                        ->getStyle('C12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D12','Memo')
                                        ->getStyle('D12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E12','Remarks')
                                        ->getStyle('E12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F12','Posted by')
                                        ->getStyle('F12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G12','Debit')
                                        ->getStyle('G12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H12','Credit')
                                        ->getStyle('H12')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('I12','Balance')
                                        ->getStyle('I12')->getFont()->setBold(TRUE);
                $i=13;
                foreach($supplier_subsidiary as $items) {
                $excel->getActiveSheet()
                        ->getStyle('G'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                        ->getStyle('H'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()
                        ->getStyle('I'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A'.$i,$items->date_txn);
                $excel->getActiveSheet()->setCellValue('B'.$i,$items->txn_no);
                $excel->getActiveSheet()->setCellValue('C'.$i,$items->particular);
                $excel->getActiveSheet()->setCellValue('D'.$i,$items->memo);
                $excel->getActiveSheet()->setCellValue('E'.$i,$items->remarks);
                $excel->getActiveSheet()->setCellValue('F'.$i,$items->posted_by);
                $excel->getActiveSheet()->setCellValue('G'.$i,number_format($items->debit,2))
                                        ->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                $excel->getActiveSheet()->setCellValue('H'.$i,number_format($items->credit,2))
                                        ->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                $excel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                $excel->getActiveSheet()->setCellValue('I'.$i,number_format($items->balance,2))
                                        ->getStyle('I'.$i)->getFont()->setBold(TRUE);

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
                $data = ob_get_clean();


                            $file_name='ACCOUNT SUBSIDIARY REPORT '.date('Y-m-d h:i:A', now());
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
                            $subject = 'ACCOUNT SUBSIDIARY REPORT';
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

            break;

            case 'account-receivable-schedule':
                $m_company_info=$this->Company_model;

                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $m_journal_accounts=$this->Journal_account_model;

                $account_id=$this->input->get('account_id');
                $date=$this->input->get('date');

                $data['date']=date('m/d/Y',strtotime($date));
                $data['ar_accounts']=$m_journal_accounts->get_account_schedule($account_id,$date);


                if ($type == 'preview' || $type == null) {
                    $pdf = $this->m_pdf->load("A4-L");
                    $content=$this->load->view('template/account_receivable_sched_report',$data,TRUE);

                }

                $pdf->setFooter('{PAGENO}');
                $pdf->WriteHTML($content);
                $pdf->Output();


                break;



            case 'account-payable-schedule':
                $m_company_info=$this->Company_model;

                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $m_journal_accounts=$this->Journal_account_model;

                $account_id=$this->input->get('account_id');
                $date=$this->input->get('date');

                $data['date']=date('m/d/Y',strtotime($date));
                $data['ar_accounts']=$m_journal_accounts->get_account_schedule($account_id,$date,'S');


                if ($type == 'preview' || $type == null) {

                    $pdf = $this->m_pdf->load("A4-L");
                    $content=$this->load->view('template/account_payable_sched_report',$data,TRUE);
                }

                $pdf->setFooter('{PAGENO}');
                $pdf->WriteHTML($content);
                $pdf->Output();
                break;

        }
    }


}
