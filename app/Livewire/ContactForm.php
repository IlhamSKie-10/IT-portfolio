<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;

/**
 * ContactForm Livewire Component
 *
 * Handles the portfolio contact form submission with
 * real-time validation and email notification.
 *
 * Usage in Blade: <livewire:contact-form />
 */
class ContactForm extends Component
{
    public string $name    = '';
    public string $email   = '';
    public string $subject = '';
    public string $message = '';
    public bool   $sent    = false;
    public bool   $error   = false;

    protected array $rules = [
        'name'    => ['required', 'string', 'min:2', 'max:100'],
        'email'   => ['required', 'email', 'max:255'],
        'subject' => ['required', 'string', 'min:3', 'max:150'],
        'message' => ['required', 'string', 'min:10', 'max:2000'],
    ];

    /**
     * Real-time validation as user types.
     */
    public function updated(string $field): void
    {
        $this->validateOnly($field);
    }

    /**
     * Handle form submission.
     */
    public function submit(): void
    {
        $this->validate();

        try {
            // Send email — configure MAIL_* in .env
            Mail::raw(
                "Name: {$this->name}\nEmail: {$this->email}\n\n{$this->message}",
                function ($mail) {
                    $mail->to(config('mail.portfolio_recipient', 'ilhamhakiki@example.com'))
                         ->subject("[Portfolio] {$this->subject}");
                }
            );

            $this->sent    = true;
            $this->error   = false;
            $this->reset(['name', 'email', 'subject', 'message']);

        } catch (\Throwable $e) {
            $this->error = true;
            report($e);
        }
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.contact-form');
    }
}
