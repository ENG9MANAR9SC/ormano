<?php

namespace App\Models;

use App\Domain\Legal\Enums\CasePriority;
use App\Domain\Legal\Enums\CaseStatus;
use App\Domain\Legal\Enums\CaseType;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $case_number
 * @property string $title
 * @property string|null $description
 * @property CaseType $type
 * @property CaseStatus $status
 * @property CasePriority|null $priority
 * @property CarbonInterface|null $filing_date
 * @property CarbonInterface|null $start_date
 * @property CarbonInterface|null $end_date
 * @property CarbonInterface|null $next_hearing_date
 * @property int $client_id
 * @property int|null $court_id
 * @property int|null $assigned_to
 * @property string|null $notes
 */
class LegalCase extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cases';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'case_number',
        'title',
        'description',
        'type',
        'status',
        'priority',
        'filing_date',
        'start_date',
        'end_date',
        'next_hearing_date',
        'client_id',
        'court_id',
        'assigned_to',
        'notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => CaseType::class,
            'status' => CaseStatus::class,
            'priority' => CasePriority::class,
            'filing_date' => 'date',
            'start_date' => 'date',
            'end_date' => 'date',
            'next_hearing_date' => 'date',
        ];
    }

    /**
     * @return BelongsTo<Client, $this>
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return BelongsTo<Court, $this>
     */
    public function court(): BelongsTo
    {
        return $this->belongsTo(Court::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
