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


$sql="SELECT main.*,ac.account_title FROM 
(SELECT 
(SELECT  cash_id from pos_integration) as account_id,
'' as memo,
cash_amount as dr_amount,
0 as cr_amount
FROM pos_integration_items
WHERE pos_integration_items_id = $item_id

UNION ALL

SELECT 
(SELECT  check_id from pos_integration) as account_id,
'' as memo,
check_amount as dr_amount,
0 as cr_amount
FROM pos_integration_items
WHERE pos_integration_items_id = $item_id

UNION ALL

SELECT 
(SELECT  card_id from pos_integration) as account_id,
'' as memo,
card_amount as dr_amount,
0 as cr_amount
FROM pos_integration_items
WHERE pos_integration_items_id = $item_id

UNION ALL

SELECT 
(SELECT  gc_id from pos_integration) as account_id,
'' as memo,
gc_amount as dr_amount,
0 as cr_amount
FROM pos_integration_items
WHERE pos_integration_items_id = $item_id

UNION ALL

SELECT 
(SELECT  ar_id from pos_integration) as account_id,
'' as memo,
ar_amount as dr_amount,
0 as cr_amount
FROM pos_integration_items
WHERE pos_integration_items_id = $item_id

UNION ALL

SELECT 
(SELECT  regular_discount_id from pos_integration) as account_id,
'' as memo,
regular_discount as dr_amount,
0 as cr_amount
FROM pos_integration_items
WHERE pos_integration_items_id = $item_id

UNION ALL

SELECT 
(SELECT  sc_discount_id from pos_integration) as account_id,
'' as memo,
sc_discount as dr_amount,
0 as cr_amount
FROM pos_integration_items
WHERE pos_integration_items_id = $item_id

UNION ALL

SELECT 
(SELECT  oth_discount_id from pos_integration) as account_id,
'' as memo,
oth_discount as dr_amount,
0 as cr_amount
FROM pos_integration_items
WHERE pos_integration_items_id = $item_id




UNION ALL

SELECT (SELECT kitchen_id from pos_integration) as account_id,
'' as memo,
0 as dr_amount,
kitchen_sales as cr_amount
from pos_integration_items
WHERE pos_integration_items_id = $item_id

UNION ALL

SELECT (SELECT bar_id from pos_integration) as account_id,
'' as memo,
0 as dr_amount,
bar_sales as cr_amount
from pos_integration_items
WHERE pos_integration_items_id = $item_id

UNION ALL

SELECT (SELECT recreational_id from pos_integration) as account_id,
'' as memo,
0 as dr_amount,
recreational_sales as cr_amount
from pos_integration_items
WHERE pos_integration_items_id = $item_id

UNION ALL

SELECT (SELECT merchandise_id from pos_integration) as account_id,
'' as memo,
0 as dr_amount,
merchandise_sales as cr_amount
from pos_integration_items
WHERE pos_integration_items_id = $item_id

UNION ALL

SELECT (SELECT tax_id from pos_integration) as account_id,
'' as memo,
0 as dr_amount,
tax_amount as cr_amount
from pos_integration_items
WHERE pos_integration_items_id = $item_id) as main
 
LEFT JOIN account_titles ac ON ac.account_id = main.account_id

WHERE main.dr_amount > 0 OR main.cr_amount > 0";
        return $this->db->query($sql)->result();
}

function get_pos_list_front_end($sales_date){


$sql="
SELECT main.*,
CASE WHEN main.dr_amount = main.cr_amount THEN 1 ELSE 0 END as is_equal 
FROM
(SELECT
pii.pos_integration_items_id,
pii.cashier,
pii.ref_no,
pii.sales_date,
pii.item_type,
(IFNULL(pii.cash_amount,0) + IFNULL(pii.check_amount,0) + IFNULL(pii.card_amount,0) +  IFNULL(pii.gc_amount,0) + 
IFNULL(pii.ar_amount,0) + 
IFNULL(pii.regular_discount,0) + IFNULL(pii.sc_discount,0) + IFNULL(pii.oth_discount,0)) as dr_amount,
(IFNULL(pii.kitchen_sales,0) + IFNULL(pii.bar_sales,0) + IFNULL(pii.recreational_sales,0) + IFNULL(pii.merchandise_sales,0) +
IFNULL(pii.tax_amount,0)) as cr_amount

 FROM pos_integration_items pii

WHERE  pii.is_posted = FALSE AND pii.sales_date <= '$sales_date'
 ) as main 
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