<?php
// app/Http/Controllers/Api/CompanyController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    public function index(): JsonResponse
    {
        $companies = auth()->user()->companies;
        return response()->json($companies);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
        ]);

        $company = auth()->user()->companies()->create($validated);

        return response()->json($company, 201);
    }

    public function show(Company $company): JsonResponse
    {
        if ($company->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json($company);
    }

    public function update(Request $request, Company $company): JsonResponse
    {
        if ($company->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'address' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
        ]);

        $company->update($validated);

        return response()->json($company);
    }

    public function destroy(Company $company): JsonResponse
    {
        if ($company->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $company->delete();

        return response()->json(null, 204);
    }
}