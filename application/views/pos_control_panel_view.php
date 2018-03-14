<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <title>JCORE - <?php echo $title; ?></title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-gjep-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="description" content="Avenxo Admin Theme">
    <meta name="author" content="">

    <?php echo $_def_css_files; ?>

    <link rel="stylesheet" href="assets/plugins/spinner/dist/ladda-themeless.min.css">
    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">

    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">


    <!--<link href="assets/dropdown-enhance/dist/css/bootstrar-select.min.css" rel="stylesheet" type="text/css">-->

    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">


    <link type="text/css" href="assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">              <!-- iCheck -->
    <link type="text/css" href="assets/plugins/iCheck/skins/minimal/_all.css" rel="stylesheet">                   <!-- Custom Checkboxes / iCheck -->

    <style>

        .toolbar{
            float: left;
        }

        td.details-control {
            background: url('assets/img/Folder_Closed.png') no-repeat center center;
            cursor: pointer;
        }
        tr.details td.details-control {
            background: url('assets/img/Folder_Opened.png') no-repeat center center;
        }

        .child_table {
            padding: 5px;
            border: 1px #ff0000 solid;
        }

        .glyphicon.spinning {
            animation: spin 1s infinite linear;
            -webkit-animation: spin2 1s infinite linear;    
        }
        .select2-container {
            min-width: 100%;
        }

        @keyframes spin {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1) rotate(360deg); }
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
        }

        .custom_frame{
            border: 1px solid lightgray;
            margin: 1% 1% 1% 1%;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }

        .numeric{
            text-align: right;
        }

        input[type=checkbox] {
          /* Double-sized Checkboxes */
          margin-top: 10px;
          margin-left: 10px;
          -ms-transform: scale(1.5); /* IE */
          -moz-transform: scale(1.5); /* FF */
          -webkit-transform: scale(1.5); /* Safari and Chrome */
          -o-transform: scale(1.5); /* Opera */
        }

        .select2-container { 
            width: 100% !important; 
        } 

        body {
            overflow-x: hidden;
        }
        #tbl_pos_integration_filter 
        {
            display:none;
        }
    </style>

</head>

<body class="animated-content" style="font-family: tahoma;">

<?php echo $_top_navigation; ?>

<div id="wrapper">
<div id="layout-static">

<?php echo $_side_bar_navigation;?>

<div class="static-content-wrapper white-bg">
<div class="static-content"  >

<div class="page-content"><!-- #page-content -->

<ol class="breadcrumb" style="margin-bottom: 0px;">
    <li><a href="dashboard">Dashboard</a></li>
    <li><a href="Pos_control_panel">Pos Control Panel</a></li>
</ol>

<div class="container-fluid">
<div data-widget-group="group1">
<div class="row">
<div class="col-md-12">

