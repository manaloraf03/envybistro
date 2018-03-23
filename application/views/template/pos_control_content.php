 <style type="text/css">
     #content td {
        font-size: 14px;
        /*border: 1px solid gray!important; */
     }
     .left{border-left: 1px solid gray!important; }
     .right{border-right: 1px solid gray!important; }
     .top{border-top: 1px solid gray!important; }
     .bottom{border-bottom: 1px solid gray!important; }

    #content tr:nth-child(even){
            background-color: : #f9f9f9 !important;

        }
    #content tr:nth-child(odd){
            background-color: transparent; !important;

        }

 </style>
    <table class="table_journal_entries_review"  width="100%" style="font-family: tahoma;">
        <tbody>
        <tr>
            <td>
            <div class="tab-container tab-top tab-default">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#journal_review_<?php echo $item_id; ?>" data-toggle="tab"><i class="fa fa-gavel"></i> Review Journal</a></li>
                <!-- <li class=""><a href="#pos_review_<?php echo $item_id; ?>" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Transaction</a></li> -->
            </ul>
                <div class="tab-content">
                 <div class="tab-pane active" id="journal_review_<?php echo $item_id; ?>" data-parent-id="<?php echo $item_id; ?>" style="min-height: 300px;">
                 <form id="frm_journal_review" role="form" class="form-horizontal row-border"><br>
                <h2 style="margin-top: 0px!important;">Sales Journal</h2> <hr />
                            <div class="row">
                            <label class="col-lg-2"> <b class="required">*</b> Txn # :</label>
                            <div class="col-lg-10">
                                <input type="text" name="txn_no" class="form-control" style="font-weight: bold;" placeholder="TXN-MMDDYYY-XXX" readonly>
                            </div>
                            <br /><br />
                            <label class="col-lg-2"> <b class="required">*</b> Date :</label>
                            <div class="col-lg-10">
                                <?php $date = new DateTime($item->sales_date); ?>
                                <input type="text" name="date_txn" class="date-picker  form-control" value="<?php echo date_format($date, 'm/d/Y');?>">
                            </div>
                            <input type="hidden" name="ref_no" value="<?php echo $item->ref_no; ?>">
                            <input type="hidden" name="pos_integration_items_id" value="<?php echo $item_id ?>">
                            <label class="col-lg-2"><b class="required">*</b> Department :</label>
                            <div class="col-lg-10">
                            
                                <select id="cbo_departments" name="department_id" class="selectpicker cbo_department_list  show-tick form-control" data-live-search="true" data-error-msg="Department is required." required>
                                        <?php foreach($departments as $department){ ?>
                                            <option value='<?php echo $department->department_id; ?>' <?php echo ($department->department_id==$int->department_id)? 'selected':'' ?>><?php echo $department->department_name; ?></option>
                                        <?php } ?>
                                </select>
                            </div>
                            <label class="col-lg-2"><b class="required">*</b> Customer :</label>
                            <div class="col-lg-10">
                                <select name="customer_id" class="selectpicker cbo_customer_list show-tick form-control" data-live-search="true" data-error-msg="Customer is required." required>
                                    <?php foreach($customers as $customer){ ?>
                                        <option value='<?php echo $customer->customer_id; ?>' <?php echo ($customer->customer_id==$customer_id)? 'selected':'' ?>><?php echo $customer->customer_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            </div>
                            <br>
                            <h4>Journal Entries</h4>
                        <table id="tbl_entries_for_review_<?php echo $item_id; ?>" class="table table-striped" style="width: 100% !important;">
                                    <thead>
                                    <tr style="">
                                        <th style="width: 30%;">Account</th>
                                        <th style="width: 15%;">Memo</th>
                                        <th style="width: 15%;text-align: right;">Dr</th>
                                        <th style="width: 15%;text-align: right;">Cr</th>
                                        <th style="width: 15%;">Department</th>
                                        <th style="width: 10%;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                            $dr_total=0.00; $cr_total=0.00;
                                            foreach($entries as $entry){
                                        ?>
                                        <tr>
                                            <td>
                                                <select name="accounts[]" class="selectpicker show-tick form-control selectpicker_accounts" data-live-search="true" >
                                                    <?php foreach($accounts as $account){ ?>
                                                        <option value='<?php echo $account->account_id; ?>' <?php echo ($entry->account_id==$account->account_id?'selected':''); ?> ><?php echo $account->account_title; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td><input type="text" name="memo[]" class="form-control"  value="<?php echo $entry->memo; ?>"></td>
                                            <td><input type="text" name="dr_amount[]" class="form-control numeric" value="<?php echo number_format($entry->dr_amount,2); ?>"></td>
                                            <td><input type="text" name="cr_amount[]" class="form-control numeric"  value="<?php echo number_format($entry->cr_amount,2);?>"></td>
                                                <td><select  name="department_id_line[]" class="dept show-tick form-control selectpicker" data-live-search="true" >
                                                    <option value="0">[ None ]</option>
                                                    <?php foreach($departments as $department){ ?>
                                                        <option value='<?php echo $department->department_id; ?>'><?php echo $department->department_name; ?></option>
                                                    <?php } ?>
                                                </select></td>
                                            <td>
                                                <button type="button" class="btn btn-default add_account"><i class="fa fa-plus-circle" style="color: green;"></i></button>
                                                <button type="button" class="btn btn-default remove_account"><i class="fa fa-times-circle" style="color: red;"></i></button>
                                            </td>
                                        </tr>
                                    <?php
                                                $dr_total+=$entry->dr_amount;
                                                $cr_total+=$entry->cr_amount;
                                            }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="2" align="right"><strong>Total</strong></td>
                                        <td align="right"><strong><?php echo number_format($dr_total,2); ?></strong></td>
                                        <td align="right"><strong><?php echo number_format($cr_total,2); ?></strong></td>
                                        <td></td>
                                    </tr>
                                    </tfoot>
                                </table>
                                <hr />
                                <label class="col-lg-2"> Remarks :</label><br />
                                <div class="col-lg-12">
                                    <textarea name="remarks" class="form-control" style="width: 100%;" >X Reading Identifier: <?php echo $item->ref_no; ?>, Sales Date: <?php echo $item->sales_date; ?>, Cashier: <?php echo $item->cashier; ?></textarea>
                                </div>
                                <br /><hr /><br>
                    <br>
                    </form>
                    <button name="btn_finalize_journal_review" class="btn btn-primary" ><i class="fa fa-check-circle"></i> <span class=""></span> Finalize this Journal</button>
                </div>    
                <!-- End OF First tab -->
                 <div class="tab-pane" id="pos_review_<?php echo $item_id; ?>" data-parent-id="<?php echo $item_id; ?>" style="min-height: 300px;">
<!--                  Cashier Name: <?php echo $item->cashier; ?><br>
                 Batch Date and Time: <?php echo date_format($date,'m/d/Y H:i:s A');?><br>
                 Beverage Sales - <br>
                 Food Sales - <br>
                 Employees' Food Sales - <br>
                 Senior Citizens and PWD Sales - <br>
                 Customer Discount - <br>
                 On the House - <br>
                 Other Income - <br>
                 Pool Games - <br>
                 Cigarettes - <br>
                 Souvenier - <br>
                 Pool Locker - <br>
                 Charge to Customer - <br> -->








                 </div>
                 <!-- End of Second Tab -->
                </div>
            </td>
        </tr>
    </tbody>
    </table>

<hr>
