<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCriteriaRequest;
use App\Models\Criteria;
use App\Models\CriteriaAnswer;
use App\Models\CriteriaType;
use Illuminate\Http\Request;
use DataTables;
use Auth;

class CriteriaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Criteria::all();
            $json = DataTables::collection($data)
                ->addIndexColumn()
                ->addColumn('required', function ($row) {
                    if ($row->required) {
                        return '<span class="badge bg-teal">Ya</span>';
                    } else {
                        return '<span class="badge bg-red">Tidak</span>';
                    }
                })
                ->addColumn('active', function ($row) {
                    if ($row->active) {
                        return '<span class="badge bg-teal">Ya</span>';
                    } else {
                        return '<span class="badge bg-red">Tidak</span>';
                    }
                })
                ->addColumn('type', function ($row) {
                    return $row->criteriaType->type;
                })
                ->addColumn('action', function ($row) {
                    $html = ' <div class="btn-group"> ';
                    $html .= '
                        <a class="btn btn-primary btn-sm" href="' . route('criteria.detail', ['id' => $row->id]) . '">
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
                ->rawColumns(['type', 'required', 'active', 'action'])
                ->toJson();
            return $json;
        }
        $prefix = 'criteria';
        return view('dashboard.criteria.index', compact('prefix'));
    }

    public function show($id)
    {
        $data = Criteria::findOrFail($id);
        $prefix = 'criteria';
        return view('dashboard.criteria.detail', compact('data', 'prefix'));
    }

    public function create(Request $request)
    {
        $prefix = 'criteria';
        $parent_order = Criteria::max('parent_order') + 1;
        $criteriaTypes = CriteriaType::orderBy('type', 'asc')->get();
        return view('dashboard.criteria.create', compact('prefix', 'criteriaTypes', 'parent_order'));
    }

    public function activate($id)
    {
        $criteria = Criteria::findOrFail($id);
        if ($criteria->active) {
            $update = 0;
            $message = 'Berhasil menonaktifkan kriteria';
        } else {
            $update = 1;
            $message = 'Berhasil mengaktifkan kriteria';
        }
        $criteria->update(['active' => $update]);
        return redirect()->back()->with('alert-success', $message);
    }

    public function formAdditional(Request $request)
    {
        $decode = null;
        if ($request->has('old')) {
            $decode = json_decode(str_replace('&quot;', '"', $request->old));
        }
        $criteriaType = CriteriaType::findOrFail($request->type);
        switch ($criteriaType->type) {
            case 'Pilihan Ganda (Radio)':
            case 'Pilihan Ganda (Dropdown)':
            case 'Pilihan (Multiple Checkbox)':
            case 'Pilihan (Multiple Dropdown)':
                return [
                    view('components.forms.choices', ['old' => $decode])->render(),
                ];
                break;
            case 'Angka':
                return [
                    view('components.forms.number', ['old' => $decode])->render(),
                ];
                break;
            case 'Teks':
                return [
                    view('components.forms.length', ['old' => $decode])->render(),
                ];
                break;
            case 'Upload File':
                return [
                    view('components.forms.file', ['old' => $decode])->render(),
                ];
                break;

            default:
                return '';
                break;
        }
        return '';
    }

    public function store(StoreCriteriaRequest $request)
    {
        $request->validated();
        if ($request->has('format_file')) {
            $request->merge(['format_file' => implode(',', $request->all()['format_file'])]);
        }

        $created = Criteria::create($request->all());
        if ($request->has('answer')) {
            foreach ($request->answer as $index => $answer) {
                CriteriaAnswer::create([
                    'criteria_id' => $created->id,
                    'index' => $index,
                    'answer' => $answer,
                ]);
            }
        }
        if ($created) {
            return redirect()->route('criteria.index')->with('alert-success', 'Berhasil menambahkan kriteria baru');
        } else {
            return redirect()->back()->with('alert-danger', 'Gagal menambahkan kriteria baru');
        }
    }
}
