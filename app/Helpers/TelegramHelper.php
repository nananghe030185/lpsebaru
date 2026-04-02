<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class TelegramHelper
{
    const API_URL = 'https://api.telegram.org/bot';

    protected $botToken;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function sendMessage($chatId, $message)
    {
        $url = self::API_URL . static::getTokenTelegram() . '/sendMessage';
        $data = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML',
        ];
        try {
            $response = Http::asForm()->post($url, $data)->throw()->json();
        } catch (\Exception $e) {
            // Handle the exception if needed
            return ['error' => $e->getMessage()];
        }

        return $response['result'] ?? [];
    }

    /**
     * Get the Telegram bot token from the AppHelper.
     *
     * @return string
     */
    public static function getTokenTelegram()
    {
        return AppHelper::getTokenTelegram();
    }

    public static function getUpdates()
    {
        $url = self::API_URL . static::getTokenTelegram() . '/getUpdates';
        $response = Http::get($url)->throw()->json();   
        return $response['result'] ?? [];
    }

    public static function getMe()
    {
        $url = self::API_URL . static::getTokenTelegram() . '/getMe';
        $response = Http::get($url)->throw()->json();
        return $response['result'] ?? [];
    }
    
}
