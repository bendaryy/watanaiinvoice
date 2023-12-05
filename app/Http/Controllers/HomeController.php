<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DraftInvoice;
use App\Models\Products;
use App\Models\SentInvoices;

class HomeController extends Controller
{

    public function index()
    {

        $products = Products::count();

        $approved = Products::whereStatus('Approved')->count();
        $customers = Customer::where('user_id', auth()->user()->id)->count();
        $sentinvoices = DraftInvoice::where('user_id', auth()->user()->id)->whereNotNull('inv_uuid')->count();
        $NotsentOfDraft = DraftInvoice::where('user_id', auth()->user()->id)->whereNull('inv_uuid')->count();

        $pending = Products::whereStatus('Submitted')->count();
        $allDraft = DraftInvoice::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->paginate(5);
        $allDraftCount = DraftInvoice::where('user_id', auth()->user()->id)->count();

        return view('index', compact('products', 'approved', 'pending', 'allDraft', 'customers', 'sentinvoices','NotsentOfDraft','allDraftCount'));
    }
}
