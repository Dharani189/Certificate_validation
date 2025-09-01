-- Certificate Validation Database Setup
-- Run this script in phpMyAdmin or MySQL command line

CREATE DATABASE IF NOT EXISTS ycore_certificates;
USE ycore_certificates;

-- Create certificates table
CREATE TABLE IF NOT EXISTS certificates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    certificate_id VARCHAR(20) UNIQUE NOT NULL,
    student_name VARCHAR(100) NOT NULL,
    course_name VARCHAR(100) NOT NULL,
    issue_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO certificates (certificate_id, student_name, course_name, issue_date) VALUES
('CERT001', 'John Doe', 'Web Development', '2024-01-15'),
('CERT002', 'Jane Smith', 'Data Science', '2024-02-20'),
('CERT003', 'Mike Johnson', 'Digital Marketing', '2024-03-10'),
('CERT004', 'Sarah Wilson', 'Cybersecurity', '2024-04-05'),
('CERT005', 'David Brown', 'Cloud Computing', '2024-05-12'),
('CERT006', 'Emily Davis', 'Machine Learning', '2024-06-18'),
('CERT007', 'Robert Taylor', 'Mobile App Development', '2024-07-22'),
('CERT008', 'Lisa Anderson', 'UI/UX Design', '2024-08-14'),
('CERT009', 'James Wilson', 'DevOps Engineering', '2024-09-01'),
('CERT010', 'Maria Garcia', 'Blockchain Technology', '2024-01-30');

-- Create index for faster searches
CREATE INDEX idx_certificate_search ON certificates (certificate_id, student_name, course_name);
CREATE INDEX idx_issue_date ON certificates (issue_date);
