CREATE DATABASE IF NOT EXISTS sb_admin_ecommerce CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sb_admin_ecommerce;

-- جدول المستخدمين
CREATE TABLE IF NOT EXISTS users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    full_name   VARCHAR(100) NOT NULL,
    email       VARCHAR(150) NOT NULL UNIQUE,
    phone       VARCHAR(20) DEFAULT NULL,
    password    VARCHAR(255) NOT NULL,
    role        ENUM('admin','merchant','user') NOT NULL DEFAULT 'user',
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- جدول Remember Me Tokens
CREATE TABLE IF NOT EXISTS remember_tokens (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT NOT NULL,
    selector    VARCHAR(255) NOT NULL,
    token_hash  VARCHAR(255) NOT NULL,
    expires_at  DATETIME NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
