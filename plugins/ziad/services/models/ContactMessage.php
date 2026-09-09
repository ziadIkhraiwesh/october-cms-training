<?php namespace Ziad\Services\Models;

use Model;

class ContactMessage extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'ziad_services_contact_messages';

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'status',
    ];

    public $rules = [
        'name' => 'required|string|min:2|max:100',
        'email' => 'required|email|max:150',
        'subject' => 'required|string|min:3|max:200',
        'message' => 'required|string|min:10|max:5000',
        'status' => 'required|in:new,read',
    ];

    public $customMessages = [
        'name.required' => 'Please enter your name.',
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
        'subject.required' => 'Please enter a subject.',
        'message.required' => 'Please enter your message.',
        'message.min' => 'The message must contain at least 10 characters.',
    ];

    public function getStatusOptions()
    {
        return [
            'new' => 'New',
            'read' => 'Read',
        ];
    }
}