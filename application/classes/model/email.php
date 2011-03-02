<?php defined('SYSPATH') or die('No direct script access.');
class Model_Email extends Model
{
	private function key_compare_func($a, $b) 
	{
    	if ($a === $b) {
        	return 0;
    	}
    	return ($a > $b)? 1:-1;
	}
	public function get_maillist($config_id=null)
	{
		if (!is_null($config_id))
		{
			$query = DB::select()->from('mail_list')->where('config_id', '=', $config_id);
			return $query->execute();
		}
		else
		{
			return false;
		}
	}
	public function save_maillist($values)
	{
		$config_id = $values['config_id'];
		unset($values['config_id']);
		$i=0;
		foreach ($values as $key=>$value)
		{
			if (preg_match('/mail/', $key, $matches))
			{
				if ($value)
				{
					$new_maillist[$i]=$value;
				}
				$i++;
			}
		}
		$current_maillist = $this->get_maillist($config_id)->as_array();
		if (isset($new_maillist))
		{
			foreach ($current_maillist as $key=>$value)
			{
				$query = DB::update('mail_list', 'email')
					->set(array('email'=>$new_maillist[0]))
					->where("id", "=", $value['id']);
				$query->execute();
				array_shift($new_maillist);
			}
		}
		if (isset($new_maillist))
		{
			foreach ($new_maillist as $mail)
			{
				$query = DB::insert('mail_list', array('config_id', 'email'))->values(array($config_id, $mail));
				$query->execute();
			}
		}
	}
}
?>
