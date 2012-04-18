<?php

/**
 * Gas ORM Unit Test
 *
 * Test case for `save` method
 *
 * @package     Gas ORM
 * @category    Unit Test
 * @version     2.1.1
 * @author      Taufan Aditya
 */

class SampleTest extends PHPUnit_Framework_TestCase {
	
	private $abc;
	
    public function setUp()
    {
		$this->abc = "TEST";
    }

	public function tearDown()
	{
		unset($this->abc);
	}

    public function testSeeIfItWorks()
    {
        // Some basic tests to test testing
        $this->assertEquals($this->abc,"TEST");
        $this->assertFalse($this->abc === "MY TEST");
    }

}
