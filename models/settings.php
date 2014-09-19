<?php
require_once "base.php";
class SchedulePressReleasePluginModels_Settings extends SchedulePressReleasePluginModels_Base{
	//public $timezone = 'UTC';
	public $confirmation_message = '<p align="center"><b>Gracias por suscribirte</b></p><p align="center">Recibirásactualizaciones cada vez que tengamos algo nuevo en nuestro sitio.</p>';
	
	public function get_settings(){
		$settings = get_object_vars($this);		
		// Read in existing option value from database
		foreach($settings as $key=>$val){
			$newval = get_option( $key );						
			//if empty then save default
			if(empty($newval)){						
				update_option( $key, $val );	
				$this->$key = $val;				
			}else{
				$this->$key = $newval;
			}			
		}
		return $this;
	}
	public function validate($settings){
		//if(empty($settings['timezone'])){
			//$this->add_error('timezone','Time zone is empty');			
		//}
		if(empty($settings['confirmation_message'])){
			$this->add_error('confirmation_message','Confirmation message is empty');			
		}
		return !$this->has_errors();
	}
	public function save_settings($newsettings){
		if(!$this->validate($newsettings)){
			return FALSE;
		}	
		$settings = get_object_vars($this);
		foreach($settings as $key=>$val){			
			$newval = isset($newsettings[$key])?$newsettings[$key]:$val;
			//echo 'k'.$key.'-'.$newval;				
			update_option($key,$newval);
			$this->$key = $newval;
		}			
		return TRUE;
	}
	//convert from utc+0 to user specified timezone
	public static function get_user_time($utc_time){
		$usertz = get_option('timezone');
		$utcdate = new DateTime($utc_time, new DateTimeZone('UTC'));
		$utcdate->setTimezone( $usertz );
		return $utcdate->format('Y-m-d H:i:s');	
	}
	//convert from user specified timezone to utc+0
	public static function get_utc_time($user_time){
		$usertz = get_option('timezone');
		$userdate = new DateTime($user_time, new DateTimeZone($usertz));
		$userdate->setTimezone('UTC');
		return $userdate->format('Y-m-d H:i:s');	
	}
}

