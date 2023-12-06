<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DraftInvoice;
use App\Models\SentInvoices;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class invoiceController extends Controller
{
    public function adminIndex($id)
    {
        $draft = DraftInvoice::where('user_id', $id)->get();
        return $draft;
    }

    public function index()
    {
        $draft = DraftInvoice::where('user_id', auth()->user()->id)->latest()->get();
        return $draft;
    }
    public function store(Request $request)
    {
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
            'user_id' => [
                'required',
                Rule::exists('users', 'id'),
            ],
            // Add more rules for other fields
        ];

        $validator = Validator::make($request->only(['user_id', 'jsondata']), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $trnsformed = json_encode($request->input('jsondata'), JSON_UNESCAPED_UNICODE);
        $draftInvoice = new DraftInvoice([
            'jsondata' => json_decode($trnsformed),
            'user_id' => $request->input('user_id'), // Associate the user's ID
        ]);

        $draftInvoice->save();

        DB::transaction(function () use ($draftInvoice) {
            $total_t4 = $draftInvoice['jsondata']['taxTotals'][0]['amount'];
            $total_t1 = $draftInvoice['jsondata']['taxTotals'][1]['amount'];
            $net_amount = $draftInvoice['jsondata']['netAmount'];
            $totalAmount = $draftInvoice['jsondata']['totalAmount'];
            if ($draftInvoice->save()) {
                if (isset($draftInvoice->user_id)) {
                    $userId = User::find($draftInvoice->user_id)->with('details')->get();
                    $draftInvoice->tax_id = $userId[0]["details"]['company_id'];
                    $draftInvoice->phone = $userId[0]['phone'];
                    $draftInvoice->t1_total = $total_t1;
                    $draftInvoice->t4_total = $total_t4;
                    $draftInvoice->net_amount = $net_amount;
                    $draftInvoice->total = $totalAmount;
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

    public function sendDraftData($id)
    {
        $userId = DraftInvoice::find($id)['user_id'];
        $data = DraftInvoice::find($id)['jsondata'];
        // $trnsformed = json_encode($data, JSON_UNESCAPED_UNICODE);
        // $myFileToJson = fopen('C:\laragon\www\watanai\EInvoicing\SourceDocumentJson.json', "w") or die("unable to open file");
        // fwrite($myFileToJson, $trnsformed);
        // $path = 'C:\laragon\www\watanai\EInvoicing\SourceDocumentJson.json';
        // $fullDraftFile = file_get_contents($path);
        // $obj = json_decode($fullDraftFile, true);
        // $datetime = $obj['dateTimeIssued'] = date('Y-m-d') . 'T' . date('H:i:s') . 'Z';
        // $trnsformed = json_encode($obj, JSON_UNESCAPED_UNICODE);
        // $myFileToJson = fopen('C:\laragon\www\watanai\EInvoicing\SourceDocumentJson.json', "w") or die("unable to open file");
        // $file = fwrite($myFileToJson, $trnsformed);
        // return $obj;
        if ($userId == auth()->user()->id) {
            return $data;

        } else {
            return response(['message' => "Unauthorize Access!"], 401);
        }

        // return redirect('cer')->with('id', $id);
    }
    public function saveToSentDocuments(Request $request)
    {
        $sentInvoices = new SentInvoices();
        $sentInvoices->uuid = $request->uuid;
        $sentInvoices->longid = $request->longid;
        $sentInvoices->user_id = auth()->user()->id;
        $sentInvoices->tax_id = auth()->user()->details->company_id;
        $sentInvoices->jsondata = $request->jsondata;
        $sentInvoices->draft_id = $request->draft_id;
        $sentInvoices->save();

        return $sentInvoices;

    }
    public function saveDraftAfterTransaction($id, Request $request)
    {

        $draftInv = DraftInvoice::where('id', $id)->first();
        $draftInv->inv_id = $request->inv_id;
        $draftInv->inv_uuid = $request->inv_uuid;
        $draftInv->save();
    }

    public function showSentInvoice()
    {
        $sentInvoices = SentInvoices::where('user_id', auth()->user()->id)->paginate(3);
        return $sentInvoices;
    }

}
