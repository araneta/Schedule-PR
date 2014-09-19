<?php
require_once "base.php";

class SchedulePressReleasePluginModels_Schedules extends SchedulePressReleasePluginModels_Base{	
	private $errors = array();
	public function __construct(){
		global $wpdb;
		$this->table_name = $wpdb->prefix . 'schedule_press_release_schedule';
	}	
	public function get_schedules(){
		global $wpdb;
		return  $wpdb->get_results('select * from '.$this->table_name);
	}
	public function get_schedule_by_id($id){
		global $wpdb;
		return $wpdb->get_row('SELECT * FROM '.$this->table_name.' WHERE id = '.intval($id));
	}
	public function get_schedules_by_time($min_schedule_time){
		global $wpdb;
		$sql = $wpdb->prepare('select * from '.$this->table_name.' 
			where sent=0 and schedule_time <=  %s', $min_schedule_time);
		return  $wpdb->get_results($sql);
	}
	public function delete_schedule($id){
		global $wpdb;
		return $wpdb->delete( $this->table_name, array( 'id' => $id ) );
	}
	function verify_date($datetime, $strict = true)
	{
		$dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $datetime);
		if ($strict) {
			$errors = DateTime::getLastErrors();
			if (!empty($errors['warning_count'])) {
				return false;
			}
		}
		return $dateTime !== false;
	}
	public function validate($schedule){
		if(empty($schedule['schedule_time'])){
			$this->add_error('schedule_time','Schedule time is empty');			
		}else{
			if(!$this->verify_date($schedule['schedule_time'])){
				$this->add_error('schedule_time','Invalid Schedule time');			
			}
		}
		if(empty($schedule['subject'])){
			$this->add_error('subject','Subject is empty');			
		}
		if(empty($schedule['message_body'])){
			$this->add_error('message_body','Message is empty');			
		}
		return !$this->has_errors();
	}
	public function save_schedule($schedule){		
		if(!$this->validate($schedule)){
			return FALSE;
		}		
		global $wpdb;
		$data = array( 
			'id'=>'',
			'schedule_time' => $schedule['schedule_time'], 
			'subject' => stripslashes($schedule['subject']), 
			'message_body' => stripslashes($schedule['message_body']), 
		) ;
		//convert time 
		//$settings = $this->load_model('Settings');
		//$data['schedule_time'] = $settings->get_utc_time($data['schedule_time']);
		
		//update
		if(!empty($schedule['id'])){			
			return $wpdb->update( 
				$this->table_name, 
				$data,
				array('id' => $schedule['id'])
			);
		}else{				
			return $wpdb->insert( 
				$this->table_name, 
				$data
			);
		}
	}
	public function mark_sent($schedule_id){
		global $wpdb;
		$data = array('sent'=>1);
		return $wpdb->update($this->table_name,$data,array('id'=>$schedule_id)); 
	}
}
