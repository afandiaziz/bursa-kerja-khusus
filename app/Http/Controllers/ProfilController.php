<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\User;
use App\Models\UserDetail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
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

    public function index()
    {
        $criteria = Criteria::where('active', true)->orderBy('parent_order', 'ASC')->get();
        return view('profil', compact('criteria'));
    }
    public function update(Request $request)
    {
        User::where('id', Auth::user()->id)->update([
            'name' => $request->name,
        ]);
        $userDetail = $request->except('_token', 'name');
        // dd($userDetail);
        foreach ($userDetail as $key => $value) {
            $criteria = Criteria::findOrFail($key);
            if (is_array($value)) {
                $value = implode(',', $value);
            }
            if ($criteria->required) {
                if ($value != null) {
                    UserDetail::updateOrCreate([
                        'user_id' => Auth::user()->id,
                        'criteria_id' => $key,
                    ], [
                        'value' => $value,
                    ]);
                }
            } else {
                UserDetail::updateOrCreate([
                    'user_id' => Auth::user()->id,
                    'criteria_id' => $key,
                ], [
                    'value' => $value,
                ]);
            }
        }
    }
}
