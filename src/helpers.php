<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Kolirt\Telegram\Core\Types\BaseType;

if (!function_exists('request_params')) {
    function request_params(array $params): array
    {
        return array_filter($params, fn($param) => $param !== null);
    }
}

if (!function_exists('response_params')) {
    function response_params($wrap, array|null $data): BaseType|null
    {
        return $data ? $wrap::from($data) : null;
    }
}

// TODO: need remove
if (!function_exists('get_belongs_to_many_table_name')) {
    function get_belongs_to_many_table_name(string $first_table_name, string $second_table_name): string
    {
        $segments = [Str::singular($first_table_name), Str::singular($second_table_name)];
        sort($segments);

        return implode('_', $segments);
    }
}

if (!function_exists('telegram_command')) {
    function telegram_command(string $command)
    {
        dd($command);
    }
}

if (!function_exists('telegram_metadata_generated')) {
    function telegram_metadata_generated()
    {
        return File::exists(base_path('.phpstorm.meta.php/' . config('telegram.metadata_filename')));
    }
}
