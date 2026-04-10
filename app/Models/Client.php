<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string|null $father_name
 * @property string|null $mother_name
 * @property string|null $national_id
 * @property string $email
 * @property string|null $phone
 * @property string $country
 * @property string|null $city
 * @property string|null $address
 * @property CarbonInterface|null $birth_date
 * @property string|null $notes
 */
class Client extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'father_name',
        'mother_name',
        'national_id',
        'email',
        'phone',
        'country',
        'city',
        'address',
        'birth_date',
        'notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    /**
     * @return Attribute<string, never>
     */
    protected function fullName(): Attribute
    {
        return Attribute::get(fn (): string => trim("{$this->first_name} {$this->last_name}"));
    }

    /**
     * @return HasMany<LegalCase, $this>
     */
    public function legalCases(): HasMany
    {
        return $this->hasMany(LegalCase::class, 'client_id');
    }
}
