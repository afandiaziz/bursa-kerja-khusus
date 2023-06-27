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
            $data = Criteria::where('parent_id', null)->orderBy('parent_order', 'asc')->get();
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
                        <a class="btn btn-primary btn-sm" href="' . route($this->prefix . '.detail', ['id' => $row->id]) . '">
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
        return view('dashboard.' . $this->prefix . '.index', compact('prefix'));
    }

    public function show($id)
    {
        $data = Criteria::findOrFail($id);
        $prefix = $this->prefix;
        return view('dashboard.' . $this->prefix . '.detail', compact('data', 'prefix'));
    }

    public function create(Request $request)
    {
        $prefix = $this->prefix;
        $parent_order = Criteria::max('parent_order') + 1;
        $criteriaTypes = CriteriaType::orderBy('type', 'asc')->get();
        return view('dashboard.' . $this->prefix . '.create', compact('prefix', 'criteriaTypes', 'parent_order'));
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
        // dd($request->all(), $criteriaType);
        if ($request->has('old') && json_decode(str_replace('&quot;', '"', $request->old))) {
            $decode = json_decode(str_replace('&quot;', '"', $request->old));
        } else if ($request->has('data')) {
            if ($request->has('sub')) {
                $decode = Criteria::where('parent_id', $request->data)->where('child_order', ($request->sub + 1))->first();
            } else {
                $decode = Criteria::where('id', $request->data)->firstOrFail();
            }
        }

        $criteriaType = CriteriaType::findOrFail($request->type);
        // dd(['old' => $decode, 'subIndex' => $request->sub]);
        switch ($criteriaType->type) {
            case 'Pilihan Ganda (Radio)':
            case 'Pilihan Ganda (Dropdown)':
            case 'Pilihan (Multiple Checkbox)':
            case 'Pilihan (Multiple Dropdown)':
                return [
                    view('components.forms.additional.choices', ['old' => $decode, 'subIndex' => $request->sub])->render(),
                ];
                break;
            case 'Angka':
                return [
                    view('components.forms.additional.length', ['old' => $decode, 'subIndex' => $request->sub])->render(),
                    view('components.forms.additional.number', ['old' => $decode, 'subIndex' => $request->sub])->render(),
                ];
                break;
            case 'Teks':
                return [
                    view('components.forms.additional.length', ['old' => $decode, 'subIndex' => $request->sub])->render(),
                ];
                break;
            case 'Upload File':
                return [
                    view('components.forms.additional.file', ['old' => $decode, 'subIndex' => $request->sub])->render(),
                ];
                break;
            case 'Custom':
                $criteriaTypes = CriteriaType::whereNotIn('type', ['custom'])->orderBy('type', 'asc')->get();
                return [
                    view('components.forms.additional.custom', ['old' => $decode, 'subIndex' => $request->sub, 'criteriaTypes' => $criteriaTypes])->render(),
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
            $sub = [];
            $children = [];
            foreach ($request->data as $item) {
                $name = $item['name'];
                if (str_contains($name, 'sub')) {
                    $exploded = explode(',', str_replace(['sub', '[', ']'], '', str_replace('][', ',', $name)));
                    $subName = $exploded[0];
                    $subIndex = $exploded[1];
                    $sub[$subIndex][$subName] = $item['value'];
                } else if ($name == 'answer[]') {
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
            if (count($sub) > 0) {
                foreach ($sub as $index => $item) {
                    $children[$index] = new Criteria();
                    $children[$index]->id = Str::uuid()->toString();
                    foreach ($item as $key => $value) {
                        $children[$index]->$key = $value;
                    }
                }
            }
            $data->children = count($children) > 0 ? $children : null;
            // dd($children);
            // dd($data);
            return response()->json([
                'selector' => $data->id,
                'html' => view('components.forms.form-container', ['data' => $data])->render(),
            ], 200);
        }
    }

    public function store(CriteriaRequest $request)
    {
        $request->validated();
        if ($request->has('format_file')) {
            $request->merge(['format_file' => implode(',', $request->all()['format_file'])]);
        }

        if ($request->has('min_length') && $request->has('min_number') && $request->min_length < strlen(str_replace('-', '', $request->min_number))) {
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
        } else if ($request->has('sub')) {
            foreach ($request->sub['name'] as $indexChildren => $name) {
                $child = [];
                foreach ($request->sub as $key => $value) {
                    $child[$key] = isset($value[$indexChildren]) ? $value[$indexChildren] : null;
                }
                Criteria::updateOrCreate([
                    'parent_id' => $created->id,
                    'child_order' => ($indexChildren + 1),
                ], $child);
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
        return view('dashboard.' . $this->prefix . '.edit', compact('data', 'prefix', 'criteriaTypes'));
    }

    public function update(CriteriaRequest $request, $id)
    {
        // dd($request->all());
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

        if ($request->has('min_length') && $request->has('min_number') && $request->min_length < strlen(str_replace('-', '', $request->min_number))) {
            return redirect()->back()->with('alert-danger', 'Minimum Angka yang Diinput tidak boleh kurang dari Minimum Panjang/Banyaknya Teks')->withInput($request->input());
        } elseif ($request->has('max_length') && $request->has('max_number') && $request->max_length < strlen(str_replace('-', '', $request->max_number))) {
            return redirect()->back()->with('alert-danger', 'Maksimum Angka yang Diinput tidak boleh kurang dari Minimum Panjang/Banyaknya Teks')->withInput($request->input());
        }

        $request->merge(['min_length' => $request->min_length]);
        $request->merge(['max_length' => $request->max_length]);
        $request->merge(['min_number' => $request->min_number]);
        $request->merge(['max_number' => $request->max_number]);
        $request->merge(['is_multiple' => $request->is_multiple]);
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
                foreach (CriteriaAnswer::where('criteria_id', $id)->get() as $index => $answer) {
                    if (!in_array($answer->index, array_keys($request->answer))) {
                        $answer->delete();
                    }
                }
            }
        } else if ($request->has('sub')) {
            // $currentChildren = Criteria::where('parent_id', $data->id)->orderBy('child_order', 'ASC')->count();
            // if (count($request->sub['name']) >= $currentChildren) {
            $indexes = [];
            for ($indexChildren = 0; $indexChildren < count($request->sub['name']); $indexChildren++) {
                $child = [];
                foreach ($request->sub as $key => $value) {
                    if ($key != 'answer') {
                        $child[$key] = isset($value[$indexChildren]) ? $value[$indexChildren] : null;
                    }
                }

                $criteriaUpdatedOrCreated = Criteria::updateOrCreate([
                    'parent_id' => $data->id,
                    'child_order' => ($indexChildren + 1),
                ], $child);

                array_push($indexes, ($indexChildren + 1));

                if (array_key_exists('answer', $request->sub) && array_key_exists(($indexChildren), $request->sub['answer'])) {
                    $indexesAnswer = [];
                    foreach ($request->sub['answer'][$indexChildren] as $indexAnswer => $answer) {
                        $criteriaAnswer = CriteriaAnswer::updateOrCreate([
                            'criteria_id' => $criteriaUpdatedOrCreated->id,
                            'answer' => $answer,
                        ], [
                            'answer' => $answer,
                            'index' => $indexAnswer,
                        ]);
                        array_push($indexesAnswer, $criteriaAnswer->id);
                    }
                    if (count($indexesAnswer) > 0) {
                        CriteriaAnswer::whereNotIn('id', $indexesAnswer)->where('criteria_id', $criteriaUpdatedOrCreated->id)->delete();
                    }
                }
            }
            Criteria::whereNotIn('child_order', $indexes)->where('parent_id', $data->id)->each(function ($item) {
                $item->delete();
            });
            Criteria::whereIn('child_order', $indexes)->where('parent_id', $data->id)->orderBy('child_order', 'ASC')->each(function ($item, $index) {
                $item->update([
                    'child_order' => ($index + 1),
                ]);
            });

            // } else {
            // dd($request->all(), $request->sub, $currentChildren);
            // $indexes = [];
            // foreach ($request->sub['name'] as $indexChildren => $name) {
            //     $child = [];
            //     foreach ($request->sub as $key => $value) {
            //         $child[$key] = isset($value[$indexChildren]) ? $value[$indexChildren] : null;
            //     }
            //     // Criteria::updateOrCreate([
            //     //     'parent_id' => $data->id,
            //     //     'child_order' => ($indexChildren + 1),
            //     // ], $child);
            //     array_push($indexes, ($indexChildren + 1));
            // }
            // Criteria::whereNotIn('child_order', $indexes)->where('parent_id', $data->id)->delete();
            // foreach (Criteria::whereIn('child_order', $indexes)->where('parent_id', $data->id)->orderBy('child_order', 'ASC')->get() as $index => $item) {
            //     // $item->update([
            //     //     'child_order' => ($index + 1),
            //     // ]);
            // }
            // }
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
