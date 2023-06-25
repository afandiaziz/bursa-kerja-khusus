<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use PDF;
use App\Models\Criteria;
use App\Models\User;
use App\Models\UserDetail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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

        // if ($request->hasFile('cv')) {
        //     $request->validate([
        //         'cv' => 'required|mimes:pdf|max:2048',
        //     ]);
        //     $file = $request->file('cv');
        //     $fileName = time() . '-' . Auth::user()->id . '.' . $file->getClientOriginalExtension();
        //     if (Auth::user()->cv && file_exists(public_path('assets/upload/cv/' . Auth::user()->cv))) {
        //         unlink(public_path('assets/upload/cv/' . Auth::user()->cv));
        //     }

        //     if ($file->move(public_path('assets/upload/cv/'), $fileName)) {
        //         Auth::user()->update([
        //             'cv' => $fileName,
        //         ]);
        //     }
        // }

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

                    $execute = UserDetail::updateOrCreate([
                        'user_id' => Auth::user()->id,
                        'criteria_id' => $key,
                    ], [
                        'value' => $value,
                        'filename' => $fileName,
                        'path' => $path,
                    ]);
                    if ($execute) {
                        foreach ($fileNameFromDB as $index => $currentFile) {
                            if (file_exists(public_path($explodedPath[$index] . '/' . $currentFile))) {
                                unlink(public_path($explodedPath[$index] . '/' . $currentFile));
                            }
                        }
                    }
                    continue;
                } else {
                    $file = $request->file($key);

                    $uploaded = $this->processUpload($criteria, $file, 0);
                    if ($uploaded) {
                        $decoded = json_decode($uploaded);
                        $fileName = $decoded->fileName;
                        $path = $decoded->path;

                        $value = null;

                        $execute = UserDetail::updateOrCreate([
                            'user_id' => Auth::user()->id,
                            'criteria_id' => $key,
                        ], [
                            'value' => $value,
                            'filename' => $fileName,
                            'path' => $path,
                        ]);
                        if ($execute) {
                            foreach ($fileNameFromDB as $index => $currentFile) {
                                if (file_exists(public_path($explodedPath[$index] . '/' . $currentFile))) {
                                    unlink(public_path($explodedPath[$index] . '/' . $currentFile));
                                }
                            }
                        }

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
            ], 200);
        } else {
            return redirect()->route('profil.index')->with('alert-success', 'Berhasil mengubah profil');
        }
    }

    public static function evidence($registrationNumber)
    {
        $data = Applicant::where('registration_number', $registrationNumber)->where('user_id', Auth::id())->firstOrFail();
        $pdf = PDF::loadView('registration-evidence', compact('data'));
        return $pdf->save('Bukti Pendaftaran.pdf');
    }
}
