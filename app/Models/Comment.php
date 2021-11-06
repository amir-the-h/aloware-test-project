<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Maximum nested layers
    const MAX_LAYER = 3;

    /**
     * All comments replies
     * Can be empty
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Replies()
    {
        return $this->hasMany(Comment::class, "parent_id", "id");
    }

    /**
     * Parent comment if the current comment is a child
     * Can be empty
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Parent()
    {
        return $this->belongsTo(Comment::class, "parent_id", "id");
    }
}
