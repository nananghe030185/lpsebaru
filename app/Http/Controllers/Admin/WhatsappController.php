<?php
namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PerangkatDataTable;
use App\Http\Controllers\Controller;
use App\Models\Perangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

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

        Alert::toast('Perangkat Whatsapp berhasil ditambahkan, silahkan login untuk menghubungkan')->success()->flash();
        return redirect()->route('admin.whatsapp.index');
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

        Alert::toast('Perangkat Whatsapp berhasil diupdate')->success()->flash();
        return redirect()->route('admin.whatsapp.index');
    }
    public function destroy(Perangkat $whatsapp)
    {
        $whatsapp->delete();
        // remove session from whatsapp server
        Http::delete("http://localhost:3000/session/{$whatsapp->number}");

        Alert::toast('Perangkat Whatsapp berhasil dihapus')->success()->flash();
        return redirect()->route('admin.whatsapp.index');
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
            Alert::toast('Logout berhasil')->success()->flash();
            return redirect()->route('admin.whatsapp.sessions');
        } else {
            Alert::toast('Logout Gagal')->error()->flash();
            return redirect()->route('admin.whatsapp.sessions');
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
                Alert::toast('Pesan berhasil dikirim')->success()->flash();
                return redirect()->route('admin.whatsapp.send.form', $request->token);
            } else {
                Alert::toast('Gagal mengirim pesan ' . $respon['data']['result']['message'])->error()->flash();
                return redirect()->route('admin.whatsapp.send.form', $request->token);
            }
        } catch (\Exception $e) {
            Alert::toast('Gagal mengirim pesan ' . $e->getMessage())->error()->flash();
            return redirect()->route('admin.whatsapp.send.form', $request->token);
        }
        

    }
}