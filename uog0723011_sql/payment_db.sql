DROP TABLE IF EXISTS bank_slip CASCADE;
DROP TABLE IF EXISTS transaction_log CASCADE;
DROP TABLE IF EXISTS payment CASCADE;
DROP TABLE IF EXISTS payment_method CASCADE;
-- Payment Method Table
CREATE TABLE payment_method (
    payment_method_id SERIAL PRIMARY KEY,
    method_name VARCHAR(50) UNIQUE NOT NULL
);
-- Payment Table
CREATE TABLE payment (
    payment_id SERIAL PRIMARY KEY,
    user_id INT NOT NULL, -- Linked to registration table (FK not enforced here)
    payment_method_id INT NOT NULL REFERENCES payment_method(payment_method_id),
    amount NUMERIC(10,2) NOT NULL,
    service_charge NUMERIC(10,2),
    tax NUMERIC(10,2),
    total_amount NUMERIC(10,2),
    status VARCHAR(20) DEFAULT 'Pending',
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Bank Slip Table
CREATE TABLE bank_slip (
    slip_id SERIAL PRIMARY KEY,
    payment_id INT NOT NULL REFERENCES payment(payment_id) ON DELETE CASCADE,
    file_path TEXT NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Transaction Log Table
CREATE TABLE transaction_log (
    transaction_id SERIAL PRIMARY KEY,
    payment_id INT NOT NULL REFERENCES payment(payment_id) ON DELETE CASCADE,
    log_message TEXT NOT NULL,
    log_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Calculate Service Charge (2%)
CREATE OR REPLACE FUNCTION calculate_service_charge(amount NUMERIC)
RETURNS NUMERIC AS $$
BEGIN
    RETURN ROUND(amount * 0.02, 2);
END;
$$ LANGUAGE plpgsql;

-- Calculate Tax (8%)
CREATE OR REPLACE FUNCTION calculate_tax(amount NUMERIC)
RETURNS NUMERIC AS $$
BEGIN
    RETURN ROUND(amount * 0.08, 2);
END;
$$ LANGUAGE plpgsql;

-- Calculate Total Payment
CREATE OR REPLACE FUNCTION calculate_total_payment(amount NUMERIC)
RETURNS NUMERIC AS $$
BEGIN
    RETURN ROUND(amount + calculate_service_charge(amount) + calculate_tax(amount), 2);
END;
$$ LANGUAGE plpgsql;

-- TRIGGERS (Validation)
-- ================================

-- Trigger Function to Check Positive Amount
CREATE OR REPLACE FUNCTION check_payment_amount()
RETURNS TRIGGER AS $$
BEGIN
    IF NEW.amount <= 0 THEN
        RAISE EXCEPTION 'Payment amount must be greater than zero';
    END IF;

	-- TRIGGERS (Validation)
-- ================================

-- Trigger Function to Check Positive Amount
CREATE OR REPLACE FUNCTION check_payment_amount()
RETURNS TRIGGER AS $$
BEGIN
    IF NEW.amount <= 0 THEN
        RAISE EXCEPTION 'Payment amount must be greater than zero';
    END IF;

    -- Auto calculate fields
    NEW.service_charge := calculate_service_charge(NEW.amount);
    NEW.tax := calculate_tax(NEW.amount);
    NEW.total_amount := calculate_total_payment(NEW.amount);

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;
