<?php
/**
 * Index
 *
 * Login screen
 *
 * @package RosarioSIS
 */

require_once 'config.inc.php';

use ScholaPro\Core\Security;
use ScholaPro\Core\SubscriptionService;

// Validate user session and permissions
Security::validateSession();

// Initialize template engine
$template = new \ScholaPro\Core\Template();

// Set global template variables
$template->assign([
    'TITLE' => 'ScholaPro',
    'VERSION' => SCHOLAPRO_VERSION,
    'USER' => Security::getCurrentUser(),
    'SUBSCRIPTION' => SubscriptionService::getCurrentPlan()
]);

// Route and render the request
\ScholaPro\Core\Router::dispatch();
