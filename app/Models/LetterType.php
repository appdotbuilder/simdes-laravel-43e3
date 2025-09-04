<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\LetterType
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property array|null $requirements
 * @property string|null $template
 * @property string $fee
 * @property int $processing_days
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LetterRequest> $letterRequests
 * @property-read int|null $letter_requests_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|LetterType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterType query()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterType whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterType whereProcessingDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterType whereRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterType whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterType whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterType active()
 * @method static \Database\Factories\LetterTypeFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class LetterType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'requirements',
        'template',
        'fee',
        'processing_days',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'requirements' => 'array',
        'fee' => 'decimal:2',
        'processing_days' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the letter requests for the letter type.
     */
    public function letterRequests(): HasMany
    {
        return $this->hasMany(LetterRequest::class);
    }

    /**
     * Scope a query to only include active letter types.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}