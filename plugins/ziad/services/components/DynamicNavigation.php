<?php namespace Ziad\Services\Components;

use Cms\Classes\ComponentBase;
use Ziad\Services\Models\DynamicPage;

class DynamicNavigation extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Dynamic Navigation',
            'description' => 'Displays published dynamic pages selected for navigation.',
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $this->page['dynamicNavigationPages'] = DynamicPage::visibleInNavigation()
            ->get();
    }
}