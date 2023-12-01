<?php

namespace App\Http\Controllers;

use App\Models\DraftInvoice;
use Illuminate\Http\Request;
use App\Models\Products;

class HomeController extends Controller
{

    public function index()
    {

        $products = Products::count();

        $approved = Products::whereStatus('Approved')->count();

        $pending = Products::whereStatus('Submitted')->count();
        $allDraft = DraftInvoice::where('tax_id', auth()->user()->details->company_id)->orderBy('id', 'desc')->paginate(5);

        return view('index', compact('products','approved', 'pending','allDraft'));
    }
}
