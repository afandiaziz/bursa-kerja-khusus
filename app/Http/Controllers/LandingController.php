<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Information;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Smalot\PdfParser\Parser;

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function raw()
    {
        $file = public_path('assets/upload/cv/resume-2.pdf');
        if (file_exists($file)) {
            // Initialize and load PDF Parser library
            $pdfParser = new Parser();
            $pdf = $pdfParser->parseFile($file);
            $textContent = $pdf->getText();
            dd($textContent);
        }
    }

    public function index()
    {
        $companies = Company::orderBy('created_at', 'desc')->limit(20)->get();
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
