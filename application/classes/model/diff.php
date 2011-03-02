<?php defined('SYSPATH') or die('No direct script access.');
class Model_Diff extends Model
{
	private function diff($old, $new){ 
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
                $this->diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)), 
                array_slice($new, $nmax, $maxlen), 
                $this->diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen))); 
	} 

	public function htmlDiff($old, $new){ 
		//$diff = $this->diff(explode(' ', $old), explode(' ', $new)); 
        $diff = $this->diff($old, $new); 
        $ret = '';
        foreach($diff as $k){ 
                if(is_array($k)) 
                        $ret .= (!empty($k['d'])?"<del>".implode(' ',$k['d'])."</del> ":''). 
                                (!empty($k['i'])?"<ins>".implode(' ',$k['i'])."</ins> ":''); 
                else $ret .= $k . ' '; 
        } 
        return $ret;
	}
}

?>