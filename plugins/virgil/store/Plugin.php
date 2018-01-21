<?php namespace Virgil\Store;

use Backend\Facades\Backend;
use System\Classes\PluginBase;

/**
 * Store Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Store',
            'description' => 'No description provided yet...',
            'author'      => 'Virgil',
            'icon'        => 'icon-leaf'
        ];
    }


    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConsoleCommand('store:seedimagestoproducts', 'Virgil\Store\Console\SeedImagesToProducts');

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Virgil\Store\Components\CategoriesMenu' => 'CategoriesMenu',
            'Virgil\Store\Components\Products' => 'Products',
            'Virgil\Store\Components\Cart' => 'Cart',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'virgil.store.some_permission' => [
                'tab' => 'Store',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {

        return [
            'orders' => [
                'label'       => 'Magazin',
                'url'         => Backend::url('virgil/store/orders'),
                'icon'        => 'icon-list',
                'order'       => 10,
                'sideMenu'    => [
                    'orders' => [
                        'label' => 'Comenzi',
                        'icon'          => 'icon-users',
                        'url'           => Backend::url('virgil/store/orders'),
                    ],
                    'products' => [
                        'label' => 'Produse',
                        'icon'          => 'icon-globe',
                        'url'           => Backend::url('virgil/store/products'),
                    ],
                    'categories' => [
                        'label' => 'Categorii',
                        'icon'          => 'icon-globe',
                        'url'           => Backend::url('virgil/store/categories'),
                    ],
                    'users' => [
                        'label' => 'Utilizatori',
                        'icon' => 'icon-globe',
                        'url' => Backend::url('virgil/store/users'),
                    ]
                ]
            ],
        ];
    }
}
