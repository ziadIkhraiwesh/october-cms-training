<?php namespace Ziad\Services\Models;

use Model;

class Settings extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $implement = [
        \System\Behaviors\SettingsModel::class,
    ];

    public $settingsCode = 'ziad_services_settings';

    public $settingsFields = 'fields.yaml';

    public $rules = [
        'contact_email' => 'required|email|max:150',
        'phone' => 'required|string|max:50',
        'address' => 'required|string|max:255',
        'help_text' => 'nullable|string|max:500',
    ];

    public $customMessages = [
        'contact_email.required' => 'Please enter the contact email.',
        'contact_email.email' => 'Please enter a valid contact email.',
        'phone.required' => 'Please enter the phone number.',
        'address.required' => 'Please enter the address.',
    ];
}
