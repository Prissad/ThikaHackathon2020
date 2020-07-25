<?php

namespace App\Notifications;

use App\Client;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SignupActivate extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        //
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
        //$url = url('/api/auth/signup/activate/'.$notifiable->activation_token);
        $url = url('https://www.almourabi.com/login/');
        return (new MailMessage)
            ->greeting('Bonjour')
            ->subject('Verification d\'adresse mail')
            ->line('Notre plate-forme vous souhaite la bienvenue. Veuillez maintenant appuyer sur ce bouton pour confirmer votre e-mail.')
            ->action('Confirmer votre compte', url($url))
            ->line('Merci pour votre confiance,')
            ->salutation('Cordialement.');
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
