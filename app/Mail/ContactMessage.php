<?php

namespace App\Mail;

use App\Models\Enquiry;
use App\Models\Property;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessage extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $enquiry;
    public $property;
    public $package;
    public $agent;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Enquiry $enquiry, Property $property = null, $package = null, $agent = null)
    {
        $this->enquiry = $enquiry;
        $this->property = $property;
        $this->package = $package;
        $this->agent = $agent;

        if (!empty($this->property)) {
            $this->subject = __('New enquiry for the property ') . $this->property->translation->title;
        } elseif (!empty($this->package)) {
            $this->subject = __('New enquiry for buying credit package ') . $this->package['name'];
        } elseif (!empty($this->agent)) {
            $this->subject = __("New enquiry from your agent profile page.");
        } else {
            $this->subject = __("New message from website.");
        }
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->subject)
            // ->from($this->enquiry->email) //this will increase spam score
            ->from('info@myanmarhouse.com.mm')
            ->view('emails.contact-message');
    }
}
