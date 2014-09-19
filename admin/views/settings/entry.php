<div class="wrap">		
	<h2><?php echo __( 'Settings') ?></h2>
	<?php self::view('status');?>
	<div>
		<form method="post"> 						
			<div>
				<label>Confimation Message</label><br />
				<textarea style="width:80%;height:200px;" id="confirmation_message" name="confirmation_message"><?php if($settings)echo $settings->confirmation_message;?></textarea>		
			</div>
			<div>
				<label>&nbsp;</label>
				<input type="hidden" name="redirect" value="<?php echo $redirect_url;?>" />
				<input type="submit" name="save_settings" value="Save" />
			</div>
		</form>
	</div>	
	
</div>
<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function($){
	jQuery.fn.extend({
		insertAtCaret: function(myValue){
		  return this.each(function(i) {
			if (document.selection) {
			  //For browsers like Internet Explorer
			  this.focus();
			  var sel = document.selection.createRange();
			  sel.text = myValue;
			  this.focus();
			}
			else if (this.selectionStart || this.selectionStart == '0') {
			  //For browsers like Firefox and Webkit based
			  var startPos = this.selectionStart;
			  var endPos = this.selectionEnd;
			  var scrollTop = this.scrollTop;
			  this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
			  this.focus();
			  this.selectionStart = startPos + myValue.length;
			  this.selectionEnd = startPos + myValue.length;
			  this.scrollTop = scrollTop;
			} else {
			  this.value += myValue;
			  this.focus();
			}
		  });
		}
	});
	$('.recentpost li a').click(function(){
		var url = $(this).attr('data-url');
		var title = $(this).attr('data-title');
		var newlink = '<a href="'+url+'">'+title+'</a>';
		$('#message_body').insertAtCaret(newlink);
	});
});

//]]>
</script>
