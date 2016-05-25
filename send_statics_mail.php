<?php
if (!defined('QA_VERSION')) {
	require_once dirname(empty($_SERVER['SCRIPT_FILENAME']) ? __FILE__ : $_SERVER['SCRIPT_FILENAME']).'/../../qa-include/qa-base.php';
	require_once QA_INCLUDE_DIR.'app/emails.php';
	require_once './db-client.php';
	require_once './mail-body-builder.php';
}

$body = mail_body_builder::create();
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
	qa_send_email($params);
}
