<?php

namespace App\Policies;

use App\Http\Models\User;
use App\Http\Models\Installment;
use Illuminate\Auth\Access\HandlesAuthorization;

class InstallmentPolicy
{
    use HandlesAuthorization;

    public function own(User $user, Installment $installment)
    {
        return $installment->user_id == $user->id;
    }
}
