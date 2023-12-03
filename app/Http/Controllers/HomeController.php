<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DraftInvoice;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\SentInvoices;

class HomeController extends Controller
{

    public function index()
    {

        $products = Products::count();

        $approved = Products::whereStatus('Approved')->count();
        $customers = Customer::where('user_id', auth()->user()->id)->count();
        $sentinvoices = SentInvoices::where('user_id', auth()->user()->id)->count();


        $pending = Products::whereStatus('Submitted')->count();
        $allDraft = DraftInvoice::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->paginate(5);

        return view('index', compact('products','approved', 'pending','allDraft','customers','sentinvoices'));
    }
}
