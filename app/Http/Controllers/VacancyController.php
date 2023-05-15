<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VacancyController extends Controller
{
    private $prefix = 'vacancy';
    public function index(Request $request)
    {
        $prefix = $this->prefix;
        // if ($request->ajax()) {
        //     $data = Vacancy::orderBy('created_at', 'DESC')->get();
        //     $json = DataTables::collection($data)
        //         ->addIndexColumn()
        //         ->addColumn('status', function ($row) {
        //             if ($row->status) {
        //                 return '<span class="badge bg-teal">Ya</span>';
        //             } else {
        //                 return '<span class="badge bg-red">Tidak</span>';
        //             }
        //         })
        //         ->addColumn('action', function ($row) {
        //             $html = ' <div class="btn-group"> ';
        //             $html .= '
        //                 <a class="btn btn-primary btn-sm" href="' . route($this->prefix . '.detail', ['id' => $row->id]) . '">
        //                     <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-2-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
        //                         <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
        //                         <path d="M8 9h8"></path>
        //                         <path d="M8 13h5"></path>
        //                         <path d="M12 21l-.5 -.5l-2.5 -2.5h-3a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v4.5"></path>
        //                         <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
        //                         <path d="M20.2 20.2l1.8 1.8"></path>
        //                     </svg>
        //                     Detail
        //                 </a>
        //             ';
        //             $html .= ' </div> ';
        //             return $html;
        //         })
        //         ->rawColumns(['status', 'action'])
        //         ->toJson();
        //     return $json;
        // }
        return view('dashboard.' . $this->prefix . '.index', compact('prefix'));
    }
}
