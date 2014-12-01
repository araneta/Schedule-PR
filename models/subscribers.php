<?php
require_once "base.php";
class SchedulePressReleasePluginModels_Subscribers extends SchedulePressReleasePluginModels_Base{	
	public function __construct(){
		global $wpdb;
		$this->table_name = $wpdb->prefix . 'schedule_press_release_subscriber';
	}
	public function get_subscribers(){
		global $wpdb;
		return  $wpdb->get_results('select * from '.$this->table_name);
	}	
	public function get_subscriber_by_email($email){
		global $wpdb;
		$sql = $wpdb->prepare('SELECT * FROM '.$this->table_name.' WHERE email = %s',$email);
		return $wpdb->get_row($sql);
	}
	public function delete_subscriber($email){
		global $wpdb;
		return  $wpdb->delete($this->table_name,array('email'=>$email));		
	}
	public function validate($subscriber){
		/*if(empty($subscriber['name'])){
			$this->add_error('name','Name is empty');
		}*/
		if(empty($subscriber['email'])){
			$this->add_error('email','Email is empty');			
		}else{
			if (!filter_var($subscriber['email'], FILTER_VALIDATE_EMAIL)) {
				$this->add_error('email','Invalid email address');			
			}
		}		
		return !$this->has_errors();
	}
	public function save_subscriber($subscriber){		
		if(!$this->validate($subscriber)){
			return FALSE;
		}				
		//check existing email
		if($this->get_subscriber_by_email($subscriber['email'])!=NULL)
			return TRUE;
		global $wpdb;
		$data = array( 
			'email' => $subscriber['email'],
			//'name'=> $subscriber['name'] 			
		) ;
		//update
		if(!empty($subscriber['id'])){			
			return $wpdb->update( 
				$this->table_name, 
				$data,
				array('id' => $subscriber['id'])
			);
		}else{				
			return $wpdb->insert( 
				$this->table_name, 
				$data
			);
		}
	}
}
