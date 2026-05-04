<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\InvoiceDataTable;
use App\Helpers\AppHelper;
use App\Helpers\Helpers;
use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Keuangan;
use App\Models\Komisi;
use App\Models\User;
use App\Notifications\InvoiceNotification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;
use Midtrans\Config;
use Midtrans\Snap;

class InvoiceController extends Controller
{
    public function index(InvoiceDataTable $dataTable)
    {
        return $dataTable->render('admin.invoice.index');
    }

    public function create()
    {
        $users = User::query()->get();
        return view('admin.invoice.create', [
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $request->merge([
            'tanggal_terbit' => now(),
            'status' => 'unpaid',
            'item' => 'Perpanjangan Masa Aktif Akun',
        ]);
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'durasi' => 'required|numeric',
            'nomer' => 'required|unique:invoices,nomer',
            'total' => 'required|numeric',
            // 'status' => ['required', In::make(['paid', 'unpaid', 'pending'])],
        ]);
        $snap = $this->submitPayload($request);
        $request->merge([
            'snap_token' => $snap,
        ]);

        Invoice::create($request->all());

        return redirect()->route('admin.invoice.index')->with('success', 'Invoice created successfully.');
    }

    public function display(Invoice $invoice)
    {
       return view('admin.invoice.invoice', [
            'invoice' => $invoice,
        ]);
    }

    
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('admin.invoice.index')->with('success', 'Invoice deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            Invoice::whereIn('id', $ids)->delete();
            return response()->json(['message' => 'Data berhasil dihapus.']);
        }
        return response()->json(['message' => 'Tidak ada data yang dipilih.'], 400);
    }

    public function pay(Invoice $invoice)
    {
        return view('admin.invoice.pay', [
            'invoice' => $invoice,
            'client_key' => config('midtrans.client_key'),
        ]);
    }

    public function checkout(Request $request)
    {
        Invoice::where('nomer', $request->order_id)
            ->update([
                'status' => $request->transaction_status,
                'pdf_url' => $request->pdf_url,
                'keterangan' => 'Silahkan lakukan pembayaran max 1x24 jam',
            ]);

        return response()->json([
            'result' => $request->all(),
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
                    ],
                    'shipping_address'=> [
                        'first_name'=> $user->name,
                        'email'=> $user->email,
                        'phone'=> $user->whatsapp,
                    ]
                ],
                'item_details' => [
                    [
                        'id'       => 'item1',
                        'price'    => $request->total,
                        'quantity' => 1,
                        'name'     => 'Perpanjangan Masa Aktif Akun',
                    ]
                ]
            ];
            
        $snapToken = Snap::getSnapToken($payload);
        
        return $snapToken;
    }

    public function webhook(Request $request)
    {
        // Mengambil konfigurasi Server Key
        $serverKey = config('midtrans.server_key');
        // Validasi signature key dari Midtrans
        $signatureKey = hash("sha512",
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );
    
        
        if ($signatureKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature key'], 403);
        }
        
        try{
            // Cek status transaksi
            $invoice = Invoice::where('nomer', $request->input('order_id'))->first();

            if (!$invoice) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            if ($request->transaction_status == 'settlement' || $request->transaction_status == 'capture') {
                $invoice->status = 'paid'; // Status pembayaran berhasil
                $invoice->tanggal_bayar = now(); // Set tanggal bayar

                // tambah masa berlaku akun
                $userhelper = new UserHelper($invoice->user);
                $userhelper->tambahMasaBerlaku($invoice->durasi);

                // buat input di laporan
                Keuangan::create([
                    'user_id' => $invoice->user_id,
                    'keterangan' => 'Pembayaran Invoice ' . $invoice->nomer . ' untuk Perpanjangan Masa Aktif Akun',
                    'pemasukan' => $invoice->total,
                    'pengeluaran' => 0,
                    'tanggal' => now(),
                ]);

                Komisi::create([
                    'id_downline' => $invoice->user_id,
                    'id_upline' => $invoice->user->upline,
                    'keterangan' => 'Komisi dari pembayaran Invoice ' . $invoice->nomer,
                    'nominal' => $invoice->total * AppHelper::getPersenKomisi() / 100,
                    'pay_date' => now(),
                    'state' => false, // belum dibayar
                ]);

                // Tambah Komisi User
                $user = User::findOrFail($invoice->user_id);
                $komisi = $user->komisi;
                $user->update(['komisi' => $komisi + ($invoice->total * AppHelper::getPersenKomisi() / 100)])

                // Kirim notifikasi jika diperlukan
                // $userhelper->user->notify(new InvoiceNotification($invoice));

            } elseif ($request->transaction_status == 'cancel' || $request->transaction_status == 'expire') {
                $invoice->status = 'failed'; // Status pembayaran gagal atau kadaluarsa
                $invoice->keterangan = 'Pembayaran gagal atau kadaluarsa';
            } elseif ($request->transaction_status == 'pending') {
                $invoice->status = 'pending'; // Status menunggu pembayaran
                $invoice->tanggal_terbit = request()->input('transaction_time', now());
                $invoice->keterangan = 'Silahkan lakukan pembayaran max 1x24 jam';
            }

            $invoice->save();
        }catch (\Exception $e) {
            return response()->json(['message' => 'Error processing webhook: ' . $e->getMessage()], 500);
        }   
        return response()->json(['message' => 'Webhook processed successfully'], 200);

    }

    
}
