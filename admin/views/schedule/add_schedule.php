<div class="wrap">	
	<?php if(empty($schedule->id)):?>
	<h2><?php echo __( 'Add Schedule') ?></h2>
	<?php else:?>
	<h2><?php echo __( 'Edit Schedule') ?></h2>
	<?php endif;?>
	<?php self::view('status');?>
	<div style="float:left;width:50%;">
		<form method="post"> 
			<input type="hidden" name="id" value="<?php if(!empty($schedule->id))echo $schedule->id;?>">
			<div>
				<label>Subject</label><br />
				<input type="text" name="subject" value="<?php if($schedule)echo $schedule->subject;?>" />
			</div>
			<div>
				<label>Message</label><br />
				<?php
				$content = '';
				if($schedule){
					$content .= $schedule->message_body;
				}
				wp_editor($content,'message_body');
				?>				
			</div>
			<div>
				<label>Schedule Time, now is <?php echo $now;?></label><br />
				<input type="text" name="schedule_time" value="<?php if($schedule)echo $schedule->schedule_time;?>" placeholder="format: yyyy-mm-dd hh:MM;ss" />
			</div>
			<div>
				<label>&nbsp;</label>
				<input type="hidden" name="redirect" value="<?php echo $redirect_url;?>" />
				<input type="submit" name="save_schedule" value="Save" />
			</div>
			<br />
			<div>
				<input type="submit" name="send_test" value="Send Test" />
				<label>Email</label>
				<input type="text" name="email" value="" />
				
			</div>
		</form>
	</div>	
	<div style="float:left;width:45%;margin-left:20px;">
		<h2>Recent Posts</h2>
		<ul class="recentpost">
		<?php
			$recent_posts = wp_get_recent_posts();
			foreach( $recent_posts as $recent ){
				echo '<li><a data-url="' . get_permalink($recent["ID"]) . '" data-title="'.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> </li> ';
			}
		?>
		</ul>
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
		var newlink = '<a href="'+url+'">'+url+'</a>';		
		var message = title + '<br />' + newlink;
		$('input[name="subject"]').val(title);		
		//$('#message_body').insertAtCaret(message);
		tinymce.activeEditor.execCommand('mceInsertContent', false, message);
	});
});

//]]>
</script>
