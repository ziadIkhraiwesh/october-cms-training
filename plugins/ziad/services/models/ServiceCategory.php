<?php namespace Ziad\Services\Models;

use Model;

class ServiceCategory extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sluggable;

    public $table = 'ziad_services_service_categories';

    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected $slugs = [
        'slug' => 'name',
    ];

    public $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:ziad_services_service_categories',
        'is_active' => 'required|boolean',
        'sort_order' => 'required|integer|min:0',
    ];

    public $customMessages = [
        'name.required' => 'Please enter a category name.',
        'slug.required' => 'Please enter a category slug.',
        'slug.unique' => 'This category slug is already in use.',
        'sort_order.required' => 'Please enter the display order.',
    ];

    public $hasMany = [
        'services' => [
            Service::class,
            'key' => 'category_id',
        ],
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}