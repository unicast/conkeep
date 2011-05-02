<?php defined('SYSPATH') or die('No direct script access.');
class Model_Config extends Model
{
	public function get_config_params($id=null)
	{
		if (!is_null($id))
		{
			$query = DB::select()->from('config')->where('config_id', '=', $id);
			$config_params = $query->execute();
			return $config_params[0];
		}
		else 
		{
			return false;
		}
	}
	
	public function get_all_configs_params()
	{
		$query = DB::select()->from('config')->order_by('order', 'desc');
		$config_params = $query->execute();
		return $config_params;
	}
	private function get_config_params_list()
	{
		#$query = DB::select()->from('comment_')->limit('1')->execute();
		#$query = DB::query(null, 'show columns from `comment_`')->execute();
		$query = Database::instance()->list_columns('config');
		#echo Kohana::debug(array_keys($query));
		#return array_keys($query);
		return $query;
	}
	
	public function save_config_params($values)
	{
		//$device_keys = array('id', 'name', 'description', 'link');
		if (isset($values['config_id']))
		{
			$tmp = $this->get_config_params_list();
			#$tmp = $this->get_config_params($values['config_id']);
			#$tmp = $tmp[0];
			unset($tmp['order']);
			$keys = array_keys($tmp);
			foreach ($keys as $key)
			{
				$new_values[$key] = $values[$key];
			}
		}
		else
		{
			$new_values['config_id']=false;
		}
			
		$query=DB::select()->from('config')->where('config_id', "=", $new_values['config_id'])->execute();
		if ($query[0])
		{
			$query = DB::update('config')->set($new_values)->where('config_id', "=", $new_values['config_id']);
			$query->execute();
			return $new_values['config_id'];
		}
		else
		{
			$query = DB::insert('config', array_keys($new_values))->values($new_values)->execute();
			#return $query->insert_id();
			return $query[0];
		}
	}
	
	public function delete_config($config_id)
	{
		DB::delete('mail_list')->where('config_id','=',$config_id)->execute();
		DB::delete('config')->where('config_id','=',$config_id)->execute();
		DB::delete('config_content')->where('config_id','=',$config_id)->execute();
	}
	
	public function get_config_revisions($config_id, $limit=10) {
		$query = DB::select('revision', 'commented', 'updated_on')->from('config_content')
			->where('config_id', '=', $config_id)
			->order_by('revision', 'desc')
			->limit($limit);
		#$revisions = $query->execute()->current();
		#echo Kohana::debug($revisions);
		#return $revisions[0];
		#return $revisions;
		return $query->execute();
	}

}
?>
