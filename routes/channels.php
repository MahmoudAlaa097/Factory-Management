<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('management.{managementId}', function (User $user, int $managementId) {
    return $user->employee?->management_id === $managementId;
});

Broadcast::channel('division.{divisionId}', function (User $user, int $divisionId) {
    return $user->employee?->isProduction()
        && $user->employee?->division_id === $divisionId;
});
