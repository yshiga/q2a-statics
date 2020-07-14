<?php
/*
	Plugin Name: Statics Report
	Plugin URI:
	Plugin Description: send statics report to admin
	Plugin Version: 0.3
	Plugin Date: 2015-06-21
	Plugin Author:
	Plugin Author URI:
	Plugin License: GPLv2
	Plugin Minimum Question2Answer Version: 1.7
	Plugin Update Check URI:
*/
if (!defined('QA_VERSION')) {
	header('Location: ../../');
	exit;
}

@define( 'QA_STATICS_DIR', dirname( __FILE__ ) );

qa_register_plugin_module('module', 'q2a-statics-admin.php','q2a_statics_admin', 'q2a statics');
qa_register_plugin_module('event', 'q2a-statics-install.php', 'q2a_statics_install', 'statics Install');
qa_register_plugin_module('event', 'q2a-statics-event.php', 'q2a_statics_event', 'Statics Event');
