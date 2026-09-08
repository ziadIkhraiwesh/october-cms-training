<?php namespace Ziad\Services\Components;

use Cms\Classes\ComponentBase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Ziad\Services\Models\Service;

class ServiceDetails extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Dynamic Service Details',
            'description' => 'Displays one published service using its URL identifier.',
        ];
    }

    public function defineProperties()
    {
        return [
            'serviceId' => [
                'title' => 'Service ID',
                'description' => 'Service identifier from the page URL.',
                'default' => '{{ :id }}',
                'type' => 'string',
            ],
        ];
    }

    public function onRun()
    {
        $serviceId = (int) $this->property('serviceId');

        $service = Service::query()
            ->with(['category', 'image'])
            ->active()
            ->whereHas('category', function ($query) {
                $query->where('is_active', true);
            })
            ->find($serviceId);

        if (!$service) {
            throw new NotFoundHttpException('Service not found.');
        }

        $this->page['service'] = $service;
        $this->page->title = $service->title;
    }
}