<?php
require('/Add.php');

class AddTests extends PHPUnit_Framework_TestCase
{
	private $calculator;
	
	protected function setUp()
	{
		$this->calculator = new Add();
	}
	
	protected function tearDown()
	{
		$this->calculator = NULL;
	}
	
	public function testAdd()
	{
		$result = $this->calculator->addNumber(1,2);
		$this->assertEquals(3, $result);
	}
}