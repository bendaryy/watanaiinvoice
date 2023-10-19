<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Details;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



class DetailsController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $details = new Details([
            'client_id' => $request->client_id,
            'client_secret' => $request->client_secret,
            'company_name' => $request->company,
            'company_id' => $request->company_id,
            'governate' => $request->governate,
            'regionCity' => $request->regionCity,
            'building_number' => $request->building_number,
            'issuerType' => "B",
            'user_id' => $user->id, // Associate the user's ID
            // Other fields as needed
        ]);

        $details->save();

        return $details;

    }
}
