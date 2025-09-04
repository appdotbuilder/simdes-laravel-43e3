<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\LetterRequest
 *
 * @property int $id
 * @property string $request_number
 * @property int $user_id
 * @property int $letter_type_id
 * @property string $purpose
 * @property array|null $attachments
 * @property array|null $additional_data
 * @property string $status
 * @property string|null $admin_notes
 * @property string|null $final_letter_path
 * @property \Illuminate\Support\Carbon $submitted_at
 * @property \Illuminate\Support\Carbon|null $processed_at
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property int|null $processed_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\LetterType $letterType
 * @property-read \App\Models\User|null $processedBy
 * @property-read \App\Models\User $user
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|LetterRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterRequest whereAdditionalData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterRequest whereAdminNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterRequest whereAttachments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterRequest whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterRequest whereFinalLetterPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterRequest whereLetterTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterRequest whereProcessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterRequest whereProcessedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterRequest wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterRequest whereRequestNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterRequest whereSubmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterRequest whereUserId($value)
 * @method static \Database\Factories\LetterRequestFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class LetterRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'request_number',
        'user_id',
        'letter_type_id',
        'purpose',
        'attachments',
        'additional_data',
        'status',
        'admin_notes',
        'final_letter_path',
        'submitted_at',
        'processed_at',
        'completed_at',
        'processed_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'attachments' => 'array',
        'additional_data' => 'array',
        'submitted_at' => 'datetime',
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the letter request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the letter type that owns the letter request.
     */
    public function letterType(): BelongsTo
    {
        return $this->belongsTo(LetterType::class);
    }

    /**
     * Get the user who processed the letter request.
     */
    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}