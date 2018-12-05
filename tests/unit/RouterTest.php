<?php

use PHPUnit\Framework\TestCase;
use FB\src\Router;
/**
 * 
 */
final class RouterTest extends TestCase
{
	
	public function testCanBeCreatedFromValidRouteAddress(): void
    {
        $this->assertInstanceOf(
            Router::class,
            Router::post('','index@HomeController')
        );
    }

}