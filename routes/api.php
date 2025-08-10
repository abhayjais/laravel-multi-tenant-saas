<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\JsonResponse;

// Public routes for authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require Sanctum authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Companies management
    Route::get('/companies', [CompanyController::class, 'index']);
    Route::post('/companies', [CompanyController::class, 'store']);
    Route::get('/companies/{company}', [CompanyController::class, 'show']);
    Route::put('/companies/{company}', [CompanyController::class, 'update']);
    Route::delete('/companies/{company}', [CompanyController::class, 'destroy']);

    // Company switching
    Route::post('/company/switch', function (Request $request): JsonResponse {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);

        $company = auth()->user()->companies()->find($validated['company_id']);

        if (!$company) {
            return response()->json(['message' => 'Unauthorized or company not found'], 403);
        }

        auth()->user()->update(['current_company_id' => $company->id]);

        return response()->json(['message' => 'Active company switched successfully.']);
    });
});

Route::middleware(['auth:sanctum', 'company.scope'])->group(function () {
    Route::apiResource('projects', ProjectController::class);
});