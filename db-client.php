<?php

class db_client
{
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
}
