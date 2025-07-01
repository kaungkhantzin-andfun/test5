<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendClaimLinkNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public $reset_token)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('စကားဝှက်ပြောင်းပြီး အကောင့်ယူလိုက်ပါ (Reset password to claim your account)')
            ->greeting('Mingalaba, ' . $notifiable->name . ' ရှင့်!')
            ->line('ကျွန်မတို့ Myanmar House .com .mm အိမ်ခြံမြေဝဘ်ဆိုက်မှာ လူကြီးမင်းအတွက် အကောင့်ပြုလုပ်ပေးထားပြီးဖြစ်ကြောင်း အကြောင်းကြားပေးတာပါရှင့်။')
            ->line('Google မှာ ' . $notifiable->name . ' နာမည်နဲ့ ရှာလိုက်ရင်လည်း လူကြီးမင်းတို့ စာမျက်နှာက ပေါ်နေပါတယ်။')
            ->line('Google မှာပေါ်နေတဲ့အတွက် အကောင့်ကိုယူပြီး အိမ်ခြံမြေတွေ အခမဲ့ တင်ထားမယ်ဆို အလားအလာကောင်းတဲ့ ဝယ်လက်၊ ငှားလက်တွေ ရပါလိမ့်မယ်ရှင့်။')
            // add line break
            ->line('')
            ->line('')
            ->line('This email is to inform you that we have created an account for you on Myanmar House .com .mm.')
            ->line('Your agent page on our website is also appearing on Google if you search with ' . $notifiable->name)
            ->line('Therefore, claim your account and upload your properties for free to get promising enquiries.')
            ->action('အကောင့်ယူရန် (Claim Account)', url(config('app.url') . route('password.reset', [$this->reset_token, "email=$notifiable->email"], false)));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
