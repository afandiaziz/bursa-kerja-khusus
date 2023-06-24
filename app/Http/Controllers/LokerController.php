<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Carbon\Carbon;
use App\Models\Vacancy;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $loker = Vacancy::active();

        if ($request->has('job_type') && $request->job_type) {
            $loker = $loker->whereIn('job_type', explode(',', $request->job_type));
        }

        if ($request->has('search') && $request->search) {
            $loker = $loker->where(function ($query) use ($request) {
                $query->where('position', 'like', '%' . $request->search . '%')
                    ->orWhereHas('company', function ($company) use ($request) {
                        $company->where('name', 'like', '%' . $request->search . '%');
                    })
                    ->orWhere('description', 'like', '%' . $request->search . '%')
                    ->orWhere('information', 'like', '%' . $request->search . '%');
            });
            // $loker = $loker->orWhereHas('vacancyCriteria', function ($vacancyCriteria) use ($request) {
            //     $vacancyCriteria->whereHas('criteria', function ($criteria) use ($request) {
            //         $criteria->where('name', 'like', '%' . $request->search . '%');
            //     });
            // });
        }
        // dd($loker->toSql());
        $loker = $loker->paginate(70);
        return view('loker/index', compact('loker'));
    }

    public function show($id)
    {
        $data = Vacancy::activeById($id);
        if ($data) {
            return view('loker/show', ['detailLoker' => $data]);
        } else {
            return redirect()->route('loker.index');
        }
    }

    public function detail(Request $request)
    {
        $data = Vacancy::activeById($request->detail);
        if ($data) {
            return response()->json([
                'status' => 'success',
                'data' => view('loker/detail', ['detailLoker' => $data])->render()
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
            ], 404);
        }
    }

    public function apply(Request $request, $id)
    {
        $request->request->add(['return_json' => true]);
        if (ProfilController::update($request)->status() == 200) {
            $vacancy = Vacancy::findOrFail($id);
            $applied = Applicant::create([
                'user_id' => Auth::user()->id,
                'vacancy_id' => $id,
                'verified' => false,
            ]);
            if ($applied) {
                return redirect()->back()->with('alert-success', 'Berhasil melamar ke ' . $vacancy->company->name . ' sebagai ' . $vacancy->position);
            } else {
                return redirect()->back()->with('alert-danger', 'Gagal melamar ke ' . $vacancy->company->name . ' sebagai ' . $vacancy->position);
            }
        }
    }
}
