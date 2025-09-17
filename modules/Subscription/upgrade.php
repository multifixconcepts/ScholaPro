<?php
require_once 'src/Modules/Subscription/SubscriptionController.php';

$controller = new ScholaPro\Modules\Subscription\SubscriptionController();
$planId = (int) $_POST['plan_id'];

if ($controller->upgradePlan($planId)) {
    $_SESSION['success'] = 'Subscription upgrade request submitted successfully.';
} else {
    $_SESSION['error'] = 'Unable to process subscription upgrade.';
}

header('Location: index.php?modname=Subscription/index.php');
exit;