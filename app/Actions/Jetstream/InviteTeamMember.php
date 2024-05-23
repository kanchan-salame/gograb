<?php

namespace App\Actions\Jetstream;

use App\Models\Team;
use App\Models\User;
use Closure;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Password;
use Laravel\Jetstream\Contracts\InvitesTeamMembers;
use Laravel\Jetstream\Events\InvitingTeamMember;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Mail\TeamInvitation;
use Laravel\Jetstream\Rules\Role;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
// use App\Actions\Jetstream\InviteTeamMember as JetstreamInviteTeamMember;

class InviteTeamMember implements InvitesTeamMembers
{
    /**
     * Invite a new team member to the given team.
     */
    public function invite(User $user, Team $team, string $email, string $role = null): void
    {
        Gate::forUser($user)->authorize('addTeamMember', $team);

        $this->validate($team, $email, $role);

        InvitingTeamMember::dispatch($team, $email, $role);

        // InvitingTeamMember::dispatch($team, $email, $role);


        $invitedUser = $this->createUserIfNotExists($email);

        app(AddsTeamMembers::class)->add(
            $user,
            $team,
            $email,
            $role
        );

        // Switch the invited user to the current team
        $invitedUser->switchTeam($team);

        // $invitation = $team->teamInvitations()->create([
        //     'email' => $email,
        //     'role' => $role,
        // ]);

        // Mail::to($email)->send(new TeamInvitation($invitation));
        $this->broker()->sendResetLink(
            ['email' => $email],
            function ($user, $token) use ($team, $invitedUser) {
                $invitedUser->wasRecentlyCreated
                    ? $invitedUser->sendTeamWelcomeNotificationWithSetPasswordLink($team, $token)
                    : $invitedUser->sendTeamWelcomeNotification($team);
            }
        );
    }

    /**
     * Custom method to create a user if it doesn't exist already in the database
     *
     * @param string $email
     * @return \App\Models\User
     */
    private function createUserIfNotExists(string $email)
    {
        if ($user = User::where('email', $email)->first()) {
            return $user;
        }

        $userCreator = app(CreatesNewUsers::class);

        // Create new user data
        $data = [
            'name' => Str::title(strtok($email, '@')),
            'email' => Str::lower($email),
            'password' => $password = Str::random(8),
            'password_confirmation' => $password,
            'terms' => true,
            'disable_personal_team' => true
        ];

        $user = $userCreator->create($data);

        // We will mark the user's email as verified as it is being
        // automatically verified when we are sending him an email to set
        // a new password. Without that the user won't able to login anyways.
        $user->markEmailAsVerified();

        event(new Registered($user));

        return $user;
    }

    /**
     * Validate the invite member operation.
     */
    protected function validate(Team $team, string $email, ?string $role): void
    {
        Validator::make([
            'email' => $email,
            'role' => $role,
        ], $this->rules($team), [
            'email.unique' => __('This user has already been invited to the team.'),
        ])->after(
            $this->ensureUserIsNotAlreadyOnTeam($team, $email)
        )->validateWithBag('addTeamMember');
    }

    /**
     * Get the validation rules for inviting a team member.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected function rules(Team $team): array
    {
        return array_filter([
            'email' => [
                'required', 'email',
                Rule::unique('team_invitations')->where(function (Builder $query) use ($team) {
                    $query->where('team_id', $team->id);
                }),
            ],
            'role' => Jetstream::hasRoles()
                            ? ['required', 'string', new Role]
                            : null,
        ]);
    }

    /**
     * Ensure that the user is not already on the team.
     */
    protected function ensureUserIsNotAlreadyOnTeam(Team $team, string $email): Closure
    {
        return function ($validator) use ($team, $email) {
            $validator->errors()->addIf(
                $team->hasUserWithEmail($email),
                'email',
                __('This user already belongs to the team.')
            );
        };
    }

    /**
     * Custom method to get the password broker to generate a Reset Password link
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    protected function broker()
    {
        return Password::broker(config('fortify.passwords'));
    }
}
