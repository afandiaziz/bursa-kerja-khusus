<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Imports\ApplicantImport;
use App\Jobs\SendEmail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Mail\ApplicantionVerifiedMail;

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
            ->first()?->id;
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
            $data = Applicant::findOrFail($id);
            if ($data->verified) {
                SendEmail::dispatch($data->user->email, new ApplicantionVerifiedMail([
                    'subject' => 'Lamaran Kamu sudah diverifikasi (' . $data->registration_number . ') - Bursa Kerja Khusus',
                    'id' => $data->id,
                    'created_at' => Carbon::parse($data->created_at)->translatedFormat('d F Y, H:i'),
                    'regist_number' => $data->registration_number,
                    'verified' => $data->verified,
                    'name' => $data->user->name,
                    'position' => $data->vacancy->position,
                    'company' => $data->vacancy->company->name,
                ]));
            }
            return redirect()->back()->with('alert-success', 'Berhasil ' . (!$data->verified ? 'membatalkan verifikasi' : 'memverifikasi') . ' lamaran pelamar');
        } else {
            return redirect()->back()->with('alert-danger', 'Gagal ' . (!$data->verified ? 'membatalkan verifikasi' : 'memverifikasi') . ' lamaran pelamar');
        }
    }

    public function destroy($id)
    {
        $prefix = $this->prefix;
    }
}
