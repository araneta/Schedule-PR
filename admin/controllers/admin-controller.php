<?php
class SchedulePressReleasePluginAdminController{	
	protected static $models = array();
	protected static function redirect($url){		
		header('location: '.$url);		
		exit(0);
	}
	protected static function set_status($status,$msg){
		$_SESSION['status'] = $status;
		$_SESSION['status_msg'] = $msg;
	}
	protected static function view($viewname,$data=NULL){	
		if($data!=NULL)
			extract($data);	
		include SCHEDULE_PR_ROOT."/admin/views/".$viewname.".php";
	}
	protected static function log($text){
		$logfile = dirname(__FILE__).'/pr.log';	
		$f = fopen($logfile,'a+');
		fwrite($f,$text."\r\n");
		fclose($f);
	}
	protected static function load_module($modelname){
		if(!array_key_exists($modelname,self::$models)){
			require_once(SCHEDULE_PR_ROOT.'/models/'.strtolower($modelname).'.php');
			$modelnamefull = 'SchedulePressReleasePluginModels_'.$modelname;
			self::$models[$modelname] = new $modelnamefull;	
		}
		return self::$models[$modelname];
	}
}
