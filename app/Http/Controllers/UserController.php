<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $prefix = 'user';
    public function index(Request $request)
    {
        $prefix = $this->prefix;
        if ($request->ajax()) {
            $data = User::where('role', 'applicant')->orderBy('created_at', 'DESC')->get();
            $json = DataTables::collection($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $html = ' <div class="btn-group"> ';
                    $html .= '
                        <a class="btn btn-primary btn-sm" href="' . route($this->prefix . '.show', ['id' => $row->id]) . '">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-2-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M8 9h8"></path>
                                <path d="M8 13h5"></path>
                                <path d="M12 21l-.5 -.5l-2.5 -2.5h-3a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v4.5"></path>
                                <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                <path d="M20.2 20.2l1.8 1.8"></path>
                            </svg>
                            Detail
                        </a>
                    ';
                    $html .= ' </div> ';
                    return $html;
                })
                ->rawColumns(['action'])
                ->toJson();
            return $json;
        }
        return view('dashboard.' . $this->prefix . '.index', compact('prefix'));
    }

    public function show(Request $request, $id)
    {
        $data = User::findOrFail($id);
        if ($request->ajax()) {
            $json = DataTables::collection($data->applications)
                ->addColumn('card', function ($item) {
                    $logo = filter_var($item->vacancy->company->logo, FILTER_VALIDATE_URL) ? $item->vacancy->company->logo : asset('assets/upload/companies/' . $item->vacancy->company->logo);
                    $html = '
                        <a href="' . route('applicant.detail', ['id' => $item->id]) . '" class="text-decoration-none p-0">
                            <div class="card card-loker cursor-pointer">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div>
                                            <div class="row">
                                                <div class="col-auto">
                                                    <span class="bg-transparent border-0 shadow-none avatar avatar-lg">
                                                        <img src="' . $logo . '" alt="' . $item->vacancy->company->name . '">
                                                    </span>
                                                </div>
                                                <div class="col">
                                                    <div class="fw-bold">
                                                        <h3 class="link-blue mb-1">' . $item->vacancy->position . '</h3>
                                                    </div>
                                                    <div class="text-dark">
                                                        ' . $item->vacancy->job_type . '
                                                        <div class="mt-1">' . $item->vacancy->company->name . '</div>
                                                    </div>
                                                    <div class="text-muted mt-3">
                                                        <span class="small">
                                                            Melamar pada ' . Carbon::parse($item->created_at)->translatedFormat('d F Y, H:i') . ' (' . $item->created_at->diffForHumans() . ')
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ms-auto">
                                            <div class="badge ' . ($item->verified ? 'bg-success' : 'bg-danger') . '">' . ($item->verified ? 'Terverifikasi' : 'Belum Terverifikasi') . '</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>';
                    return $html;
                })
                ->rawColumns(['card'])
                ->toJson();
            return $json;
        }
        $criteria = Criteria::where('parent_id', null)->get();
        $buttonBack = true;
        $prefix = $this->prefix;
        return view('dashboard.' . $this->prefix . '.show', compact('data', 'prefix', 'buttonBack', 'criteria'));
    }
}
