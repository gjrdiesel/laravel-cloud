<?php

namespace Tests\Feature;

use App\Callbacks\CheckDatabaseRestore;
use App\Database;
use App\DatabaseRestore;
use App\Jobs\RestoreDatabaseBackup;
use App\Scripts\RestoreDatabaseBackup as RestoreDatabaseBackupScript;
use Facades\App\TaskFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\Fakes\FakeTask;
use Tests\TestCase;

class RestoreDatabaseBackupJobTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    public function test_script_is_started()
    {
        $restore = factory(DatabaseRestore::class)->create();

        $job = new RestoreDatabaseBackup($restore);

        TaskFactory::shouldReceive('createFromScript')->once()->with(
            Mockery::type(Database::class), Mockery::type(RestoreDatabaseBackupScript::class), Mockery::on(function ($options) use ($restore) {
                return $options['then'][0] instanceof CheckDatabaseRestore &&
                       $options['then'][0]->id === $restore->id;
            })
        )->andReturn($task = new FakeTask());

        $job->handle();

        $this->assertTrue($task->ranInBackground);
    }
}
