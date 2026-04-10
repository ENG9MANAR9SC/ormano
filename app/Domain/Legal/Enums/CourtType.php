<?php

namespace App\Domain\Legal\Enums;

use App\Domain\Legal\Contracts\LabeledBackedEnum;

enum CourtType: string implements LabeledBackedEnum
{
    case FIRST_INSTANCE = 'first_instance';
    case APPEAL = 'appeal';
    case CASSATION = 'cassation';
    case ADMINISTRATIVE = 'administrative';
    case MILITARY = 'military';
    case ECONOMIC = 'economic';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::FIRST_INSTANCE => 'Court of first instance',
            self::APPEAL => 'Appeal court',
            self::CASSATION => 'Cassation / Supreme',
            self::ADMINISTRATIVE => 'Administrative court',
            self::MILITARY => 'Military court',
            self::ECONOMIC => 'Economic / commercial chamber',
            self::OTHER => 'Other',
        };
    }
}
