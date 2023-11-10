<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function showCustomerName(Request $request)
    {

        $name = $request->name;
        $user_id = $request->user_id;

         if (!$request->has('name')) {
            return response()->json(['error' => 'customer name is required'], 400);
        }
         if (!$request->has('user_id')) {
            return response()->json(['error' => 'ownr user is required'], 400);
        }
        $customerName = Customer::where('name', "LIKE", '%' . $name . '%')->where("user_id", $user_id)->get();
        if (isset($customerName[0])) {
            return $customerName;
        } else {
            return response()->json(["لا يوجد شركة بهذا الإسم"]);
        }
    }
}
