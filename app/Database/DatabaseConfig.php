<?php

declare(strict_types=1);

namespace App\Database;

use RuntimeException;

final readonly class DatabaseConfig
{
    private const array ALLOWED_KEYS = [
        'host',
        'port',
        'name',
        'user',
        'password',
        'charset',
    ];

    private const array ENVIRONMENT_KEYS = [
        'DB_HOST' => 'host',
        'DB_PORT' => 'port',
        'DB_NAME' => 'name',
        'DB_USER' => 'user',
        'DB_PASSWORD' => 'password',
        'DB_CHARSET' => 'charset',
    ];

    private function __construct(
        private string $host,
        private int $port,
        private string $name,
        private string $user,
        private string $password,
        private string $charset,
    ) {
    }

    /**
     * @throws RuntimeException When local or environment configuration is malformed.
     */
    public static function load(string $configFile): self
    {
        $values = [
            'host' => '127.0.0.1',
            'port' => 3306,
            'charset' => 'utf8mb4',
        ];

        if (is_file($configFile)) {
            if (!is_readable($configFile)) {
                throw new RuntimeException('The local database configuration file is not readable.');
            }

            $localValues = (static fn (string $file): mixed => require $file)($configFile);
            if (!is_array($localValues)) {
                throw new RuntimeException('The local database configuration must return an array.');
            }

            foreach (array_keys($localValues) as $key) {
                if (!is_string($key) || !in_array($key, self::ALLOWED_KEYS, true)) {
                    throw new RuntimeException('The local database configuration contains an unsupported key.');
                }
            }

            $values = array_replace($values, $localValues);
        }

        foreach (self::ENVIRONMENT_KEYS as $environmentKey => $configKey) {
            $environmentValue = getenv($environmentKey);
            if ($environmentValue !== false) {
                $values[$configKey] = $environmentValue;
            }
        }

        foreach (['host', 'name', 'user', 'charset'] as $key) {
            if (!isset($values[$key]) || !is_string($values[$key]) || trim($values[$key]) === '') {
                throw new RuntimeException(sprintf('Database configuration key "%s" must be a non-empty string.', $key));
            }
        }

        if (!array_key_exists('password', $values) || !is_string($values['password'])) {
            throw new RuntimeException('Database configuration key "password" must be a string.');
        }

        $port = filter_var(
            $values['port'] ?? null,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1, 'max_range' => 65535]],
        );
        if ($port === false) {
            throw new RuntimeException('Database configuration key "port" must be a valid TCP port.');
        }

        if (preg_match('/^[A-Za-z0-9_]+$/D', $values['charset']) !== 1) {
            throw new RuntimeException('Database configuration key "charset" is invalid.');
        }

        return new self(
            trim($values['host']),
            $port,
            trim($values['name']),
            trim($values['user']),
            $values['password'],
            $values['charset'],
        );
    }

    public function host(): string
    {
        return $this->host;
    }

    public function port(): int
    {
        return $this->port;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function user(): string
    {
        return $this->user;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function charset(): string
    {
        return $this->charset;
    }
}
