<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Project;
use Illuminate\Http\Request;

class SshDatabaseController extends Controller
{
    /**
     * Get all of the databases for the given project.
     *
     * @param Request $request
     * @param Project $project
     *
     * @return Response
     */
    public function index(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        return $project->databases()
                        ->with('address')
                        ->get()
                        ->filter
                        ->canSsh($request->user());
    }
}
