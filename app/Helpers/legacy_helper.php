<?php

use App\Models\HomeSetModel;

if (! function_exists('sql_password')) {
    function sql_password(string $value): string
    {
        return hash('sha512', $value);
    }
}

if (! function_exists('homeSetInfo')) {
    function homeSetInfo(): array
    {
        try {
            $model = model(HomeSetModel::class);
            $info  = $model->getSiteConfig(1);

            return is_array($info) ? $info : [];
        } catch (\Throwable $e) {
            return [];
        }
    }
}
