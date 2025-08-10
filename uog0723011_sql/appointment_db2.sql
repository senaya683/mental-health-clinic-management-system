CREATE OR REPLACE PROCEDURE sp_create_appointment(
    p_user_id INT,
    p_medium_id INT,
    p_language_id INT,
    p_preferred_datetime TIMESTAMP,
    p_duration_minutes INT,
    p_customer_type VARCHAR,
    p_title VARCHAR,
    p_nic VARCHAR,
    p_first_name VARCHAR,
    p_last_name VARCHAR,
    p_email VARCHAR,
    p_phone VARCHAR,
    p_display_name VARCHAR,
    p_terms_agreed BOOLEAN,
    p_purposes INT[]
)
LANGUAGE plpgsql
AS $$
DECLARE
    v_appointment_id INT;
    p INT;  -- declare the loop variable here
BEGIN
    BEGIN
        -- Start transaction block
        INSERT INTO appointment(user_id, medium_id, language_id, preferred_datetime, duration_minutes, customer_type,
                                title, nic, first_name, last_name, email, phone, display_name, terms_agreed, status)
        VALUES (p_user_id, p_medium_id, p_language_id, p_preferred_datetime, p_duration_minutes, p_customer_type,
                p_title, p_nic, p_first_name, p_last_name, p_email, p_phone, p_display_name, p_terms_agreed, 'Pending')
        RETURNING appointment_id INTO v_appointment_id;

        -- Insert purposes mapping
        IF p_purposes IS NOT NULL THEN
            FOREACH p IN ARRAY p_purposes LOOP
                INSERT INTO appointment_purpose_map(appointment_id, purpose_id)
                VALUES (v_appointment_id, p);
            END LOOP;
        END IF;

        COMMIT;
    EXCEPTION
        WHEN OTHERS THEN
            ROLLBACK;
            RAISE;
    END;
END;
$$;

-- 5. INDEXING APPLICATIONS
-- ===========================

-- Primary keys already have indexes automatically.

-- Add secondary indexes for frequent queries:
CREATE INDEX IF NOT EXISTS idx_appointment_user_id ON appointment(user_id);
CREATE INDEX IF NOT EXISTS idx_appointment_preferred_datetime ON appointment(preferred_datetime);
CREATE INDEX IF NOT EXISTS idx_appointment_status ON appointment(status);
