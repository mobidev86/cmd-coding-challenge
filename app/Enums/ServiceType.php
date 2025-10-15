<?php

namespace App\Enums;

enum ServiceType: string
{
    case CLEANING = 'cleaning';
    case MAINTENANCE = 'maintenance';
    case INSPECTIONS = 'inspections';

    public function getLabel(): string
    {
        return match($this) {
            self::CLEANING => 'Cleaning',
            self::MAINTENANCE => 'Maintenance',
            self::INSPECTIONS => 'Inspections',
        };
    }

    public function getHourlyRate(): int
    {
        return match($this) {
            self::CLEANING => 40,
            self::MAINTENANCE => 50,
            self::INSPECTIONS => 70,
        };
    }

    public static function toSelectArray(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->getLabel()])
            ->toArray();
    }
}
