<?php

namespace app\model\observer;

use app\model\ModelUser;

class UserObserver
{

    public bool $afterCommit = true;

    public function creating(ModelUser $user): void
    {
        var_dump('=UserObserver=', $user);
        if (!$user->isDirty('password')) {
            $user->resetPassword();
        }
    }

    public function deleted(ModelUser $user): void
    {
        $user->roles()->detach();
        $user->policy()->delete();
    }
}
