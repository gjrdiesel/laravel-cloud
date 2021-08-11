<?php

namespace Tests\Feature;

use App\Balancer;
use App\IpAddress;
use App\Jobs\DeleteServerOnProvider;
use App\Jobs\ProvisionBalancer;
use Exception;
use Facades\App\ServerProviderClientFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Mockery;
use Tests\TestCase;

class ProvisionBalancerJobTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    public function test_balancer_is_deleted_on_failure()
    {
        Bus::fake();

        $balancer = factory(Balancer::class)->create();
        $balancer->address()->save($address = factory(IpAddress::class)->make());

        ServerProviderClientFactory::shouldReceive('make->deleteServer')->with(Mockery::on(function ($value) use ($balancer) {
            return $value->id == $balancer->id;
        }));

        $job = new ProvisionBalancer($balancer);
        $job->failed(new Exception());

        Bus::assertDispatched(DeleteServerOnProvider::class);
        $this->assertCount(1, $balancer->project->alerts);
    }
}
