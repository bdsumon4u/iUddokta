<?php

namespace App\Http\View\Composers\Reseller;

use Illuminate\View\View;

class SidebarComposer
{
    /**
     * Menu
     */
    public $menu = [
        [
            'icon' => 'fa fa-tachometer',
            'style' => 'simple',
            'name' => 'Dashboard',
            'route' => 'reseller.home',
        ],
        [
            'icon' => 'fa fa-th-list',
            'style' => 'simple',
            'name' => 'Orders',
            'route' => 'reseller.order.index',
        ],
        // [
        //     'style' => 'title',
        //     'name' => 'BASE',
        // ],
        [
            'icon' => 'fa fa-product-hunt',
            'style' => 'simple',
            'name' => 'Products',
            'route' => 'reseller.product.index',
        ],
        [
            'icon' => 'fa fa-money',
            'style' => 'dropdown',
            'name' => 'Transactions',
            'items' => [
                [
                    'name' => 'History',
                    'route' => 'reseller.transactions.index',
                ],
                [
                    'name' => 'Settings',
                    'route' => 'reseller.setting.payment',
                ],
                [
                    'name' => 'Money Request',
                    'route' => 'reseller.transactions.request',
                ],
            ],
        ],
        // [
        //     'icon' => 'fa fa-money',
        //     'style' => 'simple',
        //     'name' => 'Transactions',
        //     'route' => 'reseller.transactions.index',
        // ],
        [
            'icon' => 'fa fa-cogs',
            'style' => 'dropdown',
            'name' => 'Settings',
            'items' => [
                [
                    'name' => 'Edit Profile',
                    'url' => 'reseller/setting/profile',
                ],
                [
                    'name' => 'Manage Shops',
                    'route' => 'reseller.shops.index',
                ],
                [
                    'name' => 'Payment Method',
                    'url' => 'reseller/setting/payment',
                ],
                [
                    'name' => 'Change Password',
                    'url' => 'reseller/setting/password',
                ],
            ],
        ],
        [
            'icon' => 'fa fa-book',
            'style' => 'simple',
            'name' => 'Tutorials',
            'url' => '/tutorials',
        ],
    ];

    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view): void
    {
        $view->with('menu', $this->menu);
        $view->with('provider', 'resellers');
    }
}
