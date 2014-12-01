<?php
class SchedulePressReleasePluginFrontController{
	private static $models = array();	
	protected static function load_model($modelname){
		if(!array_key_exists($modelname,self::$models)){
			require_once(SCHEDULE_PR_ROOT.'/models/'.strtolower($modelname).'.php');
			$modelnamefull = 'SchedulePressReleasePluginModels_'.$modelname;
			self::$models[$modelname] = new $modelnamefull;	
		}
		return self::$models[$modelname];
	}
	
	public static function get_schedules_model(){		
		return self::load_model('Schedules');
	}	
	public static function get_subscribers_model(){
		return self::load_model('Subscribers');
	}
	public static function get_settings_model(){
		return self::load_model('Settings');
	}
	public static function execute(){		
		if(isset($_POST['subscribe'])){					
			self::save_subscriber();
		}
	}
	protected static function redirect($url){		
		header('location: '.$url);		
		exit(0);
	}	
	protected static function set_status($status,$msg){
		$_SESSION['status'] = $status;
		$_SESSION['status_msg'] = $msg;
	}
	
	
	public static function render_signup_form(){
		wp_enqueue_script('jquery-ui-dialog');
		$css = 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/ui-darkness/jquery-ui.css';
		if ( is_ssl() ) {
			$css = str_replace('http:', 'https:', $css);
		}
		wp_register_style('jquery-ui-style', $css);
		wp_enqueue_style('jquery-ui-style');		
		$settings = self::get_settings_model()->get_settings();
		include "views/signup.php";
	}
	public static function save_subscriber(){
		$m = self::get_subscribers_model();
		if($m->save_subscriber($_POST)){
			self::send_confirmation_email($_POST['email']);
			$settings = self::get_settings_model()->get_settings();
			$status = $settings->confirmation_message;
			self::set_status('success',$status);	
			//redirect to list home page
			$redirect_url = $_POST['redirect'];
			self::redirect($redirect_url);		
		}else{
			$status = 'Error: '.$m->get_error_msg();
			self::set_status('error',$status);
		}		
		//die($status);		
	}
	protected static function send_confirmation_email($to){
		$settings = self::get_settings_model()->get_settings();
		$msg = $settings->email_body;
		$subject = $settings->email_subject;
		add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
		$headers = "From: ".$settings->email_from." <".$settings->email_sender.">" . "\r\n";
		wp_mail( $to, $subject, $msg,$headers);
		//send to 
		if(isset($settings->notify_email) && !empty($settings->notify_email)){
			$msg = $to . ' has subscribed to Email Alerts';
			$subject = 'Someone has subscribed to Email Alerts';			
			$headers = "From: ".$settings->email_from." <".$settings->email_sender.">" . "\r\n";
			wp_mail( $settings->notify_email, $subject, $msg,$headers);
		}
	}
	//cron
	protected static function log($text){
		$logfile = dirname(__FILE__).'/cron.log';	
		$f = fopen($logfile,'a+');
		fwrite($f,$text."\r\n");
		fclose($f);
	}	
	/*
	protected static function utc_now(){
		$userTime  = date("Y-m-d H:i:s", strtotime('now'));
		$userdate = new DateTime($userTime, new DateTimeZone('UTC'));
		return $userdate->format('Y-m-d H:i:s');	
	}*/
	public static function check_schedules(){		
		//$now = self::utc_now();
		$now = current_time('Y-m-d H:i:s');
		//get scheduls
		$m = self::get_schedules_model();
		$schedules = $m->get_schedules_by_time($now);
		//get subscribers
		$ms = self::get_subscribers_model();
		$subscribers = $ms->get_subscribers();		
		if(count($schedules)==0 || count($subscribers)==0){
			return;
		}		
		add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
		foreach($schedules as $schedule){
			foreach($subscribers as $subscriber){				
				$to = $subscriber->email;
				$subject = $schedule->subject;
				$body = $schedule->message_body;
				self::log($now." to: ".$to . " subject:".$subject
				. " messg:".$body);
				wp_mail( $to, $subject, $body);
				$m->mark_sent($schedule->id);
			}
			
		}
	}
}
