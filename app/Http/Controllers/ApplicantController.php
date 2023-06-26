<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;
use App\Imports\ApplicantImport;
use Maatwebsite\Excel\Facades\Excel;

class ApplicantController extends Controller
{
    private $prefix = 'applicant';
    public function __construct()
    {
        Carbon::setLocale('id');
    }

    public function selectionIndex()
    {
        return view('dashboard.' . $this->prefix . '.selection');
    }

    public function selectionUpload(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ]);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            Excel::import(new ApplicantImport, $file);
            return redirect()->back()->with('alert-success', 'Berhasil mengunggah data seleksi pelamar');
        }
    }

    public function verifyIndex()
    {
        return view('dashboard.' . $this->prefix . '.verify');
    }

    public function verifyCheck(Request $request)
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

    public function create()
    {
        $prefix = $this->prefix;
        return view('dashboard.' . $this->prefix . '.create', compact('prefix'));
    }

    public function show(Request $request, $id)
    {
        $data = Applicant::findOrFail($id);
        $buttonBack = true;
        $prefix = $this->prefix;
        return view('dashboard.' . $this->prefix . '.detail', compact('data', 'prefix', 'buttonBack'));
    }

    public function info(Request $request)
    {
        $data = Applicant::findOrFail($request->applicant);
        $prefix = $this->prefix;
        return view('dashboard.' . $this->prefix . '.detail-info', compact('data', 'prefix'));
    }

    public function verify($id)
    {
        $data = Applicant::findOrFail($id);
        $updated = $data->update([
            'verified' => $data->verified ? 0 : 1
        ]);
        if ($updated) {
            return redirect()->back()->with('alert-success', 'Berhasil ' . (!$data->verified ? 'membatalkan verifikasi' : 'memverifikasi') . ' pelamar');
        } else {
            return redirect()->back()->with('alert-danger', 'Gagal ' . (!$data->verified ? 'membatalkan verifikasi' : 'memverifikasi') . ' pelamar');
        }
    }

    public function destroy($id)
    {
        $prefix = $this->prefix;
    }
}
