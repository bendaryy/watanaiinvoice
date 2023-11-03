<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DetailsController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'company_name' => 'required',
            'client_id' => 'required',
            'client_secret' => 'required',
            'company_id' => 'required',
            'governate' => 'required',
            'regionCity' => 'required',
            'buildingNumber' => 'required',
            'street' => 'required',
        ];
        $company_name = $request->input('company_name');
        $client_id = $request->input('client_id');
        $client_secret = $request->input('client_secret');
        $company_id = $request->input('company_id');
        $governate = $request->input('governate');
        $regionCity = $request->input('regionCity');
        $buildingNumber = $request->input('buildingNumber');
        $street = $request->input('street');
        $issuerType = "B";
        $user_id = $user->id;

        // $details = new Details([
        //     'client_id' => $request->client_id,
        //     'client_secret' => $request->client_secret,
        //     'company_name' => $request->company_name,
        //     'company_id' => $request->company_id,
        //     'governate' => $request->governate,
        //     'regionCity' => $request->regionCity,
        //     'buildingNumber' => $request->buildingNumber,
        //     'street' => $request->street,
        //     'issuerType' => "B",
        //     'user_id' => $user->id, // Associate the user's ID
        //     // Other fields as needed
        // ]);
        $validator = validator(compact('company_name', 'client_id', 'client_secret', 'company_id', 'governate', 'regionCity', 'buildingNumber', 'street'), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();
        $model = new Details;
        $model->user_id = $user->id; // Replace with the actual model you're using
        $model->issuerType = "B"; // Replace with the actual model you're using
        $model->fill($data);
        $model->save(); //

        $model->save();

        return $model;

    }

    public function adminStore(Request $request)
    {
        // $user = Auth::user();

        $rules = [
            'company_name' => 'required',
            'client_id' => 'required',
            'client_secret' => 'required',
            'company_id' => 'required',
            'governate' => 'required',
            'regionCity' => 'required',
            'buildingNumber' => 'required',
            'street' => 'required',
            'user_id' => [
                'required',
                Rule::unique('details', 'user_id'),
                // Rule::exists('details', 'user_id'),
            ],
        ];
        $company_name = $request->input('company_name');
        $client_id = $request->input('client_id');
        $client_secret = $request->input('client_secret');
        $company_id = $request->input('company_id');
        $governate = $request->input('governate');
        $regionCity = $request->input('regionCity');
        $buildingNumber = $request->input('buildingNumber');
        $street = $request->input('street');
        $issuerType = "B";
        $user_id = $request->input('user_id');

        // $details = new Details([
        //     'client_id' => $request->client_id,
        //     'client_secret' => $request->client_secret,
        //     'company_name' => $request->company_name,
        //     'company_id' => $request->company_id,
        //     'governate' => $request->governate,
        //     'regionCity' => $request->regionCity,
        //     'buildingNumber' => $request->buildingNumber,
        //     'street' => $request->street,
        //     'issuerType' => "B",
        //     'user_id' => $user->id, // Associate the user's ID
        //     // Other fields as needed
        // ]);
        $validator = validator(compact('company_name', 'client_id', 'client_secret', 'company_id', 'governate', 'regionCity', 'buildingNumber', 'street', 'user_id'), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();
        $model = new Details;
        // $model->user_id = $user->id; // Replace with the actual model you're using
        $model->issuerType = "B"; // Replace with the actual model you're using
        $model->fill($data);
        $model->save(); //

        $model->save();

        return $model;

    }
}
