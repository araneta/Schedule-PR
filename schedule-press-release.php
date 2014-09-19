<?php
/*
 * Plugin Name: Schedule Press Release
 * Plugin URI: http://www.aldoapp.com
 * Description: Schedule email to subscribers
 * Version: 1
 * Author: Aldo Praherda
 * Author URI: http://www.aldoapp.com
 * License: GPLv2 or later
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */
ini_set('display_errors', 1); 
error_reporting(E_ALL);
define('SCHEDULE_PR_SLUG','schedulepressrelease');
define('SCHEDULE_PR_ROOT',plugin_dir_path( __FILE__ ));
define('SCHEDULE_PR_URL',plugins_url());

class SchedulePressReleasePlugin{
	/**
     * Constructor
     */
    public function __construct() {
		//for flash message
		if (!session_id())
			session_start();
			
		register_activation_hook(__FILE__, array( $this, 'activate'));
		//hooks			
		//cron
		add_filter('cron_schedules', array($this,'new_interval'));	
		add_action('wp', array($this,'setup_schedule'));		
		add_action('minutelyevent', array($this,'minutely_event'));
		add_action('plugins_loaded',array($this,'execute'));
		//admin pages		
		if(is_admin()){					
			//register all controllers here
			require_once(SCHEDULE_PR_ROOT.'/admin/controllers/admin-controller.php');
			require_once(SCHEDULE_PR_ROOT.'/admin/controllers/settings-controller.php');
			require_once(SCHEDULE_PR_ROOT.'/admin/controllers/schedule-controller.php');
			require_once(SCHEDULE_PR_ROOT.'/admin/controllers/subscriber-controller.php');
			add_action('admin_menu',array($this,'register_admin_menu'));
						
		}else{		
			//front end
			require_once(SCHEDULE_PR_ROOT.'/front/controller.php');
			add_shortcode('spr_signup_form', array('SchedulePressReleasePluginFrontController','render_signup_form'));
		}
	}
	public static function activate(){
		require_once(SCHEDULE_PR_ROOT.'/install.php');
		SchedulePressReleasePluginInstall::install();
	}
	// add once 10 minute interval to wp schedules
	function new_interval($interval) {		
		$interval['minutes1'] = array('interval' => 1*60, 'display' => 'Once 1 minutes');
		return $interval;
	}
	/**
	 * On an early action hook, check if the hook is scheduled - if not, schedule it.
	 */
	function setup_schedule() {		
		if(!wp_next_scheduled('minutelyevent' ) ) {			
			wp_schedule_event(time(), 'minutes1', 'minutelyevent');
		}
	}
	function log($text){
		$logfile = dirname(__FILE__).'/pr0.log';	
		$f = fopen($logfile,'a+');
		fwrite($f,$text."\r\n");
		fclose($f);
	}
	
	public function minutely_event(){			
		SchedulePressReleasePluginFrontController::check_schedules();
		//$this->log('dsadas');
	}
	public function execute(){
		if(isset($_POST)){
			if(is_admin()){
				SchedulePressReleasePluginSettingsController::execute();
				SchedulePressReleasePluginScheduleController::execute();
				SchedulePressReleasePluginSubscriberController::execute();
			}else{
				SchedulePressReleasePluginFrontController::execute();
			}
		}	
	}
	
	function register_admin_menu() {		
		//main
        $title = apply_filters(SCHEDULE_PR_SLUG.'_admin_list_schedule_menu_title', "Schedule Email Alert");        
        $page = add_menu_page($title, $title, 'edit_others_posts', SCHEDULE_PR_SLUG, 
			array('SchedulePressReleasePluginScheduleController', 'render_admin_page'),
			'dashicons-megaphone'
		);
        //submenu
        //add schedule        
        add_submenu_page( SCHEDULE_PR_SLUG, 'Schedule Entry', 
			'Schedule Entry', 
			'manage_options', SCHEDULE_PR_SLUG.'_add_schedules', 
			array('SchedulePressReleasePluginScheduleController','add_schedules_page_callback') 			
		); 
		add_submenu_page( SCHEDULE_PR_SLUG, 'Subscribers', 
			'Subscribers', 
			'manage_options', SCHEDULE_PR_SLUG.'_subscribers', 
			array('SchedulePressReleasePluginSubscriberController','subscribers_page_callback') 
		); 
		add_submenu_page( SCHEDULE_PR_SLUG, 'Subscriber Entry', 
			'Subscriber Entry', 
			'manage_options', SCHEDULE_PR_SLUG.'_add_subscriber', 
			array('SchedulePressReleasePluginSubscriberController','add_subscriber_page_callback') 
		); 
		
		add_submenu_page( SCHEDULE_PR_SLUG, 'Settings', 
			'Settings', 
			'manage_options', SCHEDULE_PR_SLUG.'_settings', 
			array('SchedulePressReleasePluginSettingsController','settings_page_callback') 
		); 
    }
    
}

$sprp = new SchedulePressReleasePlugin();
//$sprp->execute();
