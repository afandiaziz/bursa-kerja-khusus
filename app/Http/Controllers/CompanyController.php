<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;

class CompanyController extends Controller
{
    private $prefix = 'company';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $prefix = $this->prefix;
        if ($request->ajax()) {
            if ($request->company_datatable) {
                $data = Company::orderBy('created_at', 'DESC')->get();
                $json = DataTables::collection($data)
                    ->addIndexColumn()
                    ->addColumn('status', function ($row) {
                        if ($row->status) {
                            return '<span class="badge bg-teal">Ya</span>';
                        } else {
                            return '<span class="badge bg-red">Tidak</span>';
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
                    ->rawColumns(['status', 'action'])
                    ->toJson();
                return $json;
            }
        }
        return view('dashboard.' . $this->prefix . '.index', compact('prefix'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prefix = $this->prefix;
        return view('dashboard.' . $this->prefix . '.create', compact('prefix'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyRequest $request)
    {
        $request->validated();
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $logo_name = null;
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logo_name = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('assets/upload/companies/'), $logo_name);
        }
        $data = $request->except('logo');
        $data['logo'] = $logo_name;

        $created = Company::create($data);
        if ($created) {
            return redirect()->route($this->prefix . '.index')->with('alert-success', 'Berhasil menambahkan perusahaan baru');
        } else {
            return redirect()->back()->with('alert-danger', 'Gagal menambahkan perusahaan baru');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $request->merge(["company" => $id]);
        if ($request->ajax()) {
            $json = VacancyController::datatableVacancies($request, 'vacancy');
            return $json;
        }
        $data = Company::findOrFail($id);
        $prefix = $this->prefix;
        return view('dashboard.' . $this->prefix . '.detail', compact('data', 'prefix'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Company::findOrFail($id);
        $prefix = $this->prefix;
        return view('dashboard.' . $this->prefix . '.edit', compact('data', 'prefix'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyRequest $request, $id)
    {
        $request->validated();
        $data = Company::findOrFail($id);
        $logo_name = null;
        if ($request->hasFile('logo')) {
            if (file_exists(public_path('assets/upload/companies/' . $data->logo))) {
                unlink(public_path('assets/upload/companies/' . $data->logo));
            }
            $logo = $request->file('logo');
            $logo_name = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('assets/upload/companies/'), $logo_name);
        }
        $dataUpdated = $request->except('logo');
        if ($logo_name) {
            $data['logo'] = $logo_name;
        }
        if ($data && $data->update($dataUpdated)) {
            return redirect()->route($this->prefix . '.detail', ['id' => $data->id])->with('alert-success', 'Berhasil mengupdate perusahaan ' . $data->name);
        } else {
            return redirect()->back()->with('alert-danger', 'Gagal mengupdate perusahaan ' . $data->name);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Company::findOrFail($id);
        if ($data) {
            if (file_exists(public_path('assets/upload/companies/' . $data->logo))) {
                unlink(public_path('assets/upload/companies/' . $data->logo));
            }
            $data->vacancies()->each(function ($vacancy) {
                $vacancy->applicants()->delete();
                $vacancy->applicants()->each(function ($applicant) {
                    $applicant->applicantDetails()->delete();
                });
                $vacancy->vacancyCriteria()->delete();
            });
            $data->vacancies()->delete();
            $data->delete();
            return redirect()->route($this->prefix . '.index')->with('alert-success', 'Berhasil menghapus perusahaan ' . $data->name);
        } else {
            return redirect()->back()->with('alert-danger', 'Gagal menghapus perusahaan ' . $data->name);
        }
    }

    public function deleteLogo($id)
    {
        $data = Company::findOrFail($id);
        $data->update(['logo' => null]);
        if (file_exists(public_path('assets/upload/companies/' . $data->logo))) {
            unlink(public_path('assets/upload/companies/' . $data->logo));
        }
        return response(null, 204);
    }

    public function activate($id)
    {
        $company = Company::findOrFail($id);
        if ($company->status) {
            $update = 0;
            $message = 'Berhasil menonaktifkan perusahaan';
        } else {
            $update = 1;
            $message = 'Berhasil mengaktifkan perusahaan';
        }
        $company->update(['status' => $update]);
        $company->vacancies()->update(['status' => $update]);
        return redirect()->back()->with('alert-success', $message);
    }
}
