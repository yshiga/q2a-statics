<?php
if (!defined('QA_VERSION')) {
	require_once dirname(empty($_SERVER['SCRIPT_FILENAME']) ? __FILE__ : $_SERVER['SCRIPT_FILENAME']).'/../../qa-include/qa-base.php';
}
require_once QA_PLUGIN_DIR . 'q2a-statics/q2a-statics-db-client.php';

newuser_post_cohort();
blog_cohort();
question_cohort();
answer_cohort();

function newuser_post_cohort() {
	$type = "NEWUSER_POST";
	$config = array(
		array("MONTH", 24),
		array("WEEK", 100),
	);
	cohort($type, $config);
}

function question_cohort() {
	$type = "QUESTION";
	$config = array(
		array("MONTH", 24),
		array("WEEK", 100),
	);
	cohort($type, $config);
}

function answer_cohort() {
	$type = "ANSWER";
	$config = array(
		array("MONTH", 24),
		array("WEEK", 100),
	);
	cohort($type, $config);
}

function blog_cohort() {
	$type = "BLOG";
	$config = array(
		array("MONTH", 13),
		array("WEEK", 50),
	);
	cohort($type, $config);
}

function cohort($type, $config){
	echo $type;

	$sql = 'DELETE FROM ^statics_cohort WHERE type="' . $type . '"';
	qa_db_query_sub($sql);

	foreach($config as $item) {

		$datetype = $item[0];
		$max_number = $item[1];

		for($k = 0; $k <= $max_number; $k++) {

			$ago = $max_number - $k;
			$number = 0;
			$method = 'getFirst' . $type . 'Users';
			$result = q2a_statics_db_client::$method($ago, $datetype);

			$method = 'getCount' . $type . 'Users';

			while($ago - $number > 0) {
				$method = 'getCount' . $type . 'Users';
				$result2 = q2a_statics_db_client::$method($ago - $number,$datetype,$result['users']);
				$row = array(
					$result['date'],
					$number,
					count($result2['users']),
					count($result['users']),
					$datetype
				);
				insert_data($row, $type);
				$number++;

			}
		}
	}
}

function insert_data($data, $type) {
	$data[] = $type;
	$d = $data;
	$sql = "INSERT INTO ^statics_cohort VALUES ($, #, #, #, $,$)";
	qa_db_query_sub($sql,$d[0],$d[1],$d[2],$d[3],$d[4],$d[5]);
}
