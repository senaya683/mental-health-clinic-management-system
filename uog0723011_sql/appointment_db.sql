CREATE TABLE IF NOT EXISTS appointment_medium (
    medium_id SERIAL PRIMARY KEY,
    medium_name VARCHAR(50) UNIQUE NOT NULL
);
CREATE TABLE IF NOT EXISTS appointment_language (
    language_id SERIAL PRIMARY KEY,
    language_name VARCHAR(50) UNIQUE NOT NULL
);
CREATE TABLE IF NOT EXISTS appointment_purpose (
    purpose_id SERIAL PRIMARY KEY,
    purpose_name VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS appointment (
    appointment_id SERIAL PRIMARY KEY,
    user_id INT NOT NULL,  -- Assuming a foreign key to your existing user table
    medium_id INT NOT NULL REFERENCES appointment_medium(medium_id),
    language_id INT NOT NULL REFERENCES appointment_language(language_id),
    preferred_datetime TIMESTAMP NOT NULL,
    duration_minutes INT NOT NULL CHECK (duration_minutes > 0),
    customer_type VARCHAR(50) NOT NULL CHECK (customer_type IN ('Personal', 'Corporate Sponsored')),
    title VARCHAR(10) NOT NULL,
    nic VARCHAR(12) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    display_name VARCHAR(100),
    terms_agreed BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'Pending'
);


CREATE TABLE IF NOT EXISTS appointment_purpose_map (
    appointment_id INT NOT NULL REFERENCES appointment(appointment_id) ON DELETE CASCADE,
    purpose_id INT NOT NULL REFERENCES appointment_purpose(purpose_id),
    PRIMARY KEY (appointment_id, purpose_id)
);
CREATE OR REPLACE FUNCTION calculate_appointment_end(preferred_start TIMESTAMP, duration_min INT)
RETURNS TIMESTAMP AS $$
BEGIN
    RETURN preferred_start + (duration_min || ' minutes')::INTERVAL;
END;
$$ LANGUAGE plpgsql;
-- 3. TRIGGER FUNCTION to check valid NIC and agreement before insert
-- ===========================

CREATE OR REPLACE FUNCTION trg_check_appointment()
RETURNS TRIGGER AS $$
BEGIN
    -- Check NIC format: simple regex for 9 digits + v/V/x/X or 12 digits
    IF NOT (NEW.nic ~ '^[0-9]{9}[vVxX]$' OR NEW.nic ~ '^[0-9]{12}$') THEN
        RAISE EXCEPTION 'Invalid NIC format';
    END IF;

    -- Check terms agreed
    IF NEW.terms_agreed IS FALSE THEN
        RAISE EXCEPTION 'You must agree to the Terms & Conditions';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_check_appointment_before_insert
BEFORE INSERT ON appointment
FOR EACH ROW
EXECUTE FUNCTION trg_check_appointment();