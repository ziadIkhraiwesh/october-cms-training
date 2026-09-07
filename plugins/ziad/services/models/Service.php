<?php namespace Ziad\Services\Models;

use Model;

class Service extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'ziad_services_services';

    protected $fillable = [
        'title',
        'short_description',
        'content',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public $rules = [
        'title' => 'required|string|max:255',
        'short_description' => 'required|string|max:500',
        'content' => 'nullable|string',
        'is_active' => 'required|boolean',
        'sort_order' => 'required|integer|min:0',
    ];

    public $customMessages = [
        'title.required' => 'Please enter a service title.',
        'short_description.required' => 'Please enter a short description.',
        'sort_order.required' => 'Please enter the display order.',
        'sort_order.min' => 'Display order cannot be negative.',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query, string $direction = 'asc')
    {
        return $query->orderBy('sort_order', $direction);
    }
}