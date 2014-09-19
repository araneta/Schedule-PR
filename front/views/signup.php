<div class="contact">				
	<form method="post">
		<input type="hidden" value="180.248.9.238" name="ip">
		<span style="display:none !important">
			<label for="name">Leave Blank:</label>
			<input type="text" name="name" id="name">
			<label for="uri">Do Not Change:</label>
			<input type="text" value="http://" name="uri" id="uri">
		</span>
		<p>
			<input type="text" size="20" value="" placeholder="correo electrònico" id="s2email" name="email">
		</p>
		<p>
			<input type="hidden" name="redirect" value="<?php echo home_url();?>" />
			<input type="submit" value="enviar" name="subscribe" class="pinkbtn">&nbsp;
			<input type="submit" value="Unsubscribe" name="unsubscribe">
		</p>
	</form>
</div>
<?php if(isset($_SESSION['status']) && isset($_SESSION['status_msg'])):?>
<script type="text/javascript">
//<![CDATA[
	var xjQuery = jQuery.noConflict();
	xjQuery(document).ready(function() {
		var dialog = xjQuery('<div></div>');		
		dialog.html('<?php echo $_SESSION['status_msg'];?>');
		dialog.dialog({modal: true, zIndex: 10000, title: 'Subscribe to this blog'});
		
	});
//]]>
</script>
<?php
unset($_SESSION['status']);
unset($_SESSION['status_msg']);
?>
<?php endif;?>
