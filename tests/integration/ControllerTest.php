<?php

use PHPUnit\Framework\TestCase;
use FB\controllers\HomeController;
/**
 * 
 */
final class ControllerTest extends TestCase
{

    public function testCanGetBodyRequest(): void
    {
    	$index = new HomeController();
        $this->assertEquals('1111',$index->index());
    }
}