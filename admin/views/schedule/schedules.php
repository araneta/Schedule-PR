<div class="wrap">	
	<h2><?php echo __( 'Schedules') ?></h2>
	<?php self::view('status');?>
	<p><a href="<?php menu_page_url(SCHEDULE_PR_SLUG.'_add_schedules');?>">Add Schedule</a></p>
	<table class="wp-list-table widefat fixed pages">
		<thead>
			<tr>
				<th class="column-title" width="140">Schedule</th>
				<th width="200">Subject</th>
				<th width="300">Body</th>
				<th width="100">Sent</th>
				<th width="100">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php if(!$schedules):?>
				<tr><td colspan="4">Empty</td></tr>
			<?php else: ?>
				<?php
				$r = "alternate";
				?>
				<?php foreach($schedules as $schedule):?>
					<tr class="<?php if($r=="even"){$r="alternate";}else{$r="even";}echo $r;?>">
						<td><?php echo $schedule->schedule_time;?></td>
						<td><?php echo $schedule->subject;?></td>
						<td><?php echo $schedule->message_body;?></td>
						<td><?php echo $schedule->sent==1?'Sent':'Pending';?></td>
						<td>
							<a href="<?php menu_page_url(SCHEDULE_PR_SLUG.'_add_schedules');?>&id=<?php echo $schedule->id;?>">Edit</a>
							<a href="<?php menu_page_url(SCHEDULE_PR_SLUG.'_add_schedules');?>&delid=<?php echo $schedule->id;?>">Delete</a>
						</td>
					</tr>
				<?php endforeach;?>
			<?php endif;?>
		</tbody>
	</table>
</div>	
