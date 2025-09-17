-- ScholaPro Subscription Management Schema
CREATE TABLE subscription_plans (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    max_students INTEGER,
    features JSONB NOT NULL DEFAULT '{}',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE school_subscriptions (
    id SERIAL PRIMARY KEY,
    school_id INTEGER REFERENCES schools(id),
    plan_id INTEGER REFERENCES subscription_plans(id),
    status VARCHAR(20) NOT NULL DEFAULT 'active',
    start_date DATE NOT NULL DEFAULT CURRENT_DATE,
    end_date DATE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT valid_status CHECK (status IN ('active', 'pending', 'cancelled', 'expired'))
);

-- Insert default subscription plans
INSERT INTO subscription_plans (name, description, price, max_students, features) VALUES
('Free', 'Basic SIS functionality', 0, 50, '{"features": ["core_sis", "basic_gradebook", "attendance"]}'),
('Bronze', 'Enhanced features for small schools', 99.99, 200, '{"features": ["core_sis", "basic_gradebook", "attendance", "scheduling", "parent_portal"]}'),
('Silver', 'Advanced features for growing schools', 199.99, NULL, '{"features": ["core_sis", "basic_gradebook", "attendance", "scheduling", "parent_portal", "billing", "discipline", "reporting", "basic_api"]}'),
('Gold', 'Premium features for large institutions', 299.99, NULL, '{"features": ["core_sis", "basic_gradebook", "attendance", "scheduling", "parent_portal", "billing", "discipline", "reporting", "basic_api", "custom_reports", "integrations", "analytics", "white_label"]}');