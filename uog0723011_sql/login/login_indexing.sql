-- Primary indexes already in place via PRIMARY KEY
-- Secondary indexes
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_login_logs_user_id ON login_logs(user_id);
