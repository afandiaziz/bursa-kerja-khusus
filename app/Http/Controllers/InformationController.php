<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\InformationRequest;

class InformationController extends Controller
{
    private $prefix = 'information';

    public function index(Request $request)
    {
        $prefix = $this->prefix;
        if ($request->ajax()) {
            $data = Information::orderBy('created_at', 'DESC')->get();
            $json = DataTables::collection($data)
                ->addIndexColumn()
                ->addColumn('active', function ($row) {
                    if ($row->is_active) {
                        return '<span class="badge bg-teal">Aktif</span>';
                    } else {
                        return '<span class="badge bg-red">Tidak Aktif</span>';
                    }
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
                ->rawColumns(['active', 'action'])
                ->toJson();
            return $json;
        }
        return view('dashboard.' . $this->prefix . '.index', compact('prefix'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prefix = $this->prefix;
        return view('dashboard.' . $this->prefix . '.create', compact('prefix'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InformationRequest $request)
    {
        $request->validated();
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $image_name = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/upload/companies/'), $image_name);
        }
        $data = $request->except('image');
        $data['image'] = $image_name;
        $data['slug'] = Str::slug($request->title) . '-' . Str::lower(Str::random(5));

        $created = Information::create($data);
        if ($created) {
            return redirect()->route($this->prefix . '.index')->with('alert-success', 'Berhasil menambahkan informasi baru');
        } else {
            return redirect()->back()->with('alert-danger', 'Gagal menambahkan informasi baru');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Information::findOrFail($id);
        $prefix = $this->prefix;
        return view('dashboard.' . $this->prefix . '.detail', compact('data', 'prefix'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Information::findOrFail($id);
        $prefix = $this->prefix;
        return view('dashboard.' . $this->prefix . '.edit', compact('data', 'prefix'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InformationRequest $request, $id)
    {
        $request->validated();
        $data = Information::findOrFail($id);
        $image_name = null;
        if ($request->hasFile('image')) {
            if (file_exists(public_path('assets/upload/companies/' . $data->image))) {
                unlink(public_path('assets/upload/companies/' . $data->image));
            }
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/upload/companies/'), $image_name);
        }
        $dataUpdated = $request->except('image');
        if ($image_name) {
            $data['image'] = $image_name;
        }
        $data['slug'] = Str::slug($request->title) . '-' . Str::lower(Str::random(5));

        if ($data && $data->update($dataUpdated)) {
            return redirect()->route($this->prefix . '.detail', ['id' => $data->id])->with('alert-success', 'Berhasil mengupdate informasi ' . $data->title);
        } else {
            return redirect()->back()->with('alert-danger', 'Gagal mengupdate informasi ' . $data->title);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Information::findOrFail($id);
        if ($data) {
            if (file_exists(public_path('assets/upload/information/' . $data->image))) {
                unlink(public_path('assets/upload/information/' . $data->image));
            }
            $data->delete();
            return redirect()->route($this->prefix . '.index')->with('alert-success', 'Berhasil menghapus informasi ' . $data->name);
        } else {
            return redirect()->back()->with('alert-danger', 'Gagal menghapus informasi ' . $data->name);
        }
    }

    public function activate($id)
    {
        $company = Information::findOrFail($id);
        if ($company->is_active) {
            $update = 0;
            $message = 'Berhasil menonaktifkan informasi';
        } else {
            $update = 1;
            $message = 'Berhasil mengaktifkan informasi';
        }
        $company->update(['is_active' => $update]);
        return redirect()->back()->with('alert-success', $message);
    }
}
