<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $project = Project::create([
            'name' => $validator->validated()['name'],
            'company_id' => auth()->user()->current_company_id,
        ]);

        return response()->json($project, 200);
    }
}