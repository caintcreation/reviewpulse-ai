<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'reviewer_name',
        'product_name',
        'rating',
        'review_text',
        'review_status',
        'processing_status',
        'ai_generated_reply',
        'suggested_reply',
        'sentiment',
        'confidence_score',
        'ai_summary',
        'requires_human_review',
        'source',
        'external_review_id',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'confidence_score' => 'float',
            'requires_human_review' => 'boolean',
        ];
    }

    /**
     * Get the store that received this review.
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the reply histories for this review.
     */
    public function replyHistories(): HasMany
    {
        return $this->hasMany(ReviewReplyHistory::class)->latest();
    }

    /**
     * Get the automation logs for this review.
     */
    public function automationLogs(): HasMany
    {
        return $this->hasMany(AutomationLog::class)->latest();
    }

    /**
     * Return active reply text (suggested_reply or fallback to ai_generated_reply).
     */
    public function getActiveReplyAttribute(): ?string
    {
        return $this->suggested_reply ?? $this->ai_generated_reply;
    }
}
