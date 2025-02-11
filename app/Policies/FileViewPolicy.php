<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FileViewPolicy
{
   

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, File $file)
    {
        return $file->is_public || $file->user_id === $user->id;
    }
}
