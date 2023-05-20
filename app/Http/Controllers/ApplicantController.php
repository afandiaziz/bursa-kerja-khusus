<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class ApplicantController extends Controller
{
    private $prefix = 'applicant';
    public function __construct()
    {
        Carbon::setLocale('id');
    }
    public function index(Request $request)
    {
        $prefix = $this->prefix;
        if ($request->ajax()) {
            $data = Vacancy::orderBy('deadline', 'DESC')->orderBy('updated_at', 'DESC')->get();
            $json = DataTables::collection($data)
                ->addIndexColumn()
                ->addColumn('company', function ($row) {
                    return '<a href="' . route('company.detail', ['id' => $row->company_id]) . '">' . $row->company->name . '</a>';
                })
                ->addColumn('applicant', function ($row) {
                    $html = $row->applicants->count() . '/' . ($row->max_applicants ? $row->max_applicants : '∞');
                    return $html;
                })
                ->addColumn('deadline', function ($row) {
                    return Carbon::parse($row->deadline)->translatedFormat('d F Y');
                })
                ->addColumn('status', function ($row) {
                    if (date('Y-m-d') <= $row->deadline) {
                        return '<span class="badge bg-teal">Aktif</span>';
                    } else {
                        return '<span class="badge bg-red">Tidak Aktif</span>';
                    }
                })
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
                ->rawColumns(['deadline', 'applicant', 'company', 'status', 'action'])
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