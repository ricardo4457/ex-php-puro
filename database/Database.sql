-- Create the database
CREATE DATABASE employee_management;

-- Select the database
USE employee_management;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Profiles table
CREATE TABLE profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    birthdate DATE,
    phone VARCHAR(20),
    profile_photo VARCHAR(255), -- Path to the profile photo
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Files table
CREATE TABLE files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL, -- Path to the file on the server
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert a test user (password: "123456" hashed)
INSERT INTO users (email, password)
VALUES (
    'john.doe@example.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' -- Hash for "123456"
);

-- Insert the test user's profile
INSERT INTO profiles (user_id, name, birthdate, phone)
VALUES (
    1, -- ID of the user inserted above
    'John Doe',
    '1985-05-15',
    '912345678'
);