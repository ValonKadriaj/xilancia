CREATE DATABASE IF NOT EXISTS xilancia;
USE xilancia;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100),
    email VARCHAR(150) NOT NULL UNIQUE,
    password TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

DELIMITER $$

-- Create user procedure
CREATE PROCEDURE create_user(
    IN p_first_name VARCHAR(100),
    IN p_last_name VARCHAR(100),
    IN p_email VARCHAR(150),
    IN p_password TEXT
)
BEGIN
    INSERT INTO users (first_name, last_name, email, password, created_at, updated_at)
    VALUES (p_first_name, p_last_name, p_email, p_password, NOW(), NOW());
END$$

-- Get user by ID
CREATE PROCEDURE get_user_by_id(IN p_id INT)
BEGIN
    SELECT * FROM users WHERE id = p_id;
END$$

-- Get all users with pagination
CREATE PROCEDURE get_all_users(IN in_offset INT, IN in_limit INT)
BEGIN
    SELECT * FROM users
    LIMIT in_limit OFFSET in_offset;
END$$

-- Update user
CREATE PROCEDURE update_user(
    IN p_id INT,
    IN p_first_name VARCHAR(100),
    IN p_last_name VARCHAR(100),
    IN p_email VARCHAR(150),
    IN p_password TEXT
)
BEGIN
    UPDATE users
    SET first_name = p_first_name,
        last_name = p_last_name,
        email = p_email,
        password = p_password,
        updated_at = NOW()
    WHERE id = p_id;
END$$

-- Delete user
CREATE PROCEDURE delete_user(IN p_id INT)
BEGIN
    DELETE FROM users WHERE id = p_id;
END$$

DELIMITER ;
