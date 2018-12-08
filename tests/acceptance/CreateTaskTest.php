<?php

use PHPUnit\Framework\TestCase;
use FB\Models\Task;
/**
 * 
 */
final class CreateTaskTest extends TestCase
{
	
	public function testCanBeCreatedNewTask(): void
    {
        $res = (new Task())->create()->execute();
        $this->assertEquals([],$res);
    }

}