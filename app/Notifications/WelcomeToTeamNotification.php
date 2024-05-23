<?php

namespace App\Notifications;

use App\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeToTeamNotification extends Notification
{
    // use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Team to which the user was added
     *
     * @var \App\Models\Team
     */
    public $team;


    /**
     * Create a new notification instance.
     *
     * @var \App\Models\Team $team
     * @var string|null $token
     *
     * @return void
     */
    public function __construct(Team $team, ?string $token = null)
    {
        $this->team = $team;
        $this->token = $token;
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
    public function toMail(object $notifiable) : MailMessage
    {
        $message = (new MailMessage)
            ->subject('You have been added to :team on GoGrab', ['team' => $this->team->name])
            ->line('Dear :name,', ['name' => $notifiable->name])
            ->line(':team is using GoGrab to manage their projects, clients and invoicing and you have been added to their team.', ['team' => $this->team->name]);

        // If we don't have a token then it means we are sending notificaiton to an existing user.
        // And we don't need to construct Reset password link
        if (! $this->token) {
            $url = url(route('login', false));
            $actionText = 'Login';
            $message->line('Please login and then switch to :team from the Teams menu to start contributing.', ['team' => $this->team->name]);
        } else {
            $url = url(route('password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
            $actionText = 'Set Your Password';
            $message->line('Please click the button below to set a password for your new account and start contributing to :team.', ['team' => $this->team->name]);
        }

        return $message->action($actionText, $url)
            ->line('Thank you for using GoGrab!');
    }

}
