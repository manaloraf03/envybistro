<?php

class Account_title_model extends CORE_Model{

    protected  $table="account_titles"; //table name
    protected  $pk_id="account_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


    function create_default_account_title(){
        //return;
        $sql="INSERT IGNORE INTO account_titles
                  (account_id,account_no,account_title,account_class_id,parent_account_id,grand_parent_id)
              VALUES
                  (1,'101','Cash',1,0,1),
                  (2,'120','Account Receivable',1,0,2),
                  (3,'140','Inventory',1,0,3),
                  (10,'150','Input Tax',1,0,10),
                  (13,'160','Petty Cash',1,0,1),

                  (4,'210','Accounts Payable',3,0,4),
                  (11,'220','Output Tax',3,0,4),

                  (5,'300','Capital',5,0,5),

                  (6,'400','Sales Income',7,0,6),
                  (7,'410','Service Income',7,0,7),


                  (8,'500','Salaries Expense',6,0,8),
                  (9,'510','Supplies Expense',6,0,9),
                  (12,'510','Miscellaneous Expense',6,0,12)
        ";
        $this->db->query($sql);
    }

  function get_account_types(){

        $sql="SELECT * FROM account_types  
        order by account_type_id ASC";
        return $this->db->query($sql)->result();
    }   
    function get_account_classes(){

        $sql="SELECT * FROM account_classes  
        WHERE is_active = TRUE and is_deleted = FALSE 
        order by account_type_id ASC";
        return $this->db->query($sql)->result();
    }
    function get_account_titles(){

        $sql="SELECT at.* FROM account_titles at
        WHERE at.is_active = TRUE AND at.is_deleted = FALSE AND at.parent_account_id = 0
        ";
        return $this->db->query($sql)->result();
    }

    function get_account_titles_child(){

        $sql="SELECT at.* FROM account_titles at
        WHERE at.is_active = TRUE AND at.is_deleted = FALSE AND at.parent_account_id != 0
        ";
        return $this->db->query($sql)->result();
    }


    function get_account_titles_balance($start=null,$end=null){
        $sql="SELECT

                at.account_no,at.account_title,
                IFNULL(SUM(ja.dr_amount),0) as dr_amount,
                IFNULL(SUM(ja.cr_amount),0) as cr_amount,
                ac.account_class_id,ac.account_type_id,

                IF(
                    ac.account_type_id=1 OR ac.account_type_id=5,
                    IFNULL(SUM(ja.dr_amount),0)-IFNULL(SUM(ja.cr_amount),0),
                    IFNULL(SUM(ja.cr_amount),0)-IFNULL(SUM(ja.dr_amount),0)
                ) as balance


                FROM (account_titles as at LEFT JOIN `account_classes` as ac ON at.`account_class_id`=ac.account_class_id)
                LEFT JOIN

                (

                SELECT ja.* FROM journal_accounts as ja INNER
                JOIN journal_info as ji ON ja.journal_id=ji.journal_id
                WHERE ji.is_active AND ji.is_deleted=FALSE
                ".($start!=null&&$end!=null?" AND ji.date_txn BETWEEN '$start' AND '$end'":"")."

                )as ja

                ON at.account_id=ja.account_id



                GROUP BY at.account_id";

            return $this->db->query($sql)->result();
    }

    function get_journal_id_with_account_no($account_Id=null,$includeChild=0){
      $sql="SELECT ja.journal_id, SUM(ja.cr_amount) as tax 
      FROM journal_accounts ja 

           LEFT JOIN
            journal_info AS ji ON ji.journal_id = ja.journal_id
                LEFT JOIN
            (account_titles AS at LEFT JOIN account_titles as par ON par.account_id=at.grand_parent_id) ON at.account_id = ja.account_id
                LEFT JOIN
            account_classes AS ac ON ac.account_class_id = at.account_class_id
                LEFT JOIN
            account_types AS atypes ON atypes.account_type_id = ac.account_type_id
                LEFT JOIN
            user_accounts AS ua ON ua.user_id = ji.created_by_user

            WHERE 
            ".($includeChild==0?
                " ja.account_id=$account_Id ":
                " at.grand_parent_id IN(SELECT atx.grand_parent_id FROM account_titles as atx WHERE atx.account_id=$account_Id)"
            )."


   AND ji.is_active = TRUE AND ji.is_deleted = FALSE
      GROUP BY ja.journal_id";


      return $this->db->query($sql)->result();
    }

    function get_account_subsidiary_wht($array,$account_Id,$start_Date,$end_Date,$includeChild){
            $sql="
            SELECT 

            ji.date_txn,
            ji.txn_no,
            s.supplier_name,
            s.address,
            s.tin_no,
            CONCAT(ji.ref_type,' #', ji.ref_no) as cv_no,
            s.supplier_name,
            IFNULL(ja.gross,0) as gross,
            IFNULL(jatax.tax,0) as tax,
            (IFNULL(ja.gross,0) - IFNULL(jatax.tax,0)) as net
            FROM journal_info ji

            LEFT JOIN 
            (SELECT 
            ja.journal_id,
            SUM(ja.cr_amount) as gross FROM journal_accounts as ja
            GROUP BY ja.journal_id) as ja ON ja.journal_id = ji.journal_id

            LEFT JOIN  suppliers as s ON s.supplier_id = ji.supplier_id

            LEFT JOIN
            (SELECT ja.journal_id, SUM(ja.cr_amount) as tax 
            FROM journal_accounts ja 
            
            LEFT JOIN
            journal_info AS ji ON ji.journal_id = ja.journal_id
                LEFT JOIN
            (account_titles AS at LEFT JOIN account_titles as par ON par.account_id=at.grand_parent_id) ON at.account_id = ja.account_id
                LEFT JOIN
            account_classes AS ac ON ac.account_class_id = at.account_class_id
                LEFT JOIN
            account_types AS atypes ON atypes.account_type_id = ac.account_type_id
                LEFT JOIN
            user_accounts AS ua ON ua.user_id = ji.created_by_user
                LEFT JOIN
            suppliers AS s ON s.supplier_id = ji.supplier_id

            WHERE 


            ".($includeChild==0?
                " ja.account_id=$account_Id ":
                " at.grand_parent_id IN(SELECT atx.grand_parent_id FROM account_titles as atx WHERE atx.account_id=$account_Id)"
            )."

            GROUP BY journal_id ) as jatax ON jatax.journal_id = ji.journal_id 

            WHERE ji.is_active = TRUE AND ji.is_deleted = FALSE
            AND ji.book_type = 'CDJ' 
            AND ji.journal_id IN ($array) 
            AND ji.date_txn BETWEEN '$start_Date' AND '$end_Date'

            ORDER BY ji.date_txn ASC

           ";
                return $this->db->query($sql)->result();
        }

}




?>