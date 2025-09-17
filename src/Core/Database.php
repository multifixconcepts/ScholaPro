<?php
namespace ScholaPro\Core\Services;

use PDO;
use PDOStatement;
use PDOException;

class Database
{
    private static $instance = null;
    private $pdo;

    public static function init(array $config): void
    {
        if (!isset(self::$instance)) {
            self::$instance = new self($config);
        }
    }

    private function __construct(array $config)
    {
        $dsn = sprintf(
            "pgsql:host=%s;port=%s;dbname=%s",
            $config['host'],
            $config['port'],
            $config['name']
        );

        $this->pdo = new PDO($dsn, $config['user'], $config['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public static function prepare(string $query): PDOStatement
    {
        if (!self::$instance) {
            throw new \RuntimeException('Database not initialized');
        }
        return self::$instance->pdo->prepare($query);
    }

    public static function query(string $query): PDOStatement
    {
        return self::prepare($query)->execute();
    }

    public static function lastInsertId(): string
    {
        return self::$instance->pdo->lastInsertId();
    }
}