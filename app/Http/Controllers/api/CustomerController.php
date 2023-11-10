<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
    public function AdminAddCustomer(Request $request)
    {
        // $customer = new Customer([
        //     'name' => 'required',
        //     'tax_id' => 'required',
        //     'user_id' => 'required',
        //     'country' => 'required',
        //     'governate' => 'required',
        //     'regionCity' => 'required',
        //     'street' => 'required',
        //     'buildingNumber' => 'required',
        // ]);

        // $validator = Validator::make($request->all());
        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 400);
        // }
        // $customer->save();
        // DB::transaction(function () use ($customer) {
        //     if ($customer->save()) {
        //         $new = Customer::where('user_id', $customer->user_id)->with('details')->first();
        //         $customer->user_taxid = $new['details']["company_id"];
        //         // $draftInv->inv_id = $draftInvoice->id;
        //         // $draftInv->inv_uuid = $draftInvoice->uuid;

        //     }
        //     $customer->update();
        // });

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'tax_id' => 'required',
            'user_id' => 'required',
            'country' => 'required',
            'governate' => 'required',
            'regionCity' => 'required',
            'street' => 'required',
            'buildingNumber' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $customer = Customer::create($request->all());

      DB::transaction(function () use ($customer) {
            if ($customer->save()) {
                $new = User::where('id', $customer->user_id)->with('details')->first();
                $customer->user_taxid = $new['details']["company_id"];
                // $draftInv->inv_id = $draftInvoice->id;
                // $draftInv->inv_uuid = $draftInvoice->uuid;

            }
            $customer->update();
        });

        return $customer;

    }
}
