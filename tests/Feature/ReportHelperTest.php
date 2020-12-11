<?php

namespace Tests\Feature;

use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class ReportHelperTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    public function test_helper_reports_exceptions()
    {
        $e = new Exception();
        $mock = Mockery::mock();
        $mock->shouldReceive('report')->once()->with($e);
        $this->swap(ExceptionHandler::class, $mock);
        report($e);

        $this->assertTrue(true);
    }
}
