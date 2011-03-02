<?php defined('SYSPATH') or die('No direct script access.');

class Helper_ConkeepHelper {
	private static function wikidiff($old, $new) {
	$maxlen = 0;
	foreach($old as $oindex => $ovalue){ 
			$nkeys = array_keys($new, $ovalue);
			foreach($nkeys as $nindex){ 
					$matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ? 
							$matrix[$oindex - 1][$nindex - 1] + 1 : 1; 
					if($matrix[$oindex][$nindex] > $maxlen){ 
							$maxlen = $matrix[$oindex][$nindex];
							$omax = $oindex + 1 - $maxlen; 
							$nmax = $nindex + 1 - $maxlen; 
					} 
			}        
	} 
	if($maxlen == 0) return array(array('d'=>$old, 'i'=>$new)); 
	return array_merge( 
			Helper_ConkeepHelper::wikidiff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)), 
			array_slice($new, $nmax, $maxlen), 
			Helper_ConkeepHelper::wikidiff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen))); 
	}
	
	public static function diff($old, $new) {
		$diff = Helper_ConkeepHelper::wikidiff($old, $new);
		$n = 0;
		$array_diffs = false;
		foreach ($diff as $k) {
			if (!(isset($k['d']) and isset($k['i']) and empty($k['d']) and empty($k['i']))) {
				$newdiff[$n] = $k;
				$n++;
			}
			if (!empty($k['d']) or !empty($k['i'])) $array_diffs = true;
		}
		return ($array_diffs) ? $newdiff : $array_diffs;
	}
		
	public static function text_to_anchor($text) {
		$text = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $text);
		$text = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $text);
		return $text;
	}
	
	public static function config_array_del_all_but_lines($array) {
		$result = array();
		foreach ($array as $i => $array1) {
			foreach ($array1 as $key => $value) {
				if ($key == 'line') {
					$result[$i][$key] = $value;
				}
			}
		}
		return $result;
	}
}
?>
