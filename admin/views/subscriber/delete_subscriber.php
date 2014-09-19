<div class="wrap">	
	<h2><?php echo __( 'Delete Subscriber') ?></h2>
	<p>Are you sure you want to delete this subscriber:</p>
	<form method="post"> 
		<input type="hidden" name="id" value="<?php if($subscriber)echo $subscriber->email;?>">
		<p>Id:<?php echo $subscriber->id;?><br />
		Email: <?php echo $subscriber->email; ?>		
		</p>
		<div>
			<label>&nbsp;</label>
			 <input type="hidden" name="redirect" value="<?php echo $redirect_url;?>" />
			<input type="submit" name="delete_subscriber" value="Delete" />
		</div>
	</form>
</div>
