CREATE OR REPLACE PROCEDURE register_patient(
    p_email VARCHAR,
    p_password TEXT,
    p_dob DATE,
    p_gender VARCHAR
)
LANGUAGE plpgsql
AS $$
DECLARE
    _user_id INT;  -- Declare the variable here
BEGIN
    -- Start transaction
    BEGIN
        INSERT INTO users (email, password_hash, role)
        VALUES (p_email, crypt(p_password, gen_salt('bf')), 'patient')
        RETURNING user_id INTO _user_id;  -- no STRICT needed here

        INSERT INTO patients (user_id, date_of_birth, gender)
        VALUES (_user_id, p_dob, p_gender);

        COMMIT;
    EXCEPTION
        WHEN OTHERS THEN
            ROLLBACK;
            RAISE;
    END;
END;
$$;
