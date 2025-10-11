<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class TranslationHelper
{
    public static function pageTitle(string $title): string
    {
        return __('messages.' . Str::lower($title));
    }
}
