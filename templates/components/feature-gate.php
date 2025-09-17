<?php if (ScholaPro\Core\Services\SubscriptionService::userCanAccess($feature)): ?>
    <?php echo $content; ?>
<?php else: ?>
    <?php if (isset($upgradeMessage)): ?>
        <div class="alert alert-info">
            <i class="fa fa-lock"></i> 
            <?php echo $upgradeMessage; ?>
            <a href="Modules/Subscription/Upgrade.php" class="btn btn-primary btn-sm ml-2">Upgrade Now</a>
        </div>
    <?php endif; ?>
<?php endif; ?>