-- Trigger Function to block underage patients (must be >= 13 years)
CREATE OR REPLACE FUNCTION check_patient_age()
RETURNS TRIGGER AS $$
BEGIN
    IF DATE_PART('year', AGE(NEW.date_of_birth)) < 13 THEN
        RAISE EXCEPTION 'Patient must be at least 13 years old.';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Apply Trigger to Patients Table
CREATE TRIGGER trg_check_patient_age
BEFORE INSERT OR UPDATE ON patients
FOR EACH ROW
EXECUTE FUNCTION check_patient_age();
