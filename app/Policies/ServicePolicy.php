<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Service;

class ServicePolicy
{
    public function update(User $user, Service $service): bool
    {
        $profile = $user->freelancerProfile;

        return $profile !== null
            && (int) $profile->freelancer_profile_id
                === (int) $service->freelancer_profile_id;
    }
}