<?php
namespace ScholaPro\Core;

class Security
{
    private static $currentUser = null;

    public static function validateSession(): bool
    {
        if (!isset($_SESSION['STAFF_ID'])) {
            header('Location: index.php?login');
            exit;
        }
        return true;
    }

    public static function getCurrentUser(): ?array
    {
        if (self::$currentUser === null && isset($_SESSION['STAFF_ID'])) {
            $query = "SELECT s.*, sp.name as subscription_plan 
                     FROM staff s 
                     LEFT JOIN school_subscriptions ss ON s.school_id = ss.school_id
                     LEFT JOIN subscription_plans sp ON ss.plan_id = sp.id
                     WHERE s.staff_id = ?";
            
            $result = Database::prepare($query)->execute([$_SESSION['STAFF_ID']]);
            self::$currentUser = $result->fetch();
        }
        return self::$currentUser;
    }

    public static function hasPermission(string $permission): bool
    {
        $user = self::getCurrentUser();
        return $user && ($user['profile'] === 'admin' || in_array($permission, $user['permissions'] ?? []));
    }
}