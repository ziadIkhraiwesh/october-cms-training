<?php namespace Ziad\Services;

use Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'NexaTech Services',
            'description' => 'Manage related service categories, services, and images.',
            'author' => 'Ziad Ikhraiwesh',
            'icon' => 'icon-briefcase',
        ];
    }

    public function registerComponents()
    {
        return [
            \Ziad\Services\Components\ServiceList::class => 'serviceList',
            \Ziad\Services\Components\ServiceDetails::class => 'serviceDetails',
        ];
    }

    public function registerPermissions()
    {
        return [
            'ziad.services.manage_services' => [
                'tab' => 'Services',
                'label' => 'Manage services',
            ],
            'ziad.services.manage_categories' => [
                'tab' => 'Services',
                'label' => 'Manage service categories',
            ],
        ];
    }

    public function registerNavigation()
    {
        return [
            'services' => [
                'label' => 'Services',
                'url' => Backend::url('ziad/services/services'),
                'icon' => 'icon-briefcase',
                'permissions' => [
                    'ziad.services.manage_services',
                    'ziad.services.manage_categories',
                ],
                'order' => 500,
                'sideMenu' => [
                    'services' => [
                        'label' => 'Services',
                        'url' => Backend::url('ziad/services/services'),
                        'icon' => 'icon-list',
                        'permissions' => ['ziad.services.manage_services'],
                    ],
                    'categories' => [
                        'label' => 'Categories',
                        'url' => Backend::url('ziad/services/servicecategories'),
                        'icon' => 'icon-folder-open',
                        'permissions' => ['ziad.services.manage_categories'],
                    ],
                ],
            ],
        ];
    }
}