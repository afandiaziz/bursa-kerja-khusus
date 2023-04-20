<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\Criteria;
use Illuminate\Support\Str;
use App\Models\CriteriaType;
use Illuminate\Http\Request;
use App\Models\CriteriaAnswer;
use App\Http\Requests\CriteriaRequest;

class CriteriaController extends Controller
{
    private $prefix = 'criteria';
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
        $prefix = $this->prefix;
        return view('dashboard.criteria.index', compact('prefix'));
    }

    public function show($id)
    {
        $data = Criteria::findOrFail($id);
        $prefix = $this->prefix;
        return view('dashboard.criteria.detail', compact('data', 'prefix'));
    }

    public function create(Request $request)
    {
        $prefix = $this->prefix;
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
        if ($request->has('old') && json_decode(str_replace('&quot;', '"', $request->old))) {
            $decode = json_decode(str_replace('&quot;', '"', $request->old));
        } else if ($request->has('data')) {
            $decode = Criteria::where('id', $request->data)->get()->first();
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
                    view('components.forms.length', ['old' => $decode])->render(),
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

    public function formPreview(Request $request)
    {
        if ($request->has('data')) {
            $request->merge(['data' => array_slice($request->data, 1)]);
            if ($request->has('id')) {
                $data = Criteria::findOrFail($request->id);
            } else {
                $data = new Criteria();
            }
            $collection = collect($data->criteriaAnswer);
            $indexAnswer = 0;
            foreach ($request->data as $item) {
                $name = $item['name'];
                if ($name == 'answer[]') {
                    if ($indexAnswer < count($data->criteriaAnswer)) {
                        $collection[$indexAnswer]->answer = $item['value'];
                    } else {
                        if ($item['value']) {
                            $new = new CriteriaAnswer();
                            $new->fill([
                                'id' => Str::uuid()->toString(),
                                'answer' => $item['value'],
                                'criteria_id' => $data->id
                            ]);
                            $collection->push($new);
                        }
                    }
                    $indexAnswer++;
                } else if ($name == 'format_file[]') {
                    if (!str_contains($data->format_file, $item['value'])) {
                        if ($data->format_file) {
                            $data->format_file .= ',' . $item['value'];
                        } else {
                            $data->format_file = $item['value'];
                        }
                    }
                } else {
                    $data->id = Str::uuid()->toString();
                    $data->$name = $item['value'];
                    $data->format_file = null;
                }
            }
            $data->criteriaAnswer = $collection;
            return view('components.forms.form', ['data' => $data]);
        }
    }

    public function store(CriteriaRequest $request)
    {
        $request->validated();
        if ($request->has('format_file')) {
            $request->merge(['format_file' => implode(',', $request->all()['format_file'])]);
        }

        if ($request->has('max_length') && $request->has('min_number') && $request->max_length < strlen(str_replace('-', '', $request->min_number))) {
            return redirect()->back()->with('alert-danger', 'Minimum Angka yang Diinput tidak boleh kurang dari Minimum Panjang/Banyaknya Teks')->withInput($request->input());
        } elseif ($request->has('max_length') && $request->has('max_number') && $request->max_length < strlen(str_replace('-', '', $request->max_number))) {
            return redirect()->back()->with('alert-danger', 'Maksimum Angka yang Diinput tidak boleh kurang dari Minimum Panjang/Banyaknya Teks')->withInput($request->input());
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

    public function edit($id)
    {
        $data = Criteria::findOrFail($id);
        $prefix = $this->prefix;
        $criteriaTypes = CriteriaType::orderBy('type', 'asc')->get();
        return view('dashboard.criteria.edit', compact('data', 'prefix', 'criteriaTypes'));
    }

    public function update(CriteriaRequest $request, $id)
    {
        $request->validated();
        if ($request->has('format')) {
            if ($request->format == 0 && $request->has('format_file')) {
                $request->merge(['format_file' => implode(',', $request->all()['format_file'])]);
            } else {
                $request->merge(['format_file' => null]);
            }
        } else {
            $request->merge(['format_file' => null]);
        }

        if ($request->has('max_length') && $request->has('min_number') && $request->max_length < strlen(str_replace('-', '', $request->min_number))) {
            return redirect()->back()->with('alert-danger', 'Minimum Angka yang Diinput tidak boleh kurang dari Minimum Panjang/Banyaknya Teks')->withInput($request->input());
        } elseif ($request->has('max_length') && $request->has('max_number') && $request->max_length < strlen(str_replace('-', '', $request->max_number))) {
            return redirect()->back()->with('alert-danger', 'Maksimum Angka yang Diinput tidak boleh kurang dari Minimum Panjang/Banyaknya Teks')->withInput($request->input());
        }

        $request->merge(['min_length' => $request->min_length]);
        $request->merge(['max_length' => $request->max_length]);
        $request->merge(['min_number' => $request->min_number]);
        $request->merge(['max_number' => $request->max_number]);
        $request->merge(['type_upload' => $request->type_upload]);
        $request->merge(['max_files' => $request->max_files]);
        $request->merge(['max_size' => $request->max_size]);
        $request->merge(['custom_label' => $request->custom_label]);
        $request->merge(['mask' => $request->mask]);

        $data = Criteria::findOrFail($id);
        $data->update($request->all());

        if ($request->has('answer')) {
            if (count($request->answer) >= count($data->criteriaAnswer)) {
                foreach ($request->answer as $index => $answer) {
                    $dataAnswer = CriteriaAnswer::where('index', $index)->where('criteria_id', $id)->get()->first();
                    if ($dataAnswer) {
                        $dataAnswer->update([
                            'answer' => $answer,
                        ]);
                    } else {
                        CriteriaAnswer::create([
                            'criteria_id' => $id,
                            'index' => $index,
                            'answer' => $answer,
                        ]);
                        // dd($dataAnswer, $answer);
                    }
                }
            } else {
                foreach ($request->answer as $index => $answer) {
                    $dataAnswer = CriteriaAnswer::where('index', $index)->where('criteria_id', $id)->get()->first();
                    if ($dataAnswer) {
                        $dataAnswer->update([
                            'answer' => $answer,
                        ]);
                    }
                }
                $dataAnswer = CriteriaAnswer::where('criteria_id', $id)->get();
                foreach ($dataAnswer as $index => $answer) {
                    if (!in_array($answer->index, array_keys($request->answer))) {
                        $answer->delete();
                    }
                }
            }
        } else {
            if (count($data->criteriaAnswer)) {
                foreach ($data->criteriaAnswer as $item) {
                    $item->delete();
                }
            }
        }
        return redirect()->route('criteria.index')->with('alert-success', 'Berhasil mengupdate kriteria ' . $data->name);
    }
}
