<?php namespace Ziad\Services\Components;

use Cms\Classes\ComponentBase;
use Ziad\Services\Models\Service;

class ServiceList extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Dynamic Service List',
            'description' => 'Displays active services with categories and images.',
        ];
    }

    public function defineProperties()
    {
        return [
            'maxItems' => [
                'title' => 'Maximum Services',
                'description' => 'Maximum number of services to display.',
                'default' => 6,
                'type' => 'string',
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
            'categorySlug' => [
                'title' => 'Category Slug',
                'description' => 'Leave empty to show all categories.',
                'default' => '',
                'type' => 'string',
            ],
        ];
    }

    public function onRun()
    {
        $this->page['services'] = $this->loadServices();
        $this->page['showServicesTitle'] = (bool) $this->property('showTitle');
        $this->page['activeCategorySlug'] = trim(
            (string) $this->property('categorySlug')
        );
    }

    protected function loadServices()
    {
        $limit = max(1, min(12, (int) $this->property('maxItems', 6)));

        $direction = strtolower(
            (string) $this->property('orderDirection', 'asc')
        );

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }

        $categorySlug = trim(
            (string) $this->property('categorySlug')
        );

        return Service::query()
            ->with(['category', 'image'])
            ->active()
            ->whereHas('category', function ($query) {
                $query->where('is_active', true);
            })
            ->when($categorySlug, function ($query, $categorySlug) {
                $query->whereHas('category', function ($categoryQuery) use ($categorySlug) {
                    $categoryQuery->where('slug', $categorySlug);
                });
            })
            ->ordered($direction)
            ->limit($limit)
            ->get();
    }
}