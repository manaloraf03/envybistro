<?php

class Pos_integration_items_model extends CORE_Model{

    protected  $table="pos_integration_items"; //table name
    protected  $pk_id="pos_integration_items_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

function cashier_list(){
$sql="SELECT distinct cashier FROM pos_integration_items";
        return $this->db->query($sql)->result();
}


function bar_sales_report_list($cashier=null,$from=null,$to){
$sql="SELECT *,
DATE_FORMAT(pos_integration_items.sales_date,'%m/%d/%Y')as sales_date FROM pos_integration_items 
WHERE is_posted = TRUE
".($cashier==null?"":" AND cashier='".$cashier."'")."

AND sales_date BETWEEN '".$from."' and '".$to."' 
ORDER BY sales_date ASC
";
        return $this->db->query($sql)->result();
}

function get_pos_entries_journal($item_id){


$sql="SELECT main.*,ac.account_title FROM (SELECT 
(SELECT  asset_cash from pos_integration) as account_id,
'' as memo,
cash_amount as dr_amount,
0 as cr_amount
FROM pos_integration_items
WHERE pos_integration_items_id = $item_id


UNION ALL

SELECT 
(SELECT  asset_check from pos_integration) as account_id,
'' as memo,
check_amount as dr_amount,
0 as cr_amount
FROM pos_integration_items
WHERE pos_integration_items_id = $item_id

UNION ALL

SELECT 
(SELECT  asset_card from pos_integration) as account_id,
'' as memo,
card_amount as dr_amount,
0 as cr_amount
FROM pos_integration_items
WHERE pos_integration_items_id = $item_id

UNION ALL

SELECT 
(SELECT  asset_gc from pos_integration) as account_id,
'' as memo,
gc_amount as dr_amount,
0 as cr_amount
FROM pos_integration_items
WHERE pos_integration_items_id = $item_id

UNION ALL

SELECT (SELECT income_sales from pos_integration) as account_id,
'' as memo,
0 as dr_amount,
(IFNULL(total,0)- IFNULL(tax_amount,0)) as cr_amount
from pos_integration_items
WHERE pos_integration_items_id = $item_id


UNION ALL

SELECT (SELECT tax from pos_integration) as account_id,
'' as memo,
0 as dr_amount,
tax_amount as cr_amount
from pos_integration_items
WHERE pos_integration_items_id = $item_id
) as main
 
LEFT JOIN account_titles ac ON ac.account_id = main.account_id

WHERE main.dr_amount > 0 OR main.cr_amount > 0";
        return $this->db->query($sql)->result();
}

function get_pos_list_front_end($sales_date){


$sql="

SELECT main.*,
CASE WHEN main.dr_amount = main.cr_amount THEN 1 ELSE 0 END as is_equal
FROM

(SELECT pii.pos_integration_items_id,
pii.sales_date,
pii.cashier,
(IFNULL(pii.cash_amount,0) + IFNULL(pii.check_amount,0) + IFNULL(pii.card_amount,0) + IFNULL(pii.gc_amount,0)) dr_amount,
IFNULL(pii.total,0) as cr_amount,
ref_no  FROM pos_integration_items pii

WHERE  pii.is_posted = FALSE AND pii.sales_date <= '$sales_date') as main
";
        return $this->db->query($sql)->result();
}


function get_pos_list_balanced($sales_date){

$sql="
SELECT pos.*,x.* FROM pos_integration_items as pos

LEFT JOIN (SELECT main.*,
CASE WHEN main.dr_amount = main.cr_amount THEN 1 ELSE 0 END as is_equal
FROM

(SELECT pii.pos_integration_items_id,
pii.sales_date,
(IFNULL(pii.cash_amount,0) + IFNULL(pii.check_amount,0) + IFNULL(pii.card_amount,0) + IFNULL(pii.gc_amount,0)) dr_amount,
IFNULL(pii.total,0) as cr_amount,
ref_no  FROM pos_integration_items pii

WHERE  pii.is_posted = FALSE AND pii.sales_date <= '$sales_date') as main) as x
ON x.pos_integration_items_id = pos.pos_integration_items_id

WHERE pos.is_posted = FALSE AND x.sales_date <= '$sales_date'
" ;
       return $this->db->query($sql)->result();
}


}


?>