SELECT column_name, data_type
FROM information_schema.columns
WHERE table_name = 'users';
ALTER TABLE users
ADD COLUMN IF NOT EXISTS first_name VARCHAR(100),
ADD COLUMN IF NOT EXISTS last_name VARCHAR(100),
ADD COLUMN IF NOT EXISTS phone VARCHAR(15),
ADD COLUMN IF NOT EXISTS nic VARCHAR(12);
CREATE OR REPLACE FUNCTION get_full_name(p_email VARCHAR)
RETURNS TEXT AS $$
DECLARE
  f_name VARCHAR;
  l_name VARCHAR;
BEGIN
  SELECT first_name, last_name INTO f_name, l_name
  FROM users
  WHERE email = p_email;

  RETURN COALESCE(f_name, '') || ' ' || COALESCE(l_name, '');
END;
$$ LANGUAGE plpgsql;
CREATE OR REPLACE FUNCTION validate_nic()
RETURNS TRIGGER AS $$
BEGIN
  IF NEW.nic IS NOT NULL AND LENGTH(NEW.nic) < 10 THEN
    RAISE EXCEPTION 'NIC must be at least 10 characters';
  END IF;
  IF NEW.nic IS NOT NULL THEN
    NEW.nic := UPPER(NEW.nic);
  END IF;
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;
DROP TRIGGER IF EXISTS trg_validate_nic ON users;
CREATE TRIGGER trg_validate_nic
BEFORE INSERT OR UPDATE ON users
FOR EACH ROW EXECUTE FUNCTION validate_nic();
CREATE OR REPLACE PROCEDURE register_user(
  p_first_name VARCHAR,
  p_last_name VARCHAR,
  p_phone VARCHAR,
  p_nic VARCHAR,
  p_email VARCHAR,
  p_password_hash TEXT,
  p_role VARCHAR -- e.g., 'admin', 'counselor', 'patient'
)
LANGUAGE plpgsql
AS $$
BEGIN
  BEGIN
    INSERT INTO users (first_name, last_name, phone, nic, email, password_hash, role, created_at)
    VALUES (p_first_name, p_last_name, p_phone, p_nic, p_email, p_password_hash, p_role, CURRENT_TIMESTAMP);
    COMMIT;
  EXCEPTION WHEN OTHERS THEN
    ROLLBACK;
    RAISE;
  END;
END;
$$;
-- 5. INDEXES
CREATE UNIQUE INDEX IF NOT EXISTS idx_users_email ON users(email);
CREATE UNIQUE INDEX IF NOT EXISTS idx_users_nic ON users(nic);
-- 6. DB ROLES & PRIVILEGES 
CREATE ROLE admin_role NOLOGIN;
CREATE ROLE counselor_role NOLOGIN;
CREATE ROLE patient_role NOLOGIN;

GRANT SELECT, INSERT, UPDATE, DELETE ON users TO admin_role;
GRANT SELECT, INSERT, UPDATE ON users TO counselor_role;
GRANT SELECT ON users TO patient_role;

-- Create DB users
CREATE USER admin_user WITH PASSWORD 'AdminPass123';
CREATE USER counselor_user WITH PASSWORD 'CounselorPass123';
CREATE USER patient_user WITH PASSWORD 'PatientPass123';

-- Assign roles to users
GRANT admin_role TO admin_user;
GRANT counselor_role TO counselor_user;
GRANT patient_role TO patient_user;



