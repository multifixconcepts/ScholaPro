<?php
namespace ScholaPro\Modules\Subscription;

use ScholaPro\Core\Services\Database;
use ScholaPro\Core\Services\SubscriptionService;

class SubscriptionController
{
    public function viewPlans(): array
    {
        $query = "SELECT * FROM subscription_plans ORDER BY price ASC";
        $stmt = Database::prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCurrentPlan(): ?array
    {
        return SubscriptionService::getInstance()->getCurrentPlan();
    }

    public function upgradePlan(int $planId): bool
    {
        if (!$this->validatePlanUpgrade($planId)) {
            return false;
        }

        $schoolId = $_SESSION['SCHOOL_ID'];
        $query = "INSERT INTO school_subscriptions (school_id, plan_id, status) 
                 VALUES (?, ?, 'pending')";
        
        $stmt = Database::prepare($query);
        return $stmt->execute([$schoolId, $planId]);
    }

    private function validatePlanUpgrade(int $planId): bool
    {
        $query = "SELECT * FROM subscription_plans WHERE id = ?";
        $stmt = Database::prepare($query);
        $stmt->execute([$planId]);
        return (bool) $stmt->fetch();
    }
}