<?php

namespace App\Http\Controllers;

use App\Http\Requests\VacancyRequest;
use App\Models\Applicant;
use App\Models\Company;
use App\Models\Criteria;
use App\Models\Vacancy;
use App\Models\VacancyCriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class VacancyController extends Controller
{
    private $prefix = 'vacancy';
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
        $selectedCriteria = [];
        Criteria::where('required', 1)->where('active', 1)->orderBy('parent_order', 'ASC')->get()->each(function ($item) use (&$selectedCriteria) {
            $selectedCriteria[] = $item->id;
        });
        $companies = Company::where('status', 1)->orderBy('name', 'ASC')->get();
        $criteria = Criteria::where('active', 1)->orderBy('parent_order', 'ASC')->get();
        return view('dashboard.' . $this->prefix . '.create', compact('prefix', 'companies', 'criteria', 'selectedCriteria'));
    }

    public function store(VacancyRequest $request)
    {
        $request->validated();
        $data = Vacancy::create([
            'company_id' => $request->company_id,
            'position' => $request->position,
            'description' => $request->description,
            'information' => $request->information,
            'max_applicants' => $request->max_applicants,
            'deadline' => date('Y-m-d', strtotime($request->deadline)),
        ]);
        if ($request->criteria) {
            foreach ($request->criteria as $item) {
                VacancyCriteria::create([
                    'vacancy_id' => $data->id,
                    'criteria_id' => $item,
                ]);
            }
        }
        if ($data) {
            return redirect()->route($this->prefix . '.detail', ['id' => $data->id])->with('alert-success', 'Lowongan pekerjaan berhasil ditambahkan');
        } else {
            return redirect()->route($this->prefix . '.detail', ['id' => $data->id])->with('alert-danger', 'Lowongan pekerjaan gagal ditambahkan');
        }
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = Applicant::where('vacancy_id', $request->vacancy);
            if ($request->has('verified') && $request->verified != null) {
                $data = $data->where('verified', $request->verified);
            }
            $data = $data->orderBy('created_at', 'DESC')->get();
            $json = DataTables::collection($data)
                ->addIndexColumn()
                ->addColumn('registration_date', function ($row) {
                    return Carbon::parse($row->created_at)->translatedFormat('d F Y H:i');
                })
                ->addColumn('verified', function ($row) {
                    $html = '<div class="d-flex">';
                    if ($row->verified) {
                        $html .= '
                            <span class="badge bg-teal">Terverifikasi</span>
                            <div class="ms-auto">
                                <a class="btn btn-warning btn-sm" href="' . route('applicant.verify', ['id' => $row->id]) . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M8.18 8.189a4.01 4.01 0 0 0 2.616 2.627m3.507 -.545a4 4 0 1 0 -5.59 -5.552"></path>
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4c.412 0 .81 .062 1.183 .178m2.633 2.618c.12 .38 .184 .785 .184 1.204v2"></path>
                                        <path d="M3 3l18 18"></path>
                                    </svg>
                                    Batal Verifikasi Pelamar
                                </a>
                            </div>';
                    } else {
                        $html .= '
                            <span class="badge bg-red">Belum Terverifikasi</span>
                            <div class="ms-auto">
                                <a class="btn btn-success btn-sm" href="' . route('applicant.verify', ['id' => $row->id]) . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                                        <path d="M15 19l2 2l4 -4"></path>
                                    </svg>
                                    Verifikasi Pelamar
                                </a>
                            </div>';
                    }
                    $html .= '</div>';
                    return $html;
                })
                ->addColumn('name', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('email', function ($row) {
                    return $row->user->email;
                })
                ->addColumn('action', function ($row) {
                    $html = ' <div class="btn-group"> ';
                    $html .= '
                        <a class="btn btn-primary btn-sm" href="' . route('applicant.detail', ['id' => $row->id]) . '">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h1.5"></path>
                                <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                <path d="M20.2 20.2l1.8 1.8"></path>
                            </svg>
                            Detail Pelamar
                        </a>
                    ';
                    $html .= ' </div> ';
                    return $html;
                })
                ->rawColumns(['registration_date', 'name', 'email', 'verified', 'action'])
                ->toJson();
            return $json;
        }
        $data = Vacancy::findOrFail($id);
        $prefix = $this->prefix;
        return view('dashboard.' . $this->prefix . '.detail', compact('data', 'prefix'));
    }

    public function applicants($id)
    {
        $prefix = $this->prefix;
        $data = Vacancy::findOrFail($id)->applicants;
    }

    public function edit($id)
    {
        $data = Vacancy::findOrFail($id);
        $selectedCriteria = [];
        $data->vacancyCriteria->each(function ($item) use (&$selectedCriteria) {
            $selectedCriteria[] = $item->criteria_id;
        });
        $companies = Company::where('status', 1)->orderBy('name', 'ASC')->get();
        $criteria = Criteria::where('active', 1)->orderBy('parent_order', 'ASC')->get();
        $prefix = $this->prefix;
        return view('dashboard.' . $this->prefix . '.edit', compact('data', 'prefix', 'companies', 'criteria', 'selectedCriteria'));
    }
    public function update(VacancyRequest $request, $id)
    {
        $request->validated();
        $data = Vacancy::findOrFail($id);
        $updated = $data->update([
            'company_id' => $request->company_id,
            'position' => $request->position,
            'description' => $request->description,
            'information' => $request->information,
            'max_applicants' => $request->max_applicants,
            'deadline' => date('Y-m-d', strtotime($request->deadline)),
        ]);
        $data->vacancyCriteria()->delete();
        foreach ($request->criteria as $criteria) {
            $data->vacancyCriteria()->create([
                'criteria_id' => $criteria,
            ]);
        }
        if ($updated) {
            return redirect()->route($this->prefix . '.detail', ['id' => $id])->with('alert-success', 'Lowongan pekerjaan berhasil diubah');
        } else {
            return redirect()->route($this->prefix . '.detail', ['id' => $id])->with('alert-danger', 'Lowongan pekerjaan gagal diubah');
        }
    }

    public function destroy($id)
    {
        $data = Vacancy::findOrFail($id);
        if ($data) {
            $data->vacancyCriteria()->delete();
            $data->applicants()->delete();
            $data->delete();
            return redirect()->route($this->prefix . '.index', ['id' => $id])->with('alert-success', 'Lowongan pekerjaan berhasil dihapus');
        } else {
            return redirect()->route($this->prefix . '.index', ['id' => $id])->with('alert-danger', 'Lowongan pekerjaan gagal dihapus');
        }
    }
}
