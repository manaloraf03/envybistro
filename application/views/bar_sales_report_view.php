<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <title>JCORE - <?php echo $title; ?></title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="description" content="Avenxo Admin Theme">
    <meta name="author" content="">

    <?php echo $_def_css_files; ?>

    <link rel="stylesheet" href="assets/plugins/spinner/dist/ladda-themeless.min.css">
    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">


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

        .child_table{
            padding: 5px;
            border: 1px #ff0000 solid;
        }

        .glyphicon.spinning {
            animation: spin 1s infinite linear;
            -webkit-animation: spin2 1s infinite linear;
        }

        @keyframes spin {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1) rotate(360deg); }
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
        }

        .select2-container {
            min-width: 100%;
            z-index: 999999999;
        }
        .right-align{
            text-align: right;
        }

    </style>

</head>

<body class="animated-content">

<?php echo $_top_navigation; ?>

<div id="wrapper">
    <div id="layout-static">

        <?php echo $_side_bar_navigation;?>

        <div class="static-content-wrapper white-bg">
            <div class="static-content"  >
                <div class="page-content"><!-- #page-content -->
                    <ol class="breadcrumb" style="margin:0;">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="Bar Sales Report">Bar Sales Report</a></li>
                    </ol>
                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">

                                    <div id="div_bar_list">
                                        <div class="panel panel-default">

                                            <div class="panel-body table-responsive">
                                            <h2 class="h2-panel-heading">Bar Sales Report</h2><hr>
                                            <div class="row">
                                            <div class="col-sm-4">
                                                <b class="required">*</b> <label>Cashier </label>:<br />
                                                <select name="cashier" id="cashier" >
                                                    <option value="0"> ALL</option>
                                                    <?php foreach($cashiers as $cashier){ ?>
                                                        <option value="<?php echo $cashier->cashier; ?>"><?php echo $cashier->cashier; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <b class="required">*</b> <label>From: </label>:<br />
                                                <div class="input-group">
                                                    <input id="from_date" type="text" class="date-picker form-control" value="<?php echo date("m"); ?>/01/<?php echo date("Y"); ?>">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <b class="required">*</b> <label>To: </label>:<br />
                                                <div class="input-group">
                                                    <input id="to_date" type="text" class="date-picker form-control" value="<?php echo date('m/d/Y'); ?>">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <button class="btn btn-primary pull-left" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_print"  data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Print" ><i class="fa fa-print"></i> Print Report
                                            </button>
                                            </div>
                                            <div class="col-sm-2">
                                                <button class="btn btn-success pull-left" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_excel" data-placement="left" title="Export to Excel" ><i class="fa fa-file-excel-o"></i> Export Report
                                            </button>
                                            </div>
                                            <div class="col-sm-2">
                                                <button class="btn btn-success pull-left" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_email" data-placement="left" title="Sent to Email" ><span class=""></span> <i class="fa  fa-envelope-o"></i> Send Report
                                            </button>
                                            </div>
                                                <table id="tbl_bar" class="table table-striped" cellspacing="0" width="100%">

                                                    <thead class="">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Date</th>
                                                        <th>Cashier</th>
                                                        <th>Total Amount</th>
                                                        <th>Cash</th>
                                                        <th>Check</th>
                                                        <th>Card</th>
                                                        <th>Gift Check</th>
                                                        <th>AR Amount</th>
                                                        
                                                    </tr>
                                                    </thead>

                                                    <tbody>

                                                    </tbody>
                                                                                                <tfoot>
                                                            <tr>
                                                                <td colspan="3" style="text-align:right;">Current Page Total :</td>
                                                                <td  style="text-align:right;" id="Sum"></td>
                                                                <td  style="text-align:right;" id="cash"></td>
                                                                <td  style="text-align:right;" id="check"></td>
                                                                <td  style="text-align:right;" id="card"></td>
                                                                <td  style="text-align:right;" id="gc"></td>
                                                                <td  style="text-align:right;" id="ar"></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" style="text-align:right;">All Pages Total :</td>
                                                                <td  style="text-align:right;" id="Sum1"></td>
                                                                <td  style="text-align:right;" id="cash1"></td>
                                                                <td  style="text-align:right;" id="check1"></td>
                                                                <td  style="text-align:right;" id="card1"></td>
                                                                <td  style="text-align:right;" id="gc1"></td>
                                                                <td  style="text-align:right;" id="ar1"></td>
                                                            </tr>
                                                        </tfoot>
                                                </table>
                                            </div>
                                            <div class="panel-footer"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div> <!-- .container-fluid -->

                </div> <!-- #page-content -->
            </div>




            <footer role="contentinfo">
                <div class="clearfix">
                    <ul class="list-unstyled list-inline pull-left">
                        <li><h6 style="margin: 0;">&copy; 2016 - Paul Christian Rueda</h6></li>
                    </ul>
                    <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
                </div>
            </footer>

        </div>
    </div>
</div>


<?php echo $_switcher_settings; ?>
<?php echo $_def_js_files; ?>

<script src="assets/plugins/spinner/dist/spin.min.js"></script>
<script src="assets/plugins/spinner/dist/ladda.min.js"></script>
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="assets/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

<script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _cashier;

    var initializeControls=function(){
        dt=$('#tbl_bar').DataTable({
            "dom": '<"toolbar">frtip',
            "order": [[ 0, "asc" ]],
            "bLengthChange":false,
            "ajax": {
              "url":"Bar_sales_report/transaction/list",
              "type":"GET",
              // "order": [[ 6, "desc" ]],
              "data":function (d) {
                return $.extend( {}, d, {
                    "frm": $('#from_date').val(),
                    "to": $('#to_date').val(),
                    "cashier": $('#cashier').val()
                });
              }
            },
            "language": {
                "searchPlaceholder":"Search"
            },
            "columns": [
                { visible:false, targets:[0],data: "pos_integration_items_id" },
                { targets:[1],data: "sales_date" },
                { targets:[2],data: "cashier" },
                { sClass:"right-align", targets:[3],data: "total_amount", render: $.fn.dataTable.render.number( ',', '.', 2) },
                {  sClass:"right-align",targets:[4],data: "cash_amount",  render: $.fn.dataTable.render.number( ',', '.', 2) },
                {  sClass:"right-align",targets:[5],data: "check_amount", render: $.fn.dataTable.render.number( ',', '.', 2) },
                {  sClass:"right-align",targets:[6],data: "card_amount", render: $.fn.dataTable.render.number( ',', '.', 2) },
                {  sClass:"right-align",targets:[7],data: "gc_amount", render: $.fn.dataTable.render.number( ',', '.', 2) },
                {  sClass:"right-align",targets:[8],data: "ar_amount", render: $.fn.dataTable.render.number( ',', '.', 2) },

            ],
                    "footerCallback": function ( row, data, start, end, display ) {
                        var api = this.api(), data;
                       // console.log(data);
             
                        // Remove the formatting to get integer data for summation
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };
             
                        // Total over this page
                        pageTotalAmount = api
                            .column( 3, { page: 'current'} )
                            .data()
                            .reduce( function (a, b) {
                                // console.log(intVal(a) + intVal(b));
                                return intVal(a) + intVal(b);
                            }, 0 );

                        pageTotalcash = api
                            .column( 4, { page: 'current'} )
                            .data()
                            .reduce( function (a, b) {
                                // console.log(intVal(a) + intVal(b));
                                return intVal(a) + intVal(b);
                            }, 0 );

                        pageTotalcheck = api
                            .column( 5, { page: 'current'} )
                            .data()
                            .reduce( function (a, b) {
                                // console.log(intVal(a) + intVal(b));
                                return intVal(a) + intVal(b);
                            }, 0 );
                        pageTotalcard = api
                            .column( 6, { page: 'current'} )
                            .data()
                            .reduce( function (a, b) {
                                // console.log(intVal(a) + intVal(b));
                                return intVal(a) + intVal(b);
                            }, 0 );

                        pageTotalgc = api
                            .column( 7, { page: 'current'} )
                            .data()
                            .reduce( function (a, b) {
                                // console.log(intVal(a) + intVal(b));
                                return intVal(a) + intVal(b);
                            }, 0 );


                        pageTotalar = api
                            .column( 8, { page: 'current'} )
                            .data()
                            .reduce( function (a, b) {
                                // console.log(intVal(a) + intVal(b));
                                return intVal(a) + intVal(b);
                            }, 0 );






                        // Total over this page
                        pageTotalAmount1  = api
                            .column(3)
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );

                        pageTotalcash1  = api
                            .column(4)
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );

                        pageTotalcheck1 = api
                            .column(5)
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );
                        pageTotalcard1  = api
                            .column(6)
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );

                        pageTotalgc1 = api
                            .column(7)
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );

                        pageTotalar1 = api
                            .column(8)
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );



                        // Total over all pages
                        // totalAmount = api
                        //     .column(3)
                        //     .data()
                        //     .reduce( function (a, b) {
                        //         return intVal(a) + intVal(b);
                        //     }, 0 );

                         $('#Sum').html('<b> '+accounting.formatNumber(pageTotalAmount,2)+'</b>');
                         $('#cash').html('<b> '+accounting.formatNumber(pageTotalcash,2)+'</b>');
                         $('#check').html('<b> '+accounting.formatNumber(pageTotalcheck,2)+'</b>');
                         $('#card').html('<b> '+accounting.formatNumber(pageTotalcard,2)+'</b>');
                         $('#gc').html('<b> '+accounting.formatNumber(pageTotalgc,2)+'</b>');
                         $('#ar').html('<b> '+accounting.formatNumber(pageTotalar,2)+'</b>');



                        $('#Sum1').html('<b> '+accounting.formatNumber(pageTotalAmount1,2)+'</b>');
                         $('#cash1').html('<b> '+accounting.formatNumber(pageTotalcash1,2)+'</b>');
                         $('#check1').html('<b> '+accounting.formatNumber(pageTotalcheck1,2)+'</b>');
                         $('#card1').html('<b> '+accounting.formatNumber(pageTotalcard1,2)+'</b>');
                         $('#gc1').html('<b> '+accounting.formatNumber(pageTotalgc1,2)+'</b>');
                         $('#ar1').html('<b> '+accounting.formatNumber(pageTotalar1,2)+'</b>');
                         // $('#Sumofallpages').html('<b> '+accounting.formatNumber(totalAmount,2)+'</b>');

                    }
        });

        _cashier=$('#cashier').select2({
            placeholder: "Please Select a Cashier",
            allopwClear: true
        });
        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });
    }();
    var bindEventHandlers=(function(){
        _cashier.change(function(){
        $('#tbl_bar').DataTable().ajax.reload()
        });
        $('#from_date').change(function(){
            $('#tbl_bar').DataTable().ajax.reload()          
        });
        $('#to_date').change(function(){
            $('#tbl_bar').DataTable().ajax.reload()          
        });
        $('#btn_print').click(function(){
            window.open('Bar_sales_report/transaction/print?frm='+ $('#from_date').val() +'&to='+ $('#to_date').val()+'&cashier='+ $('#cashier').val()+'&type=contentview');
        });
        $('#btn_excel').click(function(){
            window.open('Bar_sales_report/transaction/export?frm='+ $('#from_date').val() +'&to='+ $('#to_date').val()+'&cashier='+ $('#cashier').val()+'&type=contentview');
        });
       $('#btn_email').on('click', function() {
                showNotification({title:"Sending!",stat:"info",msg:"Please wait for a few seconds."});

                var btn=$(this);
            
                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":'Bar_sales_report/transaction/email?frm='+ $('#from_date').val() +'&to='+ $('#to_date').val()+'&cashier='+ $('#cashier').val()+'&type=contentview',
                    "beforeSend": showSpinningProgress(btn)
                }).done(function(response){
                    showNotification(response);
                    showSpinningProgress(btn);

                });
                });
    })();

            var showNotification=function(obj){
            PNotify.removeAll(); //remove all notifications
            new PNotify({
                title:  obj.title,
                text:  obj.msg,
                type:  obj.stat
            });
            };


        var showSpinningProgress=function(e){
            $(e).toggleClass('disabled');
            $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
        };

});

</script>

</body>

</html>