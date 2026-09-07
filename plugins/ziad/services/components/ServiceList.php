<?php
namespace Ziad\Services\Components;

use Cms\Classes\ComponentBase;
use Ziad\Services\Models\Service;

class ServiceList extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Dynamic Service List',
            'description' => 'Displays active services from the database in display order.',
        ];
    }

    public function defineProperties()
    {
        return [
            'maxItems' => [
                'title' => 'Maximum Services',
                'description' => 'Maximum number of services to display.',
                'default' => 3,
                'type' => 'string',
                'validation' => [
                    'integer' => [
                        'message' => 'Maximum Services must be a number.',
                    ],
                    'min:1' => [
                        'message' => 'Maximum Services must be at least 1.',
                    ],
                ],
            ],
            'orderDirection' => [
                'title' => 'Order Direction',
                'description' => 'Choose how display order is sorted.',
                'default' => 'asc',
                'type' => 'dropdown',
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending',
                ],
            ],
            'showTitle' => [
                'title' => 'Show Section Title',
                'description' => 'Display the Services section heading.',
                'default' => true,
                'type' => 'checkbox',
            ],
        ];
    }

    public function onRun()
    {
        $this->page['services'] = $this->loadServices();
        $this->page['showServicesTitle'] = (bool) $this->property('showTitle');
    }

    protected function loadServices()
    {
        $limit = max(1, min(12, (int) $this->property('maxItems', 3)));

        $direction = strtolower(
            (string) $this->property('orderDirection', 'asc')
        );
        $limit = max(1, min(12, (int) $this->property('maxItems', 3)));
        $direction = strtolower((string) $this->property('orderDirection', 'asc'));

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        return Service::query()
            ->active()
            ->ordered($direction)
            ->limit($limit)
            ->get();
    }
}