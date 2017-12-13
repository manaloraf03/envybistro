<?php

class Cash_invoice_model extends CORE_Model
{
    protected $table = "cash_invoice";
    protected $pk_id = "cash_invoice_id";

    function __construct()
    {
        parent::__construct();
    }










function get_journal_entries($cash_invoice_id){
	$sql="SELECT main.* FROM (

	SELECT
	p.income_account_id as account_id,
	'' as memo,
	SUM(cii.inv_non_tax_amount) cr_amount,
	0 as dr_amount

	FROM `cash_invoice_items` as cii
	INNER JOIN products as p ON cii.product_id=p.product_id
	WHERE cii.cash_invoice_id=$cash_invoice_id AND p.income_account_id>0
	GROUP BY p.income_account_id

	UNION ALL

	SELECT output_tax.account_id,output_tax.memo,
	SUM(output_tax.cr_amount)as cr_amount,0 as dr_amount
	 FROM
	(SELECT cii.product_id,

	(SELECT output_tax_account_id FROM account_integration) as account_id
	,
	'' as memo,
	SUM(cii.inv_tax_amount) as cr_amount,
	0 as dr_amount

	FROM `cash_invoice_items` as cii
	INNER JOIN products as p ON cii.product_id=p.product_id
	WHERE cii.cash_invoice_id=$cash_invoice_id AND p.income_account_id>0
	)as output_tax GROUP BY output_tax.account_id

	UNION ALL

	SELECT acc_receivable.account_id,
	acc_receivable.memo,
	0 as cr_amount,SUM(acc_receivable.dr_amount) as dr_amount
	 FROM
	(SELECT cii.product_id,

	(SELECT cash_invoice_debit_id FROM account_integration) as account_id
	,
	'' as memo,
	0 cr_amount,
	SUM(cii.inv_line_total_after_global) as dr_amount

	FROM `cash_invoice_items` as cii
	INNER JOIN products as p ON cii.product_id=p.product_id
	WHERE cii.cash_invoice_id=$cash_invoice_id AND p.income_account_id>0
	) as acc_receivable GROUP BY acc_receivable.account_id

	UNION ALL

	SELECT acc_discount.account_id,acc_discount.memo,
	0 as cr_amount,SUM(acc_discount.dr_amount) as dr_amount
	 FROM
	(SELECT cii.product_id,

	(SELECT receivable_discount_account_id FROM account_integration) as account_id
	,
	'' as memo,
	0 cr_amount,
	SUM((cii.inv_line_total_price - cii.inv_line_total_after_global) + cii.inv_line_total_discount) as dr_amount

	FROM `cash_invoice_items` as cii
	INNER JOIN products as p ON cii.product_id=p.product_id
	WHERE cii.cash_invoice_id=$cash_invoice_id AND p.income_account_id>0
	) as acc_discount GROUP BY acc_discount.account_id

	) main WHERE main.dr_amount > 0 or main.cr_amount > 0";
	        return $this->db->query($sql)->result();
	}



}

?>
