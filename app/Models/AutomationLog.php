<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AutomationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_id',
        'workflow_type',
        'status',
        'payload_data',
        'error_message',
        'retry_count',
    ];

    protected function casts(): array
    {
        return [
            'retry_count' => 'integer',
        ];
    }

    /**
     * Get the review associated with this automation log.
     */
    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }
}
