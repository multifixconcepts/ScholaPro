-- ScholaPro Subscription Schema
CREATE TABLE subscription_plans (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL CHECK (name IN ('free', 'bronze', 'silver', 'gold')),
    description TEXT,
    price DECIMAL(10,2) NOT NULL DEFAULT 0,
    max_students INTEGER,
    features JSONB NOT NULL DEFAULT '[]',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE school_subscriptions (
    id SERIAL PRIMARY KEY,
    school_id INTEGER NOT NULL REFERENCES schools(id),
    plan_id INTEGER NOT NULL REFERENCES subscription_plans(id),
    status VARCHAR(20) NOT NULL DEFAULT 'active' CHECK (status IN ('active', 'pending', 'cancelled', 'expired')),
    start_date DATE NOT NULL DEFAULT CURRENT_DATE,
    end_date DATE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Default subscription plans
INSERT INTO subscription_plans (name, description, price, max_students, features) VALUES
('free', 'Basic SIS functionality', 0, 50, '["core_sis", "basic_gradebook", "basic_attendance"]'),
('bronze', 'Enhanced features for small schools', 99.99, 200, '["scheduling", "parent_portal", "basic_reporting"]'),
('silver', 'Advanced features for growing schools', 199.99, NULL, '["student_billing", "discipline_management", "advanced_reporting", "user_export", "basic_api"]'),
('gold', 'Premium features for large institutions', 299.99, NULL, '["custom_reports", "advanced_integrations", "analytics_dashboard", "white_label", "role_management"]');

-- Indexes for performance
CREATE INDEX idx_school_subscriptions_school_id ON school_subscriptions(school_id);
CREATE INDEX idx_school_subscriptions_status ON school_subscriptions(status) WHERE status = 'active';

-- Add subscription-related columns to schools table
ALTER TABLE schools ADD COLUMN IF NOT EXISTS max_students INTEGER;