<?php

class q2a_statics_db_client
{

    public static function getFirstANSWERUsers($ago,$type) {

      $sql = "SELECT * FROM (SELECT userid, DATE_FORMAT(MIN(created), '%Y-%m-%d') AS first_created ";
      $sql .= " FROM qa_posts WHERE TYPE='A' GROUP BY userid) AS tmp ";
      $sql .= " WHERE first_created BETWEEN DATE_ADD(NOW(), INTERVAL # " . $type . ") AND DATE_ADD(NOW(), INTERVAL # " . $type . ")";
      $result = qa_db_query_sub($sql, -$ago - 1, -$ago);
      $tmp = qa_db_read_all_assoc($result);

      $users = array_map(function($v){
        return $v['userid'];
      },$tmp);

      // 期間の初日を取得する
      $sql2 = "SELECT DATE_FORMAT(DATE_ADD(NOW(), INTERVAL # " . $type . "), '%Y-%m-%d') as date";
      $result2 = qa_db_query_sub($sql2, -$ago - 1);
      $first_date = qa_db_read_one_value($result2);

      return array('date' => $first_date, 'users' => $users);
    }

    public static function getCountANSWERUsers($ago,$type,$users) {

      if(count($users) > 0) {
        $sql = "SELECT DISTINCT userid FROM qa_posts WHERE type='A'";
        $sql .= " AND created BETWEEN DATE_ADD(NOW(), INTERVAL # " . $type . ") AND DATE_ADD(NOW(), INTERVAL # " . $type . ")";
        $sql .= " AND userid IN (" . implode(",", $users) . ")";
        $result = qa_db_query_sub($sql, -$ago - 1, -$ago);
        $tmp = qa_db_read_all_assoc($result);
        $users = array_map(function($v){
          return $v['userid'];
        },$tmp);
      }


      $sql2 = "SELECT DATE_FORMAT(DATE_ADD(NOW(), INTERVAL # " . $type . "), '%Y-%m-%d') as date";
      $result2 = qa_db_query_sub($sql2, -$ago - 1);
      $first_date = qa_db_read_one_value($result2);

      return array('date' => $first_date, 'users' => $users);
    }

    public static function getFirstQUESTIONUsers($ago,$type) {

      $sql = "SELECT * FROM (SELECT userid, DATE_FORMAT(MIN(created), '%Y-%m-%d') AS first_created ";
      $sql .= " FROM qa_posts WHERE TYPE='Q' GROUP BY userid) AS tmp ";
      $sql .= " WHERE first_created BETWEEN DATE_ADD(NOW(), INTERVAL # " . $type . ") AND DATE_ADD(NOW(), INTERVAL # " . $type . ")";
      $result = qa_db_query_sub($sql, -$ago - 1, -$ago);
      $tmp = qa_db_read_all_assoc($result);

      $users = array_map(function($v){
        return $v['userid'];
      },$tmp);

      // 期間の初日を取得する
      $sql2 = "SELECT DATE_FORMAT(DATE_ADD(NOW(), INTERVAL # " . $type . "), '%Y-%m-%d') as date";
      $result2 = qa_db_query_sub($sql2, -$ago - 1);
      $first_date = qa_db_read_one_value($result2);

      return array('date' => $first_date, 'users' => $users);
    }

    public static function getCountQUESTIONUsers($ago,$type,$users) {

      if(count($users) > 0) {
        $sql = "SELECT DISTINCT userid FROM qa_posts WHERE type='Q'";
        $sql .= " AND created BETWEEN DATE_ADD(NOW(), INTERVAL # " . $type . ") AND DATE_ADD(NOW(), INTERVAL # " . $type . ")";
        $sql .= " AND userid IN (" . implode(",", $users) . ")";
        $result = qa_db_query_sub($sql, -$ago - 1, -$ago);
        $tmp = qa_db_read_all_assoc($result);
        $users = array_map(function($v){
          return $v['userid'];
        },$tmp);
      }


      $sql2 = "SELECT DATE_FORMAT(DATE_ADD(NOW(), INTERVAL # " . $type . "), '%Y-%m-%d') as date";
      $result2 = qa_db_query_sub($sql2, -$ago - 1);
      $first_date = qa_db_read_one_value($result2);

      return array('date' => $first_date, 'users' => $users);
    }


