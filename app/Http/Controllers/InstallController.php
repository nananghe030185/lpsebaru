<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class InstallController extends Controller
{
    public function app(string $pwd){
        if($pwd !== 'R4ha$iaku1985'){
            return route('install.app');
        }

        Artisan::call('migrate:fresh');
        Artisan::call('optimize:clear');

        // Insert admin user
        Groups::create([
            'name' => 'Super Admin',
            'description' => 'Kelompok Super Admin yang punya akses penuh',
        ]);
        Groups::create([
            'name' => 'Member',
            'description' => 'Kelompok User yang sudah membayar untuk berlangganan membership',
        ]);
        Groups::create([
            'name' => 'Non Member',
            'description' => 'Kelompok User yang belum membayar untuk berlangganan membership',
        ]);
        Groups::create([
            'name' => 'GMT',
            'description' => 'Kelompok User yang berada di GMT',
        ]);

        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'status' => true,
            'group_id' => 1, // Assuming group_id 1 exists
            'system_reserve' => 1
        ]);
        return redirect()->route('login')->with('success','Installasi selesai');
    }

    public function dbseed(string $pwd){
        if($pwd !== 'R4ha$iaku1985'){
            return route('install.app');
        }

        Artisan::call('db:seed');
        Artisan::call('optimize:clear');

        return redirect()->route('login')->with('success','Installasi selesai');
    }
}
