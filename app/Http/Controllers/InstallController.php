<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class InstallController extends Controller
{
    public function app(string $pwd){
        if($pwd !== 'R4ha$iaku1985'){
            return route('install.app');
        }

        Artisan::call('migrate:fresh');
        Artisan::call('optimize:clear');

        // Insert admin user
        // nomer 1
        Groups::create([
            'name' => 'Super Admin',
            'description' => 'Kelompok Super Admin yang punya akses penuh',
        ]);
        // nomer 2
        Groups::create([
            'name' => 'Non Member',
            'description' => 'Kelompok User yang belum membayar membership',
        ]);
        //nomer 3
        Groups::create([
            'name' => 'Trial',
            'description' => 'Kelompok user yang baru masuk dan belum membayar membership dan dalam masa percobaan',
        ]);
        // nomer 4
        Groups::create([
            'name' => 'Personal',
            'description' => 'Kelompok User yang membayar tipe perorangan 350rb',
        ]);
        //nomer 5
        Groups::create([
            'name' => 'Premium',
            'description' => 'Kelompok User yang membayar tipe Premium 1200rb',
        ]);
        // nomer 6
        Groups::create([
            'name' => 'Corporate',
            'description' => 'Kelompok User yang membayar tipe Corporate 2000rb',
        ]);
        //nomer 7
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
        Alert::toast('Installasi selesai')->success()->flash();
        return redirect()->route('login');
    }

    public function dbseed(string $pwd){
        if($pwd !== 'R4ha$iaku1985'){
            return route('install.app');
        }

        Artisan::call('db:seed');
        Artisan::call('optimize:clear');

        Alert::toast('Installasi selesai')->success()->flash();
        return redirect()->route('login');
    }
}
