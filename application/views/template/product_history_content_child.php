<!DOCTYPE html>
<html>
<head>
  <title>Product History</title>
  <style>
    body {
      font-family: 'Segoe UI',sans-serif;
      font-size: 12px;
    }
    table, th, td { border-color: white; }
    tr { border-bottom: none !important; }

    .report-header {
      font-size: 22px;
    }
        .right-align{
            text-align: right;
        }
        @media print {
      @page { margin: 0; size: landscape; }
      body { margin: 1.0cm; }
}
  </style>
  <script>
    (function(){
      window.print();
    })();
  </script>
</head>
<body>
       <table width="100%">
        <tr>
            <td width="10%"><img src="<?php echo base_url().$company_info->logo_path; ?>" style="height: 90px; width: 120px; text-align: left;"></td>
            <td width="90%" class="">
                <span style="font-size: 20px;" class="report-header"><strong><?php echo $company_info->company_name; ?></strong></span><br>
                <span><?php echo $company_info->company_address; ?></span><br>
                <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br>
                <span><?php echo $company_info->email_address; ?></span>
            </td>
        </tr>
    </table><hr>
    <div>
        <h3><strong>Product History</strong></h3>
    </div>
<b>Unit of Measurement :</b> <?php echo $info[0]->child_unit_name?><br><br>
   <center>
       <table width="100%"  style="border-collapse: collapse;">
           <thead>
                <tr class="">
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Txn Date</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Reference</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Txn Type</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Description</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>In</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>Out</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>Balance</b></td>

                </tr>

           </thead>
           <tbody>
                <?php if(count($products_parent)==0){ ?>
                    <tr>
                        <td colspan="9" style="border: 1px solid lightgrey;padding: 10px;" align="center">No transaction found.</td>
                    </tr>
                <?php } ?>

                <?php foreach($products_child as $product){ ?>
               <tr>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo date("M d, Y",strtotime($product->txn_date)); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->ref_no; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->type; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->Description; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><?php echo number_format($product->child_in_qty,2); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><?php echo number_format($product->child_out_qty,2); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;font-weight: bolder;"><?php echo number_format($product->child_balance,2); ?></td>
               </tr>
                <?php } ?>
           </tbody>
       </table>
   </center>

<style>
  tr {
      border: none!important;
  }

/*  tr:nth-child(even){
      background: #414141 !important;
      border: none!important;
  }

  tr:hover {
      transition: .4s;
      background: #414141 !important;
      color: white;
  }

  tr:hover .btn {
      border-color: #494949!important;
      border-radius: 0!important;
      -webkit-box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
      -moz-box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
      box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
  }*/
</style>



















<style>
  tr {
      border: none!important;
  }

</style>

</body>
</html>
















