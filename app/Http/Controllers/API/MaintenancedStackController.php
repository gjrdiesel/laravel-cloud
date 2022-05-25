<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\SyncServers;
use App\Stack;
use Illuminate\Http\Request;

class MaintenancedStackController extends Controller
{
    /**
     * Place a stack under maintenance.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->authorize(
            'view', $stack = Stack::findOrFail($request->stack)
        );

        $stack->update([
            'under_maintenance' => true,
        ]);

        SyncServers::dispatch($stack);
    }

    /**
     * Remove the given stack from maintenance mode.
     *
     * @param  \App\Stack  $stack
     * @return Response
     */
    public function destroy(Stack $stack)
    {
        $this->authorize('view', $stack);

        $stack->update([
            'under_maintenance' => false,
        ]);

        SyncServers::dispatch($stack);
    }
}
