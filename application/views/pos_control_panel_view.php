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
    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">

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

        #tbl_pos_integration_filter 
        {
            display:none;
        }
        .right-align{ text-align: left; }
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

                    <ol class="breadcrumb">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="Hotel_control_panel">Control Panel | POS System Integration</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div class="panel panel-default">
                            <div class="panel-body">
                            <h2 class="h2-panel-heading">Control Panel | POS System Integration</h2><hr>
                                <div class="row">
                                    <div class="container-fluid">
                                        <div class="container-fluid group-box">
                                            <div id="new-search-area" class="col-sm-3 col-md-3" style=""><br>
                                                <button class="btn btn-primary pull-left" style="margin-right: 5px; margin-top: 0; margin-bottom: 10px;" id="btn_finalize" style="text-transform: none; font-family: Tahoma, Georgia, Serif; ">
                                                     POST TO ACCOUNTING
                                                </button>
                                            </div>
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

                                </div><br>
                                <div class="row">
                                    <div class="container-fluid">
                                        <div class="container-fluid group-box">
                                            <table id="tbl_pos_integration" class="table table-striped" width="100%" cellspacing="0">
                                                <thead class="">
                                                    <th></th>
                                                    <th>Sales Date</th>
                                                    <th>Debit Amount</th>
                                                    <th>Credit Amount</th>
                                                    <th>Reference No.</th>
                                                    <th style="text-align: center;">Is Equal</th>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
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
                        <li><h6 style="margin: 0;">&copy; 2017 - JDEV IT Business Solutions</h6></li>
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

<!-- Date range use moment.js same as full calendar plugin -->
<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>
<!-- numeric formatter -->
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

<script>

$(document).ready(function(){
    var dt;

    var initializeControl=function(){
        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });
        // getResponse();
        InitializeDataTable();

    }();

    var bindEventHandlers=function(){


    var showSpinningProgress=function(e){
        $(e).toggleClass('disabled');
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
    };



    
    }();

    function InitializeDataTable() {
        dt=$('#tbl_pos_integration').DataTable({
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
                { sClass: 'right-align' , targets:[2],data: "dr_amount" ,render: $.fn.dataTable.render.number( ',', '.', 2 ) },
                { sClass: 'right-align' , targets:[3],data: "cr_amount",render: $.fn.dataTable.render.number( ',', '.', 2 ) },

                { targets:[4],data: "ref_no" },
                                {
                    targets:[5],data: null,
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
    var showNotification=function(obj){
        PNotify.removeAll(); //remove all notifications
        new PNotify({
            title:  obj.title,
            text:  obj.msg,
            type:  obj.stat
        });
    };

    var bindEventHandlers=(function(){
        $('#txt_date').change(function(){
        $('#tbl_pos_integration').DataTable().ajax.reload()
        });

            var detailRows = [];

            $('#tbl_pos_integration tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dt.row( tr );
                var idx = $.inArray( tr.attr('id'), detailRows );

                if ( row.child.isShown() ) {
                    tr.removeClass( 'details' );
                    row.child.hide();

                    // Remove from the 'open' array
                    detailRows.splice( idx, 1 );
                }
                else {
                    tr.addClass( 'details' );
                    var d=row.data();
                    $.ajax({
                        "dataType":"html",
                        "type":"POST",
                        "url":"Templates/layout/pos_control/"+ d.pos_integration_items_id,
                        "beforeSend" : function(){
                            row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                        }
                    }).done(function(response){
                        row.child( response ).show();
                        if ( idx === -1 ) {
                            detailRows.push( tr.attr('id') );
                        }
                    });



                }
            } );
        $("#searchbox").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });
        $('#btn_finalize').click(function(){
            var _data= Array();
            _data.push({name : "txt_date" ,value : $('#txt_date').val() });
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Pos_control_panel/transaction/finalize",
                "data":_data
            }).done(function(response){
                    showNotification(response);
                    dt.clear().destroy();
                    InitializeDataTable();
                });
        });
    })();
});

</script>

</body>

</html>