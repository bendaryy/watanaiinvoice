<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class ActivityCodeController extends Controller
{
    public function index()
    {
        $codes = DB::table('activity_code')->where('user_id', auth()->user()->id)->get();
        return view('activitycode.index', compact('codes'));
    }
    public function create()
    {
        return view('activitycode.create');
    }
    public function store(Request $request)
    {
        $data = [
            "Desc_ar" => $request->Desc_ar,
            "code" => $request->code,
            "user_id" => auth()->user()->id,
        ];
        DB::table('activity_code')->insert($data);
        return redirect()->route('activitycode.index')->with('success',Lang::get('site.Activity Code Added'));
    }
    public function destroy($id){
        DB::table('activity_code')->where('id', $id)->delete();
        return redirect()->back()->with('deleted', Lang::get('site.Activity Code Deleted'));

    }
}
