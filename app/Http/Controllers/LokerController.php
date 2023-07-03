<?php

namespace App\Http\Controllers;

use PDF;
use Mail;
use Carbon\Carbon;
use App\Mail\ApplyMail;
use App\Models\Vacancy;
use App\Models\Applicant;
use App\Models\ApplicantDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
        $loker = $loker->paginate(7);
        return view('loker/index', compact('loker'));
    }

    public function show($id)
    {
        $statusApplied = Auth::user()->applications->where('vacancy_id', $id)->count() ? true : false;
        $data = Vacancy::activeById($id);
        if ($data) {
            return view('loker/show', ['detailLoker' => $data, 'statusApplied' => $statusApplied]);
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
        $profilUpdated = ProfilController::update($request);
        if ($profilUpdated->status() == 200) {
            // $check = Applicant::where('user_id', Auth::user()->id)->where('vacancy_id', $id)->first();
            // if (!$check) {
            $vacancy = Vacancy::findOrFail($id);
            $applied = Applicant::create([
                'user_id' => Auth::user()->id,
                'vacancy_id' => $id,
                'verified' => false,
                'cv' => $profilUpdated->getData()->cv,
            ]);
            // if ($applied) {
            Mail::to(Auth::user()->email)->send(new ApplyMail([
                'subject' => 'Lamaran Kamu sudah terkirim - Bursa Kerja Khusus',
                'id' => $applied->id,
                'created_at' => Carbon::parse($applied->created_at)->translatedFormat('d F Y, H:i'),
                'regist_number' => $applied->registration_number,
                'verified' => $applied->verified,
                'name' => Auth::user()->name,
                'position' => $applied->vacancy->position,
                'company' => $applied->vacancy->company->name,
            ]));

            //         foreach (Auth::user()->user_details as $item) {
            //             $array = array_slice(array_slice($item->toArray(), 1), 0, -3);
            //             $array['applicant_id'] = $applied->id;
            //             ApplicantDetail::create($array);
            //         }
            //         return redirect()->to(route('loker.show', ['id' => $vacancy->id]))->with('alert-success', 'Berhasil melamar ke ' . $vacancy->company->name . ' sebagai ' . $vacancy->position);
            //     } else {
            //         return redirect()->back()->with('alert-danger', 'Gagal melamar ke ' . $vacancy->company->name . ' sebagai ' . $vacancy->position);
            //     }
            // } else {
            //     return redirect()->back()->with('alert-yellow', 'Kamu sudah melamar pekerjaan ini. Cek pada menu Lamaran Saya.');
            // }
        } else {
            return redirect()->back()->with('alert-danger', 'Gagal melakukan update profil.');
        }
    }
}
