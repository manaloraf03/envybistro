<table style="font-family: 'Century Gothic', sans-serif;">
	<tr>
		<td colspan="6"><strong>PER SALES</strong></td>
	</tr>
	<?php foreach($receivables as $item){ ?>
		<?php if ($item->is_sales == '1') { ?>
	    <tr>
	        <td><?php echo $item->inv_no; ?></td>
	        <td><?php echo $item->date_due; ?></td>
	        <td><?php echo $item->remarks; ?></td>
	        <td align="right"><input type="text" name="receivable_amount[]" style="text-align: right;" class="form-control" value="<?php echo number_format($item->amount_due,2); ?>" readonly></td>
	        <td><input type="text" name="payment_amount[]" class="numeric form-control" /><input type="hidden" name="journal_id[]" value="<?php echo $item->journal_id; ?>">
	        	<input type="hidden" name="is_sales[]" value="<?php echo $item->is_sales; ?>" />
	        </td>
	        <td align="center"><button type="button" class="btn btn-success btn_set_amount"><i class="fa fa-check"></i></button></td>
	        
	    </tr>
	    <?php } ?>
	<?php } ?>
	<tr>
		<td colspan="6"><strong>PER SERVICES</strong></td>
	</tr>
	<?php foreach($receivables as $item){ ?>
		<?php if ($item->is_sales == '0') { ?>
	    <tr>
	        <td><?php echo $item->inv_no; ?></td>
	        <td><?php echo $item->date_due; ?></td>
	        <td><?php echo $item->remarks; ?></td>
	        <td align="right"><input type="text" name="receivable_amount[]" style="text-align: right;" class="form-control" value="<?php echo number_format($item->amount_due,2); ?>" readonly></td>
	        <td><input type="text" name="payment_amount[]" class="numeric form-control" /><input type="hidden" name="journal_id[]" value="<?php echo $item->journal_id; ?>">
	        	<input type="hidden" name="is_sales[]" value="<?php echo $item->is_sales; ?>" />
	        </td>
	        <td align="center"><button type="button" class="btn btn-success btn_set_amount"><i class="fa fa-check"></i></button></td>
	    </tr>
	    <?php } ?>
	<?php } ?>
</table>