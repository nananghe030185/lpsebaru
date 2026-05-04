<?php

namespace App\Http\Controllers\Member;

use App\DataTables\Member\InvoiceDataTable;
use App\Helpers\Helpers;
use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(InvoiceDataTable $dataTable)
    {
        
        return $dataTable->render('member.invoice.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::query()->get();
        return view('member.invoice.create', [
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->merge([
            'tanggal_terbit' => now(),
            'status' => 'unpaid',
            'item' => 'Perpanjangan Masa Aktif Akun',
        ]);
        $request->validate([
            // 'user_id' => 'required|exists:users,id',
            'durasi' => 'required|numeric',
            'nomer' => 'required|unique:invoices,nomer',
            'total' => 'required|numeric',
            // 'status' => ['required', In::make(['paid', 'unpaid', 'pending'])],
        ]);
        $request->merge([
            'user_id' => Helpers::getCurrentUserId()
        ]);


        $snap = $this->submitPayload($request);
        $request->merge([
            'snap_token' => $snap,
        ]);

        Invoice::create($request->all());

        return redirect()->route('app.invoice.index')->with('success', 'Invoice created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('app.invoice.index')->with('success', 'Invoice deleted successfully.');
    }

    public function pay(Invoice $invoice)
    {
        return view('member.invoice.pay', [
            'invoice' => $invoice,
            'client_key' => config('midtrans.client_key'),
        ]);
    }

    public function submitPayload($request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $user = User::find($request->user_id);

        $payload = [
                'transaction_details' => [
                    'order_id'      => $request->nomer,
                    'gross_amount'  => $request->total, // Total amount
                ],
                'customer_details' => [
                    'first_name'    => $user->name,
                    'email'         => $user->email,
                    'phone'         => $user->whatsapp,
                    'billing_address'=> [
                        'first_name'=> $user->name,
                        'email'=> $user->email,
                        'phone'=> $user->whatsapp,
                        // 'address'=> 'Sudirman',
                        // 'city'=> 'Jakarta',
                        // 'postal_code'=> '12190',
                        // 'country_code'=> 'IDN'
                    ],
                        'shipping_address'=> [
                        'first_name'=> $user->name,
                        'email'=> $user->email,
                        'phone'=> $user->whatsapp,
                        // 'address'=> 'Sudirman',
                        // 'city'=> 'Jakarta',
                        // 'postal_code'=> '12190',
                        // 'country_code'=> 'IDN'
                    ]
                ],
                'item_details' => [
                    [
                        'id'       => 'item-U' . $user->id ,
                        'price'    => $request->total,
                        'quantity' => 1,
                        'name'     => 'Perpanjangan Masa Aktif Akun',
                    ]
                ]
            ];
            
        $snapToken = Snap::getSnapToken($payload);
        
        return $snapToken;
    }

    public function display(Invoice $invoice)
    {
       return view('member.invoice.invoice', [
            'invoice' => $invoice,
        ]);
    }
}
