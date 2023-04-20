<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\UserDocuments;
use Illuminate\Http\Request;

class UserDocumentController extends Controller
{
    private function processUpload($file, $criteria)
    {
        $filename = time() . "_" . $file->getClientOriginalName();
        $mimeType = $file->getMimeType();
        if ($file->move('upload', $filename)) {
            $created = UserDocuments::create([
                'criteria_id' => $criteria,
                'user_id' => Auth::user()->id,
                'filename' => $filename,
                'mime_type' => $mimeType,
            ]);
            if ($created) {
                return true;
            } else {
                return response('Failed to Store File', 500);
            }
        } else {
            return response('Failed to Upload File', 500);
        }
    }
    public function upload(Request $request)
    {
        $request->validate([
            'criteria' => 'required',
        ]);
        if ($request->has('preview') && $request->preview) {
            return response()->json([
                'status' => 'success',
                'message' => 'File Uploaded',
            ], 200);
        }
        if ($request->hasFile($request->criteria)) {
            if (is_array($request->file($request->criteria))) {
                foreach ($request->file($request->criteria) as $file) {
                    $uploaded = $this->processUpload($file, $request->criteria);
                    if (!$uploaded) {
                        return $uploaded;
                    }
                }
            } else {
                $uploaded = $this->processUpload($request->file($request->criteria), $request->criteria);
                if (!$uploaded) {
                    return $uploaded;
                }
            }
        }
    }
}
