<div class="contact">				
	<form action="?" method="post">
		<h3>Stay updated, subscribe to our mailing list</h3>
		<p>
			<input type="text" size="20" value="" placeholder="<?php echo $settings->txtemail;?>" id="email" name="email">
		</p>
		<p>
			<input type="hidden" name="redirect" value="<?php echo home_url();?>" />
			<input type="submit" value="<?php echo $settings->txtsubscribe;?>" name="subscribe" class="redbtn submit">&nbsp;			
		</p>
	</form>
</div>
<?php if(isset($_SESSION['status']) && isset($_SESSION['status_msg'])):?>
<script type="text/javascript">
//<![CDATA[
	//var xjQuery = jQuery.noConflict();
	jQuery(document).ready(function() {
		var dlg = jQuery('<div></div>');		
		dlg.html('<?php echo $_SESSION['status_msg'];?>');
		dlg.dialog({modal: true, zIndex: 10000, title: 'Subscribe to this blog'});
		
	});
//]]>
</script>
<?php
unset($_SESSION['status']);
unset($_SESSION['status_msg']);
?>
<?php endif;?>
