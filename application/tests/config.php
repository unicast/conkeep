<?php
/**
 * @group conkeep
 */
class Controller_ConfigTest extends PHPUnit_Framework_TestCase {
	

    protected function setUp() {
        Kohana::config('database')->default = Kohana::config('database')->default;
    }

    function testaction_index() {
		$request = new Request('config/index');
		$response = new Response;
        $config = new Controller_Config($request, $response);
        $config->action_index();
        $this->assertSame($response->status(), 200);
    }
}
?>
