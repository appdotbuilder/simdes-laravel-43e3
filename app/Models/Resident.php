<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Resident
 *
 * @property int $id
 * @property string $nik
 * @property string $name
 * @property \Illuminate\Support\Carbon $birth_date
 * @property string $birth_place
 * @property string $gender
 * @property string $religion
 * @property string|null $education
 * @property string|null $occupation
 * @property string $marital_status
 * @property int $family_id
 * @property string $family_relation
 * @property string|null $phone
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Family $family
 * @property-read \App\Models\User|null $user
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Resident newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Resident newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Resident query()
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereBirthPlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereEducation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereFamilyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereFamilyRelation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereMaritalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereNik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereReligion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resident active()
 * @method static \Database\Factories\ResidentFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Resident extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nik',
        'name',
        'birth_date',
        'birth_place',
        'gender',
        'religion',
        'education',
        'occupation',
        'marital_status',
        'family_id',
        'family_relation',
        'phone',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the family that owns the resident.
     */
    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    /**
     * Get the user associated with the resident.
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * Scope a query to only include active residents.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}