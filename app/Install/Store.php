<?php

namespace App\Install;

use App\Repository\SettingsRepository;

class Store
{
    public function __construct(SettingsRepository $settingsRepo)
    {
        $this->settings = $settingsRepo;
    }

    public function setup($data)
    {
        $this->settings->setMany([
            'company' => [
                'name' => $data['store_name'],
                'email' => $data['store_email'],
                'tagline' => 'Tagline',
                'address' => 'Address',
            ],
            'contact' => [
                'phone' => '01xxxxxxxxx',
            ],
            'logo' => [
                'white' => asset('images/defaults/white-logo.png'),
                'color' => asset('images/defaults/color-logo.png'),
                'footer' => asset('images/defaults/footer-logo.png'),
                'favicon' => asset('images/defaults/favicon.png'),
            ],
            'footer_menu' => [],
            'courier' => [
                'Sundarban',
                'SA Paribahan',
                'Korotua',
            ],
        ]);
    }
}
