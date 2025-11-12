/**
 * SQL Sample Data
 * UIUArchive - Built by UIU Minds
 * Run this after database.sql to populate with sample data
 */

USE uiuarchive;

-- Sample Users
INSERT INTO users (username, full_name, email, password, department, semester, bio, role) VALUES
('ahmed_rahman', 'Ahmed Rahman', 'ahmed.rahman@student.uiu.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'CSE', 'Spring 2025', 'Passionate about AI and Machine Learning', 'student'),
('fatima_khan', 'Fatima Khan', 'fatima.khan@student.uiu.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'CSE', 'Spring 2025', 'Web developer and UI/UX enthusiast', 'student'),
('rafiul_islam', 'Rafiul Islam', 'rafiul.islam@student.uiu.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'EEE', 'Fall 2024', 'IoT and Robotics researcher', 'student'),
('tasnim_akter', 'Tasnim Akter', 'tasnim.akter@student.uiu.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'CSE', 'Spring 2025', 'Blockchain and Web3 developer', 'student'),
('dr_mohammad', 'Dr. Mohammad Ali', 'mohammad.ali@uiu.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'CSE', NULL, 'Professor of Computer Science', 'faculty');

-- Sample Projects
INSERT INTO projects (user_id, title, description, abstract, category, department, semester, github_link, demo_link, visibility, is_featured, likes_count, views_count, comments_count) VALUES
(1, 'AI-Powered Student Assistant Chatbot', 'An intelligent chatbot designed to help UIU students with course information, campus navigation, and academic queries using natural language processing.', 'This project implements a conversational AI system using TensorFlow and NLTK to assist students with university-related questions.', 'AI', 'CSE', 'Spring 2025', 'https://github.com/example/ai-chatbot', 'https://demo.example.com/chatbot', 'public', 1, 45, 230, 12),

(2, 'UIU Campus Navigator Mobile App', 'A cross-platform mobile application that helps students and visitors navigate the UIU campus with AR-powered directions and real-time location tracking.', 'Built with React Native and ARKit/ARCore, this app provides an interactive campus map with augmented reality features.', 'MobileApp', 'CSE', 'Spring 2025', 'https://github.com/example/campus-nav', NULL, 'public', 1, 38, 185, 8),

(3, 'Smart Attendance System using IoT', 'An automated attendance tracking system using RFID and facial recognition to streamline the attendance process in classrooms.', 'This IoT solution combines RFID readers and OpenCV-based facial recognition for accurate and efficient attendance management.', 'IoT', 'EEE', 'Fall 2024', 'https://github.com/example/smart-attendance', NULL, 'public', 0, 52, 298, 15),

(4, 'Decentralized Student Records on Blockchain', 'A blockchain-based system for storing and verifying student academic records securely and transparently using Ethereum smart contracts.', 'Implemented using Solidity and Web3.js, this system ensures tamper-proof academic credentials that can be verified globally.', 'Blockchain', 'CSE', 'Spring 2025', 'https://github.com/example/blockchain-records', 'https://demo.example.com/records', 'public', 1, 67, 412, 18),

(2, 'E-Learning Platform UI/UX Design', 'A complete UI/UX design system for a modern e-learning platform with focus on accessibility and user experience.', 'Designed in Figma with comprehensive user research, wireframes, prototypes, and usability testing documentation.', 'Design', 'CSE', 'Spring 2025', NULL, 'https://figma.com/example', 'public', 0, 29, 145, 6);

-- Sample Tags (already inserted in database.sql, but link them to projects)
INSERT INTO project_tags (project_id, tag_id) VALUES
(1, 3), (1, 4), -- AI, MachineLearning
(2, 2), (2, 15), -- MobileApp, AR/VR
(3, 5), (3, 16), -- IoT, Robotics
(4, 12), (4, 13), -- Blockchain, CyberSecurity
(5, 7), (5, 8); -- Design, UI/UX

-- Sample Likes
INSERT INTO likes (user_id, project_id) VALUES
(1, 3), (1, 4), (1, 5),
(2, 1), (2, 3), (2, 4),
(3, 1), (3, 2), (3, 4),
(4, 1), (4, 2), (4, 3);

-- Sample Comments
INSERT INTO comments (user_id, project_id, comment_text) VALUES
(2, 1, 'This is an amazing project! The NLP implementation is really impressive.'),
(3, 1, 'Great work! Have you considered adding voice recognition?'),
(1, 2, 'Love the AR features! This would be really helpful for new students.'),
(4, 3, 'Very practical solution. How accurate is the facial recognition?'),
(2, 4, 'Blockchain for academic records is brilliant! This could revolutionize education.'),
(1, 4, 'Excellent implementation of smart contracts. Very secure!');

-- Sample Events
INSERT INTO events (event_name, event_description, event_type, event_date, event_time, location, organizer_id, is_active) VALUES
('UIU Hackathon 2025', 'A 48-hour hackathon for building innovative solutions to campus problems', 'hackathon', '2025-12-15', '09:00:00', 'UIU Main Campus', 5, 1),
('AI & ML Workshop Series', 'Weekly workshop series covering fundamentals of artificial intelligence and machine learning', 'workshop', '2025-11-20', '14:00:00', 'CSE Lab 301', 5, 1),
('Project Showcase Competition', 'Semester-end competition to showcase the best student projects', 'competition', '2025-12-01', '10:00:00', 'UIU Auditorium', 5, 1),
('Tech Expo 2025', 'Annual technology exhibition featuring student innovations and industry partners', 'expo', '2025-12-10', '10:00:00', 'UIU Campus Ground', 5, 1);

-- Sample Follows
INSERT INTO follows (user_id, project_id) VALUES
(1, 3), (1, 4),
(2, 1), (2, 4),
(3, 1), (3, 2),
(4, 2), (4, 3);

-- Award some badges to users
INSERT INTO user_badges (user_id, badge_id) VALUES
(1, 1), (1, 2), (1, 8), -- First Project, Rising Star, Early Adopter
(2, 1), (2, 8), -- First Project, Early Adopter
(3, 1), (3, 2), (3, 8), -- First Project, Rising Star, Early Adopter
(4, 1), (4, 2), (4, 6), (4, 8); -- First Project, Rising Star, Faculty Favorite, Early Adopter

-- Sample Notifications
INSERT INTO notifications (user_id, type, message, related_id, is_read) VALUES
(1, 'like', 'Ahmed Rahman liked your project "Smart Attendance System using IoT"', 3, 0),
(2, 'comment', 'Rafiul Islam commented on your project "AI-Powered Student Assistant Chatbot"', 1, 0),
(3, 'endorsed', 'Your project has been endorsed by Dr. Mohammad Ali', 3, 0),
(4, 'featured', 'Your project "Decentralized Student Records on Blockchain" has been featured!', 4, 0),
(1, 'badge', 'You earned the "Rising Star" badge!', 2, 0);

-- Update tag usage counts
UPDATE tags SET usage_count = usage_count + 1 WHERE tag_id IN (3, 4);
UPDATE tags SET usage_count = usage_count + 1 WHERE tag_id IN (2, 15);
UPDATE tags SET usage_count = usage_count + 1 WHERE tag_id IN (5, 16);
UPDATE tags SET usage_count = usage_count + 1 WHERE tag_id IN (12, 13);
UPDATE tags SET usage_count = usage_count + 1 WHERE tag_id IN (7, 8);
