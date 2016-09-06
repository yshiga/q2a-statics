<?php

class q2a_statics_mail_body_builder
{
	public static function create()
	{
		// $body = self::createKPISection();
		// $body .= self::createPostCountSection();
		// $body .= self::createBestAnswerSection();
		$body = self::create_kpi_section_days(30);

		return $body;
	}

	public static function createKPISection()
	{
		$kpi = qa_opt('q2a_statics_kpi');
		$body = '--- kpi ---'."\n";
		$body .= $kpi."\n\n";

		return $body;
	}

	public static function createPostCountSection()
	{
		$postPerMonth = q2a_statics_db_client::getPostPerMonth();

		$body = '--- post count per month ---'."\n";
		$body .= 'month : post(前年比)'."\n";
		foreach ($postPerMonth as $key => $post) {
			$body .= $post['month'].', '.$post['count'];

			if (array_key_exists($key - 12, $postPerMonth)) {
				$lastYear = $postPerMonth[$key - 12];
				$body .= '(';
				$body .= round(($post['count'] / $lastYear['count'] - 1) * 100);
				$body .= '%)';
			}

			$body .= "\n";
		}
		$body .= "\n\n";

		return $body;
	}

	public static function createBestAnswerSection()
	{
		$noBestNum = q2a_statics_db_client::getNoBestAnswerNum();
		$bestNum = q2a_statics_db_client::getBestAnswerNum();

		$body = '--- best answer ---'."\n";
		$body .= 'no best answer : '.$noBestNum."\n";
		$body .= 'best answer : '.$bestNum."\n";
		$body .= 'best answer rate : '.round($bestNum / ($noBestNum + $bestNum) * 100, 1)."\n";

		$body .= "\n\n";

		return $body;
	}

	public static function create_kpi_section_days($days = 30)
	{
		$header = "質問数 (30日以内), 回答数 (30日以内), コメント数 (30日以内),";
		$header .= " 回答数 / 質問 (30日以内), コメント数 / 回答 (30日以内),";
		$header .= " ベストアンサー率, 支持数 / 回答 (30日以内),";
		$header .= " 回答投稿率 (1時間以内), 回答投稿率 (3時間以内),";
		$header .= " 回答投稿率 (12時間以内), 回答投稿率 (24時間以内),";
		$header .= " 投稿ユーザー数 (30日以内), 平均投稿数, ";
		$header .= "新規ユーザー1日以内投稿率, 新規ユーザー3日以内投稿率, ";
		$header .= "新規ユーザー7日以内投稿率\n";
		$posts = q2a_statics_db_client::get_post_count_days($days);
		$questions = $posts['qcount'];
		$answers = $posts['acount'];
		$comments = $posts['ccount'];
		$arate = $posts['arate'];
		$crate = $posts['crate'];
		$bestanswer_rate = q2a_statics_db_client::get_bestanswer_rate(10, $days + 10);
		$upvotes = q2a_statics_db_client::get_answer_upvotes($days);
		$answer1 = q2a_statics_db_client::get_answer_within_hour($days, 1);
		$answer3 = q2a_statics_db_client::get_answer_within_hour($days, 3);
		$answer12 = q2a_statics_db_client::get_answer_within_hour($days, 12);
		$answer24 = q2a_statics_db_client::get_answer_within_hour($days, 24);
		$ucount = q2a_statics_db_client::get_posted_user_count($days);
		$newuserrate1 = q2a_statics_db_client::get_newuser_posted_rate(1, null, 30);;
		$newuserrate3 = q2a_statics_db_client::get_newuser_posted_rate(3, 4, 34);;
		$newuserrate7 = q2a_statics_db_client::get_newuser_posted_rate(7, 7, 37);;

		$body = $header;
		$body.= $questions . ',';
		$body.= $answers . ',';
		$body.= $comments . ',';
		$body.= round($arate, 1) . ',';
		$body.= round($crate, 1) . ',';
		$body.= round($bestanswer_rate * 100, 1) . '%,';
		$body.= round($upvotes / $answers, 1) . ',';
		$body.= round(($answer1 / $questions) * 100, 2) . '%,';
		$body.= round(($answer3 / $questions) * 100, 2) . '%,';
		$body.= round(($answer12 / $questions) * 100, 2) . '%,';
		$body.= round(($answer24 / $questions) * 100, 2) . '%,';
		$body.= $ucount . ',';
		$body.= round(($questions + $answers + $comments) / $answers, 1) . ',';
		$body.= round($newuserrate1 * 100, 1) . '%,';
		$body.= round($newuserrate3 * 100, 1) . '%,';
		$body.= round($newuserrate7 * 100, 1) . '%';
		$body.= "\n";

		return $body;
	}
}
