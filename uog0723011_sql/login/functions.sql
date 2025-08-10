CREATE EXTENSION IF NOT EXISTS pgcrypto;
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

    IF stored_hash = crypt(p_password, stored_hash) THEN
        RETURN TRUE;
    ELSE
        RETURN FALSE;
    END IF;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION total_counselor_experience()
RETURNS INT AS $$
DECLARE
    total_exp INT;
BEGIN
    SELECT SUM(experience_years) INTO total_exp FROM counselors;
    RETURN COALESCE(total_exp, 0);
END;
$$ LANGUAGE plpgsql;
