<?php
class SchedulePressReleasePluginModels_Base{
	private $table_name;
	private $errors = array();
	
	protected function add_error($key,$msg){
		$this->errors[$key]= $msg;
	}
	protected function has_errors(){
		return (count($this->errors)>0)? TRUE : FALSE;
	}
	public function get_error_msg(){
		if(count($this->errors)==0)
			return NULL;
		$msg = '';
		foreach($this->errors as $k=>$v){
			$msg .= $v.'<br />';
		}
		return $msg;
	}
	public function load_model($modelname){
		require_once strtolower($modelname).".php";
		$modelnamefull = 'SchedulePressReleasePluginModels_'.$modelname;
		return new $modelnamefull;
	}
}
