-- Roles for appointment module
DO $$
BEGIN
    IF NOT EXISTS (SELECT 1 FROM pg_roles WHERE rolname = 'appointment_admin') THEN
        CREATE ROLE appointment_admin;
    END IF;

    IF NOT EXISTS (SELECT 1 FROM pg_roles WHERE rolname = 'appointment_user') THEN
        CREATE ROLE appointment_user;
    END IF;
END;
$$;

-- Create example users (adjust password hashes accordingly in production)
-- Note: You likely already have a user table; this is just role/user creation for DB login roles

DO $$
BEGIN
    IF NOT EXISTS (SELECT 1 FROM pg_roles WHERE rolname = 'app_admin_user') THEN
        CREATE USER app_admin_user WITH PASSWORD 'strongpassword1';
        GRANT appointment_admin TO app_admin_user;
    END IF;

    IF NOT EXISTS (SELECT 1 FROM pg_roles WHERE rolname = 'app_user1') THEN
        CREATE USER app_user1 WITH PASSWORD 'strongpassword2';
        GRANT appointment_user TO app_user1;
    END IF;
END;
$$;

-- Grant privileges on appointment-related tables to roles
GRANT SELECT, INSERT, UPDATE, DELETE ON appointment TO appointment_admin, appointment_user;
GRANT SELECT, INSERT, UPDATE, DELETE ON appointment_purpose_map TO appointment_admin, appointment_user;
GRANT SELECT ON appointment_medium, appointment_language, appointment_purpose TO appointment_admin, appointment_user;