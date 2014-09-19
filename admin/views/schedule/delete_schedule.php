<div class="wrap">	
	<h2><?php echo __( 'Delete Schedule') ?></h2>
	<p>Are you sure you want to delete this schedule:</p>
	<form method="post"> 
		<input type="hidden" name="id" value="<?php if($schedule)echo $schedule->id;?>">
		<p>Subject:<?php echo $schedule->subject;?><br />
		Message: <?php echo $schedule->message_body; ?><br />
		Schedule Time: <?php echo $schedule->schedule_time;?>
		</p>
		<div>
			<label>&nbsp;</label>
			 <input type="hidden" name="redirect" value="<?php echo $redirect_url;?>" />
			<input type="submit" name="delete_schedule" value="Delete" />
		</div>
	</form>
</div>
