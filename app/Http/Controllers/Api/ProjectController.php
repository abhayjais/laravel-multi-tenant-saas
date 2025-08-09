<?php

// app/Http/Controllers/Api/ProjectController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        // This will only return projects for the user's current company.
        $projects = Project::where('company_id', auth()->user()->current_company_id)->get();
        return response()->json($projects);
    }

    public function store(Request $request): JsonResponse
    {
        // The EnsureCompanyIsSet middleware would prevent this from running if no company is active.
        $validated = $request->validate(['name' => 'required|string']);

        $project = Project::create([
            'name' => $validated['name'],
            'company_id' => auth()->user()->current_company_id,
        ]);

        return response()->json($project, 201);
    }
}
