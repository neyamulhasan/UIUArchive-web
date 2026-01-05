# UIUArchive

A web platform for United International University students to showcase academic, creative, and technical projects.

## Overview

UIUArchive is a project repository system that enables students to upload and share their work. Students can create profiles, upload projects with documentation and media, and engage with other students through likes, comments, and project follows. Faculty members have the ability to endorse and highlight outstanding student work.

## Features

**User Management**
- User registration and authentication via university email
- Student profile pages with project history
- Profile customization options

**Project Management**
- Project upload and management system
- Support for multiple file types (documents, images, videos)
- Tagging and categorization system
- Project search and filtering capabilities

**Social Features**
- Project rating and feedback system
- User engagement through likes and comments
- Project following functionality
- Trending project discovery

**Additional Capabilities**
- Faculty endorsement system
- Privacy controls (public/private)
- User notification system
- Event calendar for competitions and workshops

## Technology Stack

**Frontend**
- HTML5, CSS3, JavaScript
- Tailwind CSS
- Alpine.js

**Backend**
- PHP 7.4+
- Session-based authentication
- Password hashing

**Database**
- MySQL 5.7+

**Security**
- Password hashing using bcrypt
- SQL injection prevention with prepared statements
- XSS protection
- CSRF protection
- Session security

## Project Structure

```
UIUArchive-web/
├── assets/                   # Static assets
│   ├── css/                  # Stylesheets
│   ├── js/                   # JavaScript files
│   └── images/               # Image assets
├── includes/                 # Shared PHP includes
│   ├── header.php
│   ├── footer.php
│   ├── db.php
│   └── functions.php
├── pages/                    # Application pages
├── uploads/                  # User uploaded files
├── sql/                      # Database schema
└── README.md
```

## Installation

**Prerequisites**
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server
- XAMPP or equivalent local development environment

**Setup Instructions**

1. Navigate to the project directory:
   ```bash
   cd /opt/lampp/htdocs/UIUArchive-web
   ```

2. Start Apache and MySQL services via XAMPP

3. Create database and import schema:
   - Access phpMyAdmin at `http://localhost/phpmyadmin`
   - Create new database: `uiuarchive`
   - Import `sql/database.sql`

4. Configure database connection in `includes/db.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'uiuarchive');
   ```

5. Set directory permissions:
   ```bash
   chmod 755 /opt/lampp/htdocs/UIUArchive-web
   chmod 777 /opt/lampp/htdocs/UIUArchive-web/uploads
   ```

6. Access application:
   Navigate to `http://localhost/UIUArchive-web/pages/`

## Database Schema

Primary tables include:
- `users` - User accounts and profiles
- `projects` - Project information and metadata
- `project_media` - Associated project files
- `tags` - Project categorization
- `project_tags` - Project-tag relationships
- `likes` - Project engagement
- `comments` - User feedback
- `follows` - Project subscriptions
- `notifications` - User notifications

## Usage

**For Students**
1. Register with university email
2. Complete profile setup
3. Upload projects
4. Engage with community projects
5. Participate in competitions

**For Faculty**
1. Register using faculty email
2. Browse student projects
3. Endorse outstanding work
4. Organize events and competitions

## Security

The application implements standard security practices:
- Bcrypt password hashing
- Prepared statements for SQL injection prevention
- Input validation and output encoding for XSS protection
- CSRF token validation
- Secure session management
- File upload validation

## Deployment

The application can be deployed to standard web hosting providers supporting PHP and MySQL. Database credentials should be updated in `includes/db.php` with hosting provider information.

## License

This project is developed for educational purposes at United International University.
