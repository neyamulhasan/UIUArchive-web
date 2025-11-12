# UIUArchive - Built by UIU Minds 🎓

![UIUArchive Banner](assets/images/banner.png)

## 📖 Overview

**UIUArchive** is a web platform designed for United International University (UIU) students to showcase their academic, creative, and technical projects. Students can upload various types of projects including web applications, software, IoT devices, artwork, or research posters. The platform enables other students to view, like, comment, and follow projects, while faculty members can endorse or highlight outstanding work.

**Motto:** Built by UIU Minds

## ✨ Core Features

### User Management
- 🔐 **User Registration & Login** - Students register using university email with secure authentication
- 👤 **Profile Pages** - Display student information, uploaded projects, badges, and activity
- 🎨 **Profile Customization** - Custom themes, banners, and colors

### Project Management
- 📤 **Project Upload/Submission** - Submit projects with title, description, category, tags, images/videos, GitHub/demo links
- 🖼️ **Project Gallery/Feed** - Browse projects in card/grid layout, sortable by date, popularity, or department
- 🔍 **Search & Filter** - Filter by department, semester, category, or keyword
- 📄 **PDF/Slide Upload** - Support for reports and presentations
- 📝 **Project Abstract/Summary** - Easy-to-read project overviews

### Social Features
- ❤️ **Likes & Comments** - React and provide feedback on projects
- 🏷️ **Tags/Categories** - Easy navigation with tags like #WebApp, #AI, #Design
- 👥 **Follow Projects** - Stay updated on projects you're interested in
- 🔥 **Trending/Featured Projects** - Discover popular and highlighted work

### Advanced Features
- 👨‍🏫 **Faculty Endorsement** - Faculty can endorse and highlight outstanding projects
- 🔒 **Privacy Controls** - Public/Private visibility options
- 🔗 **Portfolio Export** - Generate shareable portfolio links
- 🔔 **Notifications System** - Get notified about likes, comments, and featured projects
- 📊 **Analytics Dashboard** - Track uploads, top contributors, and trending categories
- 🏆 **Badges & Gamification** - Earn badges for achievements
- 📅 **Event Calendar** - Workshops, hackathons, and expos
- 🏆 **Project Challenges/Competitions** - Participate in competitions

## 🛠️ Tech Stack

### Frontend
- HTML5, CSS3, JavaScript (Vanilla JS)
- Tailwind CSS for responsive design
- Font Awesome for icons
- Alpine.js for interactive components

### Backend
- PHP (Basic, no frameworks)
- Session-based authentication
- Password hashing with `password_hash()`
- Input validation and SQL injection prevention

### Database
- MySQL
- Tables for users, projects, comments, likes, badges, events, categories/tags

### Security
- Password hashing
- SQL injection prevention
- XSS protection
- CSRF protection
- Secure session management

## 📁 Project Structure

```
UIUArchive-web/
├── assets/                   # Static assets
│   ├── css/
│   │   └── style.css        # Custom styles
│   ├── js/
│   │   └── main.js          # Main JavaScript
│   └── images/              # Images and icons
├── includes/                 # Common PHP includes
│   ├── header.php           # Page header
│   ├── footer.php           # Page footer
│   ├── db.php               # Database connection
│   └── functions.php        # Reusable PHP functions
├── pages/                    # Application pages
│   ├── index.php            # Homepage/project feed
│   ├── login.php            # Login page
│   ├── register.php         # Registration page
│   ├── profile.php          # User profile
│   ├── upload_project.php   # Project upload
│   ├── project_details.php  # Project details
│   └── admin_panel.php      # Admin panel
├── uploads/                  # User uploaded files
│   ├── projects/            # Project media
│   └── profiles/            # Profile images
├── sql/                      # Database scripts
│   └── database.sql         # Database schema
├── .htaccess                 # Apache configuration
└── README.md                 # This file
```

## 🚀 Installation & Setup

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- XAMPP, MAMP, or Laragon (for local development)

### Local Setup with XAMPP

1. **Clone or Download the Project**
   ```bash
   cd /opt/lampp/htdocs/
   # Your project is already here: UIUArchive-web/
   ```

2. **Start XAMPP**
   ```bash
   sudo /opt/lampp/lampp start
   ```

3. **Create Database**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create a new database named `uiuarchive`
   - Import the SQL file: `sql/database.sql`

4. **Configure Database Connection**
   - Edit `includes/db.php`
   - Update database credentials if needed:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     define('DB_NAME', 'uiuarchive');
     ```

5. **Set Permissions**
   ```bash
   chmod -R 755 /opt/lampp/htdocs/UIUArchive-web
   chmod -R 777 /opt/lampp/htdocs/UIUArchive-web/uploads
   ```

6. **Access the Application**
   - Open browser and navigate to: `http://localhost/UIUArchive-web/pages/`

### First Time Setup

1. **Register a New Account**
   - Use a UIU email format: `yourname@student.uiu.ac.bd`
   - Fill in all required information

2. **Create Admin Account** (Optional)
   - Register normally
   - Update user role in database to 'admin' or 'faculty'

## 📊 Database Schema

### Main Tables
- `users` - User accounts and profiles
- `projects` - Project information
- `project_media` - Project files (images, videos, PDFs)
- `tags` - Project tags/categories
- `project_tags` - Junction table for project-tag relationships
- `likes` - Project likes
- `comments` - Project comments
- `follows` - Project follows
- `badges` - Achievement badges
- `user_badges` - User badge awards
- `events` - Upcoming events
- `notifications` - User notifications

## 🎯 Usage Guide

### For Students

1. **Register** - Sign up with your UIU email
2. **Complete Profile** - Add your information and customize your profile
3. **Upload Projects** - Share your work with the community
4. **Engage** - Like, comment, and follow interesting projects
5. **Participate** - Join competitions and events
6. **Earn Badges** - Complete achievements to earn badges

### For Faculty

1. **Register** - Use faculty UIU email
2. **Browse Projects** - Discover student work
3. **Endorse Projects** - Highlight outstanding projects
4. **Feature Projects** - Make projects visible on homepage
5. **Organize Events** - Create workshops, competitions, hackathons

## 🔐 Security Features

- Password hashing using PHP's `password_hash()`
- SQL injection prevention with prepared statements
- XSS protection with `htmlspecialchars()`
- Session security
- CSRF token protection
- File upload validation
- Email validation (UIU domain only)

## 🚢 Deployment

### Free Hosting Options
- **InfinityFree** - https://infinityfree.net
- **000webhost** - https://www.000webhost.com
- **AwardSpace** - https://www.awardspace.com

### Deployment Steps
1. Export database from phpMyAdmin
2. Upload files via FTP
3. Import database on hosting provider
4. Update `includes/db.php` with hosting database credentials
5. Set proper file permissions

## 🤝 Contributing

This is a student project for UIU. Contributions, suggestions, and bug reports are welcome!

## 📝 License

This project is developed for educational purposes at United International University.

## 👨‍💻 Development Team

Built by UIU Students with ❤️

## 📞 Support

For issues or questions, please contact the development team through UIU channels.

---

**UIUArchive** - Empowering UIU Students to Showcase Their Creativity and Innovation
