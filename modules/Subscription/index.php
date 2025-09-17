<?php
require_once 'src/Modules/Subscription/SubscriptionController.php';

$controller = new ScholaPro\Modules\Subscription\SubscriptionController();
$plans = $controller->viewPlans();
$currentPlan = $controller->getCurrentPlan();
?>

<div class="panel">
    <h2>Subscription Management</h2>
    
    <div class="current-plan">
        <h3>Current Plan: <?php echo htmlspecialchars($currentPlan['name'] ?? 'Free'); ?></h3>
        <p>Features available: <?php echo count(SubscriptionService::getInstance()->getAvailableFeatures()); ?></p>
    </div>

    <div class="subscription-grid">
        <?php foreach ($plans as $plan): ?>
            <div class="plan-card <?php echo $plan['name']; ?>">
                <h3><?php echo htmlspecialchars(ucfirst($plan['name'])); ?> Plan</h3>
                <div class="price">$<?php echo number_format($plan['price'], 2); ?>/month</div>
                
                <ul class="features">
                    <?php foreach (json_decode($plan['features'], true) as $feature): ?>
                        <li><?php echo htmlspecialchars($feature); ?></li>
                    <?php endforeach; ?>
                </ul>

                <?php if ($plan['name'] !== $currentPlan['name']): ?>
                    <form method="post" action="Modules/Subscription/upgrade.php">
                        <input type="hidden" name="plan_id" value="<?php echo $plan['id']; ?>">
                        <button type="submit" class="btn btn-primary">Upgrade to <?php echo htmlspecialchars(ucfirst($plan['name'])); ?></button>
                    </form>
                <?php else: ?>
                    <button class="btn btn-secondary" disabled>Current Plan</button>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>