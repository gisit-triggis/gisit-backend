<?php

namespace App\Support;

class AppDefaults
{
    public static function passwordMin(): int
    {
        return config('app_rules.auth_rules.password_min_length');
    }

    public static function passwordMax(): int
    {
        return config('app_rules.auth_rules.password_max_length');
    }

    public static function userNameMin(): int
    {
        return config('app_rules.user_rules.user_name_min_length');
    }

    public static function userNameMax(): int
    {
        return config('app_rules.user_rules.user_name_max_length');
    }

    public static function userSurnameMin(): int
    {
        return config('app_rules.user_rules.user_surname_min_length');
    }

    public static function userSurnameMax(): int
    {
        return config('app_rules.user_rules.user_surname_max_length');
    }

    public static function markTypes(): array
    {
        return ['recommend','warning','danger'];
    }
}
