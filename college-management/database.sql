-- =====================================================
-- College Management System - Database Schema
-- For XAMPP / MySQL
-- =====================================================
-- Steps:
-- 1. Open phpMyAdmin (http://localhost/phpmyadmin)
-- 2. Click "New" and create a database named: college_db
-- 3. Select the database -> Import -> choose this file
-- =====================================================

CREATE DATABASE IF NOT EXISTS college_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE college_db;

-- ----------------------------
-- Students table
-- ----------------------------
DROP TABLE IF EXISTS students;
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    roll_no VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15),
    password VARCHAR(255) NOT NULL,
    course VARCHAR(50) NOT NULL,
    year VARCHAR(10) NOT NULL,
    address TEXT,
    dob DATE,
    gender ENUM('Male','Female','Other') DEFAULT 'Male',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ----------------------------
-- Teachers table
-- ----------------------------
DROP TABLE IF EXISTS teachers;
CREATE TABLE teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15),
    password VARCHAR(255) NOT NULL,
    department VARCHAR(50) NOT NULL,
    designation VARCHAR(50),
    qualification VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ----------------------------
-- Notices table
-- ----------------------------
DROP TABLE IF EXISTS notices;
CREATE TABLE notices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    target_audience ENUM('All','Students','Teachers') DEFAULT 'All',
    course VARCHAR(50) DEFAULT NULL,
    posted_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (posted_by) REFERENCES teachers(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ----------------------------
-- Events table
-- ----------------------------
DROP TABLE IF EXISTS events;
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME,
    venue VARCHAR(200),
    posted_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (posted_by) REFERENCES teachers(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ----------------------------
-- Syllabus table
-- ----------------------------
DROP TABLE IF EXISTS syllabus;
CREATE TABLE syllabus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course VARCHAR(50) NOT NULL,
    year VARCHAR(10) NOT NULL,
    subject VARCHAR(100) NOT NULL,
    description TEXT,
    file_path VARCHAR(255),
    uploaded_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES teachers(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ----------------------------
-- Fees table
-- ----------------------------
DROP TABLE IF EXISTS fees;
CREATE TABLE fees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    fee_type VARCHAR(100) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    paid_amount DECIMAL(10,2) DEFAULT 0.00,
    due_date DATE,
    status ENUM('Pending','Partial','Paid') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ----------------------------
-- Examination table
-- ----------------------------
DROP TABLE IF EXISTS examinations;
CREATE TABLE examinations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    exam_name VARCHAR(100) NOT NULL,
    course VARCHAR(50) NOT NULL,
    year VARCHAR(10) NOT NULL,
    subject VARCHAR(100) NOT NULL,
    exam_date DATE NOT NULL,
    exam_time TIME NOT NULL,
    duration VARCHAR(20),
    venue VARCHAR(100),
    posted_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (posted_by) REFERENCES teachers(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ----------------------------
-- Timetable table
-- ----------------------------
DROP TABLE IF EXISTS timetable;
CREATE TABLE timetable (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course VARCHAR(50) NOT NULL,
    year VARCHAR(10) NOT NULL,
    day_of_week ENUM('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') NOT NULL,
    period_no INT NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    subject VARCHAR(100) NOT NULL,
    teacher_id INT,
    room_no VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- =====================================================
-- Sample data
-- =====================================================
-- Default teacher login:
--   Email:    admin@college.edu
--   Password: admin123
--
-- Default student login:
--   Email:    student@college.edu
--   Password: student123
-- =====================================================

INSERT INTO teachers (employee_id, name, email, phone, password, department, designation, qualification) VALUES
('EMP001', 'Dr. Rajesh Sharma', 'admin@college.edu', '9876543210', '$2y$10$ZyIYxWCbveVP2pUhawXL2uavb8MyZ8IHJ7ujfW0F1Gww3xpZnrnBm', 'Computer Science', 'Principal', 'Ph.D Computer Science'),
('EMP002', 'Prof. Priya Patel', 'priya@college.edu', '9876543211', '$2y$10$ZyIYxWCbveVP2pUhawXL2uavb8MyZ8IHJ7ujfW0F1Gww3xpZnrnBm', 'Mathematics', 'HOD', 'M.Sc Mathematics'),
('EMP003', 'Prof. Amit Kumar', 'amit@college.edu', '9876543212', '$2y$10$ZyIYxWCbveVP2pUhawXL2uavb8MyZ8IHJ7ujfW0F1Gww3xpZnrnBm', 'Physics', 'Assistant Professor', 'M.Sc Physics');

-- All sample passwords are: admin123
INSERT INTO students (roll_no, name, email, phone, password, course, year, address, dob, gender) VALUES
('BCA001', 'Rahul Verma', 'student@college.edu', '9123456780', '$2y$10$ZyIYxWCbveVP2pUhawXL2uavb8MyZ8IHJ7ujfW0F1Gww3xpZnrnBm', 'BCA', '1st Year', 'Pune, Maharashtra', '2005-06-15', 'Male'),
('BCA002', 'Sneha Joshi', 'sneha@college.edu', '9123456781', '$2y$10$ZyIYxWCbveVP2pUhawXL2uavb8MyZ8IHJ7ujfW0F1Gww3xpZnrnBm', 'BCA', '2nd Year', 'Mumbai, Maharashtra', '2004-04-22', 'Female'),
('BBA001', 'Arjun Singh', 'arjun@college.edu', '9123456782', '$2y$10$ZyIYxWCbveVP2pUhawXL2uavb8MyZ8IHJ7ujfW0F1Gww3xpZnrnBm', 'BBA', '1st Year', 'Nagpur, Maharashtra', '2005-08-10', 'Male');

INSERT INTO notices (title, description, target_audience, course, posted_by) VALUES
('College Annual Day Celebration', 'All students and faculty are cordially invited to participate in the Annual Day celebration on 15th May. Cultural programs, prize distribution and dinner will be organised.', 'All', NULL, 1),
('Mid-Term Examination Schedule', 'Mid-term examinations for all courses will commence from 1st June. Detailed timetable available on the examination page.', 'Students', NULL, 1),
('Library Closed Notice', 'The college library will remain closed on 10th May for maintenance work. Students are requested to plan accordingly.', 'All', NULL, 2);

INSERT INTO events (title, description, event_date, event_time, venue, posted_by) VALUES
('TechFest 2026', 'Annual technical festival featuring coding competitions, robotics, hackathon and tech talks by industry experts.', '2026-05-20', '09:00:00', 'Main Auditorium', 1),
('Sports Week', 'Inter-department sports competition including cricket, football, basketball and athletics.', '2026-06-05', '08:00:00', 'College Sports Ground', 2),
('Industrial Visit', 'Educational visit to TCS Pune campus for BCA final year students.', '2026-05-28', '08:30:00', 'TCS Pune Campus', 1);

INSERT INTO syllabus (course, year, subject, description, uploaded_by) VALUES
('BCA', '1st Year', 'C Programming', 'Introduction to C, variables, control structures, functions, arrays, pointers, structures, file handling.', 1),
('BCA', '1st Year', 'Mathematics-I', 'Set theory, relations, functions, matrices, determinants, calculus basics.', 2),
('BCA', '2nd Year', 'Data Structures', 'Arrays, linked lists, stacks, queues, trees, graphs, sorting and searching algorithms.', 1),
('BBA', '1st Year', 'Business Communication', 'Principles of communication, business letters, report writing, presentation skills.', 1);

INSERT INTO fees (student_id, fee_type, amount, paid_amount, due_date, status) VALUES
(1, 'Tuition Fee - Semester 1', 25000.00, 25000.00, '2025-08-15', 'Paid'),
(1, 'Tuition Fee - Semester 2', 25000.00, 10000.00, '2026-01-15', 'Partial'),
(1, 'Library Fee', 2000.00, 0.00, '2026-05-30', 'Pending'),
(2, 'Tuition Fee - Semester 3', 25000.00, 25000.00, '2025-08-15', 'Paid'),
(2, 'Tuition Fee - Semester 4', 25000.00, 0.00, '2026-01-15', 'Pending');

INSERT INTO examinations (exam_name, course, year, subject, exam_date, exam_time, duration, venue, posted_by) VALUES
('Mid-Term Exam', 'BCA', '1st Year', 'C Programming', '2026-06-01', '10:00:00', '3 Hours', 'Hall A-101', 1),
('Mid-Term Exam', 'BCA', '1st Year', 'Mathematics-I', '2026-06-03', '10:00:00', '3 Hours', 'Hall A-101', 1),
('Mid-Term Exam', 'BCA', '2nd Year', 'Data Structures', '2026-06-02', '14:00:00', '3 Hours', 'Hall B-201', 1),
('Mid-Term Exam', 'BBA', '1st Year', 'Business Communication', '2026-06-04', '10:00:00', '3 Hours', 'Hall C-301', 1);

INSERT INTO timetable (course, year, day_of_week, period_no, start_time, end_time, subject, teacher_id, room_no) VALUES
('BCA', '1st Year', 'Monday', 1, '09:00:00', '10:00:00', 'C Programming', 1, 'A-101'),
('BCA', '1st Year', 'Monday', 2, '10:00:00', '11:00:00', 'Mathematics-I', 2, 'A-101'),
('BCA', '1st Year', 'Monday', 3, '11:15:00', '12:15:00', 'Physics', 3, 'A-101'),
('BCA', '1st Year', 'Tuesday', 1, '09:00:00', '10:00:00', 'Mathematics-I', 2, 'A-101'),
('BCA', '1st Year', 'Tuesday', 2, '10:00:00', '11:00:00', 'C Programming', 1, 'A-101'),
('BCA', '1st Year', 'Wednesday', 1, '09:00:00', '10:00:00', 'Physics', 3, 'A-101'),
('BCA', '1st Year', 'Wednesday', 2, '10:00:00', '11:00:00', 'C Programming Lab', 1, 'Lab-1');
