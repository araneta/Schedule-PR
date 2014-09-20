<?php
class SchedulePressReleasePluginSettingsController extends SchedulePressReleasePluginAdminController{		
	public static function get_settings_model(){
		return self::load_model('Settings');		
	}
	public static function execute(){		
		if(isset($_POST['save_settings'])){					
			self::save_settings();
		}		
	}
	
	public static function save_settings(){
		$m = self::get_settings_model();
		if($m->save_settings($_POST)){
			$status = 'Saved';
			self::set_status('success',$status);	
			//redirect to settings page
			$redirect_url = $_POST['redirect'];			
			self::redirect($redirect_url);		
		}else{						
			$status = 'Error: '.$m->get_error_msg();			
			self::set_status('error',$status);
		}				
	}
	
	public static function settings_page_callback() {
		$settings = NULL;		
		$view = "settings/entry";
		$redirect_url = menu_page_url(SCHEDULE_PR_SLUG.'_settings',false);				
		$settings = self::get_settings_model()->get_settings();
		if(isset($_POST)){							
			
		}
		self::view($view,array(
			'settings'=>$settings,
			'redirect_url'=>$redirect_url
		));
	}
    
	
}
