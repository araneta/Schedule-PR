<?php
class SchedulePressReleasePluginInstall{
	public static function install(){
		//create tables
		global $wpdb;
		$SchedulePressRelease_db_version = '1.4';
		
		$charset_collate = '';

		if ( ! empty( $wpdb->charset ) ) {
		  $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
		}

		if ( ! empty( $wpdb->collate ) ) {
		  $charset_collate .= " COLLATE {$wpdb->collate}";
		}
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		//create schedule table
		$table_name = $wpdb->prefix . 'schedule_press_release_schedule';
		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			schedule_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			subject text NOT NULL,
			message_body text NOT NULL,		
			sent tinyint DEFAULT 0 NOT NULL,	
			UNIQUE KEY id (id)
		) $charset_collate;";	
		dbDelta( $sql );
		//create subscriber table
		$table_name = $wpdb->prefix . 'schedule_press_release_subscriber';
		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,		
			name text NOT NULL,		
			email text NOT NULL,		
			UNIQUE KEY id (id)
		) $charset_collate;";
		dbDelta( $sql );
		
		add_option( 'SchedulePressRelease_db_version', $SchedulePressRelease_db_version );
	}
}
