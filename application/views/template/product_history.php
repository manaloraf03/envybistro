

<div style="padding:1%;" id="journal_review_<?php echo $product_info->product_id; ?>" data-parent-id="<?php echo $product_info->product_id; ?>" >

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
                <?php if(count($products)==0){ ?>
                    <tr>
                        <td colspan="9" style="border: 1px solid lightgrey;padding: 10px;" align="center">No transaction found.</td>
                    </tr>
                <?php } ?>

                <?php foreach($products as $product){ ?>
               <tr>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo date("M d, Y",strtotime($product->txn_date)); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->ref_no; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->type; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->Description; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><?php echo number_format($product->in_qty,0); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><?php echo number_format($product->out_qty,0); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;font-weight: bolder;"><?php echo number_format($product->balance,0); ?></td>
               </tr>
                <?php } ?>

           </tbody>
       </table>
       <br /><br />

   </center>

     <a href="Products/transaction/history-product?id=<?php  echo $product_id?>&type=print" class="btn btn-success btn-sm" name=""  target="_blank" data-toggle="tooltip" data-placement="top" title="Print History" style="margin-right:-5px;"><i class="fa fa-print"></i> Print</a>
&nbsp;
     <a href="Products/Export?product_id=<?php  echo $product_id?>" class="btn btn-success btn-sm" name=""   data-toggle="tooltip" data-placement="top" title="Export To Excel" style="margin-right:-5px;"><i class="fa fa-file-excel-o"></i> Export</a>
&nbsp;
&nbsp;
     <button class="btn btn-success btn-sm" name="" id="btn_email" data-toggle="tooltip" data-placement="top" title="Email" style="margin-right:-5px;"><i class="fa fa-share"></i> Email</button>
&nbsp;
<!--     <button class="btn btn-success btn btn-sm" style="" name="btn_email" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " title="Send to Email" ><i class="fa fa-share"></i> Email
    </button> -->
</div>


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





<script>




$(document).ready(function(){
    var dt; 


       var bindEventHandlers=function(){

            $('#btn_email').on('click', function() {
                showNotification({title:"Sending!",stat:"info",msg:"Please wait for a few seconds."});

                var btn=$(this);
            
                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":'Products/Email?product_id=<?php echo $product_id ?>',
                    "beforeSend": showSpinningProgress(btn)
                }).done(function(response){
                    showNotification(response);
                    showSpinningProgress(btn);

                });
            });

            var showSpinningProgress=function(e){
                $(e).toggleClass('disabled');
                $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
            };


            var showNotification=function(obj){
                PNotify.removeAll(); //remove all notifications
                new PNotify({
                    title:  obj.title,
                    text:  obj.msg,
                    type:  obj.stat
                });
            };

    }();



});




</script>