<div id="div_payable_list">
        <div class="panel panel-default">
                <div class="panel-body table-responsive">
                    <h2 class="h2-panel-heading">Review Sales Journal (Pos Sales)</h2><hr>
                    <div class="row-panel">
                                    <div class="container-fluid">
                                        <div class="container-fluid group-box">
                                            <div class="col-xs-12 col-md-4" style="margin-bottom: 10px;">
                                                <strong>As of Date :</strong>
                                                <div class="input-group">
                                                    <input id="txt_date" type="text" class="date-picker form-control" value="<?php echo date('m/d/Y'); ?>">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="new-search-area" class="col-sm-2 col-md-2" style="float: right;">
                                             <strong>Search :</strong><br>
                                                <input type="text" id="searchbox" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                        <table id="tbl_pos_integration" class="table table-striped" cellspacing="0" width="100%">
                            <thead class="">
                            <tr>
                                <th></th>
                                <th>Sales Date</th>
                                <th>Cashier</th>
                                <th>Debit Amount</th>
                                <th>Credit Amount</th>
                                <th>X-Reading ID</th>
                                <th style="text-align: center;">Is Equal</th>
                            </tr>
                            </thead>
                            <tbody>
    
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
</div>
                <table id="table_hidden" class="hidden">
                    <tr>
                        <td>
                            <select name="accounts[]" class="selectpicker show-tick form-control selectpicker_accounts" data-live-search="true">
                                <?php foreach($accounts as $account){ ?>
                                    <option value='<?php echo $account->account_id; ?>'><?php echo $account->account_title; ?></option>
                                <?php } ?>
                            </select>   
                        </td>
                        <td><input type="text" name="memo[]" class="form-control"></td>
                        <td><input type="text" name="dr_amount[]" class="form-control numeric"></td>
                        <td><input type="text" name="cr_amount[]" class="form-control numeric"></td>
                        <td>       
                            <select name="department_id_line[]" class="selectpicker show-tick form-control dept" data-live-search="true" >
                                <option value="0">[ None ]</option>
                                <?php foreach($departments as $department){ ?>
                                    <option value='<?php echo $department->department_id; ?>'><?php echo $department->department_name; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <button type="button" class="btn btn-default add_account"><i class="fa fa-plus-circle" style="color: green;"></i></button>
                            <button type="button" class="btn btn-default remove_account"><i class="fa fa-times-circle" style="color: red;"></i></button>
                        </td>
                    </tr>
                </table>

</div>
</div>
</div>
</div> <!-- .container-fluid -->
</div> <!-- #page-content -->
</div>

<footer role="contentinfo">
    <div class="clearfix">
        <ul class="list-unstyled list-inline pull-left">
            <li><h6 style="margin: 0;">&copy; 2017 - JDEV IT BUSINESS SOLUTION</h6></li>
        </ul>
        <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-gjerow-up"></i></button>
    </div>
</footer>

</div>
</div>
</div>



<?php echo $_switcher_settings; ?>
<?php echo $_def_js_files; ?>


<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

<!-- Select2-->
<script src="assets/plugins/select2/select2.full.min.js"></script>
<!---<script src="assets/plugins/dropdown-enhance/dist/js/bootstrar-select.min.js"></script>-->



<!-- Date range use moment.js same as full calendar plugin -->
<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>




<!-- numeric formatter -->
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>



<script>
$(document).ready(function(){
    var _txnMode; var _cboParticulars; var _cboMethods; var _selectRowObj; var _selectedID; var _txnMode;
    var dtReview; var _cboDepartments; var _option; var _optGroup;
    var dtReviewAdjustment;

var dtReviewPos;

    var oTBJournal={
        "dr" : "td:eq(2)",
        "cr" : "td:eq(3)"
    };

    var oTFSummary={
        "dr" : "td:eq(1)",
        "cr" : "td:eq(2)"
    };

    var initializeRecurringTable=function(){
        dtReviewPos=$('#tbl_pos_integration').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "language": {
                searchPlaceholder: "Search..."
            },
            "ajax": {
              "url":"Pos_control_panel/transaction/list",
              "type":"GET",
              // "order": [[ 6, "desc" ]],
              "data":function (d) {
                return $.extend( {}, d, {
                    "aod": $('#txt_date').val()
                });
              }
            },
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "sales_date" },
                { targets:[2],data: "cashier" },
                { sClass: 'right-align' , targets:[3],data: "dr_amount" ,render: $.fn.dataTable.render.number( ',', '.', 2 ) },
                { sClass: 'right-align' , targets:[4],data: "cr_amount",render: $.fn.dataTable.render.number( ',', '.', 2 ) },

                { targets:[5],data: "ref_no" },
                                {
                    targets:[6],data: null,
                    render: function (data, type, full, meta){
                        var _attribute='';
                        //console.log(data.is_email_sent);
                        if(data.is_equal=="1"){
                            _attribute=' class="fa fa-check-circle" style="color:green;" ';
                        }else{
                            _attribute=' class="fa fa-times-circle" style="color:red;" ';
                        }
                        return '<center><i '+_attribute+'></i></center>';
                    }
                }
                
            ]
        });
    };

    var initializeControls=function(){
        initializeRecurringTable();
        reInitializeNumeric();
        reInitializeDropDownAccounts($('#tbl_entries'));


        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true

        });


    }();



    var bindEventHandlers=function(){
        var detailRows = [];
        $('#txt_date').change(function(){
        $('#tbl_pos_integration').DataTable().ajax.reload()
        });
            $('#tbl_pos_integration tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dtReviewPos.row( tr );
                var idx = $.inArray( tr.attr('id'), detailRows );

                if ( row.child.isShown() ) {
                    tr.removeClass( 'details' );
                    row.child.hide();

                    // Remove from the 'open' array
                    detailRows.splice( idx, 1 );
                }
                else {
                    tr.addClass( 'details' );
                    //console.log(row.data());
                    var d=row.data();

                    $.ajax({
                        "dataType":"html",
                        "type":"POST",
                        "url":"Templates/layout/pos_control/"+ d.pos_integration_items_id,
                        "beforeSend" : function(){
                            row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                        }
                    }).done(function(response){
                        row.child( response,'no-padding' ).show();

                        reInitializeSpecificDropDown($('.cbo_customer_list'));
                        reInitializeSpecificDropDown($('.cbo_department_list'));

                        reInitializeNumeric();

                        var tbl=$('#tbl_entries_for_review_'+ d.pos_integration_items_id);
                        var parent_tab_pane=$('#journal_review_'+ d.pos_integration_items_id);
                        reInitializeDropDownAccounts(tbl);
                        reInitializeChildEntriesTableAdjustment(tbl);
                        reInitializeChildElementsAdjustment(parent_tab_pane);

                        // Add to the 'open' array
                        if ( idx === -1 ) {
                            detailRows.push( tr.attr('id') );
                        }


                    });




                }
            } );





        $('#btn_cancel_browsing').on('click',function(){
            $('#modal_recurring').modal('hide');
        });

        $("#searchbox").keyup(function(){         
        dtReviewPos
                .search(this.value)
                .draw();
        });


        //add account button on table
        $('#tbl_entries').on('click','button.add_account',function(){

            var row=$('#table_hidden').find('tr');
            row.clone().insertAfter('#tbl_entries > tbody > tr:last');

            reInitializeNumeric();
            reInitializeDropDownAccounts($('#tbl_entries'));

        });

        var _oTblEntries=$('#tbl_entries > tbody');
        _oTblEntries.on('keyup','input.numeric',function(){
            var _oRow=$(this).closest('tr');

            if(_oTblEntries.find(oTBJournal.dr).index()===$(this).closest('td').index()){ //if true, this is Debit amount
                if(getFloat(_oRow.find(oTBJournal.dr).find('input.numeric').val())>0){
                    _oRow.find(oTBJournal.cr).find('input.numeric').val('0.00');
                }
            }else{

                if(getFloat(_oRow.find(oTBJournal.cr).find('input.numeric').val())>0) {
                    _oRow.find(oTBJournal.dr).find('input.numeric').val('0.00');
                }
            }


            reComputeTotals($('#tbl_entries'));
        });


        $('#tbl_accounts_receivable').on('click','button[name="cancel_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.journal_id;
            $('#modal_confirmation').modal('show');
        });


        $('#btn_yes').click(function(){
            $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"General_journal/transaction/cancel",
                "data":{journal_id : _selectedID},
                "success": function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                        dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                    }

                }
            });
        });


        $('#tbl_accounts_receivable').on('click','button[name="edit_info"]',function(){
            _txnMode="edit";

            $('#div_check').hide();
            $('#div_no_check').show();

            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.journal_id;


            $('input,textarea').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name){
                        _elem.val(value);
                    }
                });
            });

           _cboParticulars.select2('val',data.particular_id);
           _cboDepartments.select2('val',data.department_id);

            $.ajax({
                url: 'General_journal/transaction/get-entries?id=' + data.journal_id,
                type: "GET",
                cache: false,
                dataType: 'html',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#tbl_entries > tbody').html('<tr><td align="center" colspan="4"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                }
            }).done(function(response){
                $('#tbl_entries > tbody').html(response);
                reInitializeNumeric();
                reInitializeDropDownAccounts($('#tbl_entries'));
                reComputeTotals($('#tbl_entries'));
            });
            showList(false);
        });

        $('#tbl_entries').on('click','button.remove_account',function(){
            var oRow=$('#tbl_entries > tbody tr');

            if(oRow.length>1){
                $(this).closest('tr').remove();
            }else{
                showNotification({"title":"Error!","stat":"error","msg":"Sorry, you cannot remove all rows."});
            }
            reComputeTotals($('#tbl_entries'));
        });

        $('#btn_save').click(function(){
            var btn=$(this);
            var f=$('#frm_journal');

            if(validateRequiredFields(f)){
                if(_txnMode=="new"){
                    createJournal().done(function(response){
                        showNotification(response);
                        $('#btn_save').attr('disabled',true);
                        if(response.stat=="success"){
                            dt.row.add(response.row_added[0]).draw();
                            clearFields(f);
                            showList(true);
                            $('#btn_save').attr('disabled',false);
                        }

                    }).always(function(){
                        showSpinningProgress(btn);
                    });

                    if ($('input[name="chk_save"]').is(':checked')) {
                        createTemplate().done(function(response){
                            showNotification(response);
                        }).always(function(){
                            showSpinningProgress(btn);
                        });
                    }
                }else{
                    updateJournal().done(function(response){
                        showNotification(response);
                        $('#btn_save').attr('disabled',true);
                        if(response.stat=="success"){
                            dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                            clearFields(f);
                            showList(true);
                            $('#btn_save').attr('disabled',false);
                        }

                    }).always(function(){
                        showSpinningProgress(btn);
                    });
                }

            }

        });

        $('#btn_save_customer').click(function(){
            if(validateRequiredFields($('#frm_customer'))){
                createCustomer().done(function(response){
                    showNotification(response);
                    var _customer = response.row_added[0];
                    _cboParticulars.select2().find('optgroup[label="Customers"]').append('<option value="'+ 'C-'+_customer.customer_id +'">'+ _customer.customer_name +'</option>');
                    _cboParticulars.select2('val','C-'+_customer.customer_id);
                    $('input,textarea,select',$('#frm_customer')).val('');
                }).always(function(){
                    $('#modal_create_customer').modal('toggle');
                    showSpinningProgress($('#btn_save_supplier'));
                });
                return;
            }
        });

        $('#btn_save_supplier').click(function(){
            if(validateRequiredFields($('#frm_supplier'))){
                createSupplier().done(function(response){
                    showNotification(response);
                    var _supplier = response.row_added[0];
                    _cboParticulars.select2().find('optgroup[label="Suppliers"]').append('<option value="'+ 'S-'+_supplier.supplier_id +'">'+ _supplier.supplier_name +'</option>');
                    _cboParticulars.select2('val','S-'+_supplier.supplier_id);
                    clearFields($('#frm_supplier'));
                }).always(function(){
                    $('#modal_create_suppliers').modal('toggle');
                    showSpinningProgress($('#btn_save_supplier'));
                });
                return;
            }
        });

        $('#btn_cancel').click(function(){
            showList(true);
        });
    }();

    //*********************************************************************8
    //              user defines

        var reInitializeChildEntriesTable=function(tbl){

            var _oTblEntries=tbl.find('tbody');
            _oTblEntries.on('keyup','input.numeric',function(){
                var _oRow=$(this).closest('tr');

                if(_oTblEntries.find(oTBJournal.dr).index()===$(this).closest('td').index()){ //if true, this is Debit amount
                    if(getFloat(_oRow.find(oTBJournal.dr).find('input.numeric').val())>0){
                        _oRow.find(oTBJournal.cr).find('input.numeric').val('0.00');
                    }
                }else{
                    if(getFloat(_oRow.find(oTBJournal.cr).find('input.numeric').val())>0) {
                        _oRow.find(oTBJournal.dr).find('input.numeric').val('0.00');
                    }
                }
                reComputeTotals(tbl);
            });



            //add account button on table
            tbl.on('click','button.add_account',function(){

                var row=$('#table_hidden').find('tr');
                row.clone().insertAfter(tbl.find('tbody > tr:last'));

                reInitializeNumeric();
                reInitializeDropDownAccounts(tbl,false);

            });


            tbl.on('click','button.remove_account',function(){
                var oRow=tbl.find('tbody tr');

                if(oRow.length>1){
                    $(this).closest('tr').remove();
                }else{
                    showNotification({"title":"Error!","stat":"error","msg":"Sorry, you cannot remove all rows."});
                }

                reComputeTotals(tbl);

            });




        };
        var reInitializeChildEntriesTableAdjustment=function(tbl){

            var _oTblEntries=tbl.find('tbody');
            _oTblEntries.on('keyup','input.numeric',function(){
                var _oRow=$(this).closest('tr');

                if(_oTblEntries.find(oTBJournal.dr).index()===$(this).closest('td').index()){ //if true, this is Debit amount
                    if(getFloat(_oRow.find(oTBJournal.dr).find('input.numeric').val())>0){
                        _oRow.find(oTBJournal.cr).find('input.numeric').val('0.00');
                    }
                }else{
                    if(getFloat(_oRow.find(oTBJournal.cr).find('input.numeric').val())>0) {
                        _oRow.find(oTBJournal.dr).find('input.numeric').val('0.00');
                    }
                }
                reComputeTotals(tbl);
            });



            //add account button on table
            tbl.on('click','button.add_account',function(){

                var row=$('#table_hidden').find('tr');
                row.clone().insertAfter(tbl.find('tbody > tr:last'));

                reInitializeNumeric();
                reInitializeDropDownAccounts(tbl,false);

            });


            tbl.on('click','button.remove_account',function(){
                var oRow=tbl.find('tbody tr');

                if(oRow.length>1){
                    $(this).closest('tr').remove();
                }else{
                    showNotification({"title":"Error!","stat":"error","msg":"Sorry, you cannot remove all rows."});
                }

                reComputeTotals(tbl);

            });




        };

        var reInitializeChildElementsAdjustment=function(parent){
            var _dataParentID=parent.data('parent-id');
            var btn=parent.find('button[name="btn_finalize_journal_review"]');

            //initialize datepicker
            parent.find('input.date-picker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true

            });

            parent.on('click','button[name="btn_finalize_journal_review"]',function(){
       
                var _curBtn=$(this);

                if(isBalance('#tbl_entries_for_review_'+_dataParentID)){
                    if(validateRequiredFields('#tbl_entries_for_review_'+_dataParentID)){
                        finalizeJournalReview().done(function(response){
                            showNotification(response);
                            if(response.stat=="success"){
                                var _parentRow=_curBtn.parents('table.table_journal_entries_review').parents('tr').prev();
                                dtReviewPos.row(_parentRow).remove().draw();
                            }


                    }).always(function(){
                        showSpinningProgress(_curBtn);
                    }); 

                    }

                }else{
                    showNotification({title:"Not Balance!",stat:"error",msg:'Please make sure Debit and Credit amount are equal.'});
                    stat=false;
                }

            });

            var finalizeJournalReview=function(){
                var _data_review=parent.find('form').serializeArray();
            
                return $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Pos_control_panel/transaction/create-pos",
                    "data":_data_review,
                    "beforeSend": showSpinningProgress(btn)

                });
            };



        };

        var reInitializeChildElements=function(parent){
            var _dataParentID=parent.data('parent-id');
            var btn=parent.find('button[name="btn_finalize_journal_review"]');

            //initialize datepicker
            parent.find('input.date-picker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true

            });


            parent.on('click','button[name="btn_finalize_journal_review"]',function(){

                var _curBtn=$(this);

                if(isBalance('#tbl_entries_for_review_'+_dataParentID)){
                    if(validateRequiredFields('#tbl_entries_for_review_'+_dataParentID)){
                                           finalizeJournalReview().done(function(response){
                        showNotification(response);
                        if(response.stat=="success"){
                            dt.row.add(response.row_added[0]).draw();
                            var _parentRow=_curBtn.parents('table.table_journal_entries_review').parents('tr').prev();
                            dtReview.row(_parentRow).remove().draw();
                        }


                    }).always(function(){
                        showSpinningProgress(_curBtn);
                    }); 
                    }

                }else{
                    showNotification({title:"Not Balance!",stat:"error",msg:'Please make sure Debit and Credit amount are equal.'});
                    stat=false;
                }

            });

            var finalizeJournalReview=function(){
                var _data_review=parent.find('form').serializeArray();

                return $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"General_journal/transaction/create",
                    "data":_data_review,
                    "beforeSend": showSpinningProgress(btn)

                });
            };



        };





    var createJournal=function(){
        var _data=$('#frm_journal').serializeArray();
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"General_journal/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))

        });
    };

    var createCustomer=function(){
        var _data=$('#frm_customer').serializeArray();
        _data.push({name : "photo_path" ,value : $('img[name="img_customer"]').attr('src')});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Customers/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var createSupplier=function() {
        var _data=$('#frm_supplier').serializeArray();
        _data.push({name : "photo_path" ,value : $('img[name="img_supplier"]').attr('src')});
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Suppliers/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save_supplier'))
        });
    };


    var updateJournal=function(){
        var _data=$('#frm_journal').serializeArray();
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"General_journal/transaction/update?id="+_selectedID,
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var createTemplate=function(){
        var _data=$('#frm_journal').serializeArray();
        _data.push({ name:'template_code', value:$("#cbo_particulars option:selected").text() });
        _data.push({ name:'book_type', value: 'GJE'});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Recurring_template/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var showList=function(b){
        if(b){
            $('#div_payable_list').show();
            $('#div_payable_fields').hide();
        }else{
            $('#div_payable_list').hide();
            $('#div_payable_fields').show();
        }
    };

    var clearFields=function(f){
        $('input,textarea',f).val('');
        $(f).find('select').select2('val',null); 
        //_cboDepartments.select2('val',null);
        $(f).find('input:first').focus();
        $('#tbl_entries > tbody tr').slice(2).remove();

        $('#tbl_entries > tfoot tr').find(oTFSummary.dr).html('<b>0.00</b>');
        $('#tbl_entries > tfoot tr').find(oTFSummary.cr).html('<b>0.00</b>');
    };

    //initialize numeric text
    function reInitializeNumeric(){
        $('.numeric').autoNumeric('init');
    };

    function reInitializeDropDownAccounts(tbl){
        tbl.find('select.selectpicker').select2({
            placeholder: "Please select account.",
            allowClear: false
        });
    };


    function reInitializeSpecificDropDown(elem){
        elem.select2({
            placeholder: "Please select item.",
            allowClear: false
        });
    };

    var showSpinningProgress=function(e){
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
    };


    var reComputeTotals=function(tbl){
        var oRows=tbl.find('tbody tr');
        var _DR_amount=0.00; var _CR_amount=0.00;

        $.each(oRows,function(i,value){
            _DR_amount+=getFloat($(this).find(oTBJournal.dr).find('input.numeric').val());
            _CR_amount+=getFloat($(this).find(oTBJournal.cr).find('input.numeric').val());


        });



        tbl.find('tfoot tr').find(oTFSummary.dr).html('<b>'+accounting.formatNumber(_DR_amount,2)+'</b>');
        tbl.find('tfoot tr').find(oTFSummary.cr).html('<b>'+accounting.formatNumber(_CR_amount,2)+'</b>');

    };

    var getFloat=function(f){
        return parseFloat(accounting.unformat(f));
    };


    var showNotification=function(obj){
        PNotify.removeAll(); //remove all notifications
        new PNotify({
            title:  obj.title,
            text:  obj.msg,
            type:  obj.stat
        });
    };


    var validateRequiredFields=function(f){
        var stat=true;

        $('div.form-group').removeClass('has-error');
        $('input[required],textarea[required],select[required]',f).each(function(){

            if($(this).is('select')){
                if($(this).select2('val')==0||$(this).select2('val')==null){
                    showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                    $(this).closest('div.form-group').addClass('has-error');
                    $(this).focus();
                    stat=false;
                    return false;
                }
            }else{
                if($(this).val()==""){
                    showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                    $(this).closest('div.form-group').addClass('has-error');
                    $(this).focus();
                    stat=false;
                    return false;
                }
            }
        });


        if(!isBalance()){
            showNotification({title:"Error!",stat:"error",msg:'Please make sure Debit and Credit amount are equal.'});
            stat=false;
        }

        return stat;
    };


    var isBalance=function(opTable=null){
        var oRow; var dr; var cr;

        if(opTable==null){
            oRow=$('#tbl_entries > tfoot tr');
        }else{
            oRow=$(opTable+' > tfoot tr');
        }

        dr=getFloat(oRow.find(oTFSummary.dr).text());
        cr=getFloat(oRow.find(oTFSummary.cr).text());

        return (dr==cr);
    };



});


</script>

</body>

</html>