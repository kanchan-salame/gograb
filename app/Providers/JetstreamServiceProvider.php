<?php

namespace App\Providers;

use App\Actions\Jetstream\AddTeamMember;
use App\Actions\Jetstream\CreateTeam;
use App\Actions\Jetstream\DeleteTeam;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\InviteTeamMember;
use App\Actions\Jetstream\RemoveTeamMember;
use App\Actions\Jetstream\UpdateTeamName;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::createTeamsUsing(CreateTeam::class);
        Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
        Jetstream::addTeamMembersUsing(AddTeamMember::class);
        Jetstream::inviteTeamMembersUsing(InviteTeamMember::class);
        Jetstream::removeTeamMembersUsing(RemoveTeamMember::class);
        Jetstream::deleteTeamsUsing(DeleteTeam::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the roles and permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::role('admin', 'Administrator', [
            'create',
            'read',
            'update',
            'delete',
        ])->description('Administrator users can perform any action.');

        Jetstream::role('editor', 'Editor', [
            'read',
            'create',
            'update',
        ])->description('Editor users have the ability to manage users and orders.');
        Jetstream::role('user', 'User', [
            'read',
            'create',
            'update',
        ])->description('User users have the ability place and remove orders.');
        Jetstream::role('driver', 'Driver', [
            'read',
            'create',
            'update',
        ])->description('Driver dispatch orders.');
        Jetstream::role('vendor', 'Vendor', [
            'read',
            'create',
            'update',
        ])->description('Vendor users have the ability to read, create, and update.');
        Jetstream::role('restaurant', 'Restaurant', [
            'read',
            'create',
            'update',
        ])->description('Restaurant users have the ability to read, create, and update the orders and users.');
        Jetstream::role('customer', 'Customer', [
            'read',
            'create',
            'update',
        ])->description('Customer users have the ability buy products.');
    }
}
