<?php
class q2a_statics_admin {
	function init_queries($tableslc) {
		return null;
	}
	function option_default($option) {
		switch($option) {
			case 'q2a_statics_emails':
				return ''; 
			case 'q2a_statics_kpi':
				return ''; 
			default:
				return null;
		}
	}
		
	function allow_template($template) {
		return ($template!='admin');
	}       
		
	function admin_form(&$qa_content){                       
		// process the admin form if admin hit Save-Changes-button
		$ok = null;
		if (qa_clicked('q2a-statics-save')) {
			qa_opt('q2a_statics_emails', qa_post_text('q2a_statics_emails')); 
			qa_opt('q2a_statics_kpi', qa_post_text('q2a_statics_kpi')); 
			$ok = qa_lang('admin/options_saved');
		}
		
		// form fields to display frontend for admin
		$fields = array();
		
		$fields[] = array(
			'type' => 'text',
			'label' => 'email(csv)',
			'tags' => 'name="q2a_statics_emails"',
			'value' => qa_opt('q2a_statics_emails'),
		);

		$fields[] = array(
			'type' => 'textarea',
			'label' => 'KPI',
			'tags' => 'name="q2a_statics_kpi"',
			'value' => qa_opt('q2a_statics_kpi'),
		);

		return array(     
			'ok' => ($ok && !isset($error)) ? $ok : null,
			'fields' => $fields,
			'buttons' => array(
				array(
					'label' => qa_lang_html('main/save_button'),
					'tags' => 'name="q2a-statics-save"',
				),
			),
		);
	}
}

