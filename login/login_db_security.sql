DO $$
BEGIN
   IF EXISTS (SELECT 1 FROM pg_roles WHERE rolname = 'admin_role') THEN
       REVOKE ALL PRIVILEGES ON ALL TABLES IN SCHEMA public FROM admin_role;
   END IF;
   IF EXISTS (SELECT 1 FROM pg_roles WHERE rolname = 'counselor_role') THEN
       REVOKE ALL PRIVILEGES ON counselors, login_logs FROM counselor_role;
   END IF;
   IF EXISTS (SELECT 1 FROM pg_roles WHERE rolname = 'patient_role') THEN
       REVOKE ALL PRIVILEGES ON patients FROM patient_role;
   END IF;
END $$;

DROP ROLE IF EXISTS admin_role;
DROP ROLE IF EXISTS counselor_role;
DROP ROLE IF EXISTS patient_role;

DROP USER IF EXISTS admin_user;
DROP USER IF EXISTS counselor_user;
DROP USER IF EXISTS patient_user;

CREATE ROLE admin_role;
CREATE ROLE counselor_role;
CREATE ROLE patient_role;

CREATE USER admin_user WITH PASSWORD 'admin123';
CREATE USER counselor_user WITH PASSWORD 'counselor123';
CREATE USER patient_user WITH PASSWORD 'patient123';

GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO admin_role;
GRANT SELECT, INSERT, UPDATE ON counselors, login_logs TO counselor_role;
GRANT SELECT, INSERT, UPDATE ON patients TO patient_role;

GRANT admin_role TO admin_user;
GRANT counselor_role TO counselor_user;
GRANT patient_role TO patient_user;


