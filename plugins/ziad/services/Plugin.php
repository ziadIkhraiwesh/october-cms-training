<?php namespace Ziad\Services;

use Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'NexaTech Services',
            'description' => 'Manage and display dynamic services.',
            'author' => 'Ziad Ikhraiwesh',
            'icon' => 'icon-briefcase',
        ];
    }

    public function registerComponents()
    {
        return [
            \Ziad\Services\Components\ServiceList::class => 'serviceList',
        ];
    }

    public function registerPermissions()
    {
        return [
            'ziad.services.manage_services' => [
                'tab' => 'Services',
                'label' => 'Manage services',
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
                'permissions' => ['ziad.services.manage_services'],
                'order' => 500,
            ],
        ];
    }
}