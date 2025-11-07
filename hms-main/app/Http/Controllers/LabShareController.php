<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SharedLab;
use Illuminate\Support\Facades\Log;

class LabShareController extends Controller
{
    public function share(Request $request)
    {
        try {
            $validated = $request->validate([
                'lab_data' => 'required|array',
                'patient_data' => 'required|array',
                'tests_data' => 'required|array',
                'components_data' => 'required|array',
            ]);

            // Create shared lab record
            $sharedLab = SharedLab::create([
                'share_token' => SharedLab::generateShareToken(),
                'lab_data' => $validated['lab_data'],
                'patient_data' => $validated['patient_data'],
                'tests_data' => $validated['tests_data'],
                'components_data' => $validated['components_data'],
                'expires_at' => now()->addDays(30), // Expires in 30 days
            ]);

            return response()->json([
                'success' => true,
                'share_url' => $sharedLab->share_url,
                'message' => 'Lab test shared successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Lab sharing error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to share lab test'
            ], 500);
        }
    }

    public function show($token)
    {
        try {
            $sharedLab = SharedLab::where('share_token', $token)
                ->where(function($query) {
                    $query->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                })
                ->first();

            if (!$sharedLab) {
                abort(404, 'Shared lab test not found or expired');
            }

            // Pass the shared data to the view
            return view('printed.shared_labtest', [
                'sharedLab' => $sharedLab
            ]);

        } catch (\Exception $e) {
            Log::error('Shared lab display error: ' . $e->getMessage());
            abort(500, 'Error displaying shared lab test');
        }
    }
}
