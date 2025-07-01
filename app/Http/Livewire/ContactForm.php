<?php

namespace App\Http\Livewire;

use App\Models\Enquiry;
use Livewire\Component;
use App\Mail\ContactMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactForm extends Component
{
    public $property;
    public $package;
    public $creditPage;
    public $agent;

    public $contactedBy;
    public $name;
    public $phone;
    public $email;
    public $title;
    public $msg;

    public function mount()
    {
        if (!empty(Auth::user())) {
            $this->contactedBy = Auth::user()->id;
            $this->name = Auth::user()->name;
            $this->phone = Auth::user()->phone;
            $this->email = Auth::user()->email;
        }
    }

    protected $rules = [
        'name' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
        // 'title' => 'required',
        'msg' => 'required',
    ];

    protected $messages = [
        'name.required' => 'Name is required.',
        'phone.required' => 'Phone is required.',
        'email.required' => 'Email is required.',
        'email.email' => 'Email format is incorrect.',
        'title.required' => 'Your title is required.',
        'msg.required' => 'Message is required.',
    ];

    public function updated()
    {
        if ($this->creditPage) {
            unset($this->rules['title']);
        }

        $this->validate();

        $this->package = session()->get('singlePackage');
    }

    public function sendMail()
    {
        // if ($this->creditPage) {
        //     unset($this->rules['title']);
        // }

        $this->validate();

        // first save the enquiry in the database
        $enquiry = Enquiry::create([
            'property_id' => !empty($this->property) ? $this->property->id : null,
            'package_id' => !empty($this->package) ? $this->package['id'] : null,
            'agent' => !empty($this->agent) ? $this->agent->id : null,
            'contacted_by' => $this->contactedBy ?: null,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'title' => $this->title ?: '',
            'message' => $this->msg,
        ]);

        if (!empty($this->property) && $this->property->user != null && $this->property->user->email != null) {
            // User is submitting from single property page
            Mail::to($this->property->user)->send(new ContactMessage($enquiry, $this->property));
            // } elseif (!empty($this->package)) {
            //     // User is submitting from top up points page
            //     Mail::to(env('ADMIN_EMAIL', 'info@myanmarwebdesigner.com'))->send(new ContactMessage($enquiry, null, $this->package));
        } elseif (!empty($this->agent)) {
            // User is submitting from agent detail page
            Mail::to($this->agent)->send(new ContactMessage($enquiry, null, null, $this->agent));
        } else {
            // User is submitting from contact page or suggestion page
            Mail::to(env('ADMIN_EMAIL', 'info@myanmarwebdesigner.com'))->send(new ContactMessage($enquiry));
        }

        // session()->flash('success', 'Enquiry sent successfully.');
        $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => 'Enquiry sent successfully.']);

        $this->name = null;
        $this->phone = null;
        $this->email = null;
        $this->title = null;
        $this->msg = null;

        // forget so that it would not still remaining while submitting other contact forms
        session()->forget('singlePackage');
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
