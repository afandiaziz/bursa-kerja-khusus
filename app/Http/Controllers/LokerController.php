<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use PDF;
use Mail;
use Carbon\Carbon;
use App\Mail\ApplyMail;
use App\Mail\RecommendationMail;
use App\Models\Vacancy;
use App\Models\Applicant;
use App\Models\ApplicantDetail;
use App\Models\Keyword;
use App\Models\UserDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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
        // dd($loker->toSql(), $loker->getBindings());

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
        $loker = $loker->paginate(20);
        return view('loker/index', compact('loker'));
    }

    public function show($id)
    {
        $statusApplied = Auth::check() && Auth::user()->applications->where('vacancy_id', $id)->count() ? true : false;
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
        $request->merge(["return_json" => true]);
        $check = Applicant::where('user_id', Auth::user()->id)->where('vacancy_id', $id)->first();
        if (!$check) {
            $profilUpdated = ProfilController::update($request);
            if ($profilUpdated->status() == 200) {
                $vacancy = Vacancy::findOrFail($id);
                $applied = Applicant::create([
                    'user_id' => Auth::user()->id,
                    'vacancy_id' => $id,
                    'verified' => false,
                    'cv' => $profilUpdated->getData()->cv,
                ]);
                if ($applied) {
                    SendEmail::dispatch(Auth::user()->email, new ApplyMail([
                        'subject' => 'Lamaran Kamu sudah terkirim - Bursa Kerja Khusus',
                        'id' => $applied->id,
                        'created_at' => Carbon::parse($applied->created_at)->translatedFormat('d F Y, H:i'),
                        'regist_number' => $applied->registration_number,
                        'verified' => $applied->verified,
                        'name' => Auth::user()->name,
                        'position' => $applied->vacancy->position,
                        'company' => $applied->vacancy->company->name,
                    ]));
                    foreach (UserDetail::where('user_id', Auth::user()->id)->get() as $item) {
                        $array = array_slice(array_slice($item->toArray(), 1), 0, -3);
                        $array['applicant_id'] = $applied->id;
                        // dd(ApplicantDetail::create($array));
                        ApplicantDetail::create($array);
                    }
                    return redirect()->to(route('loker.show', ['id' => $vacancy->id]))->with('alert-success', 'Berhasil melamar ke ' . $vacancy->company->name . ' sebagai ' . $vacancy->position);
                } else {
                    return redirect()->back()->with('alert-danger', 'Gagal melamar ke ' . $vacancy->company->name . ' sebagai ' . $vacancy->position);
                }
            } else {
                return redirect()->back()->with('alert-danger', 'Gagal melakukan update profil.');
            }
        } else {
            return redirect()->back()->with('alert-yellow', 'Kamu sudah melamar pekerjaan ini. Cek pada menu Lamaran Saya.');
        }
    }

    public function setKeyword(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'applicant') {
            if ($request->notification) {
                Keyword::create([
                    'user_id' => Auth::user()->id,
                    'keyword' => $request->search,
                ]);
            } else {
                Keyword::where('user_id', Auth::user()->id)->where('keyword', $request->search)->delete();
                if ($request->has('redirect') && $request->redirect) {
                    return redirect()->route('loker.notifikasi.index')->with('alert-success', 'Berhasil menghapus notifikasi.');
                }
            }
            return response()->json([
                'status' => 'success',
            ], 200);
        }
        return response()->json([
            'status' => 'error',
        ], 500);
    }

    public function notifikasiIndex()
    {
        return view('loker/notifikasi');
    }

    // public function cbrsByKeyword()
    // {
    //     // $users = User::where('role', 'applicant')
    //     //     ->whereHas('keywords')
    //     //     ->get();
    //     // if (Auth::check() && Auth::user()->role == 'applicant' && Auth::user()->keywords->count() > 0) {
    //     $latestDelay = 2;
    //     $minWeight = 0.15;
    //     $latestUserNotified = null;
    //     $keywords = Keyword::orderBy('created_at', 'desc')->with('user')->get();

    //     if ($keywords->count() > 0) {
    //         foreach ($keywords as $item) {
    //             // $pages = 0;
    //             $page = 1;
    //             $loker = Vacancy::active()
    //                 ->whereNotNull('preprocessed_text_id')
    //                 ->whereHas('company', function ($query) {
    //                     $query->whereNotNull('logo');
    //                 })
    //                 ->whereDoesntHave('applicants', function ($query) use ($item) {
    //                     // eliminate vacancy that has been applied by user
    //                     $query->where('user_id', $item->user_id);
    //                 })->whereDoesntHave('notifiedUsers', function ($query) use ($item) {
    //                     // eliminate vacancy that has been notified to user
    //                     $query->where('user_id', $item->user_id);
    //                 });

    //             $lokerBindings = [];
    //             foreach ($loker->getBindings() as $value) {
    //                 $lokerBindings[] = "'$value'";
    //             }
    //             $lokerQuery = Str::replaceArray('?', $lokerBindings, $loker->toSql());
    //             // dd($lokerQuery);
    //             $response = Http::get('http://' . env('CBRS_HOST') . ':' . env('CBRS_PORT') . '/search/' . $item->keyword, [
    //                 'customquery' => $lokerQuery,
    //                 'min' => $minWeight,
    //                 'page' => $page
    //             ])->object();
    //             if ($response && count($response->data) > 0 && $response->pages > 0) {
    //                 $vacancies = collect();
    //                 foreach ($response?->data as $vacancy) {
    //                     $vacancy = Vacancy::where('id', $vacancy->id)->with('company')->first();
    //                     $vacancies->push($vacancy);
    //                 }

    //                 if ($latestUserNotified == $item->user_id) {
    //                     $latestDelay += 5;
    //                 } else {
    //                     $latestDelay = 2;
    //                 }
    //                 $details = new RecommendationMail([
    //                     'subject' => 'Pekerjaan yang mungkin cocok untuk kamu (' . $item->keyword . ') - Bursa Kerja Khusus',
    //                     'title' => 'Pekerjaan yang mungkin cocok untuk kamu (' . $item->keyword . ')',
    //                     'vacancies' => $vacancies,
    //                 ]);
    //                 $emailJob = (new SendEmail($item->user->email, $details, $item->user->id, $vacancies))
    //                     ->delay(Carbon::now()->addMinutes($latestDelay));
    //                 dispatch($emailJob);
    //                 $latestUserNotified = $item->user_id;
    //             }

    //             dd($response, $item->keyword);
    //             break;
    //         }
    //     }
    // }
}
