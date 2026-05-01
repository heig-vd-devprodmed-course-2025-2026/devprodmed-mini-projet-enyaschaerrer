<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class SavedPost extends Model
{
    // get the user who saved the post
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    // get the post that was saved
    public function post(): BelongsTo {
        return $this->belongsTo(Post::class);
    }
}
