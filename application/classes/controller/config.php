<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Config extends Controller {
	
	public function action_index()
	{
		$config_model = new Model_Config;
		$configs = $config_model->get_all_configs_params();
		
		$view = View::factory('config');
		$view->title = 'My Configs';
		$view->configs = $configs;
		$this->response->body($view);
	}
	
	public function action_edit($config_id=null)
	{
		if (!($_POST))
		{
			if (is_null($config_id))
			{
				$view = View::factory('config-edit-settings');
				$view->title = 'Add new config';
				$view->config = array('config_id'=>'', 'name'=>'', 'description'=>'');
				$view->mail_list = array();
				$this->response->body($view);
			}
			else
			{
				$config_model = new Model_Config();
				$config = $config_model->get_config_params($config_id);
		
				if ($config)
				{
					$view = View::factory('config-edit-settings');
					$config_name = $config['name'];
					$view->title = $config_name . ' / settings';
					$view->config = $config;
					$view->config_id = $config_id;
					$email_model = new Model_Email();
					$maillist = $email_model->get_maillist($config_id);
					$view->mail_list = $maillist;
					$this->response->body($view);
				}
				else
				{
					$this->request->redirect('/config/new');
				}
			}
		}
		else 
		{
			$config_model = new Model_Config();
			$email_model = new Model_Email();
			$post = $_POST;
			#echo Kohana::debug($post);
			$return_id = $config_model->save_config_params($post);
			$email_model->save_maillist($post);
			#echo Kohana::debug($return_id);
			#$this->request->redirect(URL::site(Request::instance()->uri()));
			$this->request->redirect('/config/edit/'.$return_id);
		}
	}
	
	public function action_show($config_id=null, $revision=null)
	{
		if (is_null($config_id))
		{
			$this->request->redirect('/');
		}
		$config_content_model = new Model_Config_Content();

		if (empty($revision)) {
			$revision = $config_content_model->get_current_config_revision($config_id);
		}

		$config_content = $config_content_model->get_config($config_id, $revision);
		
		$config_model = new Model_Config();
		$config_params = $config_model->get_config_params($config_id);
		$config_name = $config_params['name'];

		$view = View::factory('config-content');
		$view->title = $config_name . ' / config revision #' . $revision;
		$view->config_content = $config_content;
		$view->config_id = $config_id;
		$this->response->body($view);		
	}
	
	public function action_delete($config_id=null)
	{
		if (is_null($config_id))
		{
			$this->request->redirect('/');
		}
		else
		{
			$config_model = new Model_Config();
			$config_content = $config_model->get_config_params($config_id);
			$view = View::factory('config-delete');
			$view->title = 'conkeep / config delete confirmation';
			$view->config_content = $config_content;
			$this->response->body($view);
		}
	}

	public function action_delete_confirm($config_id=null)
	{
		if (is_null($config_id))
		{
			$this->request->redirect('/');
		}
		else
		{
			$config_model = new Model_Config();
			$config_delete_responce = $config_model->delete_config($config_id);
			$this->request->redirect('/');
		}
	}
	public function action_update($config_id=null)
	{
		if (is_null($config_id))
		{
			$this->request->redirect('/');
		}
		if (!($_POST) and (!($_FILES)))
		{
			$this->request->redirect('/');
		}
		
		elseif (!empty($_FILES['file']['tmp_name']))
		{
			$post = $_POST;
			$new_config_plaintext = file($_FILES['file']['tmp_name']);
			foreach ($new_config_plaintext as $key=>$line) {
				$line = rtrim($line);
				$new_config_array[$key]['line'] = $line;
			}
			
			$config_content_model = new Model_Config_Content();
			$current_config_array = $config_content_model->get_config($config_id);
			if (!empty($current_config_array)) {
				$new_config_array = $this->add_comments_to_new_config($current_config_array, $new_config_array);
				if (Helper_ConkeepHelper::diff($current_config_array, $new_config_array))
				{
					$config_content_model->add_rules($config_id, $new_config_array);
					$this->request->redirect('/config/show/' . $config_id);
				}
				else
				{
					$this->request->status = 404;
					$this->request->headers['HTTP/1.1'] = '404';
					$this->request->response = "New config is fully identical to previous.\n";
				}
			}
			else {
				$config_content_model->add_rules($config_id, $new_config_array);
				$this->request->redirect('/config/show/' . $config_id);
			}
		}
		else
		{
			$post = $_POST;
			$new_comments = array();
			$i = 0;
			foreach ( $post as $key => $value ) {
				if (strpos($key, 'rule_id') !== false) {
					$new_comments[$i]['comment'] = $value;
					$i++;
				}
			}
			$config_content_model = new Model_Config_Content();
			$current_config_array = $config_content_model->get_config($config_id);
			$new_config_array = $this->update_comments($new_comments, $current_config_array);
			if (Helper_ConkeepHelper::diff($current_config_array, $new_config_array))
			{
				$config_content_model->update_rules($config_id, $new_config_array);
				$this->request->redirect('/config/show/' . $config_id);
				//$this->request->redirect($post['return']);
			}
			else
			{
				$this->request->status = 404;
				$this->request->headers['HTTP/1.1'] = '404';
				$this->request->response = "New config is fully identical to previous.\n";
			}
		}
	}
	
	private function get_config_name($config_id) {
		$config_model = new Model_Config();
		$config_params = $config_model->get_config_params($config_id);
		return $config_params['name'];
	}

	private function add_comments_to_new_config($old, $new) {
		$maxlen = 0;
		$new_config_with_comments_array = $new;
		foreach ($old as $oindex => $ovalue ) {
			foreach ($new as $nindex => $nvalue ) {
				if (($ovalue['line'] == $nvalue['line']) and (isset($ovalue['comment']))) {
					$new_config_with_comments_array[$nindex]['comment'] = $ovalue['comment'];
					break;
				}
			}
		}
		return $new_config_with_comments_array;
	}
	
	private function update_comments($comments, $config) {
		if (count($comments) == count($config)) {
			foreach ( $config as $key => $value ) {
				$config[$key]['comment'] = $comments[$key]['comment'];
			}
			$ret = $config;
		}
		else {
			$ret = false;
		}
		return $ret;
	}
	
	public function action_changelog($config_id = null) {
		if (is_null($config_id))
		{
			$this->request->redirect('/');
		}
		$config_model = new Model_Config();
		$limit = 15;
		$changelog = $config_model->get_config_revisions($config_id, $limit);
		$config_model = new Model_Config();
		$config_params = $config_model->get_config_params($config_id);
		$config_name = $config_params['name'];

		$view = View::factory('config-changelog');
		$view->title = $config_name . ' / changelog';
		$view->changelog = $changelog;
		$view->config_id = $config_id;
		$this->response->body($view);
	}
	
	public function action_diff($config_id) {
		if (!empty($_REQUEST)) {
			$config_content_model = new Model_Config_Content();
			$new_revision = $_REQUEST['revision'];
			$old_revision = $_REQUEST['revision_from'];
			$new = Helper_ConkeepHelper::config_array_del_all_but_lines($config_content_model->get_config($config_id, $new_revision));
			$old = Helper_ConkeepHelper::config_array_del_all_but_lines($config_content_model->get_config($config_id, $old_revision));
			$diff = Helper_ConkeepHelper::diff($old, $new);
			$view = View::factory('config-diff');
			if ($diff) {
				$config_name = $this->get_config_name($config_id);
				$view->title = $config_name . ' / config diff revisions ' . $new_revision . ' and ' . $old_revision;
				$view->diff = $diff;
				$view->config_id = $config_id;
			}
			else {
				$error = 'revisions ' . $new_revision . ' and ' . $old_revision . ' is identical';
				$view->title = $error;
				$view->error = $error;
				$view->config_id = $config_id;
			}
			$this->response->body($view);
		}
		else {
			$this->request->redirect('/');
		}
	}

}
