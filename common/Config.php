<?php

namespace Common;

/**
 *
 */
class Config
{
    protected array $config = [];

    public function __construct(array $env)
    {
        $this->config = [
            'db' => [
                'host'     => getenv('MYSQL_HOST'),
                'user'     => getenv('MYSQL_USER'),
                'password' => getenv('MYSQL_PASSWORD'),
                'dbname'   => getenv('MYSQL_DATABASE'),
                'driver'   => getenv('MYSQL_DRIVER'),
            ],
        ];
    }

    public function get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}