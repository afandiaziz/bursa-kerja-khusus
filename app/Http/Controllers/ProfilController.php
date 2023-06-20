<?php

namespace App\Http\Controllers;

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

    public function update(Request $request)
    {
        // dd($request->all());
        User::where('id', Auth::user()->id)->update([
            'name' => $request->name,
        ]);
        $userDetail = $request->except('_token', 'name', 'cv');
        // dd($userDetail);
        $fileName = null;
        $path = null;

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
    }
}
