<?php

use Illuminate\Support\Facades\File;
use Kolirt\Telegram\Core\Types\BaseType;

if (!function_exists('request_params')) {
    function request_params(array $input): array
    {
        foreach ($input as &$value) {
            if (is_array($value)) {
                $value = request_params($value);
            }
        }

        return array_filter($input, function ($value) {
            return !is_null($value);
        });
    }
}

if (!function_exists('response_params')) {
    function response_params($wrap, array|null $data): BaseType|null
    {
        return $data ? $wrap::from($data) : null;
    }
}

if (!function_exists('telegram_metadata_generated')) {
    function telegram_metadata_generated()
    {
        return File::exists(base_path('.phpstorm.meta.php/' . config('telegram.metadata_filename')));
    }
}
