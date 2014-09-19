<div class="wrap">	
	<?php if(empty($subscriber->id)):?>
	<h2><?php echo __( 'Add Subscriber') ?></h2>
	<?php else:?>
	<h2><?php echo __( 'Edit Subscriber') ?></h2>
	<?php endif;?>
	<?php self::view('status');?>
	<form method="post"> 
		<input type="hidden" name="id" value="<?php if($subscriber)echo $subscriber->id;?>">
		<div>
			<label>Email</label><br />
			<input type="text" name="email" value="<?php if($subscriber)echo $subscriber->email;?>" />
		</div>		
		<div>
			<label>&nbsp;</label>
			<input type="hidden" name="redirect" value="<?php echo $redirect_url;?>" />
			<input type="submit" name="save_subscriber" value="Save" />
		</div>
	</form>
</div>
