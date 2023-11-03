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
        $customerName = Customer::where('name', "LIKE", '%' . $name . '%')->get();
        if (isset($customerName[0])) {
            return $customerName;
        } else {
            return response()->json(["لا يوجد شركة بهذا الإسم"]);
        }
    }
}
