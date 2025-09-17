<?php
namespace ScholaPro\Core\Services;

class SubscriptionService
{
    public const TIER_FREE = 'free';
    public const TIER_BRONZE = 'bronze';
    public const TIER_SILVER = 'silver';
    public const TIER_GOLD = 'gold';

    private static $instance = null;
    private static $tierFeatures = [
        self::TIER_FREE => [
            'core_sis',
            'basic_gradebook',
            'basic_attendance'
        ],
        self::TIER_BRONZE => [
            'scheduling',
            'parent_portal',
            'basic_reporting'
        ],
        self::TIER_SILVER => [
            'student_billing',
            'discipline_management',
            'advanced_reporting',
            'user_export',
            'basic_api'
        ],
        self::TIER_GOLD => [
            'custom_reports',
            'advanced_integrations',
            'analytics_dashboard',
            'white_label',
            'role_management'
        ]
    ];

    private $currentPlan = null;

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getCurrentPlan(): ?array
    {
        if ($this->currentPlan === null) {
            $schoolId = $_SESSION['SCHOOL_ID'] ?? null;
            if (!$schoolId) {
                return null;
            }

            $query = "SELECT sp.* FROM subscription_plans sp
                     JOIN school_subscriptions ss ON sp.id = ss.plan_id
                     WHERE ss.school_id = ? AND ss.status = 'active'
                     AND (ss.end_date IS NULL OR ss.end_date >= CURRENT_DATE)
                     ORDER BY ss.created_at DESC LIMIT 1";
            
            $stmt = Database::prepare($query);
            $stmt->execute([$schoolId]);
            $this->currentPlan = $stmt->fetch();
        }
        return $this->currentPlan;
    }

    public static function userCanAccess(string $feature): bool
    {
        $instance = self::getInstance();
        $plan = $instance->getCurrentPlan();
        
        if (!$plan) {
            return false;
        }

        // Free tier features are available to all
        if (in_array($feature, self::$tierFeatures[self::TIER_FREE])) {
            return true;
        }

        $tierLevel = array_search($plan['name'], [
            self::TIER_FREE,
            self::TIER_BRONZE,
            self::TIER_SILVER,
            self::TIER_GOLD
        ]);

        if ($tierLevel === false) {
            return false;
        }

        // Check if feature exists in current or lower tiers
        for ($i = 0; $i <= $tierLevel; $i++) {
            $tier = array_values([
                self::TIER_FREE,
                self::TIER_BRONZE,
                self::TIER_SILVER,
                self::TIER_GOLD
            ])[$i];
            
            if (in_array($feature, self::$tierFeatures[$tier])) {
                return true;
            }
        }

        return false;
    }

    public function getAvailableFeatures(): array
    {
        $plan = $this->getCurrentPlan();
        if (!$plan) {
            return self::$tierFeatures[self::TIER_FREE];
        }

        $features = [];
        $tiers = [self::TIER_FREE, self::TIER_BRONZE, self::TIER_SILVER, self::TIER_GOLD];
        $currentTierIndex = array_search($plan['name'], $tiers);

        for ($i = 0; $i <= $currentTierIndex; $i++) {
            $features = array_merge($features, self::$tierFeatures[$tiers[$i]]);
        }

        return array_unique($features);
    }
}