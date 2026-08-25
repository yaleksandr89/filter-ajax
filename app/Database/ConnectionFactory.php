<?php

declare(strict_types=1);

namespace App\Database;

use PDO;

final readonly class ConnectionFactory
{
    public function __construct(private DatabaseConfig $config)
    {
    }

    public function create(): PDO
    {
        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $this->config->host(),
            $this->config->port(),
            $this->config->name(),
            $this->config->charset(),
        );

        return new PDO(
            $dsn,
            $this->config->user(),
            $this->config->password(),
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ],
        );
    }
}
