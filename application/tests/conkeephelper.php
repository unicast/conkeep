<?php
/**
 * @group conkeep
 */
class Helper_ConkeepHelperTest extends PHPUnit_Framework_TestCase {
	
    function testtext_to_anchor() {
        $this->assertSame(
				Helper_ConkeepHelper::text_to_anchor('http://conkeep.org'), 
				'<a href="http://conkeep.org" target="_blank">http://conkeep.org</a>'
			);
        $this->assertSame(
				Helper_ConkeepHelper::text_to_anchor('https://conkeep.org'), 
				'<a href="https://conkeep.org" target="_blank">https://conkeep.org</a>'
			);
        $this->assertSame(
				Helper_ConkeepHelper::text_to_anchor('http://www.conkeep.org'), 
				'<a href="http://www.conkeep.org" target="_blank">http://www.conkeep.org</a>'
			);
        $this->assertSame(
				Helper_ConkeepHelper::text_to_anchor('www.conkeep.org'), 
				'<a href="http://www.conkeep.org" target="_blank">www.conkeep.org</a>'
			);
        $this->assertSame(
				Helper_ConkeepHelper::text_to_anchor('ftp.conkeep.org'), 
				'<a href="http://ftp.conkeep.org" target="_blank">ftp.conkeep.org</a>'
			);
    }
    function testconfig_array_del_all_but_lines() {
		$array_orig[0] = array(
			'line' => 'test_line',
			'comment' => 'test_comment',
			'garbage' => 'test_garbage',
			);
		$array_cleaned[0] = array(
			'line' => 'test_line',
			);
		$this->assertSame(
				Helper_ConkeepHelper::config_array_del_all_but_lines($array_orig),
				$array_cleaned
			);
	}
}

?>
