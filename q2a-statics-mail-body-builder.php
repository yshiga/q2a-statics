<?php

class q2a_statics_mail_body_builder
{
    public static function create()
    {
        $body = self::createKPISection();
        $body .= self::createPostCountSection();
        $body .= self::createBestAnswerSection();

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
}