    /**
     * 初めてブログを書いたユーザーのIDを取得する
     *
     * @param  ago 何期間前か
     * @param  type 日(DAY), 週(WEEK), 月(MONTH)
     * @return
     */
    public static function getFirstBLOGUsers($ago,$type) {

      $sql = "SELECT * FROM (SELECT userid, DATE_FORMAT(MIN(created), '%Y-%m-%d') AS first_created ";
      $sql .= " FROM qa_blogs WHERE TYPE='B' GROUP BY userid) AS tmp ";
      $sql .= " WHERE first_created BETWEEN DATE_ADD(NOW(), INTERVAL # " . $type . ") AND DATE_ADD(NOW(), INTERVAL # " . $type . ")";
      $result = qa_db_query_sub($sql, -$ago - 1, -$ago);
      $tmp = qa_db_read_all_assoc($result);

      $users = array_map(function($v){
        return $v['userid'];
      },$tmp);

      // 期間の初日を取得する
      $sql2 = "SELECT DATE_FORMAT(DATE_ADD(NOW(), INTERVAL # " . $type . "), '%Y-%m-%d') as date";
      $result2 = qa_db_query_sub($sql2, -$ago - 1);
      $first_date = qa_db_read_one_value($result2);

      return array('date' => $first_date, 'users' => $users);
    }

    public static function getCountBLOGUsers($ago,$type,$users) {

      if(count($users) > 0) {
        $sql = "SELECT DISTINCT userid FROM qa_blogs WHERE type='B'";
        $sql .= " AND created BETWEEN DATE_ADD(NOW(), INTERVAL # " . $type . ") AND DATE_ADD(NOW(), INTERVAL # " . $type . ")";
        $sql .= " AND userid IN (" . implode(",", $users) . ")";
        $result = qa_db_query_sub($sql, -$ago - 1, -$ago);
        $tmp = qa_db_read_all_assoc($result);
        $users = array_map(function($v){
          return $v['userid'];
        },$tmp);
      }


      $sql2 = "SELECT DATE_FORMAT(DATE_ADD(NOW(), INTERVAL # " . $type . "), '%Y-%m-%d') as date";
      $result2 = qa_db_query_sub($sql2, -$ago - 1);
      $first_date = qa_db_read_one_value($result2);

      return array('date' => $first_date, 'users' => $users);
    }

    public static function getPostPerMonth()
    {
        $sql = "select DATE_FORMAT(created, '%Y-%m') as month, count(*) as count from qa_posts GROUP BY DATE_FORMAT(created, '%Y%m')";
        $result = qa_db_query_sub($sql);
        return qa_db_read_all_assoc($result);
    }

    public static function getBestAnswerNum()
    {
        $sql = "select count(*) as count from qa_posts where selchildid is not null and type='Q'";
        $result = qa_db_query_sub($sql);
        $allData = qa_db_read_all_assoc($result);

        return $allData[0]['count'];
    }

    public static function getNoBestAnswerNum()
    {
        $sql = "select count(*) as count from qa_posts where selchildid is null and type='Q'";
        $result = qa_db_query_sub($sql);
        $allData = qa_db_read_all_assoc($result);

        return $allData[0]['count'];
    }

    public static function getUserInfo($userid)
    {
        $sql = 'select email,handle from qa_users where userid='.$userid;
        $result = qa_db_query_sub($sql);

        return qa_db_read_all_assoc($result);
    }

