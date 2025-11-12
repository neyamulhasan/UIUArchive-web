/**
 * Comprehensive Sample Data for UIUArchive - Fixed Version
 * UIUArchive - Built by UIU Minds
 */

USE uiuarchive;

-- Clear existing data first
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE notifications;
TRUNCATE TABLE follows;
TRUNCATE TABLE likes;
TRUNCATE TABLE project_tags;
TRUNCATE TABLE project_media;
TRUNCATE TABLE projects;
TRUNCATE TABLE tags;
TRUNCATE TABLE events;
TRUNCATE TABLE users;
SET FOREIGN_KEY_CHECKS = 1;

-- Reset auto increment
ALTER TABLE users AUTO_INCREMENT = 1;
ALTER TABLE projects AUTO_INCREMENT = 1;
ALTER TABLE tags AUTO_INCREMENT = 1;

-- Insert 7 realistic users
INSERT INTO users (username, full_name, email, password, department, semester, bio, role, theme_color) VALUES
('ahmed_ai', 'Ahmed Rahman', 'ahmed.rahman@student.uiu.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'CSE', 'Spring 2024', 'AI enthusiast specializing in machine learning and deep learning.', 'student', '#3B82F6'),
('fatima_dev', 'Fatima Khan', 'fatima.khan@student.uiu.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'CSE', 'Fall 2023', 'Full-stack developer passionate about web technologies.', 'student', '#EC4899'),
('rafiq_iot', 'Rafiq Islam', 'rafiq.islam@student.uiu.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'EEE', 'Spring 2024', 'IoT and embedded systems specialist.', 'student', '#10B981'),
('sadia_design', 'Sadia Akter', 'sadia.akter@student.uiu.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'CSE', 'Summer 2024', 'UI/UX designer and frontend developer.', 'student', '#9333EA'),
('hassan_cyber', 'Hassan Ahmed', 'hassan.ahmed@student.uiu.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'CSE', 'Fall 2023', 'Cybersecurity researcher focusing on blockchain technology.', 'student', '#EF4444'),
('nusrat_data', 'Nusrat Jahan', 'nusrat.jahan@student.uiu.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'CSE', 'Spring 2024', 'Data scientist specializing in big data analytics.', 'student', '#F59E0B'),
('karim_robotics', 'Karim Uddin', 'karim.uddin@student.uiu.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'EEE', 'Fall 2023', 'Robotics engineer working on autonomous systems.', 'student', '#14B8A6');

-- Insert comprehensive tags
INSERT INTO tags (tag_name) VALUES
('AI'), ('MachineLearning'), ('DeepLearning'), ('NeuralNetworks'), ('DataScience'), 
('BigData'), ('DataAnalytics'), ('CloudComputing'), ('CyberSecurity'), ('Blockchain'),
('IoT'), ('WebDevelopment'), ('AppDevelopment'), ('MobileApp'), ('ARVR'),
('GameDevelopment'), ('NLP'), ('ComputerVision'), ('ImageProcessing'), ('Chatbot'),
('Automation'), ('SoftwareEngineering'), ('DatabaseManagement'), ('DevOps'), ('FullStack'),
('UIUX'), ('ReinforcementLearning'), ('EdgeComputing'), ('VirtualAssistant'), ('DigitalTwin'),
('Arduino'), ('RaspberryPi'), ('EmbeddedSystems'), ('IoTDevices'), ('Microcontrollers'),
('PowerElectronics'), ('ControlSystems'), ('SignalProcessing'), ('WirelessCommunication'), ('Robotics'),
('SensorNetworks'), ('SmartGrid'), ('RenewableEnergy'), ('SolarEnergy'), ('ElectricalAutomation'),
('IndustrialElectronics'), ('VLSI'), ('FPGA'), ('PCBDesign'), ('ElectromechanicalSystems'),
('Instrumentation'), ('DigitalSystems'), ('AnalogCircuits'), ('ResearchPaper'), ('FinalYearProject'),
('MiniProject'), ('CapstoneProject'), ('Innovation'), ('Prototype'), ('AcademicShowcase'),
('STEM'), ('TechExhibition'), ('OpenSource'), ('HackathonProject'), ('JavaScript'),
('Python'), ('React'), ('NodeJS'), ('MySQL'), ('MongoDB'), ('TensorFlow'), ('PyTorch');

-- Insert projects using only required fields to avoid column mismatch
INSERT INTO projects (user_id, title, description, category, department, semester, github_link, demo_link) VALUES
-- Ahmed's AI Projects (5)
(1, 'Bengali Handwriting Recognition System', 'Advanced OCR system using deep learning for Bengali text recognition with 94% accuracy.', 'AI', 'CSE', 'Spring 2024', 'https://github.com/ahmed-ai/bengali-ocr', 'https://bengali-ocr-demo.herokuapp.com'),
(1, 'Smart Traffic Management System', 'Real-time traffic optimization using computer vision and reinforcement learning.', 'AI', 'CSE', 'Spring 2024', 'https://github.com/ahmed-ai/smart-traffic', NULL),
(1, 'Medical Diagnosis Assistant', 'Deep learning model for disease detection from medical images with 91% accuracy.', 'AI', 'CSE', 'Spring 2024', 'https://github.com/ahmed-ai/medical-ai', 'https://medical-ai-demo.vercel.app'),
(1, 'Bengali Sentiment Analysis', 'NLP model analyzing sentiment in Bengali social media posts.', 'AI', 'CSE', 'Spring 2024', 'https://github.com/ahmed-ai/bengali-sentiment', NULL),
(1, 'Reinforcement Learning Gaming AI', 'RL agent mastering arcade games using Deep Q-Networks.', 'AI', 'CSE', 'Spring 2024', 'https://github.com/ahmed-ai/rl-gaming', 'https://rl-demo.netlify.app'),

-- Fatima's Web/Mobile Projects (5)
(2, 'UIU Student Portal Redesign', 'Modern redesign of UIU portal with improved UX and real-time features.', 'WebApp', 'CSE', 'Fall 2023', 'https://github.com/fatima-dev/uiu-portal-v2', 'https://uiu-portal-redesign.vercel.app'),
(2, 'E-Commerce with AI Recommendations', 'Full-stack e-commerce with ML recommendations and payment integration.', 'WebApp', 'CSE', 'Fall 2023', 'https://github.com/fatima-dev/smart-ecommerce', 'https://smart-shop-bd.herokuapp.com'),
(2, 'Campus Food Delivery App', 'React Native app for UIU campus food delivery with real-time tracking.', 'MobileApp', 'CSE', 'Fall 2023', 'https://github.com/fatima-dev/campus-food', NULL),
(2, 'Local Business Directory PWA', 'Progressive web app connecting local businesses with customers.', 'WebApp', 'CSE', 'Fall 2023', 'https://github.com/fatima-dev/biz-directory', 'https://localbiz-bd.netlify.app'),
(2, 'Social Learning Platform', 'Interactive platform for student collaboration and knowledge sharing.', 'WebApp', 'CSE', 'Fall 2023', 'https://github.com/fatima-dev/social-learn', 'https://studypal-bd.vercel.app'),

-- Rafiq's IoT Projects (5)
(3, 'Smart Home Automation System', 'Comprehensive IoT solution for home automation using ESP32 and Arduino.', 'IoT', 'EEE', 'Spring 2024', 'https://github.com/rafiq-iot/smart-home', NULL),
(3, 'Industrial IoT Monitoring', 'Real-time industrial equipment monitoring with predictive maintenance.', 'IoT', 'EEE', 'Spring 2024', 'https://github.com/rafiq-iot/industry-monitor', 'https://industry-iot-dashboard.herokuapp.com'),
(3, 'Smart Agriculture with Drones', 'IoT crop monitoring system with autonomous drone surveillance.', 'IoT', 'EEE', 'Spring 2024', 'https://github.com/rafiq-iot/agri-drone', NULL),
(3, 'Campus Energy Management', 'Smart grid solution for university energy optimization.', 'IoT', 'EEE', 'Spring 2024', 'https://github.com/rafiq-iot/campus-energy', 'https://energy-dashboard.uiu.ac.bd'),
(3, 'Environmental Sensor Network', 'Large-scale sensor deployment for air quality monitoring.', 'IoT', 'EEE', 'Spring 2024', 'https://github.com/rafiq-iot/env-monitoring', 'https://env-monitor.netlify.app'),

-- Sadia's Design Projects (4)
(4, 'Digital Design System for Startups', 'UI/UX design system tailored for Bangladeshi startups.', 'Design', 'CSE', 'Summer 2024', 'https://github.com/sadia-design/bd-design-system', 'https://bd-design-system.figma.com'),
(4, 'AR/VR Educational Interfaces', 'Innovative 3D interfaces for immersive educational experiences.', 'Design', 'CSE', 'Summer 2024', 'https://github.com/sadia-design/arvr-edu-ui', 'https://arvr-edu-demo.unity.com'),
(4, 'Rural Banking App Interface', 'User-centered banking interface design for rural Bangladesh.', 'Design', 'CSE', 'Summer 2024', 'https://github.com/sadia-design/rural-banking-ui', NULL),
(4, 'Educational Gamification Framework', 'Gamification design patterns for learning applications.', 'Design', 'CSE', 'Summer 2024', 'https://github.com/sadia-design/edu-gamification', 'https://edu-game-demo.vercel.app'),

-- Hassan's Cybersecurity/Blockchain Projects (4)
(5, 'Blockchain Academic Credentials', 'Decentralized credential verification using Ethereum smart contracts.', 'Blockchain', 'CSE', 'Fall 2023', 'https://github.com/hassan-cyber/blockchain-credentials', 'https://edu-blockchain.netlify.app'),
(5, 'Cybersecurity Threat Detection', 'ML-powered intrusion detection system with 96% accuracy.', 'CyberSecurity', 'CSE', 'Fall 2023', 'https://github.com/hassan-cyber/threat-detection', NULL),
(5, 'Decentralized Identity Management', 'Self-sovereign identity solution using blockchain technology.', 'Blockchain', 'CSE', 'Fall 2023', 'https://github.com/hassan-cyber/did-system', 'https://did-demo.herokuapp.com'),
(5, 'Smart Contract Vulnerability Scanner', 'Automated security vulnerability detection for smart contracts.', 'Blockchain', 'CSE', 'Fall 2023', 'https://github.com/hassan-cyber/contract-scanner', 'https://contract-security.vercel.app'),

-- Nusrat's Data Science Projects (4)
(6, 'Traffic Big Data Analytics', 'Processes millions of traffic data points for Dhaka optimization.', 'DataScience', 'CSE', 'Spring 2024', 'https://github.com/nusrat-data/traffic-bigdata', 'https://traffic-analytics.herokuapp.com'),
(6, 'Healthcare Data Mining', 'Disease prediction from health records with 89% accuracy.', 'DataScience', 'CSE', 'Spring 2024', 'https://github.com/nusrat-data/health-mining', NULL),
(6, 'Social Media Sentiment Analytics', 'Real-time sentiment analysis of 1M+ daily social posts.', 'DataScience', 'CSE', 'Spring 2024', 'https://github.com/nusrat-data/social-sentiment', 'https://sentiment-dashboard.netlify.app'),
(6, 'Climate Prediction Models', 'ML models for Bangladesh climate change prediction.', 'DataScience', 'CSE', 'Spring 2024', 'https://github.com/nusrat-data/climate-ml', 'https://climate-predictor.vercel.app'),

-- Karim's Robotics Projects (3)
(7, 'Autonomous Campus Delivery Robot', 'Self-navigating robot for campus delivery using LIDAR and vision.', 'Robotics', 'EEE', 'Fall 2023', 'https://github.com/karim-robotics/delivery-bot', NULL),
(7, 'AI-Powered Industrial Robotic Arm', '6-DOF arm with computer vision for manufacturing quality control.', 'Robotics', 'EEE', 'Fall 2023', 'https://github.com/karim-robotics/ai-robotic-arm', 'https://robot-demo.uiu.ac.bd'),
(7, 'Smart Warehouse Automation', 'Complete automation with multiple robots and IoT sensors.', 'Automation', 'EEE', 'Fall 2023', 'https://github.com/karim-robotics/smart-warehouse', 'https://warehouse-automation.herokuapp.com');

-- Update view counts and like counts manually
UPDATE projects SET views_count = 456, likes_count = 0 WHERE project_id = 1;
UPDATE projects SET views_count = 342, likes_count = 0 WHERE project_id = 2;
UPDATE projects SET views_count = 578, likes_count = 0 WHERE project_id = 3;
UPDATE projects SET views_count = 298, likes_count = 0 WHERE project_id = 4;
UPDATE projects SET views_count = 234, likes_count = 0 WHERE project_id = 5;
UPDATE projects SET views_count = 689, likes_count = 0 WHERE project_id = 6;
UPDATE projects SET views_count = 523, likes_count = 0 WHERE project_id = 7;
UPDATE projects SET views_count = 445, likes_count = 0 WHERE project_id = 8;
UPDATE projects SET views_count = 367, likes_count = 0 WHERE project_id = 9;
UPDATE projects SET views_count = 398, likes_count = 0 WHERE project_id = 10;
UPDATE projects SET views_count = 534, likes_count = 0 WHERE project_id = 11;
UPDATE projects SET views_count = 423, likes_count = 0 WHERE project_id = 12;
UPDATE projects SET views_count = 387, likes_count = 0 WHERE project_id = 13;
UPDATE projects SET views_count = 456, likes_count = 0 WHERE project_id = 14;
UPDATE projects SET views_count = 298, likes_count = 0 WHERE project_id = 15;
UPDATE projects SET views_count = 423, likes_count = 0 WHERE project_id = 16;
UPDATE projects SET views_count = 356, likes_count = 0 WHERE project_id = 17;
UPDATE projects SET views_count = 445, likes_count = 0 WHERE project_id = 18;
UPDATE projects SET views_count = 289, likes_count = 0 WHERE project_id = 19;
UPDATE projects SET views_count = 567, likes_count = 0 WHERE project_id = 20;
UPDATE projects SET views_count = 434, likes_count = 0 WHERE project_id = 21;
UPDATE projects SET views_count = 389, likes_count = 0 WHERE project_id = 22;
UPDATE projects SET views_count = 312, likes_count = 0 WHERE project_id = 23;
UPDATE projects SET views_count = 478, likes_count = 0 WHERE project_id = 24;
UPDATE projects SET views_count = 523, likes_count = 0 WHERE project_id = 25;
UPDATE projects SET views_count = 367, likes_count = 0 WHERE project_id = 26;
UPDATE projects SET views_count = 445, likes_count = 0 WHERE project_id = 27;
UPDATE projects SET views_count = 598, likes_count = 0 WHERE project_id = 28;
UPDATE projects SET views_count = 456, likes_count = 0 WHERE project_id = 29;
UPDATE projects SET views_count = 423, likes_count = 0 WHERE project_id = 30;

-- Add project tags (multiple tags per project)
INSERT INTO project_tags (project_id, tag_id) VALUES
-- Ahmed's Projects (AI focus)
(1, 1), (1, 2), (1, 3), (1, 17), (1, 18), (1, 66), (1, 69), (1, 54), (1, 55),
(2, 1), (2, 18), (2, 27), (2, 21), (2, 5), (2, 66), (2, 69),
(3, 1), (3, 2), (3, 3), (3, 18), (3, 54), (3, 69), (3, 55),
(4, 1), (4, 17), (4, 2), (4, 5), (4, 66), (4, 69), (4, 55),
(5, 1), (5, 27), (5, 16), (5, 2), (5, 69), (5, 55),

-- Fatima's Projects (Web/Mobile focus)
(6, 12), (6, 25), (6, 26), (6, 65), (6, 67), (6, 69), (6, 22), (6, 55),
(7, 12), (7, 25), (7, 1), (7, 2), (7, 65), (7, 67), (7, 69), (7, 55),
(8, 13), (8, 14), (8, 65), (8, 67), (8, 26),
(9, 12), (9, 25), (9, 8), (9, 65), (9, 67), (9, 55),
(10, 12), (10, 25), (10, 26), (10, 65), (10, 67), (10, 55),

-- Rafiq's Projects (IoT focus)
(11, 11), (11, 31), (11, 32), (11, 34), (11, 21), (11, 40), (11, 55),
(12, 11), (12, 33), (12, 34), (12, 41), (12, 51), (12, 2),
(13, 11), (13, 31), (13, 32), (13, 40), (13, 41), (13, 18), (13, 21),
(14, 11), (14, 42), (14, 43), (14, 33), (14, 41), (14, 5),
(15, 11), (15, 33), (15, 41), (15, 38), (15, 39), (15, 51),

-- Sadia's Projects (Design focus)
(16, 26), (16, 12), (16, 25), (16, 58), (16, 59), (16, 61),
(17, 26), (17, 15), (17, 16), (17, 58), (17, 59), (17, 61),
(18, 26), (18, 14), (18, 58), (18, 59), (18, 61),
(19, 26), (19, 16), (19, 58), (19, 59), (19, 61),

-- Hassan's Projects (Security/Blockchain focus)
(20, 10), (20, 9), (20, 22), (20, 66), (20, 55), (20, 58), (20, 61),
(21, 9), (21, 1), (21, 2), (21, 22), (21, 66), (21, 61),
(22, 10), (22, 9), (22, 22), (22, 55), (22, 61),
(23, 10), (23, 9), (23, 22), (23, 66), (23, 55), (23, 61),

-- Nusrat's Projects (Data Science focus)
(24, 5), (24, 6), (24, 7), (24, 2), (24, 66), (24, 70), (24, 55), (24, 61),
(25, 5), (25, 6), (25, 7), (25, 2), (25, 55), (25, 61),
(26, 5), (26, 6), (26, 7), (26, 17), (26, 2), (26, 55), (26, 61),
(27, 5), (27, 6), (27, 7), (27, 2), (27, 55), (27, 61),

-- Karim's Projects (Robotics focus)
(28, 40), (28, 21), (28, 18), (28, 1), (28, 31), (28, 32), (28, 55),
(29, 40), (29, 21), (29, 18), (29, 1), (29, 59), (29, 55),
(30, 21), (30, 40), (30, 11), (30, 33), (30, 55), (30, 61);

-- Add realistic likes
INSERT INTO likes (user_id, project_id) VALUES
-- Popular projects get more likes
(2, 1), (3, 1), (4, 1), (5, 1), (6, 1), (7, 1),
(1, 6), (3, 6), (4, 6), (5, 6), (6, 6), (7, 6),
(1, 11), (2, 11), (4, 11), (5, 11), (6, 11), (7, 11),
(1, 20), (2, 20), (3, 20), (4, 20), (6, 20), (7, 20),
(1, 28), (2, 28), (3, 28), (4, 28), (5, 28), (6, 28),

-- Medium popularity
(2, 3), (4, 3), (5, 3), (6, 3),
(1, 7), (3, 7), (5, 7), (6, 7),
(2, 12), (4, 12), (6, 12), (7, 12),
(1, 16), (2, 16), (3, 16), (5, 16),
(2, 24), (3, 24), (4, 24), (5, 24),

-- Lower popularity
(2, 2), (4, 2), (6, 2),
(1, 4), (3, 4), (5, 4),
(2, 5), (4, 5), (6, 5),
(1, 8), (3, 8), (5, 8),
(2, 9), (4, 9), (6, 9),
(1, 10), (3, 10), (5, 10);

-- Add follows
INSERT INTO follows (user_id, project_id) VALUES
(2, 1), (3, 1), (4, 1),
(1, 6), (3, 6), (5, 6),
(1, 11), (2, 11), (4, 11),
(2, 16), (3, 16), (6, 16),
(1, 20), (2, 20), (4, 20),
(1, 24), (2, 24), (3, 24),
(2, 28), (3, 28), (4, 28);

-- Add notifications
INSERT INTO notifications (user_id, type, message, related_id, is_read) VALUES
(1, 'like', 'Fatima Khan liked your project "Bengali Handwriting Recognition System"', 1, 0),
(1, 'like', 'Rafiq Islam liked your project "Smart Traffic Management System"', 2, 0),
(1, 'follow', 'Sadia Akter started following your project "Medical Diagnosis Assistant"', 3, 1),
(2, 'like', 'Ahmed Rahman liked your project "UIU Student Portal Redesign"', 6, 0),
(2, 'follow', 'Hassan Ahmed started following your project "E-Commerce with AI Recommendations"', 7, 1),
(3, 'like', 'Nusrat Jahan liked your project "Smart Home Automation System"', 11, 0),
(5, 'like', 'Fatima Khan liked your project "Blockchain Academic Credentials"', 20, 0),
(6, 'follow', 'Hassan Ahmed started following your project "Traffic Big Data Analytics"', 24, 1),
(7, 'like', 'Sadia Akter liked your project "Autonomous Campus Delivery Robot"', 28, 0);

-- Update like counts for projects
UPDATE projects SET likes_count = (SELECT COUNT(*) FROM likes WHERE likes.project_id = projects.project_id);

-- Update tag usage counts
UPDATE tags SET usage_count = (SELECT COUNT(*) FROM project_tags WHERE project_tags.tag_id = tags.tag_id);

COMMIT;

SELECT 'Database successfully populated with 7 users and 30 comprehensive projects!' AS Status;