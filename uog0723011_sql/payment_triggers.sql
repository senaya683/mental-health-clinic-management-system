-- Trigger Function to Check Positive Amount
CREATE OR REPLACE FUNCTION check_payment_amount()
RETURNS TRIGGER
LANGUAGE plpgsql
AS $$
BEGIN
    IF NEW.amount <= 0 THEN
        RAISE EXCEPTION 'Payment amount must be greater than zero';
    END IF;

    -- Auto calculate fields
    NEW.service_charge := calculate_service_charge(NEW.amount);
    NEW.tax := calculate_tax(NEW.amount);
    NEW.total_amount := calculate_total_payment(NEW.amount);

    RETURN NEW;
END;
$$;

-- Create Trigger
CREATE TRIGGER trg_check_payment_amount
BEFORE INSERT ON payment
FOR EACH ROW
EXECUTE FUNCTION check_payment_amount();

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

DROP TRIGGER IF EXISTS trg_check_payment_amount ON payment;

CREATE TRIGGER trg_check_payment_amount
BEFORE INSERT ON payment
FOR EACH ROW
EXECUTE FUNCTION check_payment_amount();
