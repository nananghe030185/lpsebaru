<?php

namespace App\Http\Controllers;

use App\AppLpse;
use App\Models\LaporanKeuangan;
use App\Models\Outbox;
use App\Models\OutboxModel;
use App\Models\Tiket;
use App\Models\User;
use App\Models\UserGroup;
use App\Models\UserProfile;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createCharge(Request $request)
    {
        $params = [
            'transaction_details' => [
                'order_id' => rand(),
                'gross_amount' => 20000,
            ],
            // 'customer_details' => [
            //     'first_name' => $request->first_name,
            //     'last_name' => $request->last_name,
            //     'email' => $request->email,
            //     'phone' => $request->phone,
            // ],
        ];

        $snapToken = Snap::getSnapToken($params);
        return response()->json($snapToken);
    }

    public function notificationHandler(Request $request)
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
            return response()->json([
                'message' => 'Invalid signature key'
            ], 403);
        }

        // Cek status transaksi
        $transaction = Tiket::where('order_id',$request->order_id)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Kirim Pesan ke User
        $profile = UserProfile::where('user_id', $transaction->user_id)->first();
        $message = [];
       if ($request->transaction_status == 'settlement') 
       {
            $transaction->status = 'settlement'; 
            $transaction->description = $this->pesanDiterima($transaction, $request);
            // Tambah masa aktif member
            $this->tambahMasaBerlaku($transaction);

            // Masukan ke laporan keuangan
            LaporanKeuangan::create([
                'user_id' => $transaction->user_id,
                'tanggal' => now(),
                'keterangan' => static::pesanDiterima($transaction, $request),
                'pemasukan' => $transaction->nominal
            ]);

            // diupdate group id
            $transaction->user->update([
                'group_id' => UserGroup::where('name', Str::explode(' ', $transaction->item)[0])->first()->id
            ]);
            // Kirim pesan ke user
            // via email
            OutboxModel::create([
                'channel' => 'email',
                'pesan' => $this->pesanDiterima($transaction, $request),
                'status' => 'pending',
                'user_id' => $transaction->user_id,
                'tujuan' => $transaction->user->email
            ]);

            if($profile->telegram != ''){
                OutboxModel::create([
                    'channel' => 'telegram',
                    'pesan' => $this->pesanDiterima($transaction, $request),
                    'status' => 'pending',
                    'user_id' => $transaction->user_id,
                    'tujuan' => $profile->telegram
                ]);
            }

            // Kirim Pesan ke Whatsapp
            if($profile->whatsapp != ''){
                OutboxModel::create([
                    'channel' => 'whatsapp',
                    'pesan' => $this->pesanDiterima($transaction, $request),
                    'status' => 'pending',
                    'user_id' => $transaction->user_id,
                    'tujuan' => $profile->whatsapp
                ]);
            }

            $message['message'] = 'settlement';
        } elseif($request->transaction_status == 'capture') {
            $transaction->status = 'capture'; // Status pembayaran berhasil
            $transaction->description = $this->pesanDiterima($transaction, $request);
             // Tambah masa aktif member
             $this->tambahMasaBerlaku($transaction);

             // Masukan ke laporan keuangan
            LaporanKeuangan::create([
                'user_id' => $transaction->user_id,
                'tanggal' => now(),
                'keterangan' => static::pesanDiterima($transaction, $request),
                'pemasukan' => $transaction->nominal
            ]);

            // Kirim pesan ke user
            // via email
            OutboxModel::create([
                'channel' => 'email',
                'pesan' => $this->pesanDiterima($transaction, $request),
                'status' => 'pending',
                'user_id' => $transaction->user_id,
                'tujuan' => $transaction->user->email
            ]);

            if($profile->telegram != ''){
                OutboxModel::create([
                    'channel' => 'telegram',
                    'pesan' => $this->pesanDiterima($transaction, $request),
                    'status' => 'pending',
                    'user_id' => $transaction->user_id,
                    'tujuan' => $profile->telegram
                ]);
            }

            // Kirim Pesan ke Whatsapp
            if($profile->whatsapp != ''){
                OutboxModel::create([
                    'channel' => 'whatsapp',
                    'pesan' => $this->pesanDiterima($transaction, $request),
                    'status' => 'pending',
                    'user_id' => $transaction->user_id,
                    'tujuan' => $profile->whatsapp
                ]);
            }

            $message['message'] = 'capture';
        } elseif ($request->transaction_status == 'cancel') {
            $transaction->status = 'cancel'; // Status pembayaran gagal atau kadaluarsa
            $store = $request->store ?? ''; 
            $transaction->description = 'Tiket Pembayaran ' . $request->payment_type .' ' . $store . ' telah di batalkan';

            $message['message'] = 'cancel';
        } elseif ($request->transaction_status == 'expire') {
            $transaction->status = 'expire'; // Status pembayaran gagal atau kadaluarsa
            $store = $request->store ?? ''; 
            $transaction->description = 'Pembayaran melalui ' . $request->payment_type . ' ' . $store . ' telah kadaluarsa, silahkan buat tiket baru';

            $message['message'] = 'expire';
        } elseif ($request->transaction_status == 'deny') {
            $transaction->status = 'deny'; // Status pembayaran gagal atau kadaluarsa
            $transaction->description = 'Tiket Pembayaran anda telah di abaikan';

            $message['message'] = 'deny';
        } elseif ($request->transaction_status == 'refund') {
            $transaction->status = 'refund'; // Status pembayaran gagal atau kadaluarsa
            $transaction->description = 'Tiket Pembayaran anda telah di kembalikan';
            $message['message'] = 'refund';
        } elseif ($request->transaction_status == 'pending') {
            $transaction->status = 'pending'; // Status menunggu pembayaran
            $rekening = '';
            
            if(isset($request->va_numbers)){
                $rekening = ' ke nomor Virtual Account ' . Str::upper($request->va_numbers[0]['bank']) . '  ' . $request->va_numbers[0]['va_number'];
            }elseif(isset($request->permata_va_number)){
                $rekening = 'ke Virtual Account Permata ' . $request->permata_va_number ?? '';
            }elseif(isset($request->biller_code)){
                $rekening = ' ke Virtual Account Mandiri Kode '. $request->biller_code . ' Nomor VA ' . $request->bill_key ?? '';
            }elseif(isset($request->store)){
                $rekening = ' di ' . $request->store . ' dan ikuti petunjuk yang diberikan';
            }elseif($request->payment_type == 'bca_klikpay'){
                $rekening = ' di ' . $request->payment_type . ' dan ikuti petunjuk yang diberikan';
            }
            $pesan = 'Silahkan selesaikan pembayaran anda sejumlah Rp. ' . number_format($request->gross_amount, 0, ',', '.') . ' sebelum ' . Carbon::parse($request->expiry_time)->format('d M Y H:i:s') . $rekening;

            $transaction->description = $pesan;

            // Kirim Pesan Email
            OutboxModel::create([
                'channel' => 'email',
                'pesan' => $pesan,
                'status' => 'pending',
                'user_id' => $transaction->user_id,
                'tujuan' => $transaction->user->email
            ]);

            // Kirik pesan telegram
            if($profile->telegram != ''){
                OutboxModel::create([
                    'channel' => 'telegram',
                    'pesan' => $pesan,
                    'status' => 'pending',
                    'user_id' => $transaction->user_id,
                    'tujuan' => $profile->telegram
                ]);
            }

            // Kirim Pesan whatsapp
            if($profile->whatsapp != '')
            {
                OutboxModel::create([
                    'channel' => 'whatsapp',
                    'pesan' => $pesan,
                    'status' => 'pending',
                    'user_id' => $transaction->user_id,
                    'tujuan' => $profile->whatsapp
                ]);
            }

            $message['message'] = 'pending';
        }
        
        $transaction->save();

        // Kirim Notifikasi
        $this->kirimNotifikasi($transaction, $request);
        
        return response()->json($message);
    }

    public static function tambahMasaBerlaku($record)
    {
        $date = new Carbon();
        $user_id = $record->user_id ?? 0;
        $durasi = $record->days ?? 0;

        $profile = UserProfile::where('user_id', $user_id)->first();
        $masa_berlaku = $profile->masa_berlaku;

        if ($profile->isAktif) {
            // Jika masa berlaku masih ada maka tambahkan sisanya
            $hari = $durasi + ceil($date->diffInDays($masa_berlaku, true));
            $profile->update(['masa_berlaku' => $date->add($hari . ' days')->format('Y-m-d 00:00:00')]);
        } else {
            // Jika Masa berlaku sudah lewat
            $profile->update(['masa_berlaku' => $date->add($durasi . ' days')->format('Y-m-d 00:00:00')]);
        }
    }

    public static function pesanDiterima($record, $request)
    {
        
        $pesan_notifikasi_perpanjangan = AppLpse::setting('message_notifikasi_perpanjangan');

        return Str::replace(
            [
                '{name}',
                '{id}',
                '{days}',
                '{tanggal}',
                '{payment_type}',
                '{item}',
                '{nominal}'
            ],[
                User::find($record->user_id)->name ?? '',
                $record->user_id ?? 0,
                $record->days ?? 0,
                Carbon::now()->format('d M Y H:i:s'),
                $request->payment_type ?? '',
                $record->item,
                number_format($record->nominal,0,'.','.')
            ],
            $pesan_notifikasi_perpanjangan
        );
    }

    public static function kirimNotifikasi($record, $request)
    {
        $user_id = $record->user_id ?? 0;

        $profile = UserProfile::where('user_id', $user_id)->first();

        if($record->status == 'settlement' || $record->status == 'capture') {
            // Kirim Notifikasi ke user
            $user = User::find($user_id);
            $user->notify(
                Notification::make()
                    ->title('Konfirmasi Pembayaran')
                    ->body(static::pesanDiterima($user_id, $request))
                    ->success()
                    ->toDatabase()
            );
            // Kirim Pesan ke User
            if ($profile->notif_email_lpse) {
                OutboxModel::create([
                    'user_id' => $user_id,
                    'tender_id' => 0,
                    'pesan' => static::pesanDiterima($user_id, $request),
                    'channel' => 'email',
                    'status' => 'pending',
                    'tujuan' => $user->email
                ]);
            }

            //Kirim pesan via telegram
            if ($profile->notif_telegram_lpse && $profile->telegram != '') {
                OutboxModel::create([
                    'user_id' => $user_id,
                    'tender_id' => 0,
                    'pesan' => static::pesanDiterima($user_id, $request),
                    'channel' => 'telegram',
                    'status' => 'pending',
                    'tujuan' => $profile->telegram
                ]);
            }

            // Kirim Pesan via whatsapp
            if ($profile->notif_whatsapp_lpse && $profile->whatsapp != '') {
                OutboxModel::create([
                    'user_id' => $user_id,
                    'tender_id' => 0,
                    'pesan' => static::pesanDiterima($user_id, $request),
                    'channel' => 'whatsapp',
                    'status' => 'pending',
                    'tujuan' => $profile->whatsapp
                ]);
            }
        }elseif($record->status == 'pending'){
            // Kirim Notifikasi ke user
            $rekening = ' ke nomor rekening ';
            if(isset($request->va_numbers)){
                $rekening .= $request->va_numbers[0]->bank . '  ' . $request->va_numbers[0]->va_number;
            }elseif(isset($request->permata_va_number)){
                $rekening .= 'Permata Virtual Account ' . $request->permata_va_number;
            }
            $user = User::find($user_id);
            $user->notify(
                Notification::make()
                    ->title('Menunggu Pembayaran')
                    ->body('Silahkan selesaikan pembayaran anda sejumlah Rp. ' . number_format($request->gross_amount, 0, ',', '.') . ' sebelum ' . Carbon::parse($request->expiry_time)->format('d M Y H:i:s') . $rekening)
                    ->success()
                    ->toDatabase()
            );
            // Kirim Pesan Email ke User
            OutboxModel::create([
                'user_id' => $user_id,
                'tender_id' => 0,
                'pesan' => 'Silahkan selesaikan pembayaran anda sejumlah Rp. ' . number_format($request->gross_amount, 0, ',', '.') . ' sebelum ' . Carbon::parse($request->expiry_time)->format('d M Y H:i:s') . $rekening,
                'channel' => 'email',
                'status' => 'pending',
                'tujuan' => $user->email
            ]);

            //Kirim pesan via telegram
            if ($profile->telegram != '') {
                OutboxModel::create([
                    'user_id' => $user_id,
                    'tender_id' => 0,
                    'pesan' => 'Silahkan selesaikan pembayaran anda sejumlah Rp. ' . number_format($request->gross_amount, 0, ',', '.') . ' sebelum ' . Carbon::parse($request->expiry_time)->format('d M Y H:i:s') . $rekening,
                    'channel' => 'telegram',
                    'status' => 'pending',
                    'tujuan' => $profile->telegram
                ]);
            }

            // Kirim Pesan via whatsapp
            if ($profile->whatsapp != '') {
                OutboxModel::create([
                    'user_id' => $user_id,
                    'tender_id' => 0,
                    'pesan' => 'Silahkan selesaikan pembayaran anda sejumlah Rp. ' . number_format($request->gross_amount, 0, ',', '.') . ' sebelum ' . Carbon::parse($request->expiry_time)->format('d M Y H:i:s') . $rekening,
                    'channel' => 'whatsapp',
                    'status' => 'pending',
                    'tujuan' => $profile->whatsapp
                ]);
            }
        }elseif($record->status == 'cancel' || $record->status == 'deny'){
            $user = User::find($user_id);
            $user->notify(
                Notification::make()
                    ->title('Pembayaran dibatalkan')
                    ->body('Pembayaran anda sejumlah Rp ' . number_format($request->gross_amount, 0, ',', '.'). 'telah dibatalkan')
                    ->success()
                    ->toDatabase()
            );
            // Kirim Pesan Email ke User
            OutboxModel::create([
                'user_id' => $user_id,
                'tender_id' => 0,
                'pesan' => 'Pembayaran anda sejumlah Rp ' . number_format($request->gross_amount, 0, ',', '.'). 'telah dibatalkan',
                'channel' => 'email',
                'status' => 'pending',
                'tujuan' => $user->email
            ]);

            //Kirim pesan via telegram
            if ($profile->telegram != '') {
                OutboxModel::create([
                    'user_id' => $user_id,
                    'tender_id' => 0,
                    'pesan' => 'Pembayaran anda sejumlah Rp ' . number_format($request->gross_amount, 0, ',', '.'). 'telah dibatalkan',
                    'channel' => 'telegram',
                    'status' => 'pending',
                    'tujuan' => $profile->telegram
                ]);
            }

            // Kirim Pesan via whatsapp
            if ($profile->whatsapp != '') {
                OutboxModel::create([
                    'user_id' => $user_id,
                    'tender_id' => 0,
                    'pesan' => 'Pembayaran anda sejumlah Rp ' . number_format($request->gross_amount, 0, ',', '.'). 'telah dibatalkan',
                    'channel' => 'whatsapp',
                    'status' => 'pending',
                    'tujuan' => $profile->whatsapp
                ]);
            }
        }elseif($record->status == 'expire'){
            $user = User::find($user_id);
            $user->notify(
                Notification::make()
                    ->title('Pembayaran Kadaluarsa')
                    ->body('Pembayaran anda sejumlah Rp ' . number_format($request->gross_amount, 0, ',', '.'). 'telah Kadaluarsa')
                    ->success()
                    ->toDatabase()
            );
            // Kirim Pesan Email ke User
            OutboxModel::create([
                'user_id' => $user_id,
                'tender_id' => 0,
                'pesan' => 'Pembayaran anda sejumlah Rp ' . number_format($request->gross_amount, 0, ',', '.'). 'telah Kadaluarsa',
                'channel' => 'email',
                'status' => 'pending',
                'tujuan' => $user->email
            ]);

            //Kirim pesan via telegram
            if ($profile->telegram != '') {
                OutboxModel::create([
                    'user_id' => $user_id,
                    'tender_id' => 0,
                    'pesan' => 'Pembayaran anda sejumlah Rp ' . number_format($request->gross_amount, 0, ',', '.'). 'telah Kadaluarsa',
                    'channel' => 'telegram',
                    'status' => 'pending',
                    'tujuan' => $profile->telegram
                ]);
            }

            // Kirim Pesan via whatsapp
            if ($profile->whatsapp != '') {
                OutboxModel::create([
                    'user_id' => $user_id,
                    'tender_id' => 0,
                    'pesan' => 'Pembayaran anda sejumlah Rp ' . number_format($request->gross_amount, 0, ',', '.'). 'telah Kadaluarsa',
                    'channel' => 'whatsapp',
                    'status' => 'pending',
                    'tujuan' => $profile->whatsapp
                ]);
            }
        }
        
    }

    public function status(Request $request){
        Tiket::where('order_id', $request->order_id)->update([
            'pdf_url' => $request->pdf_url,
            'description' => 'Silahkan selesaikan pembayaran anda, panduan pembayaran unduh pdf disamping'
        ]);

        return response()->json(['message' => 'success']);
    }
}
