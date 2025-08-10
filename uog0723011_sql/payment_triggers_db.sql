DROP TRIGGER IF EXISTS trg_check_payment_amount ON payment;

CREATE TRIGGER trg_check_payment_amount
BEFORE INSERT ON payment
FOR EACH ROW
EXECUTE FUNCTION check_payment_amount();
-- STORED PROCEDURES (with Transactions)
-- ================================

-- Process Online Payment
CREATE OR REPLACE PROCEDURE process_online_payment(
    p_user_id INT,
    p_amount NUMERIC
)
LANGUAGE plpgsql
AS $$
DECLARE
    v_payment_id INT;
BEGIN
    BEGIN
        -- Insert payment
        INSERT INTO payment(user_id, payment_method_id, amount, status)
        VALUES (p_user_id, 1, p_amount, 'Completed')
        RETURNING payment_id INTO v_payment_id;

        -- Insert into transaction log
        INSERT INTO transaction_log(payment_id, log_message)
        VALUES (v_payment_id, 'Online payment processed successfully');

        COMMIT;
    EXCEPTION
        WHEN OTHERS THEN
            ROLLBACK;
            RAISE;
    END;
END;
$$;

-- Process Bank Slip Payment
CREATE OR REPLACE PROCEDURE process_bank_slip_payment(
    p_user_id INT,
    p_amount NUMERIC,
    p_file_path TEXT
)
LANGUAGE plpgsql
AS $$
DECLARE
    v_payment_id INT;
BEGIN
    BEGIN
        -- Insert payment
        INSERT INTO payment(user_id, payment_method_id, amount, status)
        VALUES (p_user_id, 2, p_amount, 'Pending')
        RETURNING payment_id INTO v_payment_id;

        -- Insert bank slip
        INSERT INTO bank_slip(payment_id, file_path)
        VALUES (v_payment_id, p_file_path);

        -- Insert transaction log
        INSERT INTO transaction_log(payment_id, log_message)
        VALUES (v_payment_id, 'Bank slip uploaded, awaiting approval');

        COMMIT;
    EXCEPTION
        WHEN OTHERS THEN
            ROLLBACK;
            RAISE;
    END;
END;
$$;

-- INDEXING
-- ================================
CREATE INDEX idx_payment_method_id ON payment(payment_method_id);
CREATE INDEX idx_payment_status ON payment(status);
