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

    public function index(Request $request)
    {
        $prefix = $this->prefix;
        if ($request->ajax()) {
            $data = User::where('role', 'applicant')->orderBy('created_at', 'DESC')->get();
            $json = DataTables::collection($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $html = ' <div class="btn-group"> ';
                    $html .= '
                        <a class="btn btn-primary btn-sm" href="' . route($this->prefix . '.detail', ['id' => $row->id]) . '">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-2-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M8 9h8"></path>
                                <path d="M8 13h5"></path>
                                <path d="M12 21l-.5 -.5l-2.5 -2.5h-3a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v4.5"></path>
                                <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                <path d="M20.2 20.2l1.8 1.8"></path>
                            </svg>
                            Detail
                        </a>
                    ';
                    $html .= ' </div> ';
                    return $html;
                })
                ->rawColumns(['action'])
                ->toJson();
            return $json;
        }
        return view('dashboard.' . $this->prefix . '.index', compact('prefix'));
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
