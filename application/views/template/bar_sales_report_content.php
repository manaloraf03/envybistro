<head>
    <title>Bar Sales</title>
    </head>
    <body><style type="text/css" media="print">
  @page { size: portrait; }
</style>

<style>
    body {
            font-family: 'Calibri',sans-serif;
            font-size: 12px;
        }

        .align-right {
            text-align: right;
        }

        .align-left {
            text-align: left;
        }

        .data {
      /*      border-bottom: 1px solid #404040;*/
        }

        .align-center {
            text-align: center;
        }

        .report-header {
            font-weight: bolder;
        }

        hr {
     /*       border-top: 3px solid #404040;*/
        }

        thead td{
            font-weight: bolder;
        }
.left {border-left: 1px solid black;}
.right{border-right: 1px solid black;}
.bottom{border-bottom: 1px solid black;}
.top{border-top: 1px solid black;}
.fifteen{ width: 15%; }
.text-center{text-align: center;}
.text-right{text-align: right;}
span {
    font-size: 14px;
}
</style>

<div>
    <table width="100%" cellspacing="5" cellspacing="0">
        <tr>
            <td width="10%"  class="bottom"><img src="<?php echo base_url($company_info->logo_path); ?>" style="height: 90px; width: 120px; text-align: left;"></td>
            <td width="90%"  class="bottom" >
                <h1 class="report-header" style="margin-bottom: 0"><strong><?php echo $company_info->company_name; ?></strong></h1>
                <span><?php echo $company_info->company_address; ?></span><br>
                <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br>
                <span><?php echo $company_info->email_address; ?></span><br>

            </td>
        </tr>
    </table>
    <h1 class="text-center report-header">Bar Sales Report</h1>
    <span>Cashier: <?php  $cashier = $this->input->get('cashier',TRUE); echo ($cashier == '0')? 'ALL' : $cashier; ?></span><br>   
    <span>Date: <?php echo $from; ?> - <?php echo $to; ?></span>

    <table cellspacing="0" cellpadding="5" width="100%">
    <thead>
        <td class="left top bottom">Date</td>
        <td  class=" top bottom">Cashier</td>   
        <td  class="text-right top bottom">Total</td>
        <td class="text-right top bottom">Cash</td>
        <td class="text-right top bottom">Check</td>
        <td class="text-right top bottom">Card</td>
        <td class="text-right top bottom ">Gift Check</td>
        <td class="text-right top bottom right">A/R</td>

    </thead>
        <tbody>
    <?php
$total = 0;
$total_cash = 0;
$total_card = 0;
$total_check = 0;
$total_gc = 0;
$total_ar = 0;


     foreach ($reports as $report) { ?>
    <tr>
    <td class="  left bottom"><?php echo $report->sales_date; ?></td>
    <td class=" bottom"><?php echo $report->cashier; ?></td>
    <td class="text-right  bottom"><?php echo number_format($report->total_amount,2); ?></td>
    <td class="text-right  bottom"><?php echo number_format($report->cash_amount,2); ?></td>
    <td class="text-right  bottom"><?php echo number_format($report->check_amount,2); ?></td>
    <td class="text-right  bottom"><?php echo number_format($report->card_amount,2); ?></td>
    <td class="text-right bottom"><?php echo number_format($report->gc_amount,2); ?></td>
    <td class="text-right right bottom"><?php echo number_format($report->ar_amount,2); ?></td>
    </tr>
   <?php 
   $total += $report->total_amount ;
   $total_cash += $report->cash_amount;
   $total_card += $report->card_amount;
   $total_check+= $report->check_amount;
   $total_gc+= $report->gc_amount;
   $total_ar+= $report->ar_amount;

    } ?>
    <tr>
        <td class="  left bottom"></td>
        <td class=" bottom"></td>
        <td  class="text-right  bottom" style="font-weight: bolder;"><?php echo number_format($total,2); ?></td>
        <td  class="text-right  bottom" style="font-weight: bolder;"><?php echo number_format($total_cash,2); ?></td>
        <td  class="text-right  bottom" style="font-weight: bolder;"><?php echo number_format($total_check,2); ?></td>
        <td  class="text-right  bottom" style="font-weight: bolder;"><?php echo number_format($total_card,2); ?></td>
        <td class="text-right  bottom" style="font-weight: bolder;"><?php echo number_format($total_gc,2); ?></td>
        <td class="text-right right bottom" style="font-weight: bolder;"><?php echo number_format($total_ar,2); ?></td>
    </tr>
    </tbody>
    </table>
    <center>

    </center>
</div>



<script type="text/javascript">
window.onload = function () {
    window.print();
}    

</script>
















