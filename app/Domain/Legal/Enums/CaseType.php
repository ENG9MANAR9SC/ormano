<?php

namespace App\Domain\Legal\Enums;

use App\Domain\Legal\Contracts\LabeledBackedEnum;

enum CaseType: string implements LabeledBackedEnum
{
    case CIVIL = 'civil';
    case CRIMINAL = 'criminal';
    case COMMERCIAL = 'commercial';
    case ADMINISTRATIVE = 'administrative';
    case LABOR = 'labor';
    case PERSONAL_STATUS = 'personal_status';
    case EXECUTION = 'execution';
    case REAL_ESTATE = 'real_estate';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::CIVIL => 'Civil',
            self::CRIMINAL => 'Criminal',
            self::COMMERCIAL => 'Commercial',
            self::ADMINISTRATIVE => 'Administrative',
            self::LABOR => 'Labor',
            self::PERSONAL_STATUS => 'Personal status / family',
            self::EXECUTION => 'Execution / enforcement',
            self::REAL_ESTATE => 'Real estate',
            self::OTHER => 'Other',
        };
    }
}
