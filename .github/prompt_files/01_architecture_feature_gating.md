[Architecture Mode]

Analyze the entire ScholaPro codebase. Based on our tiered plan (Free, Bronze, Silver, Gold), propose a robust and non-intrusive feature-gating architecture.

Consider the following:
1.  **Database Schema Changes:** Where do we store the tenant's (school's) subscription level? Propose SQL `ALTER TABLE` statements. Should we add a `subscription_tier` column to the `schools` table? Or create a new `subscriptions` table?
2.  **Feature Definition:** How should we define the features? A PHP array/enum? A database table? Example features: `FEATURE_STUDENT_BILLING`, `FEATURE_CUSTOM_REPORTS`, `FEATURE_API_ACCESS`.
3.  **The Core Logic:** Create a PHP class or a set of functions, e.g., `SubscriptionService`. It must include a central function: `public static function userCanAccess(string $featureKey): bool`. This function will check the current school's tier and determine if the feature is enabled for them.
4.  **Implementation Strategy:** How will we use this function? Show examples of how to wrap it around:
    * A menu item in the UI (e.g., in a `.php` template file).
    * A full page/module (e.g., at the top of `StudentBilling.php`).
    * A specific API endpoint.

Provide code examples for each point.