<?php

namespace App\Models;

use App\Domain\Legal\Enums\CourtType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property CourtType|null $type
 * @property string|null $jurisdiction
 * @property string|null $city
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $email
 * @property bool $is_active
 * @property string|null $notes
 */
class Court extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'code',
        'type',
        'jurisdiction',
        'city',
        'address',
        'phone',
        'email',
        'is_active',
        'notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => CourtType::class,
            'is_active' => 'boolean',
        ];
    }

    /**
     * @return HasMany<LegalCase, $this>
     */
    public function legalCases(): HasMany
    {
        return $this->hasMany(LegalCase::class, 'court_id');
    }
}
