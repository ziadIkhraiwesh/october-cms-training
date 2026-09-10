<?php namespace Ziad\Services\Models;

use Illuminate\Validation\Rule;
use Model;

class DynamicPage extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'ziad_services_dynamic_pages';

    protected $fillable = [
        'title',
        'slug',
        'status',
        'seo_title',
        'seo_description',
        'show_in_navigation',
        'navigation_order',
        'sections',
    ];

    protected $jsonable = [
        'sections',
    ];

    public $rules = [
        'title' => 'required|string|min:2|max:150',
        'status' => 'required|in:draft,published',
        'seo_title' => 'nullable|string|max:160',
        'seo_description' => 'nullable|string|max:255',
        'show_in_navigation' => 'boolean',
        'navigation_order' => 'required|integer|min:0',
        'sections' => 'required|array|min:1',
        'sections.*._group' => 'required|in:hero,text_content,image_text,cta',
    ];

    public function beforeValidate()
    {
        $this->rules['slug'] = [
            'required',
            'alpha_dash',
            'max:150',
            Rule::unique($this->table, 'slug')->ignore($this->id),
        ];
    }

    public function getStatusOptions()
    {
        return [
            'draft' => 'Draft',
            'published' => 'Published',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeVisibleInNavigation($query)
    {
        return $query
            ->published()
            ->where('show_in_navigation', true)
            ->orderBy('navigation_order')
            ->orderBy('title');
    }

    public function getActiveSectionsAttribute()
    {
        return collect($this->sections ?: [])
            ->filter(fn ($section) => (bool) ($section['is_active'] ?? true))
            ->values()
            ->all();
    }
}