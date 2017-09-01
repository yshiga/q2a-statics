<?php
// don't allow this page to be requested directly from browser
if (!defined('QA_VERSION')) {
	header('Location: ../../');
	exit;
}

class q2a_statics_install {
	function init_queries($tableslc) {

    if (!in_array(qa_db_add_table_prefix('statics_cohort'), $tableslc)) {
      $queries[] = "CREATE TABLE IF NOT EXISTS `^statics_cohort` (
        `date` datetime NOT NULL,
        `number` int(10) unsigned NOT NULL,
        `value` int(10) unsigned NOT NULL,
        `total` int(10) unsigned NOT NULL,
        `datetype` varchar(20) NOT NULL,
        `type` varchar(20) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
    }

		if (count($queries) > 0) {
			return $queries;
    }

    return null;
	}
}
