<?php

namespace App\Domain\Legal\Enums;

use App\Domain\Legal\Contracts\LabeledBackedEnum;

enum CaseStatus: string implements LabeledBackedEnum
{
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case CLOSED = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::OPEN => 'Open',
            self::IN_PROGRESS => 'In progress',
            self::CLOSED => 'Closed',
        };
    }
}
