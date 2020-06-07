<?php

namespace Tests\Feature;

use App\Environment;
use App\Jobs\CreateLoadBalancerIfNecessary;
use App\Stack;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HandlesStackProvisioningFailuresTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    public function test_stack_is_deleted_and_alert_created()
    {
        $stack = new HandlesStackProvisioningFailuresTestFakeStack();
        $stack->environment()->associate(factory(Environment::class)->create());
        $job = new CreateLoadBalancerIfNecessary($stack);
        $job->failed(new Exception());

        $this->assertTrue($stack->wasDeleted);
    }
}

class HandlesStackProvisioningFailuresTestFakeStack extends Stack
{
    public $wasDeleted = false;

    public function delete()
    {
        $this->wasDeleted = true;
    }
}
