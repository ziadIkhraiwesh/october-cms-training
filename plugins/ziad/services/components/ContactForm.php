<?php namespace Ziad\Services\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\RateLimiter;
use October\Rain\Exception\ValidationException;
use Ziad\Services\Models\ContactMessage;
use Ziad\Services\Models\Settings;
use Flash;
use Validator;

class ContactForm extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Contact Form',
            'description' => 'Displays contact settings and processes AJAX messages.',
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $this->page['contactSettings'] = Settings::instance();
    }

    public function onSubmit()
    {
        $data = post();

        // Honeypot: normal visitors never fill this hidden field.
        if (!empty($data['website'])) {
            throw new ValidationException([
                'website' => 'Spam submission rejected.',
            ]);
        }

        $validation = Validator::make($data, [
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:150',
            'subject' => 'required|string|min:3|max:200',
            'message' => 'required|string|min:10|max:5000',
        ], [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'subject.required' => 'Please enter a subject.',
            'message.required' => 'Please enter your message.',
            'message.min' => 'The message must contain at least 10 characters.',
        ]);

        if ($validation->fails()) {
            throw new ValidationException($validation);
        }

        $rateLimitKey = 'contact-form:' . request()->ip();

        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            throw new ValidationException([
                'message' => 'Too many submissions. Please wait one minute and try again.',
            ]);
        }

        RateLimiter::hit($rateLimitKey, 60);

        ContactMessage::create([
            'name' => trim($data['name']),
            'email' => trim($data['email']),
            'subject' => trim($data['subject']),
            'message' => trim($data['message']),
            'status' => 'new',
        ]);

        Flash::success('Your message was sent successfully.');

        return [
            '#contact-form-feedback' =>
                '<div class="form-success">Your message was sent successfully.</div>',
        ];
    }
}