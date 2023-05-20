<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    private $prefix = 'verify';
    public function index()
    {
        return view('dashboard.' . $this->prefix . '.index');
    }

    public function check(Request $request)
    {
        $request->validate([
            'registration_number' => 'required'
        ]);

        $applicant = Applicant::where('registration_number', $request->registration_number)
            ->firstOrFail()?->id;
        if ($applicant) {
            return response()->json([
                'message' => 'success',
                'data' => $applicant
            ], 200);
        } else {
            return response()->json([
                'message' => 'failed',
            ], 404);
        }
    }
}
