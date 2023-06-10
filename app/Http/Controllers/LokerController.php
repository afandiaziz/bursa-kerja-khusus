<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vacancy;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class LokerController extends Controller
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

    public function index(Request $request)
    {
        $detailLoker = null;
        $loker = Vacancy::active()->paginate(15);
        if ($request->has('detail')) {
            $detailLoker = Vacancy::activeById($request->detail);
        } else {
            return redirect('/loker?page=' . ($request->has('page') ? $request->page : 1) . '&detail=' . $loker->first()->id);
        }

        if ($loker->lastPage() < $request->page) {
            return redirect()->route('loker.index');
        }

        return view('loker', compact('loker', 'detailLoker'));
    }
    public function detail(Request $request)
    {
        $data = Vacancy::activeById($request->detail);
        if ($data) {
            return response()->json([
                'status' => 'success',
                'data' => view('loker-detail', ['detailLoker' => $data])->render()
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
            ], 404);
        }
    }
}