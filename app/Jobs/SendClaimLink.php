<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Notifications\SendClaimLinkNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\Passwords\DatabaseTokenRepository;

class SendClaimLink implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        if ($this->isOfficeHours(now())) {
            // get last sent user ID
            $last_sent_user_id = Cache::get('last_sent_user_id');

            // if ($this->isFirstMondayOfMonth()) {

            // get 50 imported users to send mail
            $to_send = 50;

            if (empty($last_sent_user_id)) {
                $users = User::where('status', 'imported')->limit($to_send)->get();
            } else {
                $users = User::where('status', 'imported')->where('id', '>', $last_sent_user_id)->limit($to_send)->get();

                // users will be empty when the last_sent_user_id is max
                if (count($users) == 0) {
                    // if that so we are getting users from start again
                    $users = User::where('status', 'imported')->limit($to_send)->get();
                }
            }

            // create password_resets entry for each user
            foreach ($users as $user) {
                // create reset token
                $reset_token = app(PasswordBroker::class)->createToken($user);

                // send cliam link notification
                $user->notify(new SendClaimLinkNotification($reset_token));
            }

            // remember last user id
            $last_user = $users->last();
            Cache::put('last_sent_user_id', $last_user->id);

            // }
        }
    }

    function isOfficeHours($date): bool
    {
        $dateNumber = date('w', strtotime($date));

        // if the time is in week days, return
        if ($dateNumber != 0 && $dateNumber != 6) {
            // then check if the time is office hours

            $hour = date('H', strtotime($date));

            // if the hour is office hours, return true
            return ($hour >= 9 && $hour <= 16);
        }
    }

    protected function isFirstMondayOfMonth(): bool
    {
        $firstOfMonth = now()->firstOfMonth(1);
        $today = today();

        return $firstOfMonth->is($today);
    }
}
