<?php if(isset($_SESSION['status']) && isset($_SESSION['status_msg'])):?>
<div class="updated">
	<p><?php echo $_SESSION['status_msg'];?></p>
</div>
<?php
unset($_SESSION['status']);
unset($_SESSION['status_msg']);
?>
<?php endif;?>
