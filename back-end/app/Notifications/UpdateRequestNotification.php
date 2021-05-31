<?php

namespace App\Notifications;

use App\Models\userInformation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class UpdateRequestNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $transactionNumber;
    public $status;
    public function __construct($status,$transactionNumber)
    {
        //
        $this->transactionNumber = $transactionNumber;
        $this->status = $status;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }


    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {
        $user = userInformation::where('email',Auth::user()->email)->get();
        return [
            'updater' => $user[0]->firstName.' '.$user[0]->lastName,
            'transactionNumber' => $this->transactionNumber,
            'updaterPic' => $user[0]->profilePicture,
            'status' => $this->status

        ];
    }

    public function toBroadcast($notifiable)
    {
        $user = userInformation::where('email',Auth::user()->email)->get();
        return new BroadcastMessage([
            'updater' => $user[0]->firstName.' '.$user[0]->lastName,
            'transactionNumber' => $this->transactionNumber,
            'updaterPic' => $user[0]->profilePicture,
            'status' => $this->status
            
        ]);
    }

}
