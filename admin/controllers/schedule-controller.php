<?php

class SchedulePressReleasePluginScheduleController extends SchedulePressReleasePluginAdminController{	
	public static function get_schedules_model(){
		return self::load_model('Schedules');		
	}	
	
	public static function execute(){		
		if(isset($_POST['save_schedule'])){					
			self::save_schedule();
		}else if(isset($_POST['delete_schedule'])){					
			self::delete_schedule();
		}		
	}
	//schedules
	public static function save_schedule(){
		$m = self::get_schedules_model();
		if($m->save_schedule($_POST)){
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
	public static function delete_schedule(){
		$m = self::get_schedules_model();
		if($m->delete_schedule($_POST['id'])){
			$status = 'Deleted';
			self::set_status('success',$status);			
		}else{
			$status = 'Failed deleting schedule '.$_POST['id'];
			self::set_status('error',$status);	
		}		
		$redirect_url = $_POST['redirect'];
		self::redirect($redirect_url);			
	}
	/*
	protected static function utc_now(){
		$userTime  = date("Y-m-d H:i:s", strtotime('now'));
		$userdate = new DateTime($userTime, new DateTimeZone('UTC'));
		return $userdate->format('Y-m-d H:i:s');	
	}*/
	public static function add_schedules_page_callback() {
		$schedule = NULL;		
		$view = "schedule/add_schedule";
		$redirect_url = menu_page_url(SCHEDULE_PR_SLUG,false);				
		//edit mode
		if(isset($_GET['id'])){
			$m = self::get_schedules_model();
			$schedule = $m->get_schedule_by_id($_GET['id']);			
		}
		//delete mode
		else if(isset($_GET['delid'])){					
			$m = self::get_schedules_model();
			$schedule = $m->get_schedule_by_id($_GET['delid']);				
			$view = "schedule/delete_schedule";
			
		}
		else if(isset($_POST)){							
			$schedule = new stdClass();
			$schedule->schedule_time = isset($_POST['schedule_time'])?$_POST['schedule_time']:'';
			$schedule->subject = isset($_POST['subject'])?stripslashes($_POST['subject']):''; 
			$schedule->message_body = isset($_POST['message_body'])?stripslashes($_POST['message_body']):'';
			
		}
		self::view($view,array(
			'schedule'=>$schedule,
			'redirect_url'=>$redirect_url,
			'now'=>current_time('Y-m-d H:i:s')
		));
	}
    public static function render_admin_page(){		
		$m = self::get_schedules_model('');		
		self::view("schedule/schedules",array('schedules' => $m->get_schedules()));
	}
	
	
	
	
}
