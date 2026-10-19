<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewReplyHistory extends Model
{
    use HasFactory;

    protected $table = 'review_reply_history';

    protected $fillable = [
        'review_id',
        'original_reply',
        'edited_reply',
        'user_id',
        'action_type',
    ];

    /**
     * Get the review associated with this reply history.
     */
    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }

    /**
     * Get the user who made the edit/action.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
