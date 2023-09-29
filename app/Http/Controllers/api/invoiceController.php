<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DraftInvoice;
use Illuminate\Http\Request;

class invoiceController extends Controller
{
    public function index()
    {
        $draft = DraftInvoice::all();
    }
    public function store(Request $request)
    {
        $draft = DraftInvoice::create($request->only([
            'tax_id', 'inv_id', 'jsondata',
        ]));

        return $draft;

    }
}
