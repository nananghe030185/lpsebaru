<?php

namespace App;

use Illuminate\Support\Facades\Http;

class Whatsapp
{
    protected $url;
    protected $apikey;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
        $this->url = 'http://localhost:3000';
        $this->apikey = 'KQKsYsg6SDEL0p7';
    }

    public function sendText($sender, $to, $message)
    {
        $json = Http::post($this->url . '/send-message', [
            'api_key' => $this->apikey,
            'sender' => $sender,
            'number' => $to,
            'message' => $message
        ]);

        return $json;
    }

    public function qrcode($number)
    {
        $json = Http::post($this->url . '/generate-qr', [
            'device' => $number,
            'api_key' => $this->apikey
        ]);

        return $json;
    }

    public function disconnect($number){
        $json = Http::post($this->url . '/logout-device', [
            'sender' => $number,
            'api_key' => $this->apikey
        ]);

        return $json;
    }


}
