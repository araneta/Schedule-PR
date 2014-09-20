<?php

class SchedulePressReleasePluginSubscriberController extends SchedulePressReleasePluginAdminController{	
	public static function get_subscribers_model(){
		return self::load_model('Subscribers');		
	}	
	
	public static function execute(){
		if(isset($_POST['save_subscriber'])){							
			self::save_subscriber();
		}else if(isset($_POST['delete_subscriber'])){					
			self::delete_subscriber();
		}		
	}
	//subscriber
	public static function save_subscriber(){
		$m = self::get_subscribers_model();
		if($m->save_subscriber($_POST)){
			$status = 'Saved';
			self::set_status('success',$status);	
			//redirect to list schedule page
			$redirect_url = $_POST['redirect'];
			self::redirect($redirect_url);		
		}else{
			$status = 'Error: '.$m->get_error_msg();
			self::set_status('error',$status);
		}				
	}
	public static function delete_subscriber(){
		$m = self::get_subscribers_model();
		if($m->delete_subscriber($_POST['id'])){
			$status = 'Deleted';
			self::set_status('success',$status);			
		}else{
			$status = 'Failed deleting subscriber '.$_POST['id'];
			self::set_status('error',$status);	
		}		
		$redirect_url = $_POST['redirect'];
		self::redirect($redirect_url);			
	}
	
	public static function subscribers_page_callback(){		
		$m = self::get_subscribers_model();
		self::view("subscriber/subscribers",array('subscribers'=>$m->get_subscribers()));		
	}
	public static function add_subscriber_page_callback(){
		$subscriber = NULL;		
		$view = "subscriber/add_subscriber";
		$redirect_url = menu_page_url(SCHEDULE_PR_SLUG.'_subscribers',false);	
		//delete mode
		if(isset($_GET['delid'])){					
			$m = self::get_subscribers_model();
			$view = "subscriber/delete_subscriber";
			$subscriber = $m->get_subscriber_by_email($_GET['delid']);			
		}
		self::view($view,array(
			'subscriber'=>$subscriber,
			'redirect_url'=>$redirect_url
		));
	}
}
