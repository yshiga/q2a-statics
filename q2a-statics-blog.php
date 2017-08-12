<?php
if (!defined('QA_VERSION')) {
	require_once dirname(empty($_SERVER['SCRIPT_FILENAME']) ? __FILE__ : $_SERVER['SCRIPT_FILENAME']).'/../../qa-include/qa-base.php';
}

require_once QA_PLUGIN_DIR . 'q2a-statics/q2a-statics-db-client.php';

$result = array();


output_week_retaintion();

output_month_retaintion();

function output_month_retaintion( $month_count = 13) {


    for($month=0; $month< $month_count; $month++) {
        $users = q2a_statics_db_client::getFirstBlogPostUsersByMonth($month);
        $users = array_map(function($v){
            return $v['userid'];
        },$users);
        $result[$month][0] = count($users);
    
        for($k = 1; $k < $month_count - $month; $k++) {
            $post_count = -1;
            if(count($users) == 0) {
                $post_count = 0;
            } else {
                $post_count = q2a_statics_db_client::getCountOfBlogPostUsersByMonth($k + $month, $users);
            }
            $result[$month][$k] = $post_count;
        }
    }
    
    for($i=0; $i< $month_count; $i++) {
        echo 'month: ' . $i. ','; 
        for($k=0; $k < $month_count; $k++) {
            echo $result[$i][$k] . ',';
        } 
        echo "\n";
    }
}


function output_week_retaintion( $week_count = 52) {


    for($week=0; $week < $week_count; $week++) {
        $users = q2a_statics_db_client::getFirstBlogPostUsersByWeek($week);
        $users = array_map(function($v){
            return $v['userid'];
        },$users);
        $result[$week][0] = count($users);
    
        for($k = 1; $k < $week_count - $week; $k++) {
            $post_count = -1;
            if(count($users) == 0) {
                $post_count = 0;
            } else {
                $post_count = q2a_statics_db_client::getCountOfBlogPostUsersByWeek($k + $week, $users);
            }
            $result[$week][$k] = $post_count;
        }
    }
    
    for($week=0; $week < $week_count; $week++) {
        echo 'week: ' . $week . ','; 
        for($k=0; $k < $week_count; $k++) {
            echo $result[$week][$k] . ',';
        } 
        echo "\n";
    }
}
