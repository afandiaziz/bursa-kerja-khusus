<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Company;
use App\Models\Vacancy;
use App\Models\Information;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LandingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        Carbon::setLocale('id');
        // $this->middleware('auth');
    }

    public function dashboard()
    {
        $totalActiveJobs = Vacancy::active()->count();
        $totalNotActiveJobs = Vacancy::notActive()->count();
        $totalApplicants = User::where('role', 'applicant')->count();
        $totalCompanies = Company::where('status', true)->count();
        $totalInformations = Information::where('is_active', true)->count();
        return view('dashboard.index', compact('totalCompanies', 'totalApplicants', 'totalInformations', 'totalActiveJobs', 'totalNotActiveJobs'));
    }



    public function translate()
    {
        ini_set('max_execution_time', 3000);
        // $vacancies = DB::table('vacancies_copy1')->whereRaw('id NOT IN (SELECT id FROM vacancies)')->where('added', 0);
        // dd($vacancies->count());

        // $vacancies = Vacancy::where('x', 0)->get()->each(function ($vacancy) {
        //     $tr = new GoogleTranslate();
        //     $tr->setSource();
        //     $tr->setTarget('id');
        //     $vacancy->description = $tr->translate($vacancy->description);
        //     $vacancy->x = 1;
        //     // dd($vacancy->description);
        //     $vacancy->save();
        // });
    }
    // public function raw()
    // {
    //     $file = public_path('assets/upload/cv/resume-2.pdf');
    //     if (file_exists($file)) {
    //         // Initialize and load PDF Parser library
    //         $pdfParser = new Parser();
    //         $pdf = $pdfParser->parseFile($file);
    //         $textContent = $pdf->getText();
    //         dd($textContent);
    //     }
    // }

    public function index()
    {
        $companies = Company::orderBy('created_at', 'desc')->whereNotNull('logo')->where('logo', '!=', '')->limit(20)->get();
        $information = Information::where('is_active', 1)->orderBy('created_at', 'desc')->limit(3)->get();
        return view('home', compact('companies', 'information'));
    }

    public function information(Request $request)
    {
        if ($request->ajax()) {
            $data = Information::where('is_active', 1)->orderBy('created_at', 'desc')->get();
            $json = DataTables::collection($data)
                ->addColumn('content', function ($row) {
                    return strip_tags($row->content);
                })
                ->addColumn('card', function ($row) {
                    $html = '
                        <a href="' . route('informasi.detail', ['slug' => $row->slug]) . '" class="text-decoration-none">
                            <div class="card shadow-sm border">
                                <div class="img-responsive img-responsive-21x9 card-img-top" style="background-image: url(\'' . (filter_var($row->image, FILTER_VALIDATE_URL) ? $row->image : asset('assets/upload/information/' . $row->image)) . '\')"></div>
                                <div class="card-body">
                                    <h3 class="card-title">' . $row->title . '</h3>
                                    <p class="text-muted">
                                        ' . strip_tags(Str::limit($row->content, 100)) . '
                                    </p>
                                </div>
                            </div>
                        </a>';
                    return $html;
                })
                ->rawColumns(['card'])
                ->toJson();
            return $json;
        }
        return view('information');
    }

    public function detailInfo($slug)
    {
        $data = Information::where('slug', $slug)->firstOrFail();
        return view('detail-information', compact('data'));
    }
}
