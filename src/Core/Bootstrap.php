<?php
namespace ScholaPro\Core;

class Bootstrap
{
    private static $instance = null;
    private $config;

    public static function init(array $config = []): self
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    private function __construct(array $config)
    {
        $this->config = $config;
        $this->initializeCore();
    }

    private function initializeCore(): void
    {
        // Initialize database connection
        Database::init($this->config);
        
        // Start session management
        session_name('ScholaPro');
        session_start();
        
        // Load subscription service
        SubscriptionService::getInstance();
    }
}