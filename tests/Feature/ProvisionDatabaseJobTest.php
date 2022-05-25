<?php

namespace Tests\Feature;

use App\Database;
use App\IpAddress;
use App\Jobs\DeleteServerOnProvider;
use App\Jobs\ProvisionDatabase;
use Exception;
use Facades\App\ServerProviderClientFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Mockery;
use Tests\TestCase;

class ProvisionDatabaseJobTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    public function test_databases_is_deleted_on_failure()
    {
        Bus::fake();

        $database = factory(Database::class)->create();
        $database->address()->save($address = factory(IpAddress::class)->make());

        ServerProviderClientFactory::shouldReceive('make->deleteServer')->with(Mockery::on(function ($value) use ($database) {
            return $value->id == $database->id;
        }));

        $job = new ProvisionDatabase($database);
        $job->failed(new Exception());

        Bus::assertDispatched(DeleteServerOnProvider::class);
        $this->assertCount(1, $database->project->alerts);
    }
}
