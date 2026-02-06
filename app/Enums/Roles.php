<?php

namespace App\Enums;

enum Roles: string
{
    case ADMIN = 'admin';
    case AGENT = 'agent';
    public static function getValues(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
