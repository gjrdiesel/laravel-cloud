<?php

namespace Tests\Feature;

use App\Environment;
use App\Stack;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnvironmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_stack_can_be_retrieved()
    {
        $environment = factory(Environment::class)->create([
            'project_id' => 1,
        ]);

        $environment->stacks()->save($stack = factory(Stack::class)->make([
            'promoted' => true,
        ]));

        $environment->stacks()->save(factory(Stack::class)->make([
            'promoted' => false,
        ]));

        $this->assertEquals($stack->id, $environment->promotedStack()->id);
    }
}
