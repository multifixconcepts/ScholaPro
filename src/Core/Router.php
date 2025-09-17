<?php
namespace ScholaPro\Core;

class Router
{
    public static function dispatch(): void
    {
        $modname = $_REQUEST['modname'] ?? 'Dashboard';
        $module = "Modules/{$modname}/index.php";
        
        if (!file_exists($module)) {
            header('HTTP/1.0 404 Not Found');
            Template::display('errors/404');
            exit;
        }

        // Check module access based on subscription
        if (!SubscriptionService::userCanAccess($modname)) {
            header('HTTP/1.0 403 Forbidden');
            Template::display('errors/subscription_required');
            exit;
        }

        require_once $module;
    }

    public static function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
}