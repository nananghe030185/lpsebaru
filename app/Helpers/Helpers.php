<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Country;
use App\Models\Attachment;
use App\Models\Fokus;
use App\Models\FokusLelang;
use App\Models\Lelang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class Helpers
{
    public static function isUserLogin()
    {
        // return auth()?->check();
        return Auth::check(); // Check if the user is authenticated
    }

    public static function getCurrentUserId()
    {
      if (self::isUserLogin()) {
        // return auth()?->user()?->id;
        return Auth::user()?->id ?? 0; // Return 0 if user is not authenticated
      }else {
        return 0;
      }
    }

    public static function getMedia($id)
    {
      return Attachment::find($id);
    }

    public static function getCountryCode(){
      return Country::get(["calling_code", "id", "iso_3166_2", 'flag'])->unique('calling_code');
    }

    public static function getUser()
    {
        $user = User::with('roles')->where('system_reserve' ,'!=', 1)->latest()->take(5)->get();
        return $user;
    }

    public static function link($link, $anchor, $target = true)
    {
      $trgt = $target === true ? ' target="_blank"' : '';
      
        return '<a href="' . $link . '" ' . $trgt .'>'. $anchor .'</a>';
    }

    public static function createErrorLog($message, $trace = null)
    {
        // Create a new error log entry
        \App\Models\ErrorLog::create([
            'message' => Str::limit($message, 250),
            'trace' => '',
        ]);
    }

    public static function isUserFokusLelang(Object $row)
    {
      $lelang = FokusLelang::where('user_id', Auth::user()->id)->where('lelang_id', $row->id)->count();
      if($lelang){
        return true;
      }

      return false;
    }

    public static function isUserFokusTender(Object $row)
    {
      	$fokustender = Fokus::where('user_id', Auth::user()->id)->where('tender_id', $row->id)->where('fokus', true)->count();
		if($fokustender){
			return true;
		}
      	return false;
    }
}