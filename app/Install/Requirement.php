<?php

namespace App\Install;

class Requirement
{
    public function extensions(): array
    {
        return [
            'PHP >= 8.2' => version_compare(phpversion(), '8.2'),
            'Intl PHP Extension' => extension_loaded('intl'),
            'OpenSSL PHP Extension' => extension_loaded('openssl'),
            'PDO PHP Extension' => extension_loaded('pdo'),
            'Mbstring PHP Extension' => extension_loaded('mbstring'),
            'Tokenizer PHP Extension' => extension_loaded('tokenizer'),
            'XML PHP Extension' => extension_loaded('xml'),
            'Ctype PHP Extension' => extension_loaded('ctype'),
            'JSON PHP Extension' => extension_loaded('json'),
        ];
    }

    public function directories(): array
    {
        return [
            'storage' => is_writable(storage_path()),
            'bootstrap/cache' => is_writable(app()->bootstrapPath('cache')),
        ];
    }

    public function satisfied()
    {
        return collect($this->extensions())
            ->merge($this->directories())
            ->every(fn($item) => $item);
    }
}
