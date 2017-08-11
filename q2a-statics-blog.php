<?php
if (!defined('QA_VERSION')) {
	require_once dirname(empty($_SERVER['SCRIPT_FILENAME']) ? __FILE__ : $_SERVER['SCRIPT_FILENAME']).'/../../qa-include/qa-base.php';
}

require_once QA_PLUGIN_DIR . 'q2a-statics/q2a-statics-db-client.php';

$result = array();

$week_count = 60;

for($week=0; $week < $week_count; $week++) {
    $users = q2a_statics_db_client::getFirstBlogPostUsers($week);
    $users = array_map(function($v){
        return $v['userid'];
    },$users);
    var_dump($users);
    $result[$week][0] = count($users);

    for($k = 1; $k < $week_count - $week; $k++) {
        $post_count = -1;
        if(count($users) == 0) {
            $post_count = 0;
        } else {
            $post_count = q2a_statics_db_client::getCountOfBlogPostUsers($k + $week, $users);
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
