<?php

use PHPUnit\Framework\TestCase;
use FB\src\Route;
/**
 * 
 */
final class RouterTest extends TestCase
{
	
	public function testCanBeCreatedFromValidRouteAddress(): void
    {
        $this->assertInstanceOf(
            Route::class,
            Route::post('','index@HomeController')
        );
    }

}