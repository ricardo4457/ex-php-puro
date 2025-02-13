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
    'ricardo.vieira@example.com',
    SHA2('123456', 256)
);

-- Insert the test user's profile
INSERT INTO profiles (user_id, name, birthdate, phone)
VALUES (
    1, -- ID do utilizador inserido acima
    'Ricardo Vieira',
    '2003-01-14',
    '912345678'
);