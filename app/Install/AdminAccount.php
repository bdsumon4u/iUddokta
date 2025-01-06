<?php

namespace App\Install;

use App\Models\Reseller;
use App\Models\User as AppUser;

class AdminAccount
{
    public function setup($data): void
    {
        AppUser::create([
            'name' => $data['first_name'].' '.$data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        Reseller::create([
            'name' => 'Reseller',
            'email' => 'reseller@cyber32.com',
            'phone' => '01xxxxxxxxx',
            'password' => 'password',
        ]);
    }
}
