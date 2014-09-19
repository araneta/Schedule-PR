<div class="wrap">	
	<h2><?php echo __( 'Subscribers') ?></h2>
	<?php self::view('status');?>	
	<p><a href="<?php menu_page_url(SCHEDULE_PR_SLUG.'_add_subscriber');?>">Add Subscriber</a></p>
	<table class="wp-list-table widefat fixed pages">
		<thead>
			<tr>				
				<th width="200">Email</th>				
				<th width="100">Action</th>			
			</tr>
		</thead>
		<tbody>
			<?php if(!$subscribers):?>
				<tr><td colspan="2">Empty</td></tr>
			<?php else: ?>
				<?php foreach($subscribers as $s):?>
					<tr class="<?php if($r=="even"){$r="alternate";}else{$r="even";}echo $r;?>">						
						<td><?php echo $s->email;?></td>						
						<td>							
							<a href="<?php menu_page_url(SCHEDULE_PR_SLUG.'_add_subscriber');?>&delid=<?php echo $s->email;?>">Delete</a>
						</td>
					</tr>
				<?php endforeach;?>
			<?php endif;?>
		</tbody>
	</table>
</div>	
