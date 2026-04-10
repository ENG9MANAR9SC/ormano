<?php

namespace App\Domain\Legal\Contracts;

interface LabeledBackedEnum
{
    public function label(): string;
}
