Project Mission: Transformation, Not Maintenance 🚀
This repository contains ScholaPro, a commercial SaaS product. It is an active and total refactor of the legacy open-source project. Your primary goal is to help transform the legacy procedural codebase into a modern, secure, and tiered application. Do not follow old Rosariosis conventions if they conflict with our new architecture.

Core Architecture & Mandates
Tiered Feature Gating is CRITICAL: This is the most important business rule. All new features, and many existing ones, must be locked behind a subscription plan check.

The Golden Rule: Always use the central function SubscriptionService::userCanAccess('FEATURE_KEY') to check permissions.

Comment Convention: Clearly mark tiered code so we know why it's there. Use this format: // SCHOLAPRO-TIER: GOLD | This section is for custom reporting.

Subscription Tiers: Free, Bronze, Silver, Gold.

Complete Rebranding: All instances of "Rosariosis" must be eradicated.

Replace all user-facing text, comments, and documentation.

Update variable and function names where appropriate (e.g., legacy_connect() becomes scholapro_connect() before being refactored into a class).

Code Modernization: We are moving from legacy procedural code to modern Object-Oriented PHP.

Target: All new logic must be encapsulated in classes under the ScholaPro namespace (e.g., in a new src/ directory).

Style: Adhere strictly to the PSR-12 coding standard.

Security First: All database queries must use parameterized statements. Sanitize all inputs and escape all outputs to prevent SQL injection and XSS.

Refactoring Workflow
When converting a legacy module (e.g., from modules/Attendance/) into a ScholaPro feature:

Analyze the existing procedural code: Identify the core business logic.

Create new classes: Encapsulate the logic within new classes in the ScholaPro namespace (e.g., ScholaPro\Modules\Attendance\AttendanceManager).

Apply Feature Gates: Wrap functions, UI elements (buttons, menu items), and entire pages with SubscriptionService::userCanAccess() checks according to the feature plan.

Isolate the UI: Keep the PHP logic separate from the HTML presentation. The PHP code should prepare data, and the template should only be responsible for displaying it.

Update Assets: Any related CSS/JS in assets/ should be reviewed, modernized, and minified using the Grunt build process (Gruntfile.js).

Key Files & Directories (Past vs. Future)
src/ (New): The home for all new ScholaPro namespaced classes (e.g., SubscriptionService.php). This is our target.

functions/: (Legacy) Contains old core helper functions. Our goal is to slowly refactor the logic from these files into new classes inside src/.

modules/: (Refactoring Target) Contains the core feature modules like Attendance and Discipline. We will refactor these one by one to use our new architecture and apply feature gates.

plugins/: (Future Integration Point) For third-party integrations like Moodle. These will also be updated to respect feature tiers (e.g., Moodle sync might be a Silver+ feature).

locale/: Contains localization files. When adding new user-facing text, ensure it is wrapped for gettext extraction so it can be translated.

assets/themes/: UI themes. The default theme will be redesigned for the ScholaPro brand.