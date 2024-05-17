<?php

namespace App\Helpers;

class FormatHelper
{
    public static function formatPhoneNumber(?string $phone): ?string
    {
        $phone = str_replace(' ', '', $phone);

        if (
            (str_starts_with($phone, '+31') && strlen($phone) === 12) ||
            (str_starts_with($phone, '31') && strlen($phone) === 11)
        ) {
            return str_replace('+', '', $phone);
        }

        if (str_starts_with($phone, '06') && strlen($phone) === 10) {
            return '31' . substr($phone, 1);
        }

        return null;
    }
}
