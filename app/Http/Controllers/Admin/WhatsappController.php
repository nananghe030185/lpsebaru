<?php
namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PerangkatDataTable;
use App\Http\Controllers\Controller;
use App\Models\Perangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsappController extends Controller
{

    public function index(PerangkatDataTable $dataTable)
    {
        return $dataTable->render('admin.whatsapp.index');
    }

    public function create()
    {
        return view('admin.whatsapp.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|unique:perangkats,number|starts_with:62|numeric|digits_between:10,14',
            'description' => 'nullable|string|max:500',
        ]);

        $perangkat = Perangkat::create([
            'name' => $request->name,
            'number' => $request->number,
            'description' => $request->description,
            'status' => 'disconnected',
        ]);

        // Initialize session on WhatsApp server
        Http::post('http://localhost:3000/session', [
            'sessionId' => $perangkat->name,
            'phoneNumber' => $perangkat->number,
        ]);

        return redirect()->route('admin.whatsapp.index')->with('success', 'Perangkat WhatsApp berhasil ditambahkan. Silakan login untuk menghubungkan.');
    }

    public function edit(Perangkat $whatsapp)
    {
        return view('admin.whatsapp.edit', ['whatsapp' => $whatsapp]);
    }

    public function update(Request $request, Perangkat $whatsapp)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:20|unique:perangkats,number,' . $whatsapp->id,
            'description' => 'nullable|string|max:500',
        ]);

        $whatsapp->update([
            'name' => $request->name,
            'number' => $request->number,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.whatsapp.index')->with('success', 'Perangkat WhatsApp berhasil diperbarui.');
    }
    public function destroy(Perangkat $whatsapp)
    {
        $whatsapp->delete();
        // remove session from whatsapp server
        Http::delete("http://localhost:3000/session/{$whatsapp->number}");

        return redirect()->route('admin.whatsapp.index')->with('success', 'Perangkat WhatsApp berhasil dihapus.');
    }

    public function sessions()
    {
        // Display sessions page
        return view('admin.whatsapp.sessions');
    }

    public function sessionsData()
    {
        // Fetch sessions from WhatsApp server
        $response = Http::get('http://localhost:3000/sessions');
        return response()->json($response->json());
    }

    public function login($sessionId)
    {
        return view('admin.whatsapp.login', compact('sessionId'));
    }

    public function logout($sessionId)
    {
        $response = Http::delete("http://localhost:3000/session/{$sessionId}/logout");
        if ($response->successful()) {
            return redirect()->route('admin.whatsapp.sessions')->with('success', 'Logout berhasil.');
        } else {
            return redirect()->route('admin.whatsapp.sessions')->with('error', 'Gagal logout.');
        }
    }

    public function qr($sessionId)
    {
        $response = Http::get("http://localhost:3000/session/{$sessionId}/qr");
        return response()->json($response->json());
    }

    public function sendForm($sessionId)
    {
        return view('admin.whatsapp.send', compact('sessionId'));
    }

    /**
     * Send WhatsApp message via form
     */
    public function send(Request $request)
    {
        $request->validate([
            'number' => 'required|starts_with:62|numeric|digits_between:10,14',
            'message' => 'required|string|max:1000',
        ]);

        try{
            $respon = Http::asForm()->post("http://localhost:3000/wa/send-message", [
                'token' => $request->token,
                'number' => $request->number,
                'message' => $request->message,
            ]);

            $respon = $respon->json();

            if ($respon['data']['status']?? false) {
                return redirect()->route('admin.whatsapp.send.form', $request->token)->with('success', 'Pesan berhasil dikirim.');
            } else {
                return redirect()->route('admin.whatsapp.send.form', $request->token)->with('error', 'Gagal mengirim pesan: ' . $respon['data']['result']['message']);
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.whatsapp.send.form', $request->token)->with('error', 'Gagal mengirim pesan error: ' . $e->getMessage());
        }
        

    }
}