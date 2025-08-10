-- Create roles only if they don't exist
DO $$
BEGIN
   IF NOT EXISTS (SELECT FROM pg_catalog.pg_roles WHERE rolname = 'admin_role') THEN
      CREATE ROLE admin_role NOLOGIN;
   END IF;
   IF NOT EXISTS (SELECT FROM pg_catalog.pg_roles WHERE rolname = 'counselor_role') THEN
      CREATE ROLE counselor_role NOLOGIN;
   END IF;
   IF NOT EXISTS (SELECT FROM pg_catalog.pg_roles WHERE rolname = 'patient_role') THEN
      CREATE ROLE patient_role NOLOGIN;
   END IF;
END
$$;


GRANT SELECT, INSERT, UPDATE, DELETE ON users TO admin_role;
GRANT SELECT, INSERT, UPDATE ON users TO counselor_role;
GRANT SELECT ON users TO patient_role;

DO $$
BEGIN
   IF NOT EXISTS (SELECT FROM pg_catalog.pg_user WHERE usename = 'admin_user') THEN
      CREATE USER admin_user WITH PASSWORD 'AdminPass123';
   END IF;
   IF NOT EXISTS (SELECT FROM pg_catalog.pg_user WHERE usename = 'counselor_user') THEN
      CREATE USER counselor_user WITH PASSWORD 'CounselorPass123';
   END IF;
   IF NOT EXISTS (SELECT FROM pg_catalog.pg_user WHERE usename = 'patient_user') THEN
      CREATE USER patient_user WITH PASSWORD 'PatientPass123';
   END IF;
END
$$;

-- Assign roles to users
GRANT admin_role TO admin_user;
GRANT counselor_role TO counselor_user;
GRANT patient_role TO patient_user;
