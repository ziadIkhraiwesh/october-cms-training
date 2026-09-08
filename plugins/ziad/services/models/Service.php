<?php
namespace Ziad\Services\Models;

use Model;
use System\Models\File;

class Service extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'ziad_services_services';

    protected $fillable = [
        'category_id',
        'title',
        'short_description',
        'content',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'category_id' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public $rules = [
        'category_id' => 'required|integer|exists:ziad_services_service_categories,id',
        'title' => 'required|string|max:255',
        'short_description' => 'required|string|max:500',
        'content' => 'nullable|string',
        'is_active' => 'required|boolean',
        'sort_order' => 'required|integer|min:0',
    ];

    public $customMessages = [
        'category_id.required' => 'Please select a service category.',
        'category_id.exists' => 'The selected category is invalid.',
        'title.required' => 'Please enter a service title.',
        'short_description.required' => 'Please enter a short description.',
        'sort_order.required' => 'Please enter the display order.',
        'sort_order.min' => 'Display order cannot be negative.',
    ];

    public $belongsTo = [
        'category' => [
            ServiceCategory::class,
            'key' => 'category_id',
        ],
    ];

    public $attachOne = [
        'image' => [
            File::class,
            'delete' => true,
        ],
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query, string $direction = 'asc')
    {
        return $query
            ->orderBy('sort_order', $direction)
            ->orderBy('title', $direction);
    }

    public function getCategoryIdOptions(): array
    {
        return ServiceCategory::query()
            ->active()
            ->ordered()
            ->pluck('name', 'id')
            ->all();
    }
}