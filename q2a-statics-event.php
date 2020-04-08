<?php

    if ( !defined( 'QA_VERSION' ) ) { // don't allow this page to be requested directly from browser
        header( 'Location: ../' );
        exit;
    }

    require_once QA_STATICS_DIR.'/lib/GoogleAnalytics.php';

    class q2a_statics_event
    {
        private $supported_event = array(
            'q_post',
            'a_post',
            'c_post',
            'q_vote_up',
            'a_vote_up',
            'qas_blog_b_post',
            'qas_blog_c_post',
            'qas_blog_vote_up',
            'u_message',
        );

        public function process_event($event, $post_userid, $post_handle, $cookieid, $params)
        {
            // not supported event
            if(!in_array($event, $this->supported_event, true)) {
                return;
            }
            $category = $this->get_category($event);
            $label = $this->get_label($event, $params);
            
            $ga_id = qa_opt('material_lite_option_google_analytics_id');
            $analytics = new GoogleAnalitics($ga_id);
            $analytics->TrackEvent($category, $event, $label);
        }

        private function get_category($event)
        {
            switch ($event) {
                case 'q_post':
                case 'a_post':
                case 'c_post':
                case 'q_vote_up':
                case 'a_vote_up':
                    return 'question';
                    break;
                case 'qas_blog_b_post':
                case 'qas_blog_c_post':
                case 'qas_blog_vote_up':
                    return 'blog';
                    break;
                case 'u_message':
                    return 'message';
                    break;
                defalut:
                    return 'unknown';
            }
        }

        private function get_label($event, $params)
        {
            switch ($event) {
                case 'u_message':
                    return $params['messageid'];
                    break;
                defalut:
                    return $params['postid'];
            }

        }
    }

    /*
        Omit PHP closing tag to help avoid accidental output
    */
