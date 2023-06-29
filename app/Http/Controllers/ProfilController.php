<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use PDF;
use App\Models\Criteria;
use App\Models\UserDetail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ProfilController extends Controller
{
    public function __construct()
    {
        Carbon::setLocale('id');
    }

    public function index()
    {
        $criteria = Criteria::where('active', true)->where('parent_id', null)->orderBy('parent_order', 'ASC')->get();
        return view('profil', compact('criteria'));
    }

    public function edit()
    {
        $criteria = Criteria::where('active', true)->where('parent_id', null)->orderBy('parent_order', 'ASC')->get();
        return view('edit-profil', compact('criteria'));
    }

    private function processUpload($criteria, $file, $index, $fileName = null)
    {
        $path = 'assets/upload/' . Str::slug($criteria->id);
        $fileName = $fileName ? $fileName : $index . '-' . time() . '-' . Auth::user()->id . '.' . $file->getClientOriginalExtension();
        if ($file->move(public_path($path), $fileName)) {
            return json_encode([
                'path' => $path,
                'fileName' => $fileName,
            ]);
        } else {
            return false;
        }
    }

    public function loadModalCustom(Request $request)
    {
        $request->validate([
            'criteria' => 'required',
        ]);
        $data = Criteria::findOrFail($request->criteria);
        $isUpdate = false;
        $index = null;
        if ($request->has('index')) {
            $isUpdate = true;
            $index = $request->index;
        }
        return response()->json([
            'message' => 'success',
            'view' => view('components.forms.form-modal-custom', ['data' => $data, 'isUpdate' => $isUpdate, 'index' => $index])->render(),
        ], 200);
    }

    public function deleteValueCustom(Request $request)
    {
        $request->validate([
            'index' => 'required',
            'parent' => 'required',
        ]);
        $criteria = Criteria::findOrFail($request->parent);
        foreach ($criteria->children as $child) {
            UserDetail::where('user_id', Auth::user()->id)->where('criteria_id', $child->id)->where('index', $request->index)->forceDelete();
        }

        return response()->json([
            'message' => 'success',
        ], 200);
    }

    public function storeValueCustom(Request $request)
    {
        $request->validate([
            'parent' => 'required',
        ]);

        $criteria = Criteria::findOrFail($request->parent);
        $latestIndex = UserDetail::where('user_id', Auth::user()->id)->whereHas('criteria', function ($query) use ($criteria) {
            $query->where('parent_id', $criteria->id);
        })->max('index');
        foreach ($request->except('_token', 'parent') as $key => $value) {
            if ($request->has('index')) {
                UserDetail::where('user_id', Auth::user()->id)->where('criteria_id', $key)->where('index', $request->index)->update([
                    'value' => $value,
                ]);
            } else {
                UserDetail::create([
                    'user_id' => Auth::user()->id,
                    'criteria_id' => $key,
                    'index' => ($latestIndex + 1),
                    'value' => $value,
                ]);
            }
        }
        if ($request->has('index')) {
            return redirect()->route('profil.edit')->with('alert-success', 'Berhasil mengubah ' . strtolower($criteria->name));
        } else {
            return redirect()->route('profil.edit')->with('alert-success', 'Berhasil menambahkan ' . strtolower($criteria->name));
        }

        // for ($index = 0; $index < count($request->data); $index++) {
        //     UserDetail::create([
        //         'user_id' => Auth::user()->id,
        //         'criteria_id' => $request->data[$index]['name'],
        //         'value' => $request->data[$index]['value'],
        //         'filename' => null,
        //         'path' => null,
        //     ]);
        // }
        // return response()->json([
        //     'message' => 'success',
        // ], 201);
    }

    public static function update(Request $request)
    {
        // dd($request->all());
        if ($request->has('name')) {
            $request->validate([
                'name' => 'required',
            ]);
            Auth::user()->update([
                'name' => $request->name,
            ]);
        }

        if ($request->hasFile('cv')) {
            $request->validate([
                'cv' => 'required|mimes:pdf|max:2048',
            ]);
            $file = $request->file('cv');
            $fileName = time() . '-' . Auth::user()->id . '.' . $file->getClientOriginalExtension();
            // if (Auth::user()->cv && file_exists(public_path('assets/upload/cv/' . Auth::user()->cv))) {
            //     unlink(public_path('assets/upload/cv/' . Auth::user()->cv));
            // }

            if ($file->move(public_path('assets/upload/cv/'), $fileName)) {
                Auth::user()->update([
                    'cv' => $fileName,
                ]);
            }
        }

        $userDetail = $request->except('_token', 'name', 'cv', 'return_json');
        $fileName = null;
        $path = null;

        // dd($userDetail);
        foreach ($userDetail as $key => $value) {
            $criteria = Criteria::findOrFail($key);
            $user_detail = Auth::user()->user_details->where('criteria_id', $criteria->id)->first();
            $fileNameFromDB = $user_detail && $user_detail->filename ? explode(',', $user_detail->filename) : null;
            $explodedPath = $user_detail && $user_detail->path ? explode(',', $user_detail->path) : null;

            if ($request->hasFile($key)) {
                if (is_array($value)) {
                    $fileName = [];
                    $path = [];

                    foreach ($value as $indexFile => $file) {
                        $uploaded = $this->processUpload($criteria, $file, $indexFile);
                        if ($uploaded) {
                            $decoded = json_decode($uploaded);
                            array_push($fileName, $decoded->fileName);
                            array_push($path, $decoded->path);
                        }
                    }

                    $fileName = implode(',', $fileName);
                    $path = implode(',', $path);
                    $value = null;

                    UserDetail::updateOrCreate([
                        'user_id' => Auth::user()->id,
                        'criteria_id' => $key,
                    ], [
                        'value' => $value,
                        'filename' => $fileName,
                        'path' => $path,
                    ]);
                    // if ($execute) {
                    //     foreach ($fileNameFromDB as $index => $currentFile) {
                    //         if (file_exists(public_path($explodedPath[$index] . '/' . $currentFile))) {
                    //             unlink(public_path($explodedPath[$index] . '/' . $currentFile));
                    //         }
                    //     }
                    // }
                    continue;
                } else {
                    $file = $request->file($key);

                    $uploaded = $this->processUpload($criteria, $file, 0);
                    if ($uploaded) {
                        $decoded = json_decode($uploaded);
                        $fileName = $decoded->fileName;
                        $path = $decoded->path;

                        $value = null;

                        UserDetail::updateOrCreate([
                            'user_id' => Auth::user()->id,
                            'criteria_id' => $key,
                        ], [
                            'value' => $value,
                            'filename' => $fileName,
                            'path' => $path,
                        ]);
                        // if ($execute) {
                        //     foreach ($fileNameFromDB as $index => $currentFile) {
                        //         if (file_exists(public_path($explodedPath[$index] . '/' . $currentFile))) {
                        //             unlink(public_path($explodedPath[$index] . '/' . $currentFile));
                        //         }
                        //     }
                        // }

                        continue;
                    }
                }
            } else if (is_array($value)) {
                $value = implode(',', $value);
            }

            if ($criteria->required) {
                if ($value != null) {
                    UserDetail::updateOrCreate([
                        'user_id' => Auth::user()->id,
                        'criteria_id' => $key,
                    ], [
                        'value' => $value,
                        'filename' => $fileName,
                        'path' => $path,
                    ]);
                }
            } else {
                UserDetail::updateOrCreate([
                    'user_id' => Auth::user()->id,
                    'criteria_id' => $key,
                ], [
                    'value' => $value,
                    'filename' => $fileName,
                    'path' => $path,
                ]);
            }
        }

        if ($request->has('return_json') && $request->return_json) {
            return response()->json([
                'message' => 'success',
                'cv' => Auth::user()->cv,
            ], 200);
        } else {
            return redirect()->route('profil.index')->with('alert-success', 'Berhasil mengubah profil');
        }
    }

    public static function evidence($registrationNumber)
    {
        $data = Applicant::where('registration_number', $registrationNumber)->where('user_id', Auth::id())->firstOrFail();
        $pdf = PDF::loadView('registration-evidence', compact('data'));
        return $pdf->download('Bukti Pendaftaran.pdf');
    }

    public function applications(Request $request)
    {
        if ($request->ajax()) {
            $json = DataTables::collection(Auth::user()->applications)
                ->addColumn('card', function ($item) {
                    $logo = filter_var($item->vacancy->company->logo, FILTER_VALIDATE_URL) ? $item->vacancy->company->logo : asset('assets/upload/companies/' . $item->vacancy->company->logo);
                    $html = '
                        <a href="' . route('lamaran.show', ['id' => $item->id]) . '" class="text-decoration-none p-0">
                            <div class="card card-loker cursor-pointer">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div>
                                            <div class="row">
                                                <div class="col-auto">
                                                    <span class="bg-transparent border-0 shadow-none avatar avatar-lg">
                                                        <img src="' . $logo . '" alt="' . $item->vacancy->company->name . '">
                                                    </span>
                                                </div>
                                                <div class="col">
                                                    <div class="fw-bold">
                                                        <h3 class="link-blue mb-1">' . $item->vacancy->position . '</h3>
                                                    </div>
                                                    <div class="text-dark">
                                                        ' . $item->vacancy->job_type . '
                                                        <div class="mt-1">' . $item->vacancy->company->name . '</div>
                                                    </div>
                                                    <div class="text-muted mt-3">
                                                        <span class="small">
                                                            Melamar pada ' . Carbon::parse($item->created_at)->translatedFormat('d F Y, H:i') . ' (' . $item->created_at->diffForHumans() . ')
                                                        </span>
                                                    </div>
                                                    <div class="btn btn-outline-blue mt-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-text" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                                            <path d="M9 9l1 0"></path>
                                                            <path d="M9 13l6 0"></path>
                                                            <path d="M9 17l6 0"></path>
                                                        </svg>
                                                        Unduh Bukti Pendaftaran
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ms-auto">
                                            <div class="badge ' . ($item->verified ? 'bg-success' : 'bg-danger') . '">' . ($item->verified ? 'Terverifikasi' : 'Belum Terverifikasi') . '</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>';
                    return $html;
                })
                ->rawColumns(['card'])
                ->toJson();
            return $json;
        }
        return view('application.index');
    }

    public function applicationDetail(Request $request)
    {
        $data = Applicant::where('id', $request->id)->where('user_id', Auth::id())->firstOrFail();
        return view('application.show', compact('data'));
    }
}
