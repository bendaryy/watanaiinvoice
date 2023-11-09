<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DraftInvoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class invoiceController extends Controller
{
    public function index()
    {
        $draft = DraftInvoice::where('user_id', auth()->user()->id)->get();
        return $draft;
    }
    public function store(Request $request)
    {
        // $draft = DraftInvoice::create($request->only([
        //     'tax_id', 'inv_id', 'jsondata', 'user_id' => Auth::user()->id,
        // ]));

        // Create a new DraftInvoice record and associate it with the user's ID
        $user = Auth::user();
        $draftInvoice = new DraftInvoice([
            'tax_id' => $user->details->company_id,
            'inv_id' => $request->input('inv_id'),
            'jsondata' => $request->input('jsondata'),
            'phone' => $user->phone,
            'user_id' => $user->id, // Associate the user's ID
            // Other fields as needed
        ]);

        $draftInvoice->save();

        return $draftInvoice;

    }

    public function adminStoreInvoice(Request $request)
    {
        $rules = [
            'jsondata' => 'required',
            'user_id' => 'required',
            // Add more rules for other fields
        ];

        $draftInvoice = new DraftInvoice([
            'jsondata' => $request->input('jsondata'),
            'user_id' => $request->input('user_id'), // Associate the user's ID
        ]);

        $draftInvoice->save();

        DB::transaction(function () use ($draftInvoice) {
            if ($draftInvoice->save()) {
                // $draftInv = DraftInvoice::where('user_id', $draftInvoice->draft_id)->first();
                // $draftInv->inv_id = $draftInvoice->id;
                // $draftInv->inv_uuid = $draftInvoice->uuid;
                if (isset($draftInvoice->user_id)) {
                    $userId = User::find($draftInvoice->user_id)->with('details')->get();
                    $draftInvoice->tax_id = $userId[0]["details"]['company_id'];
                    $draftInvoice->phone = $userId[0]['phone'];
                }
            }
            $draftInvoice->update();
        });

        return $draftInvoice;

    }

    public function show($id)
    {
        $invoice = DraftInvoice::findOrFail($id);
        if ($invoice->user_id === auth()->user()->id) {
            return $invoice;
        } else {
            return response(['message' => "unauthorized"], 403);
        }
    }
}
