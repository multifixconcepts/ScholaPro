<?php

namespace ScholaPro\Core;

class SubscriptionService
{
    private static $features_cache = [];
    
    public static function userCanAccess(string $featureKey): bool
    {
        // TODO: Implement subscription tier checks
        return true;
    }
}