<?php
/**
 * Configuration File
 * UIUArchive - Built by UIU Minds
 */

// Site Configuration
define('SITE_NAME', 'UIUArchive');
define('SITE_MOTTO', 'Built by UIU Minds');
define('SITE_URL', 'http://localhost/UIUArchive-web');
define('BASE_URL', 'http://localhost/UIUArchive-web'); // Base URL for links and resources
define('SITE_EMAIL', 'info@uiuarchive.com');

// Path Configuration
define('ROOT_PATH', dirname(__DIR__));
define('UPLOAD_PATH', ROOT_PATH . '/uploads/');
define('ASSETS_PATH', ROOT_PATH . '/assets/');

// Upload Settings
define('MAX_FILE_SIZE', 10485760); // 10MB in bytes
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
define('ALLOWED_VIDEO_TYPES', ['mp4', 'webm', 'ogg']);
define('ALLOWED_DOCUMENT_TYPES', ['pdf', 'doc', 'docx', 'ppt', 'pptx']);

// Pagination
define('PROJECTS_PER_PAGE', 12);
define('NOTIFICATIONS_PER_PAGE', 15);

// Session Configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS

// Timezone
date_default_timezone_set('Asia/Dhaka');

// Error Reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Categories
$categories = [
    'WebApp' => 'Web Application',
    'MobileApp' => 'Mobile Application',
    'AI' => 'Artificial Intelligence',
    'MachineLearning' => 'Machine Learning',
    'IoT' => 'Internet of Things',
    'Hardware' => 'Hardware',
    'Design' => 'Design',
    'UI/UX' => 'UI/UX Design',
    'Research' => 'Research',
    'DataScience' => 'Data Science',
    'GameDev' => 'Game Development',
    'Blockchain' => 'Blockchain',
    'CyberSecurity' => 'Cyber Security',
    'CloudComputing' => 'Cloud Computing',
    'AR/VR' => 'AR/VR',
    'Robotics' => 'Robotics'
];

// Departments
$departments = [
    'CSE' => 'Computer Science & Engineering',
    'EEE' => 'Electrical & Electronic Engineering',
    'CE' => 'Civil Engineering',
    'BBA' => 'Business Administration',
    'Economics' => 'Economics',
    'LLB' => 'Law',
    'English' => 'English',
    'Other' => 'Other'
];

// Semesters
$semesters = [
    'Spring 2025',
    'Fall 2024',
    'Summer 2024',
    'Spring 2024',
    'Fall 2023',
    'Summer 2023'
];

// Profile Theme Colors
$themeColors = [
    '#3B82F6' => 'Blue',
    '#9333EA' => 'Purple',
    '#10B981' => 'Green',
    '#EF4444' => 'Red',
    '#F59E0B' => 'Orange',
    '#EC4899' => 'Pink',
    '#14B8A6' => 'Teal',
    '#8B5CF6' => 'Violet'
];
?>
