<?php

namespace App\Domain\Legal\Enums;

use App\Domain\Legal\Contracts\LabeledBackedEnum;

enum CasePriority: string implements LabeledBackedEnum
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';

    public function label(): string
    {
        return match ($this) {
            self::LOW => 'Low',
            self::MEDIUM => 'Medium',
            self::HIGH => 'High',
        };
    }
}
