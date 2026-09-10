<?php namespace Ziad\Services\Components;

use Cms\Classes\ComponentBase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Ziad\Services\Models\DynamicPage;

class DynamicPageRenderer extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Dynamic Page Renderer',
            'description' => 'Loads a published dynamic page and renders its reusable sections.',
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title' => 'Page Slug',
                'description' => 'Slug value received from the public URL.',
                'type' => 'string',
                'default' => '{{ :slug }}',
            ],
        ];
    }

    public function onRun()
    {
        $slug = trim((string) $this->property('slug'));

        $dynamicPage = DynamicPage::published()
            ->where('slug', $slug)
            ->first();

        if (!$dynamicPage) {
            throw new NotFoundHttpException('Dynamic page not found.');
        }

        $this->page['dynamicPage'] = $dynamicPage;
        $this->page['pageSections'] = $dynamicPage->active_sections;

        $this->page->title = $dynamicPage->seo_title ?: $dynamicPage->title;
        $this->page->meta_title = $dynamicPage->seo_title ?: $dynamicPage->title;
        $this->page->meta_description = $dynamicPage->seo_description
            ?: 'Learn more about ' . $dynamicPage->title . '.';
    }
}