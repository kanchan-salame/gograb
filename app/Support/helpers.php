<?php
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;

/**
 * Function to return
 */
function currentTeam(?User $user = null): Team
{
    $user = $user ?? auth()->user();

    return optional($user)->currentTeam;
}
