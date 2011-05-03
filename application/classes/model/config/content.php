<?php defined('SYSPATH') or die('No direct script access.');

class Model_Config_Content extends Model
{
	public function get_current_config_revision($config_id)	{
		$query = DB::select('revision')->from('config_content')->where('config_id', "=", $config_id);
		$query .= " order by `revision` desc limit 1";
		$revision = DB::query(Database::SELECT,$query)->execute();
		return $revision[0]["revision"];
	}

	public function get_config($config_id, $current_revision = null, $commented = null)	{
		if (is_null($current_revision)){
			$current_revision = $this->get_current_config_revision($config_id);
		}
		$query = DB::select('config_content')->from('config_content')
			->where('revision', "=", $current_revision)
			->where('config_id', "=", $config_id);
		if (!is_null($commented)){
			$query = $query->where('commented', "=", $commented);
		}
		$config_serialized = DB::query(Database::SELECT,$query)->execute();
		if ($config_serialized[0])
		{
			return unserialize(gzuncompress($config_serialized[0]["config_content"]));
		}
		else
		{
			return false;
		}
	}

	public function add_rules($config_id, $config_content_array) {
		$new_revision = $this->get_current_config_revision($config_id)+1;
		$config_content_array_serialized = gzcompress(serialize($config_content_array));
		$query = DB::insert('config_content', array('config_id', 'config_content', 'revision'))
			->values(array($config_id, $config_content_array_serialized, $new_revision));
		return $query->execute();
	}
	
	public function update_rules($config_id, $config_content_array) {
		$current_revision = $this->get_current_config_revision($config_id);
		$config_content_array_serialized = gzcompress(serialize($config_content_array));
		$query = DB::update('config_content')
			->set(array('config_content'=>$config_content_array_serialized, 'commented'=>true))
			->where('config_id', '=', $config_id)
			->where('revision', '=', $current_revision);
		$query->execute();
	}
		
/*
##legacy code
	public function get_current_rules($device_id, $current_revision = null)
	{
		if (is_null($current_revision)){
			$current_revision = $this->get_current_rules_revesion($device_id);
		}
		$query = "SELECT * FROM rule where `device-id`=\"$device_id\" and `rev-id`=\"$current_revision\"";
		return DB::query(Database::SELECT,$query)->execute();
	}
	
	public function dump_current_rules($device_id)
	{
		$current_revision = $this->get_current_rules_revesion($device_id);
		$query = "select id, linenum, rule from rule where `rev-id`=\"$current_revision\" and `device-id`=\"$device_id\"";
		//echo Kohana::debug((string) $query);
		return  DB::query(Database::SELECT,$query)->execute();
	}

	public function get_current_rules_revesion($device_id)
	{
		$query = DB::select()->from('rule')->where('device-id', "=", $device_id);
		$query .= "order by `rev-id` desc limit 1";
		$revision = DB::query(Database::SELECT,$query)->execute();
		return $revision[0]["rev-id"];
	}
	

	
	public function add_new_revision($device_id)
	{
		$current_config_revision = $this->get_current_config_revision($device_id);
		$query = DB::insert('revision', array(''));
	}
*/

	

}

?>
