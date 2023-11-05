<?php

namespace App\Http\Controllers;

use App\Models\Details;
use Illuminate\Http\Request;

class ApisettingController extends Controller
{

    public function index()
    {
        $setting = Details::where('user_id', auth()->user()->id)->get();
        // return $setting;

        return view('apisetting.index', compact('setting'));
    }

    public function create(){
        return view ('apisetting.create');
    }

    public function store(Request $request)
    {
        $request->validate([

            'client_id' => 'required',
            'client_secret' => 'required',
            'company_id' => 'required',
            'company_name' => 'required',
            'governate' => 'required',
            'regionCity' => 'required',
            'street' => 'required',
            'buildingNumber' => 'required',
            // 'issuerType' => 'required',
        ]);

        $data = $request->all();
        $setting = new Details;
        $setting->issuerType = "B";
        $setting->user_id = auth()->user()->id;


        $setting->fill($data);
        $setting->save();

        session()->flash('message', 'created Successfully');

        return redirect('setting');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $setting = Details::findOrFail($id);
        // $setting = Details::first();
        if ($setting['user_id'] === auth()->user()->id) {
            // return $apiSetting;
            return view('apisetting.edit', compact('setting'));

        } else {
            return abort(403);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {

        $request->validate([

            'client_id' => 'required',
            'client_secret' => 'required',
            'company_id' => 'required',
            'company_name' => 'required',
            'governate' => 'required',
            'regionCity' => 'required',
            'street' => 'required',
            'buildingNumber' => 'required',
            // 'issuerType' => 'required',
        ]);

        $setting = Details::findOrFail($id);

        $setting->update($request->all());

        session()->flash('message', 'Updated Successfully');

        return redirect('setting');

    }
}
