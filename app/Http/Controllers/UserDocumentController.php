<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\UserDocuments;
use Illuminate\Http\Request;

class UserDocumentController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'criteria' => 'required',
        ]);
        if ($request->has('preview')) {
            return response()->json([
                'status' => 'success',
                'message' => 'File Uploaded',
            ], 200);
        }
        if ($request->hasFile($request->criteria)) {
            if (is_array($request->file($request->criteria))) {
                foreach ($request->file($request->criteria) as $file) {
                    $filename = time() . "_" . $file->getClientOriginalName();
                    $mimeType = $file->getMimeType();
                    if ($file->move('upload', $filename)) {
                        $created = UserDocuments::create([
                            'criteria_id' => $request->criteria,
                            'user_id' => Auth::user()->id,
                            'filename' => $filename,
                            'mime_type' => $mimeType,
                        ]);
                        if ($created) {
                        } else {
                            return response('Failed to Store File', 500);
                        }
                    } else {
                        return response('Failed to Upload File', 500);
                    }
                }
            } else {
                $file = $request->file($request->criteria);
                $filename = time() . "_" . $file->getClientOriginalName();
                $mimeType = $file->getMimeType();
                if ($file->move('upload', $filename)) {
                    $created = UserDocuments::create([
                        'criteria_id' => $request->criteria,
                        'user_id' => Auth::user()->id,
                        'filename' => $filename,
                        'mime_type' => $mimeType,
                    ]);
                    if ($created) {
                    } else {
                        return response()->json([
                            'status' => 'failed',
                            'message' => 'Failed to Store File',
                        ], 500);
                    }
                } else {
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'Failed to Upload File',
                    ], 500);
                }
            }
        }
    }
}
