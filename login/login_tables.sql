-- Users Table (common login)
CREATE TABLE users (
    user_id SERIAL PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash TEXT NOT NULL,
    role VARCHAR(20) CHECK (role IN ('admin', 'counselor', 'patient')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Counselors Table
CREATE TABLE counselors (
    counselor_id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(user_id) ON DELETE CASCADE,
    specialty VARCHAR(100),
    experience_years INT CHECK (experience_years >= 0)
);

-- Patients Table
CREATE TABLE patients (
    patient_id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(user_id) ON DELETE CASCADE,
    date_of_birth DATE,
    gender VARCHAR(10) CHECK (gender IN ('Male', 'Female', 'Other'))
);

-- Login Logs
CREATE TABLE login_logs (
    log_id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(user_id) ON DELETE CASCADE,
    login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    success BOOLEAN
);
CREATE EXTENSION IF NOT EXISTS pgcrypto;

-- Function to check login credentials
CREATE OR REPLACE FUNCTION check_login(p_email VARCHAR, p_password TEXT)
RETURNS BOOLEAN AS $$
DECLARE
    stored_hash TEXT;
BEGIN
    SELECT password_hash INTO stored_hash
    FROM users
    WHERE email = p_email;

    IF stored_hash IS NULL THEN
        RETURN FALSE;
    END IF;

    -- For real-world use, replace with proper hashing comparison
    IF stored_hash = crypt(p_password, stored_hash) THEN
        RETURN TRUE;
    ELSE
        RETURN FALSE;
    END IF;
END;
$$ LANGUAGE plpgsql;

-- Function to calculate counselor's total years of experience
CREATE OR REPLACE FUNCTION total_counselor_experience()
RETURNS INT AS $$
DECLARE
    total_exp INT;
BEGIN
    SELECT SUM(experience_years) INTO total_exp FROM counselors;
    RETURN COALESCE(total_exp, 0);
END;
$$ LANGUAGE plpgsql;
-- Function to check login credentials
CREATE OR REPLACE FUNCTION check_login(p_email VARCHAR, p_password TEXT)
RETURNS BOOLEAN AS $$
DECLARE
    stored_hash TEXT;
BEGIN
    SELECT password_hash INTO stored_hash
    FROM users
    WHERE email = p_email;

    IF stored_hash IS NULL THEN
        RETURN FALSE;
    END IF;

    -- For real-world use, replace with proper hashing comparison
    IF stored_hash = crypt(p_password, stored_hash) THEN
        RETURN TRUE;
    ELSE
        RETURN FALSE;
    END IF;
END;
$$ LANGUAGE plpgsql;

-- Function to calculate counselor's total years of experience
CREATE OR REPLACE FUNCTION total_counselor_experience()
RETURNS INT AS $$
DECLARE
    total_exp INT;
BEGIN
    SELECT SUM(experience_years) INTO total_exp FROM counselors;
    RETURN COALESCE(total_exp, 0);
END;
$$ LANGUAGE plpgsql;

