<?php
if (!defined('QA_VERSION')) { 
	require_once dirname(empty($_SERVER['SCRIPT_FILENAME']) ? __FILE__ : $_SERVER['SCRIPT_FILENAME']).'/../../qa-include/qa-base.php';
	require_once QA_INCLUDE_DIR.'app/emails.php';
}


$body = createBody();
$params['fromemail'] = qa_opt('from_email');
$params['fromname'] = qa_opt('site_title');
$params['subject'] = '【' . qa_opt('site_title') . '】statics reports';
$params['body'] = $body;
$params['toname'] = '管理人';
$params['html'] = false;

$emailCSV = qa_opt('q2a_statics_emails');
$emailArr = explode(',', $emailCSV);

foreach($emailArr as $email) {
	$params['toemail'] = trim($email);
	$result = sendEmail($params);
}

function createBody(){
	$noBestNum = getNoBestAnswerNum();
	$bestNum = getBestAnswerNum();
	$postPerMonth = getPostPerMonth();
	$body .= '';

	$kpi = qa_opt('q2a_statics_kpi');
	$body .= '--- kpi ---' . "\n";
	$body .= $kpi . "\n\n";
	$body .= '--- post count per month ---' . "\n";
	$body .= 'month : post(前年比)' . "\n";
	foreach($postPerMonth as $key => $post) {
		$body .= $post['month'] . ' : ' . $post['count'];

		if(array_key_exists($key - 12, $postPerMonth)) {
			$lastYear = $postPerMonth[$key - 12];
			$body .= '(';
			$body .= round(($post['count']/$lastYear['count'] - 1) * 100);
			$body .= '%)';
		}

		$body .= "\n";
	}

	$body .= "\n\n";
	$body .= '--- best answer ---' . "\n";
	$body .= 'no best answer : ' . $noBestNum . "\n";
	$body .= 'best answer : ' . $bestNum . "\n";
	$body .= 'best answer rate : ' . round($bestNum / ($noBestNum + $bestNum) * 100, 1) . "\n";
	return $body;
}


function getPostPerMonth() {
	$sql = "select DATE_FORMAT(created, '%Y-%m') as month, count(*) as count from qa_posts GROUP BY DATE_FORMAT(created, '%Y%m')";
	$result = qa_db_query_sub($sql); 
	return qa_db_read_all_assoc($result);
}

function getBestAnswerNum() {
	$sql = "select count(*) as count from qa_posts where selchildid is not null and type='Q'";
	$result = qa_db_query_sub($sql); 
	$allData = qa_db_read_all_assoc($result);
	return $allData[0]['count'];
}

function getNoBestAnswerNum() {
	$sql = "select count(*) as count from qa_posts where selchildid is null and type='Q'";
	$result = qa_db_query_sub($sql); 
	$allData = qa_db_read_all_assoc($result);
	return $allData[0]['count'];
}

function getUserInfo($userid) {
	$sql = 'select email,handle from qa_users where userid=' . $userid;
	$result = qa_db_query_sub($sql); 
	return qa_db_read_all_assoc($result);
}
function sendEmail($params){
	qa_send_email($params);
}
