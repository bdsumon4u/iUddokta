<?php

namespace App\Http\View\Composers\Admin;

use Illuminate\View\View;

class SidebarComposer
{
    protected $order_count;

    /**
     * @var array{array{icon: 'fa fa-tachometer', style: 'simple', name: 'Dashboard', route: 'home'}, array{icon: 'fa fa-th-list', style: 'simple', name: 'Orders', url: mixed}, array{icon: 'fa fa-image', style: 'simple', name: 'Media', route: 'admin.images.index'}, array{icon: 'fa fa-columns', style: 'simple', name: 'Categories', route: 'admin.categories.index'}, array{icon: 'fa fa-server', style: 'dropdown', name: 'Products', items: array{array{name: 'All', route: 'admin.products.index'}, array{name: 'Trash', route: 'admin.products.trashed'}, array{name: 'Create', route: 'admin.products.create'}}}, array{icon: 'fa fa-image', style: 'simple', name: 'Slider', route: 'admin.slides.index'}, array{icon: 'fa fa-file-text', style: 'dropdown', name: 'Pages', items: array{array{name: 'All', route: 'admin.pages.index'}, array{name: 'Create', route: 'admin.pages.create'}}}, array{icon: 'fa fa-bars', style: 'simple', name: 'Menus', url: 'admin/hmenus'}, array{icon: 'fa fa-users', style: 'simple', name: 'Resellers', route: 'admin.resellers.index'}, array{icon: 'fa fa-money', style: 'dropdown', name: 'Transactions', items: array{array{name: 'History', route: 'admin.transactions.index'}, array{name: 'Requests', route: 'admin.transactions.requests'}}}, array{icon: 'fa fa-gg', style: 'simple', name: 'Admins', route: 'admin.admins.index'}, array{icon: 'fa fa-question', style: 'dropdown', name: 'FAQs', items: array{array{name: 'All', route: 'admin.faqs.index'}, array{name: 'Add New', route: 'admin.faqs.create'}}}}
     */
    public $menu;

    public function __construct()
    {
        $this->menu = [
            [
                'icon' => 'fa fa-tachometer',
                'style' => 'simple',
                'name' => 'Dashboard',
                'route' => 'home',
            ],
            // [
            //     'style' => 'title',
            //     'name' => 'BASE',
            // ],
            [
                'icon' => 'fa fa-th-list',
                'style' => 'simple',
                'name' => 'Orders',
                'url' => route('admin.order.index', [
                    'status' => 'PENDING',
                ]),
            ],
            [
                'icon' => 'fa fa-image',
                'style' => 'simple',
                'name' => 'Media',
                'route' => 'admin.images.index',
            ],
            [
                'icon' => 'fa fa-columns',
                'style' => 'simple',
                'name' => 'Categories',
                'route' => 'admin.categories.index',
            ],
            [
                'icon' => 'fa fa-server',
                'style' => 'dropdown',
                'name' => 'Products',
                'items' => [
                    [
                        'name' => 'All',
                        'route' => 'admin.products.index',
                    ],
                    [
                        'name' => 'Trash',
                        'route' => 'admin.products.trashed',
                    ],
                    [
                        'name' => 'Create',
                        'route' => 'admin.products.create',
                    ],
                ],
            ],
            [
                'icon' => 'fa fa-image',
                'style' => 'simple',
                'name' => 'Slider',
                'route' => 'admin.slides.index',
            ],
            [
                'icon' => 'fa fa-file-text',
                'style' => 'dropdown',
                'name' => 'Pages',
                'items' => [
                    [
                        'name' => 'All',
                        'route' => 'admin.pages.index',
                    ],
                    [
                        'name' => 'Create',
                        'route' => 'admin.pages.create',
                    ],
                ],
            ],
            [
                'icon' => 'fa fa-bars',
                'style' => 'simple',
                'name' => 'Menus',
                'url' => 'admin/hmenus',
            ],
            [
                'icon' => 'fa fa-users',
                'style' => 'simple',
                'name' => 'Resellers',
                'route' => 'admin.resellers.index',
            ],
            [
                'icon' => 'fa fa-money',
                'style' => 'dropdown',
                'name' => 'Transactions',
                'items' => [
                    // [
                    //     'name' => 'Pay',
                    //     'route' => 'admin.transactions.pay',
                    // ],
                    [
                        'name' => 'History',
                        'route' => 'admin.transactions.index',
                    ],
                    [
                        'name' => 'Requests',
                        'route' => 'admin.transactions.requests',
                    ],
                ],
            ],
            [
                'icon' => 'fa fa-gg',
                'style' => 'simple',
                'name' => 'Admins',
                'route' => 'admin.admins.index',
            ],
            [
                'icon' => 'fa fa-question',
                'style' => 'dropdown',
                'name' => 'FAQs',
                'items' => [
                    [
                        'name' => 'All',
                        'route' => 'admin.faqs.index',
                    ],
                    [
                        'name' => 'Add New',
                        'route' => 'admin.faqs.create',
                    ],
                ],
            ],
        ];
    }

    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view): void
    {
        $view->with('menu', $this->menu);
        $view->with('provider', 'web');
    }
}
