<?php
namespace Ziad\Services;

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
            \Ziad\Services\Components\ContactForm::class => 'contactForm',
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
            'ziad.services.manage_contact_messages' => [
                'tab' => 'Services',
                'label' => 'Manage contact messages',
            ],
            'ziad.services.manage_settings' => [
                'tab' => 'Services',
                'label' => 'Manage contact settings',
            ],
        ];
    }
    public function registerSettings()
    {
        return [
            'contact_settings' => [
                'label' => 'Contact Settings',
                'description' => 'Manage public website contact information.',
                'category' => 'NexaTech',
                'icon' => 'icon-address-book',
                'class' => \Ziad\Services\Models\Settings::class,
                'order' => 500,
                'keywords' => 'contact email phone address',
                'permissions' => ['ziad.services.manage_settings'],
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
                    'ziad.services.manage_contact_messages',
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
                    'contactmessages' => [
                        'label' => 'Contact Messages',
                        'url' => Backend::url('ziad/services/contactmessages'),
                        'icon' => 'icon-envelope',
                        'permissions' => ['ziad.services.manage_contact_messages'],
                    ],
                ],
            ],
        ];
    }
}