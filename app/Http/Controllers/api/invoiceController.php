<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DraftInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
