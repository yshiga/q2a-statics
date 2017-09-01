<?php
if (!defined('QA_VERSION')) {
	require_once dirname(empty($_SERVER['SCRIPT_FILENAME']) ? __FILE__ : $_SERVER['SCRIPT_FILENAME']).'/../../qa-include/qa-base.php';
}
require_once QA_PLUGIN_DIR . 'q2a-statics/q2a-statics-db-client.php';

blog_cohort();

function blog_cohort() {
	$sql = 'DELETE FROM ^statics_cohort WHERE type="BLOG"';
	qa_db_query_sub($sql);

	$config = array(
		array("MONTH", 13),
		array("WEEK", 50),
	);

	foreach($config as $item) {

		$type = $item[0];
		$max_number = $item[1];

		for($k = 0; $k <= $max_number; $k++) {

			$ago = $max_number - $k;
			$number = 0;
			$result = q2a_statics_db_client::getFirstBlogPostUsers($ago, $type);

			$row = array(
				$result['date'],
				0,
				count($result['users']),
				count($result['users']),
				$type
			);
			insert_data($row);

			while($ago - $number > 0) {
				$number++;
				$result2 = q2a_statics_db_client::getCountBlogPostUsers($ago - $number,$type,$result['users']);
				$row = array(
					$result['date'],
					$number,
					count($result2['users']),
					count($result['users']),
					$type
				);
				insert_data($row);

			}
		}
	}
}


function insert_data($data) {
	$data[] = 'BLOG';
	$d = $data;
	$sql = "INSERT INTO ^statics_cohort VALUES ($, #, #, #, $,$)";
	qa_db_query_sub($sql,$d[0],$d[1],$d[2],$d[3],$d[4],$d[5]);
}
