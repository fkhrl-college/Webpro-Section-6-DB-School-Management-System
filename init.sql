CREATE DATABASE IF NOT EXISTS db_school;
USE db_school;

-- 1) Majors table
CREATE TABLE IF NOT EXISTS majors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- Seed majors
INSERT INTO majors (name)
VALUES
    ('Informatics'),
    ('Information Systems'),
    ('Computer Science')
ON DUPLICATE KEY UPDATE name = VALUES(name);

-- 2) Students table
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    major_id INT NOT NULL,
    CONSTRAINT fk_students_major
        FOREIGN KEY (major_id) REFERENCES majors(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

-- 3) Sample students
INSERT INTO students (nim, name, major_id)
VALUES
    ('2301001', 'Andi Pratama', 1),
    ('2301002', 'Siti Rahma', 2),
    ('2301003', 'Budi Santoso', 1),
    ('2301004', 'Dewi Lestari', 3)
ON DUPLICATE KEY UPDATE
    name = VALUES(name),
    major_id = VALUES(major_id);

-- 4) Users table for login
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff') NOT NULL DEFAULT 'staff'
);

-- Seed users from seed_admin.php