	public static function get_post_count_days($days = 30)
	{
		$sql = "SELECT SUM(CASE WHEN type = 'Q' THEN 1 ELSE 0 END) as qcount,
				SUM(CASE WHEN type = 'A' THEN 1 ELSE 0 END) as acount,
				SUM(CASE WHEN type = 'C' THEN 1 ELSE 0 END) as ccount,
				SUM(CASE WHEN type = 'A' THEN 1 ELSE 0 END) / SUM(CASE WHEN type = 'Q' THEN 1 ELSE 0 END) as arate,
				SUM(CASE WHEN type = 'C' THEN 1 ELSE 0 END) / SUM(CASE WHEN type = 'A' THEN 1 ELSE 0 END) as crate
				FROM qa_posts
				WHERE created >= DATE_SUB(NOW(), INTERVAL # DAY)";
		return qa_db_read_one_assoc(qa_db_query_sub($sql, $days));
	}

	public static function get_bestanswer_rate($sday = 10, $eday = 40)
	{
		$sql = "SELECT SUM(CASE WHEN selchildid IS NOT NULL THEN 1 ELSE 0 END) as bestcount,
				COUNT(postid) as qcount
				FROM qa_posts
				WHERE type = 'Q'
				AND created <= DATE_SUB(NOW(), INTERVAL # DAY)
				AND created >= DATE_SUB(NOW(), INTERVAL # DAY)";
		$result = qa_db_read_one_assoc(qa_db_query_sub($sql, $sday, $eday));
		if (isset($result['bestcount']) && isset($result['qcount']) && (int)$result['qcount'] !== 0 ) {
			return (int)$result['bestcount'] / (int)$result['qcount'];
		} else {
			return '';
		}
	}

	public static function get_answer_upvotes($days = 30)
	{
		$sql = "SELECT count(*) as vcount
		FROM `qa_uservotes`
		WHERE vote = 1
		AND postid IN
		(SELECT postid
		FROM qa_posts
		WHERE type = 'A'
		AND created >= DATE_SUB(NOW(), INTERVAL # DAY))";
		$result = qa_db_read_one_assoc(qa_db_query_sub($sql, $days));
		if (isset($result['vcount'])) {
			return $result['vcount'];
		} else {
			return 0;
		}
	}

	public static function get_answer_within_hour($days = 30, $hour = 1)
	{
		$sql = "SELECT count(*) as qcount
		FROM (SELECT q.postid
			  FROM qa_posts a
			  LEFT JOIN qa_posts q
			  ON a.parentid = q.postid
			  AND a.type = 'A'
			  AND q.type = 'Q'
			  WHERE q.created >= DATE_SUB(NOW(), INTERVAL # DAY)
			  AND q.created >= DATE_SUB(a.created, INTERVAL # HOUR)
			  GROUP BY q.postid
		) posts";
		$result = qa_db_read_one_assoc(qa_db_query_sub($sql, $days, $hour));
		if (isset($result['qcount'])) {
			return $result['qcount'];
		} else {
			return 0;
		}
	}

	public static function get_posted_user_count($days = 30)
	{
		$sql = "SELECT count(*) AS ucount
		FROM (SELECT userid
			  FROM qa_posts
			  WHERE created >= DATE_SUB(NOW(), INTERVAL # DAY)
			  GROUP BY userid) users";
		$result = qa_db_read_one_assoc(qa_db_query_sub($sql, $days));
		if (isset($result['ucount'])) {
			return $result['ucount'];
		} else {
			return 0;
		}
	}

	public static function get_newuser_posted_rate($postday = 1, $start = null, $end = 30)
	{
		$sql = " SELECT count(*) postedusers,";
		$sql .= " (SELECT count(*) FROM qa_users";
		$sql .= " WHERE created >= DATE_SUB(NOW(), INTERVAL # DAY)";
		if(isset($start)) {
			$sql .= qa_db_apply_sub(" AND created <= DATE_SUB(NOW(), INTERVAL # DAY)",
			 						array($start));
		}
		$sql .= " ) newusers";
		$sql .= " FROM";
		$sql .= " (SELECT u.userid";
		$sql .= " FROM qa_users u";
		$sql .= " LEFT JOIN qa_posts p";
		$sql .= " ON p.userid = u.userid";
		$sql .= " WHERE u.created >= DATE_SUB(NOW(), INTERVAL # DAY)";
		if(isset($start)) {
			$sql .= qa_db_apply_sub(" AND u.created <= DATE_SUB(NOW(), INTERVAL # DAY)",
			 						array($start));
		}
		$sql .= " AND u.created >= DATE_SUB(p.created, INTERVAL # DAY)";
		$sql .= " GROUP BY u.userid ) count";
		$result = qa_db_read_one_assoc(qa_db_query_sub($sql, $end, $end, $postday));
		if (isset($result['postedusers']) && $result['postedusers'] > 0 &&
			isset($result['newusers']) && $result['newusers'] > 0) {
			return (int)$result['postedusers'] / (int)$result['newusers'];
		} else {
			return 0;
		}
	}

    public static function get_private_messages_count($day = 30)
    {
        $sql = " SELECT count(*) messages";
        $sql .= " FROM ^messages";
        $sql .= " WHERE type = $";
        $sql .= " AND created >= DATE_SUB(NOW(), INTERVAL # DAY)";
        $result = qa_db_read_one_assoc(qa_db_query_sub($sql, 'PRIVATE', $day));
        if (isset($result['messages']) && $result['messages'] > 0) {
            return (int)$result['messages'];
        } else {
            return 0;
        }
    }

    public static function get_notified_read_rate($start = 12, $end = 24)
    {
        $sql = "SELECT TRUNCATE(SUM(CASE WHEN read_flag = 1 THEN 1 ELSE 0 END) / count(noticeid) * 100 + 0.009, 2) AS readrate";
        $sql .= " FROM ^sn_notice";
        $sql .= " WHERE created <= DATE_SUB(NOW(), INTERVAL # HOUR)";
        $sql .= " AND created >= DATE_SUB(NOW(), INTERVAL # HOUR)";
        $result = qa_db_read_one_assoc(qa_db_query_sub($sql, $start, $end), true);

        return $result;
    }
}
