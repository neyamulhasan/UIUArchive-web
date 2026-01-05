-- UIUArchive Sample Data
-- Generated for testing and demo purposes
-- Built by UIU Minds

USE uiuarchive;

-- =============================================
-- INSERT USERS (5 students + 1 faculty)
-- =============================================

INSERT INTO users (username, full_name, email, google_id, password, department, semester, bio, profile_image, theme_color, is_verified, role, created_at, updated_at) VALUES
('sarah_ahmed', 'Sarah Ahmed', 'sarah.ahmed@uiu.ac', NULL, '$2y$10$YourHashedPasswordHere1', 'Computer Science', 'Fall 2024', 'Passionate about AI and machine learning. Love building intelligent systems that solve real-world problems.', NULL, '#8B5CF6', TRUE, 'student', '2024-01-15 10:30:00', '2024-01-15 10:30:00'),
('rafid_khan', 'Rafid Khan', 'rafid.khan@uiu.ac', NULL, '$2y$10$YourHashedPasswordHere2', 'Computer Science', 'Spring 2024', 'Full-stack developer with a keen interest in web technologies and cloud computing. Always exploring new frameworks.', NULL, '#10B981', TRUE, 'student', '2024-02-10 14:20:00', '2024-02-10 14:20:00'),
('nadia_islam', 'Nadia Islam', 'nadia.islam@uiu.ac', NULL, '$2y$10$YourHashedPasswordHere3', 'Electrical Engineering', 'Fall 2023', 'IoT enthusiast and hardware hacker. Building smart solutions for everyday problems.', NULL, '#F59E0B', TRUE, 'student', '2023-09-05 09:15:00', '2023-09-05 09:15:00'),
('tahmid_hassan', 'Tahmid Hassan', 'tahmid.hassan@uiu.ac', NULL, '$2y$10$YourHashedPasswordHere4', 'Computer Science', 'Spring 2025', 'Cybersecurity researcher and ethical hacker. Passionate about protecting digital infrastructure.', NULL, '#EF4444', FALSE, 'student', '2024-08-20 11:45:00', '2024-08-20 11:45:00'),
('zara_rahman', 'Zara Rahman', 'zara.rahman@uiu.ac', NULL, '$2y$10$YourHashedPasswordHere5', 'Business Administration', 'Fall 2024', 'UI/UX designer who loves creating beautiful and intuitive user experiences. Design thinking advocate.', NULL, '#EC4899', TRUE, 'student', '2024-03-12 16:00:00', '2024-03-12 16:00:00'),
('dr_karim', 'Dr. Mahmud Karim', 'mahmud.karim@uiu.ac', NULL, '$2y$10$YourHashedPasswordHere6', 'Computer Science', NULL, 'Professor of Computer Science specializing in artificial intelligence and data science. Mentor and researcher.', NULL, '#3B82F6', TRUE, 'faculty', '2020-01-10 08:00:00', '2020-01-10 08:00:00');

-- =============================================
-- INSERT PROJECTS (30 projects)
-- =============================================

INSERT INTO projects (user_id, title, description, project_blueprint, category, department, semester, github_link, demo_link, thumbnail, visibility, views_count, likes_count, created_at, updated_at) VALUES

-- Sarah Ahmed's Projects (AI/ML focused) - user_id: 1
(1, 'Smart Healthcare Diagnosis System', 'An AI-powered medical diagnosis assistant that uses machine learning to predict diseases based on symptoms. Achieved 92% accuracy using Random Forest classifier.', '# Smart Healthcare Diagnosis System

## Overview
An intelligent healthcare diagnosis system that leverages machine learning algorithms to assist in preliminary disease diagnosis. The system analyzes patient symptoms and medical history to provide accurate predictions.

## Features
- Multi-disease prediction (Diabetes, Heart Disease, Parkinson''s)
- User-friendly web interface
- Real-time prediction with confidence scores
- Historical data tracking
- Export reports as PDF

## Technologies Used
- Python 3.9
- Scikit-learn
- Flask
- React.js
- PostgreSQL
- TensorFlow

## Installation
```bash
# Clone the repository
git clone https://github.com/sarah-ahmed/smart-healthcare-diagnosis

# Install backend dependencies
cd backend
pip install -r requirements.txt

# Install frontend dependencies
cd ../frontend
npm install
```

## Usage
```bash
# Start backend server
python app.py

# Start frontend (in new terminal)
npm start
```

## Notes
- Trained on 10,000+ medical records
- Model updated quarterly with new data
- Not a replacement for professional medical advice', 'AI', 'Computer Science', 'Fall 2024', 'https://github.com/sarah-ahmed/smart-healthcare-diagnosis', 'https://healthcare-diagnosis-demo.vercel.app', NULL, 'public', 245, 0, '2024-09-15 10:30:00', '2024-09-15 10:30:00'),

(1, 'Natural Language Processing Chatbot', 'Advanced conversational AI chatbot using transformer models. Supports context-aware responses and multi-turn conversations with sentiment analysis.', '# NLP Chatbot

## Overview
A sophisticated chatbot built using state-of-the-art NLP techniques and transformer architecture. Capable of understanding context, maintaining conversation history, and providing intelligent responses.

## Features
- Context-aware conversations
- Sentiment analysis
- Multi-language support (English, Bengali)
- Intent recognition
- Custom training on domain-specific data

## Technologies Used
- Python
- Transformers (Hugging Face)
- BERT
- FastAPI
- Redis (for session management)
- Docker

## Installation
```bash
git clone https://github.com/sarah-ahmed/nlp-chatbot
cd nlp-chatbot
docker-compose up
```

## Usage
Access the API at `http://localhost:8000`

Example request:
```python
import requests
response = requests.post("http://localhost:8000/chat", 
    json={"message": "Hello, how are you?"})
```

## Notes
- Pre-trained on 1M+ conversation pairs
- Supports fine-tuning for specific domains
- GPU recommended for optimal performance', 'AI', 'Computer Science', 'Fall 2024', 'https://github.com/sarah-ahmed/nlp-chatbot', NULL, NULL, 'public', 189, 0, '2024-08-22 14:20:00', '2024-08-22 14:20:00'),

(1, 'Image Classification Mobile App', 'Mobile application for real-time image classification using deep learning. Identifies objects, animals, and plants with 95% accuracy using MobileNetV2.', '# Image Classification Mobile App

## Overview
A cross-platform mobile application that uses deep learning models to classify images in real-time. Perfect for educational purposes and quick identification needs.

## Features
- Real-time camera classification
- Gallery image upload
- 1000+ object categories
- Offline mode support
- Classification history
- Share results on social media

## Technologies Used
- React Native
- TensorFlow Lite
- MobileNetV2
- Expo
- AsyncStorage

## Installation
```bash
git clone https://github.com/sarah-ahmed/image-classifier-app
cd image-classifier-app
npm install
expo start
```

## Usage
1. Open the app
2. Point camera at object or upload image
3. View classification results with confidence scores

## Notes
- Model size: 14MB (optimized for mobile)
- Works offline after initial download
- Supports both iOS and Android', 'MobileApp', 'Computer Science', 'Fall 2024', 'https://github.com/sarah-ahmed/image-classifier-app', 'https://expo.dev/@sarah/image-classifier', NULL, 'public', 312, 0, '2024-07-10 09:45:00', '2024-07-10 09:45:00'),

(1, 'Facial Recognition Attendance System', 'Automated attendance tracking system using facial recognition technology. Reduces manual attendance time by 90% with 98% accuracy.', '# Facial Recognition Attendance System

## Overview
An automated attendance management system that uses facial recognition to mark student attendance. Eliminates proxy attendance and streamlines the process.

## Features
- Face detection and recognition
- Real-time attendance marking
- Admin dashboard
- Attendance reports and analytics
- Email notifications
- Anti-spoofing protection

## Technologies Used
- Python
- OpenCV
- dlib
- Face Recognition library
- Django
- MySQL
- Bootstrap

## Installation
```bash
git clone https://github.com/sarah-ahmed/face-attendance
cd face-attendance
pip install -r requirements.txt
python manage.py migrate
python manage.py runserver
```

## Usage
1. Admin registers students with face images
2. System captures faces during class
3. Automatic attendance marking
4. Generate reports from dashboard

## Notes
- Requires good lighting for accuracy
- Supports multiple faces in one frame
- GDPR compliant with encrypted storage', 'AI', 'Computer Science', 'Fall 2024', 'https://github.com/sarah-ahmed/face-attendance', NULL, NULL, 'public', 428, 0, '2024-06-18 11:30:00', '2024-06-18 11:30:00'),

(1, 'Predictive Text Generator', 'AI-powered text generation tool using GPT-style architecture. Generates coherent text continuations for creative writing and content creation.', '# Predictive Text Generator

## Overview
A neural network-based text generation system that predicts and generates coherent text continuations. Useful for creative writing assistance and content generation.

## Features
- Context-aware text generation
- Multiple writing styles
- Temperature control for creativity
- Batch generation
- Fine-tuning on custom datasets

## Technologies Used
- Python
- PyTorch
- Transformers
- Streamlit
- CUDA

## Installation
```bash
git clone https://github.com/sarah-ahmed/text-generator
cd text-generator
pip install -r requirements.txt
streamlit run app.py
```

## Usage
Enter seed text and adjust parameters to generate continuations.

## Notes
- Trained on diverse text corpus
- GPU acceleration supported
- Avoid using for misinformation', 'AI', 'Computer Science', 'Fall 2024', 'https://github.com/sarah-ahmed/text-generator', 'https://text-gen-demo.streamlit.app', NULL, 'public', 156, 0, '2024-05-25 13:15:00', '2024-05-25 13:15:00'),

-- Rafid Khan's Projects (Web/Cloud focused) - user_id: 2
(2, 'E-Commerce Platform with Microservices', 'Scalable e-commerce platform built with microservices architecture. Handles 10,000+ concurrent users with load balancing and auto-scaling.', '# E-Commerce Microservices Platform

## Overview
A modern e-commerce platform designed with microservices architecture for scalability and maintainability. Features include product catalog, shopping cart, payment processing, and order management.

## Features
- Product catalog with search and filters
- User authentication (JWT)
- Shopping cart and wishlist
- Payment gateway integration (Stripe)
- Order tracking
- Admin dashboard
- RESTful APIs

## Technologies Used
- Node.js & Express
- React.js
- MongoDB
- Redis
- Docker & Kubernetes
- AWS (EC2, S3, RDS)
- Nginx

## Installation
```bash
git clone https://github.com/rafid-khan/ecommerce-microservices
cd ecommerce-microservices
docker-compose up
```

## Usage
Access the platform at `http://localhost:3000`
Admin panel: `http://localhost:3000/admin`

## Notes
- Follows 12-factor app methodology
- CI/CD pipeline with GitHub Actions
- Monitoring with Prometheus and Grafana', 'WebApp', 'Computer Science', 'Spring 2024', 'https://github.com/rafid-khan/ecommerce-microservices', 'https://ecommerce-demo.rafidkhan.com', NULL, 'public', 567, 0, '2024-10-05 15:40:00', '2024-10-05 15:40:00'),

(2, 'Real-Time Collaboration Tool', 'Web-based collaborative workspace similar to Notion. Features real-time editing, comments, and team collaboration with WebSocket integration.', '# Real-Time Collaboration Tool

## Overview
A collaborative workspace application that enables teams to work together in real-time. Features include document editing, task management, and team chat.

## Features
- Real-time collaborative editing
- Rich text editor
- Task boards (Kanban style)
- Team chat and mentions
- File sharing
- Version history
- Workspace management

## Technologies Used
- React.js & TypeScript
- Node.js
- Socket.io
- PostgreSQL
- Quill.js (editor)
- Tailwind CSS

## Installation
```bash
git clone https://github.com/rafid-khan/collab-tool
cd collab-tool
npm install
npm run dev
```

## Usage
1. Create workspace
2. Invite team members
3. Start collaborating in real-time

## Notes
- Operational Transform for conflict resolution
- End-to-end encryption for sensitive data
- Offline support with sync', 'WebApp', 'Computer Science', 'Spring 2024', 'https://github.com/rafid-khan/collab-tool', 'https://collab.rafidkhan.com', NULL, 'public', 389, 0, '2024-09-12 10:20:00', '2024-09-12 10:20:00'),

(2, 'Cloud Storage Service', 'Dropbox-like cloud storage solution with file synchronization, sharing, and version control. Supports 5GB free storage per user.', '# Cloud Storage Service

## Overview
A personal cloud storage service that allows users to upload, store, and share files securely. Features automatic synchronization across devices.

## Features
- File upload/download
- Folder synchronization
- File sharing with permissions
- Version control
- File preview (images, PDFs, docs)
- Search functionality
- Storage analytics

## Technologies Used
- Python & Flask
- AWS S3
- PostgreSQL
- Celery (background tasks)
- Redis
- Vue.js

## Installation
```bash
git clone https://github.com/rafid-khan/cloud-storage
cd cloud-storage
pip install -r requirements.txt
python app.py
```

## Usage
Register account → Upload files → Access from any device

## Notes
- Files encrypted at rest and in transit
- Incremental backup support
- Rate limiting to prevent abuse', 'CloudComputing', 'Computer Science', 'Spring 2024', 'https://github.com/rafid-khan/cloud-storage', NULL, NULL, 'public', 423, 0, '2024-08-30 14:50:00', '2024-08-30 14:50:00'),

(2, 'Social Media Analytics Dashboard', 'Comprehensive analytics dashboard for social media insights. Tracks engagement, sentiment, and trends across multiple platforms.', '# Social Media Analytics Dashboard

## Overview
An analytics platform that aggregates data from multiple social media platforms and provides actionable insights through interactive visualizations.

## Features
- Multi-platform integration (Twitter, Instagram, Facebook)
- Engagement metrics
- Sentiment analysis
- Trend detection
- Custom reports
- Schedule posts
- Competitor analysis

## Technologies Used
- React.js & D3.js
- Node.js & Express
- MongoDB
- Python (data processing)
- Twitter API, Instagram API
- Chart.js

## Installation
```bash
git clone https://github.com/rafid-khan/social-analytics
cd social-analytics
npm install
npm start
```

## Usage
1. Connect social media accounts
2. View analytics dashboard
3. Generate reports

## Notes
- OAuth 2.0 authentication
- Real-time data updates
- Export reports as PDF/CSV', 'WebApp', 'Computer Science', 'Spring 2024', 'https://github.com/rafid-khan/social-analytics', 'https://analytics.rafidkhan.com', NULL, 'public', 298, 0, '2024-07-15 09:30:00', '2024-07-15 09:30:00'),

(2, 'GraphQL API Gateway', 'Unified GraphQL API gateway that aggregates multiple REST APIs. Reduces over-fetching and improves client-side performance.', '# GraphQL API Gateway

## Overview
A GraphQL API gateway that provides a unified interface for multiple backend services. Optimizes data fetching and reduces network overhead.

## Features
- Schema stitching
- Query batching
- Caching layer
- Authentication & authorization
- Rate limiting
- API documentation (GraphiQL)
- Monitoring and logging

## Technologies Used
- Node.js
- Apollo Server
- GraphQL
- Redis
- Docker
- Prometheus

## Installation
```bash
git clone https://github.com/rafid-khan/graphql-gateway
cd graphql-gateway
npm install
npm start
```

## Usage
Access GraphiQL playground at `http://localhost:4000/graphql`

## Notes
- Supports subscriptions for real-time data
- DataLoader for batching and caching
- Schema-first development approach', 'WebApp', 'Computer Science', 'Spring 2024', 'https://github.com/rafid-khan/graphql-gateway', NULL, NULL, 'public', 167, 0, '2024-06-20 16:10:00', '2024-06-20 16:10:00'),

-- Nadia Islam's Projects (IoT/Hardware focused) - user_id: 3
(3, 'Smart Home Automation System', 'IoT-based home automation system controlling lights, temperature, and security. Accessible via mobile app with voice control integration.', '# Smart Home Automation System

## Overview
A comprehensive IoT solution for home automation that allows users to control various home appliances remotely. Features include scheduling, automation rules, and voice control.

## Features
- Remote appliance control
- Temperature and humidity monitoring
- Motion detection and alerts
- Voice control (Alexa/Google Home)
- Energy consumption tracking
- Automation rules and scheduling
- Mobile app (iOS/Android)

## Technologies Used
- Arduino/ESP8266
- MQTT protocol
- Node.js backend
- React Native
- Firebase
- Sensors: DHT22, PIR, Relay modules

## Installation
```bash
# Flash Arduino code
arduino-cli upload -p /dev/ttyUSB0

# Setup backend
git clone https://github.com/nadia-islam/smart-home
cd smart-home
npm install
npm start
```

## Usage
1. Connect devices to WiFi
2. Register devices in mobile app
3. Control via app or voice commands

## Notes
- Supports 2.4GHz WiFi only
- Low power consumption mode available
- Local network operation for privacy', 'IoT', 'Electrical Engineering', 'Fall 2023', 'https://github.com/nadia-islam/smart-home', NULL, NULL, 'public', 512, 0, '2024-10-20 11:25:00', '2024-10-20 11:25:00'),

(3, 'IoT Weather Station', 'Advanced weather monitoring station with IoT capabilities. Tracks temperature, humidity, pressure, and air quality with data visualization.', '# IoT Weather Station

## Overview
A DIY weather station that collects environmental data and transmits it to the cloud for real-time monitoring and historical analysis.

## Features
- Temperature and humidity sensing
- Barometric pressure measurement
- Air quality index (PM2.5, PM10)
- Wind speed and direction
- Rainfall detection
- Solar-powered option
- Web dashboard with graphs

## Technologies Used
- Raspberry Pi
- Python
- BME280, MQ135 sensors
- InfluxDB
- Grafana
- MQTT

## Installation
```bash
git clone https://github.com/nadia-islam/weather-station
cd weather-station
pip install -r requirements.txt
python main.py
```

## Usage
Access dashboard at `http://raspberry-pi-ip:3000`

## Notes
- 5-minute data logging interval
- Battery backup for power outages
- Weather API integration for forecasts', 'IoT', 'Electrical Engineering', 'Fall 2023', 'https://github.com/nadia-islam/weather-station', 'https://weather.nadiaislam.com', NULL, 'public', 345, 0, '2024-09-08 13:40:00', '2024-09-08 13:40:00'),

(3, 'Automated Plant Watering System', 'Smart irrigation system using soil moisture sensors. Automatically waters plants based on soil conditions and weather forecasts.', '# Automated Plant Watering System

## Overview
An intelligent plant care system that monitors soil moisture and automatically waters plants when needed. Prevents over-watering and under-watering.

## Features
- Soil moisture monitoring
- Automatic watering
- Weather forecast integration
- Water level alerts
- Schedule override
- Multiple plant zones
- Mobile notifications

## Technologies Used
- Arduino Uno
- Soil moisture sensors
- Water pump and relay
- ESP8266 (WiFi)
- Blynk platform
- OpenWeather API

## Installation
```bash
git clone https://github.com/nadia-islam/auto-watering
# Upload Arduino sketch via Arduino IDE
# Configure Blynk app with auth token
```

## Usage
1. Insert sensors in soil
2. Set moisture thresholds in app
3. System waters automatically

## Notes
- Solar panel compatible
- Adjustable watering duration
- Works offline with basic features', 'IoT', 'Electrical Engineering', 'Fall 2023', 'https://github.com/nadia-islam/auto-watering', NULL, NULL, 'public', 289, 0, '2024-08-14 10:15:00', '2024-08-14 10:15:00'),

(3, 'Smart Energy Meter', 'IoT energy monitoring device that tracks real-time power consumption. Helps reduce electricity bills by 20% through usage insights.', '# Smart Energy Meter

## Overview
A smart electricity meter that monitors power consumption in real-time and provides detailed analytics to help reduce energy waste.

## Features
- Real-time power monitoring
- Daily/monthly consumption reports
- Appliance-level tracking
- Cost estimation
- Peak usage alerts
- Energy saving tips
- Historical data analysis

## Technologies Used
- ESP32
- ACS712 current sensor
- PZEM-004T module
- Node-RED
- InfluxDB
- Grafana

## Installation
```bash
git clone https://github.com/nadia-islam/smart-energy-meter
# Flash ESP32 with provided firmware
# Import Node-RED flow
# Configure Grafana dashboards
```

## Usage
Install device in electrical panel → View data on dashboard

## Notes
- Non-invasive installation
- Supports single and three-phase systems
- Data exported to CSV for analysis', 'IoT', 'Electrical Engineering', 'Fall 2023', 'https://github.com/nadia-islam/smart-energy-meter', NULL, NULL, 'public', 401, 0, '2024-07-22 15:30:00', '2024-07-22 15:30:00'),

(3, 'Wireless Sensor Network for Agriculture', 'Large-scale agricultural monitoring system using wireless sensor networks. Monitors crop health across vast farmlands.', '# Agricultural Wireless Sensor Network

## Overview
A distributed sensor network designed for precision agriculture. Monitors soil conditions, crop health, and environmental factors across large agricultural areas.

## Features
- Multi-sensor deployment
- Mesh networking
- Soil NPK levels
- Crop disease detection
- Irrigation recommendations
- Drone integration
- Farmer mobile app

## Technologies Used
- LoRa (Long Range)
- Raspberry Pi gateway
- Arduino sensor nodes
- Python data processing
- Machine learning (crop analysis)
- MySQL database

## Installation
```bash
git clone https://github.com/nadia-islam/agri-wsn
cd agri-wsn
pip install -r requirements.txt
python gateway.py
```

## Usage
Deploy sensor nodes → Collect data → Analyze via dashboard

## Notes
- 10km+ communication range
- Solar powered sensor nodes
- Predictive analytics for yield optimization', 'IoT', 'Electrical Engineering', 'Fall 2023', 'https://github.com/nadia-islam/agri-wsn', NULL, NULL, 'public', 278, 0, '2024-06-30 09:50:00', '2024-06-30 09:50:00'),

-- Tahmid Hassan's Projects (Cybersecurity focused) - user_id: 4
(4, 'Network Intrusion Detection System', 'ML-based intrusion detection system that identifies malicious network traffic. Detects 95% of common attack patterns in real-time.', '# Network Intrusion Detection System (NIDS)

## Overview
A machine learning-based network security tool that monitors network traffic and detects potential intrusions and attacks using behavioral analysis.

## Features
- Real-time packet analysis
- Anomaly detection
- Signature-based detection
- Alert system with severity levels
- Traffic visualization
- Attack pattern database
- Integration with SIEM systems

## Technologies Used
- Python & Scapy
- Scikit-learn
- Snort (signature engine)
- Elasticsearch
- Kibana
- Random Forest classifier

## Installation
```bash
git clone https://github.com/tahmid-hassan/nids
cd nids
pip install -r requirements.txt
sudo python nids.py -i eth0
```

## Usage
Run with sudo/admin privileges to capture packets
Configure rules in `config.yaml`

## Notes
- Requires promiscuous mode
- High CPU usage during peak traffic
- Regular signature updates needed', 'CyberSecurity', 'Computer Science', 'Spring 2025', 'https://github.com/tahmid-hassan/nids', NULL, NULL, 'public', 456, 0, '2024-10-28 14:20:00', '2024-10-28 14:20:00'),

(4, 'Password Strength Analyzer & Generator', 'Advanced password security tool that analyzes password strength and generates cryptographically secure passwords. Checks against 10M+ breached passwords.', '# Password Strength Analyzer & Generator

## Overview
A comprehensive password security tool that evaluates password strength, checks against known breaches, and generates secure passwords based on customizable criteria.

## Features
- Entropy calculation
- Dictionary attack simulation
- Breach database check (HIBP API)
- Password generation with custom rules
- Strength visualization
- Security recommendations
- Browser extension available

## Technologies Used
- Python
- zxcvbn algorithm
- Have I Been Pwned API
- JavaScript (browser extension)
- Crypto libraries

## Installation
```bash
git clone https://github.com/tahmid-hassan/password-analyzer
cd password-analyzer
pip install -r requirements.txt
python analyzer.py
```

## Usage
```python
from analyzer import check_password
result = check_password("yourpassword")
print(result)
```

## Notes
- Zero-knowledge architecture
- Passwords never stored or transmitted
- Open source and auditable', 'CyberSecurity', 'Computer Science', 'Spring 2025', 'https://github.com/tahmid-hassan/password-analyzer', 'https://passcheck.tahmidhassan.com', NULL, 'public', 367, 0, '2024-09-18 11:35:00', '2024-09-18 11:35:00'),

(4, 'Vulnerability Scanner for Web Apps', 'Automated web application vulnerability scanner that detects SQL injection, XSS, CSRF, and other OWASP Top 10 vulnerabilities.', '# Web Application Vulnerability Scanner

## Overview
An automated security testing tool that scans web applications for common vulnerabilities and generates detailed reports with remediation suggestions.

## Features
- SQL injection detection
- XSS (Cross-Site Scripting) testing
- CSRF vulnerability check
- Security header analysis
- SSL/TLS configuration audit
- Directory traversal detection
- Detailed HTML reports

## Technologies Used
- Python
- Requests library
- BeautifulSoup
- Selenium
- OWASP ZAP integration
- JSON report format

## Installation
```bash
git clone https://github.com/tahmid-hassan/web-vuln-scanner
cd web-vuln-scanner
pip install -r requirements.txt
python scanner.py -u https://target.com
```

## Usage
```bash
# Basic scan
python scanner.py -u https://example.com

# Full scan with authentication
python scanner.py -u https://example.com -a cookie.txt --full
```

## Notes
- Only scan authorized targets
- May trigger WAF/IDS alerts
- False positives possible - manual verification recommended', 'CyberSecurity', 'Computer Science', 'Spring 2025', 'https://github.com/tahmid-hassan/web-vuln-scanner', NULL, NULL, 'public', 523, 0, '2024-08-25 16:45:00', '2024-08-25 16:45:00'),

(4, 'Encrypted Messaging Application', 'End-to-end encrypted messaging app with perfect forward secrecy. Built with Signal protocol for maximum privacy.', '# Encrypted Messaging Application

## Overview
A privacy-focused messaging application that implements end-to-end encryption using the Signal protocol. No messages are stored on servers.

## Features
- End-to-end encryption
- Perfect forward secrecy
- Self-destructing messages
- Screen security (screenshot prevention)
- Encrypted file sharing
- Group chats (encrypted)
- No phone number required

## Technologies Used
- React Native
- libsignal-protocol
- WebRTC (voice/video calls)
- Node.js backend
- MongoDB (metadata only)
- Socket.io

## Installation
```bash
git clone https://github.com/tahmid-hassan/encrypted-messenger
cd encrypted-messenger
npm install
expo start
```

## Usage
1. Install app on device
2. Create account with username
3. Start secure conversations

## Notes
- Messages deleted from server after delivery
- Metadata minimization
- Open source for security audits', 'CyberSecurity', 'Computer Science', 'Spring 2025', 'https://github.com/tahmid-hassan/encrypted-messenger', NULL, NULL, 'private', 234, 0, '2024-07-12 10:20:00', '2024-07-12 10:20:00'),

(4, 'Phishing Detection Browser Extension', 'Chrome/Firefox extension that detects phishing websites using ML and heuristics. Protects users from credential theft.', '# Phishing Detection Browser Extension

## Overview
A browser extension that analyzes websites in real-time and warns users about potential phishing attempts using machine learning and heuristic rules.

## Features
- Real-time URL analysis
- Domain reputation check
- Visual similarity detection
- SSL certificate verification
- Suspicious form detection
- Report phishing sites
- Privacy-focused (local processing)

## Technologies Used
- JavaScript
- TensorFlow.js
- Chrome/Firefox Extension APIs
- PhishTank API
- VirusTotal API

## Installation
```bash
git clone https://github.com/tahmid-hassan/phishing-detector
cd phishing-detector
npm install
npm run build
# Load unpacked extension in browser
```

## Usage
Install extension → Browse normally → Get alerts on suspicious sites

## Notes
- No browsing data collected
- Works offline with cached models
- Regular signature updates', 'CyberSecurity', 'Computer Science', 'Spring 2025', 'https://github.com/tahmid-hassan/phishing-detector', NULL, NULL, 'public', 445, 0, '2024-06-05 13:55:00', '2024-06-05 13:55:00'),

-- Zara Rahman's Projects (UI/UX/Design focused) - user_id: 5
(5, 'Design System Component Library', 'Comprehensive React component library following Material Design principles. Includes 50+ customizable components with accessibility support.', '# Design System Component Library

## Overview
A complete design system and component library for React applications. Provides consistent, accessible, and customizable UI components.

## Features
- 50+ React components
- Dark mode support
- Accessibility (WCAG 2.1 AA)
- TypeScript support
- Storybook documentation
- Theming system
- Responsive design
- Icon library

## Technologies Used
- React & TypeScript
- Styled Components
- Storybook
- Jest & React Testing Library
- Rollup (bundler)
- Figma (design)

## Installation
```bash
npm install @zara/design-system
```

## Usage
```jsx
import { Button, Card, Modal } from "@zara/design-system";

function App() {
  return <Button variant="primary">Click me</Button>;
}
```

## Notes
- Tree-shakeable for optimal bundle size
- Comprehensive documentation
- Active maintenance and updates', 'Design', 'Business Administration', 'Fall 2024', 'https://github.com/zara-rahman/design-system', 'https://design-system.zararahman.com', NULL, 'public', 389, 0, '2024-10-15 09:30:00', '2024-10-15 09:30:00'),

(5, 'Portfolio Website Builder', 'No-code portfolio website builder with drag-and-drop interface. Perfect for designers and creatives to showcase their work.', '# Portfolio Website Builder

## Overview
A user-friendly website builder that allows designers and creatives to build stunning portfolio websites without writing code. Features drag-and-drop editor and beautiful templates.

## Features
- Drag-and-drop editor
- 20+ premium templates
- Custom domain support
- SEO optimization
- Analytics integration
- Contact forms
- Gallery and lightbox
- Mobile responsive

## Technologies Used
- React & Next.js
- GrapesJS (editor)
- MongoDB
- AWS S3 (hosting)
- Stripe (payments)
- Tailwind CSS

## Installation
```bash
git clone https://github.com/zara-rahman/portfolio-builder
cd portfolio-builder
npm install
npm run dev
```

## Usage
1. Choose template
2. Customize with drag-and-drop
3. Publish to custom domain

## Notes
- Free tier available
- Export HTML/CSS code
- Regular template updates', 'WebApp', 'Business Administration', 'Fall 2024', 'https://github.com/zara-rahman/portfolio-builder', 'https://portfoliobuilder.zararahman.com', NULL, 'public', 567, 0, '2024-09-22 14:15:00', '2024-09-22 14:15:00'),

(5, 'UI/UX Design Toolkit', 'Figma plugin with design utilities, accessibility checkers, and color palette generators. Used by 5000+ designers worldwide.', '# UI/UX Design Toolkit - Figma Plugin

## Overview
A comprehensive Figma plugin that provides designers with essential tools for creating accessible, beautiful, and consistent designs.

## Features
- Color contrast checker
- Typography scale generator
- Accessibility audit
- Design token exporter
- Lorem ipsum generator
- Icon library (1000+ icons)
- Spacing system helper
- Component organizer

## Technologies Used
- TypeScript
- Figma Plugin API
- React (UI)
- Webpack
- WCAG guidelines

## Installation
Install from Figma Community: "Design Toolkit by Zara"

Or install manually:
```bash
git clone https://github.com/zara-rahman/design-toolkit
cd design-toolkit
npm install
npm run build
```

## Usage
Open plugin in Figma → Select tool → Apply to design

## Notes
- Free and open source
- Regular updates with new features
- Community-driven development', 'Design', 'Business Administration', 'Fall 2024', 'https://github.com/zara-rahman/design-toolkit', NULL, NULL, 'public', 672, 0, '2024-08-10 11:40:00', '2024-08-10 11:40:00'),

(5, 'User Research and Testing Platform', 'Platform for conducting user research, usability testing, and feedback collection. Streamlines the UX research process.', '# User Research and Testing Platform

## Overview
A comprehensive platform for UX researchers and designers to conduct user interviews, usability tests, and collect feedback efficiently.

## Features
- Remote usability testing
- User interview scheduling
- Screen recording
- Survey creation
- Heatmap generation
- Participant recruitment
- Report generation
- Collaboration tools

## Technologies Used
- React & Redux
- Node.js & Express
- PostgreSQL
- WebRTC (screen sharing)
- Socket.io
- Chart.js

## Installation
```bash
git clone https://github.com/zara-rahman/ux-research-platform
cd ux-research-platform
npm install
npm run dev
```

## Usage
1. Create research project
2. Recruit participants
3. Conduct tests
4. Analyze results

## Notes
- GDPR compliant
- Video storage for 30 days
- Integrates with design tools', 'WebApp', 'Business Administration', 'Fall 2024', 'https://github.com/zara-rahman/ux-research-platform', 'https://uxresearch.zararahman.com', NULL, 'public', 298, 0, '2024-07-18 15:25:00', '2024-07-18 15:25:00'),

(5, 'Mobile App Mockup Generator', 'Tool for quickly generating mobile app mockups and prototypes. Exports to various formats for presentations and client pitches.', '# Mobile App Mockup Generator

## Overview
A fast and easy tool for creating professional mobile app mockups without design skills. Perfect for quick prototyping and client presentations.

## Features
- Device frame library (iOS/Android)
- Screenshot upload
- Background customization
- Shadow and reflection effects
- Batch processing
- Export to PNG/PDF
- Presentation mode
- Custom branding

## Technologies Used
- React
- Canvas API
- TypeScript
- Zustand (state)
- File-saver
- PDFKit

## Installation
```bash
git clone https://github.com/zara-rahman/mockup-generator
cd mockup-generator
npm install
npm start
```

## Usage
1. Upload screenshots
2. Select device frame
3. Customize appearance
4. Export mockup

## Notes
- No watermarks
- High resolution exports
- Works offline as PWA', 'Design', 'Business Administration', 'Fall 2024', 'https://github.com/zara-rahman/mockup-generator', 'https://mockups.zararahman.com', NULL, 'public', 445, 0, '2024-06-28 10:50:00', '2024-06-28 10:50:00'),

-- Dr. Karim's Projects (Research/Advanced topics) - user_id: 6
(6, 'Deep Learning Framework Comparison', 'Comprehensive research comparing TensorFlow, PyTorch, and JAX. Benchmarks performance, ease of use, and ecosystem maturity.', '# Deep Learning Framework Comparison Study

## Overview
An extensive research project comparing the three major deep learning frameworks: TensorFlow, PyTorch, and JAX. Includes performance benchmarks and developer experience analysis.

## Features
- Performance benchmarks (training/inference)
- Memory usage analysis
- API usability comparison
- Ecosystem evaluation
- Migration guides
- Best practices
- Real-world use cases

## Technologies Used
- TensorFlow 2.x
- PyTorch 2.x
- JAX
- CUDA
- Python
- Jupyter Notebooks

## Installation
```bash
git clone https://github.com/dr-karim/dl-framework-comparison
cd dl-framework-comparison
pip install -r requirements.txt
jupyter notebook
```

## Usage
Run benchmark notebooks in `/benchmarks` directory
View analysis in `/reports` directory

## Notes
- Tested on NVIDIA RTX 3090
- Results may vary with different hardware
- Updated quarterly with new versions', 'Research', 'Computer Science', NULL, 'https://github.com/dr-karim/dl-framework-comparison', NULL, NULL, 'public', 789, 0, '2024-03-15 09:00:00', '2024-03-15 09:00:00'),

(6, 'Federated Learning Implementation', 'Privacy-preserving machine learning system using federated learning. Enables collaborative model training without sharing raw data.', '# Federated Learning System

## Overview
A complete implementation of federated learning that allows multiple parties to collaboratively train machine learning models while keeping data decentralized and private.

## Features
- Secure aggregation protocol
- Differential privacy
- Client selection strategies
- Model compression
- Byzantine-robust aggregation
- Simulation framework
- Production-ready codebase

## Technologies Used
- Python
- TensorFlow Federated
- PySyft
- gRPC
- Docker
- Kubernetes

## Installation
```bash
git clone https://github.com/dr-karim/federated-learning
cd federated-learning
pip install -r requirements.txt
python setup.py install
```

## Usage
```python
from fedlearn import FederatedServer, FederatedClient

server = FederatedServer(model, num_clients=10)
server.train(rounds=100)
```

## Notes
- Supports horizontal and vertical FL
- Healthcare and finance use cases
- Research paper published at NeurIPS 2024', 'AI', 'Computer Science', NULL, 'https://github.com/dr-karim/federated-learning', NULL, NULL, 'public', 623, 0, '2024-05-20 10:30:00', '2024-05-20 10:30:00'),

(6, 'Explainable AI Dashboard', 'Interactive dashboard for interpreting black-box machine learning models. Implements SHAP, LIME, and attention visualization.', '# Explainable AI (XAI) Dashboard

## Overview
A comprehensive tool for understanding and interpreting machine learning model predictions. Provides multiple explanation techniques in an intuitive interface.

## Features
- SHAP values visualization
- LIME explanations
- Feature importance ranking
- Counterfactual examples
- Attention heatmaps (for neural nets)
- Model-agnostic methods
- Export reports

## Technologies Used
- Python & Flask
- SHAP library
- LIME
- Plotly & Dash
- scikit-learn
- TensorFlow/PyTorch

## Installation
```bash
git clone https://github.com/dr-karim/xai-dashboard
cd xai-dashboard
pip install -r requirements.txt
python app.py
```

## Usage
Upload model → Select explanation method → Analyze predictions

## Notes
- Supports classification and regression
- Works with tabular, text, and image data
- Recommended for high-stakes applications', 'AI', 'Computer Science', NULL, 'https://github.com/dr-karim/xai-dashboard', 'https://xai-demo.drkarim.com', NULL, 'public', 534, 0, '2024-07-08 14:45:00', '2024-07-08 14:45:00'),

(6, 'Automated Research Paper Summarizer', 'NLP system that automatically generates summaries of academic papers. Extracts key findings, methodology, and conclusions.', '# Research Paper Summarizer

## Overview
An advanced NLP tool that automatically reads academic papers and generates concise summaries, helping researchers stay updated with the latest publications.

## Features
- Abstract and full-text summarization
- Key finding extraction
- Methodology identification
- Citation graph analysis
- Multi-paper comparison
- PDF parsing
- BibTeX export

## Technologies Used
- Python
- BERT & SciBERT
- Hugging Face Transformers
- spaCy
- PyMuPDF
- FastAPI

## Installation
```bash
git clone https://github.com/dr-karim/paper-summarizer
cd paper-summarizer
pip install -r requirements.txt
python main.py
```

## Usage
```bash
python summarize.py --pdf path/to/paper.pdf
```

## Notes
- Optimized for CS and engineering papers
- Can process 100+ pages
- Integrates with arXiv API', 'AI', 'Computer Science', NULL, 'https://github.com/dr-karim/paper-summarizer', NULL, NULL, 'public', 456, 0, '2024-08-16 11:20:00', '2024-08-16 11:20:00'),

(6, 'Quantum Computing Simulator', 'Educational quantum computing simulator for learning quantum algorithms. Implements Shor\'s, Grover\'s, and other key algorithms.', '# Quantum Computing Simulator

## Overview
An educational quantum computing simulator designed to help students and researchers understand quantum algorithms without needing actual quantum hardware.

## Features
- Quantum circuit designer
- Built-in quantum algorithms
- State vector visualization
- Measurement simulation
- Noise modeling
- Jupyter notebook tutorials
- Step-by-step execution

## Technologies Used
- Python
- NumPy
- Qiskit (reference)
- Matplotlib
- Jupyter
- Qt (GUI)

## Installation
```bash
git clone https://github.com/dr-karim/quantum-simulator
cd quantum-simulator
pip install -r requirements.txt
python simulator.py
```

## Usage
```python
from qsim import QuantumCircuit

qc = QuantumCircuit(2)
qc.h(0)  # Hadamard gate
qc.cx(0, 1)  # CNOT gate
qc.measure_all()
result = qc.run()
```

## Notes
- Supports up to 20 qubits (simulation limit)
- Educational focus, not production-ready
- Companion textbook available', 'Research', 'Computer Science', NULL, 'https://github.com/dr-karim/quantum-simulator', NULL, NULL, 'public', 378, 0, '2024-04-12 13:30:00', '2024-04-12 13:30:00');

-- =============================================
-- INSERT PROJECT_TAGS (Assign 1-3 tags per project)
-- =============================================

-- Tag mapping reference:
-- 1: WebApp, 2: MobileApp, 3: AI, 4: MachineLearning
-- 5: IoT, 6: Hardware, 7: Design, 8: UI/UX
-- 9: Research, 10: DataScience, 11: GameDev, 12: Blockchain
-- 13: CyberSecurity, 14: CloudComputing, 15: AR/VR, 16: Robotics

INSERT INTO project_tags (project_id, tag_id) VALUES
-- Sarah's Projects (1-5)
(1, 3), (1, 4), (1, 1),  -- Smart Healthcare: AI, MachineLearning, WebApp
(2, 3), (2, 4),          -- NLP Chatbot: AI, MachineLearning
(3, 2), (3, 3), (3, 4),  -- Image Classification: MobileApp, AI, MachineLearning
(4, 3), (4, 4),          -- Facial Recognition: AI, MachineLearning
(5, 3), (5, 4),          -- Text Generator: AI, MachineLearning

-- Rafid's Projects (6-10)
(6, 1), (6, 14),         -- E-Commerce: WebApp, CloudComputing
(7, 1),                  -- Collaboration Tool: WebApp
(8, 14), (8, 1),         -- Cloud Storage: CloudComputing, WebApp
(9, 1), (9, 10),         -- Social Analytics: WebApp, DataScience
(10, 1),                 -- GraphQL Gateway: WebApp

-- Nadia's Projects (11-15)
(11, 5), (11, 6),        -- Smart Home: IoT, Hardware
(12, 5), (12, 6),        -- Weather Station: IoT, Hardware
(13, 5), (13, 6),        -- Auto Watering: IoT, Hardware
(14, 5), (14, 6),        -- Energy Meter: IoT, Hardware
(15, 5), (15, 6), (15, 3), -- Agriculture WSN: IoT, Hardware, AI

-- Tahmid's Projects (16-20)
(16, 13), (16, 4),       -- NIDS: CyberSecurity, MachineLearning
(17, 13),                -- Password Analyzer: CyberSecurity
(18, 13),                -- Vuln Scanner: CyberSecurity
(19, 13), (19, 2),       -- Encrypted Messenger: CyberSecurity, MobileApp
(20, 13), (20, 1),       -- Phishing Detector: CyberSecurity, WebApp

-- Zara's Projects (21-25)
(21, 7), (21, 8),        -- Design System: Design, UI/UX
(22, 1), (22, 7),        -- Portfolio Builder: WebApp, Design
(23, 7), (23, 8),        -- Design Toolkit: Design, UI/UX
(24, 1), (24, 9),        -- UX Research: WebApp, Research
(25, 7), (25, 8),        -- Mockup Generator: Design, UI/UX

-- Dr. Karim's Projects (26-30)
(26, 9), (26, 3), (26, 10), -- DL Framework: Research, AI, DataScience
(27, 3), (27, 9), (27, 4),  -- Federated Learning: AI, Research, MachineLearning
(28, 3), (28, 10),       -- XAI Dashboard: AI, DataScience
(29, 3), (29, 9),        -- Paper Summarizer: AI, Research
(30, 9),                 -- Quantum Simulator: Research

-- =============================================
-- INSERT LIKES (0-5 likes per project from different users)
-- =============================================

INSERT INTO likes (user_id, project_id, created_at) VALUES
-- Project 1 (Smart Healthcare) - 4 likes
(2, 1, '2024-09-16 11:20:00'),
(3, 1, '2024-09-17 09:30:00'),
(5, 1, '2024-09-18 14:15:00'),
(6, 1, '2024-09-20 10:45:00'),

-- Project 2 (NLP Chatbot) - 3 likes
(2, 2, '2024-08-23 15:30:00'),
(4, 2, '2024-08-25 11:20:00'),
(6, 2, '2024-08-28 09:10:00'),

-- Project 3 (Image Classification) - 5 likes
(2, 3, '2024-07-11 10:15:00'),
(3, 3, '2024-07-12 14:30:00'),
(4, 3, '2024-07-13 16:45:00'),
(5, 3, '2024-07-14 11:00:00'),
(6, 3, '2024-07-15 13:20:00'),

-- Project 4 (Facial Recognition) - 5 likes
(2, 4, '2024-06-19 09:30:00'),
(3, 4, '2024-06-20 11:15:00'),
(4, 4, '2024-06-21 14:40:00'),
(5, 4, '2024-06-22 10:20:00'),
(6, 4, '2024-06-23 15:30:00'),

-- Project 5 (Text Generator) - 2 likes
(3, 5, '2024-05-26 14:20:00'),
(6, 5, '2024-05-28 10:45:00'),

-- Project 6 (E-Commerce) - 5 likes
(1, 6, '2024-10-06 09:15:00'),
(3, 6, '2024-10-07 11:30:00'),
(4, 6, '2024-10-08 14:45:00'),
(5, 6, '2024-10-09 10:20:00'),
(6, 6, '2024-10-10 16:00:00'),

-- Project 7 (Collaboration Tool) - 4 likes
(1, 7, '2024-09-13 10:30:00'),
(3, 7, '2024-09-14 15:20:00'),
(5, 7, '2024-09-15 11:45:00'),
(6, 7, '2024-09-16 09:30:00'),

-- Project 8 (Cloud Storage) - 4 likes
(1, 8, '2024-08-31 11:20:00'),
(3, 8, '2024-09-01 14:30:00'),
(4, 8, '2024-09-02 10:15:00'),
(5, 8, '2024-09-03 16:45:00'),

-- Project 9 (Social Analytics) - 3 likes
(1, 9, '2024-07-16 09:45:00'),
(4, 9, '2024-07-17 13:20:00'),
(5, 9, '2024-07-18 11:30:00'),

-- Project 10 (GraphQL Gateway) - 2 likes
(1, 10, '2024-06-21 14:30:00'),
(6, 10, '2024-06-23 10:15:00'),

-- Project 11 (Smart Home) - 5 likes
(1, 11, '2024-10-21 09:30:00'),
(2, 11, '2024-10-22 11:45:00'),
(4, 11, '2024-10-23 14:20:00'),
(5, 11, '2024-10-24 10:15:00'),
(6, 11, '2024-10-25 15:30:00'),

-- Project 12 (Weather Station) - 4 likes
(1, 12, '2024-09-09 10:20:00'),
(2, 12, '2024-09-10 14:35:00'),
(5, 12, '2024-09-11 11:45:00'),
(6, 12, '2024-09-12 09:20:00'),

-- Project 13 (Auto Watering) - 3 likes
(1, 13, '2024-08-15 11:30:00'),
(2, 13, '2024-08-16 14:45:00'),
(4, 13, '2024-08-17 10:20:00'),

-- Project 14 (Energy Meter) - 4 likes
(1, 14, '2024-07-23 09:45:00'),
(2, 14, '2024-07-24 13:20:00'),
(4, 14, '2024-07-25 11:30:00'),
(6, 14, '2024-07-26 15:45:00'),

-- Project 15 (Agriculture WSN) - 3 likes
(1, 15, '2024-07-01 10:30:00'),
(2, 15, '2024-07-02 14:15:00'),
(6, 15, '2024-07-03 11:45:00'),

-- Project 16 (NIDS) - 5 likes
(1, 16, '2024-10-29 09:30:00'),
(2, 16, '2024-10-30 11:45:00'),
(3, 16, '2024-10-31 14:20:00'),
(5, 16, '2024-11-01 10:15:00'),
(6, 16, '2024-11-02 15:30:00'),

-- Project 17 (Password Analyzer) - 4 likes
(1, 17, '2024-09-19 10:20:00'),
(2, 17, '2024-09-20 14:35:00'),
(3, 17, '2024-09-21 11:45:00'),
(6, 17, '2024-09-22 09:20:00'),

-- Project 18 (Vuln Scanner) - 5 likes
(1, 18, '2024-08-26 09:30:00'),
(2, 18, '2024-08-27 11:45:00'),
(3, 18, '2024-08-28 14:20:00'),
(5, 18, '2024-08-29 10:15:00'),
(6, 18, '2024-08-30 15:30:00'),

-- Project 19 (Encrypted Messenger) - 3 likes (private project)
(1, 19, '2024-07-13 11:30:00'),
(2, 19, '2024-07-14 14:45:00'),
(3, 19, '2024-07-15 10:20:00'),

-- Project 20 (Phishing Detector) - 5 likes
(1, 20, '2024-06-06 09:45:00'),
(2, 20, '2024-06-07 13:20:00'),
(3, 20, '2024-06-08 11:30:00'),
(5, 20, '2024-06-09 15:45:00'),
(6, 20, '2024-06-10 10:30:00'),

-- Project 21 (Design System) - 4 likes
(1, 21, '2024-10-16 10:30:00'),
(2, 21, '2024-10-17 14:15:00'),
(4, 21, '2024-10-18 11:45:00'),
(6, 21, '2024-10-19 09:30:00'),

-- Project 22 (Portfolio Builder) - 5 likes
(1, 22, '2024-09-23 09:30:00'),
(2, 22, '2024-09-24 11:45:00'),
(3, 22, '2024-09-25 14:20:00'),
(4, 22, '2024-09-26 10:15:00'),
(6, 22, '2024-09-27 15:30:00'),

-- Project 23 (Design Toolkit) - 5 likes
(1, 23, '2024-08-11 10:20:00'),
(2, 23, '2024-08-12 14:35:00'),
(3, 23, '2024-08-13 11:45:00'),
(4, 23, '2024-08-14 09:20:00'),
(6, 23, '2024-08-15 15:40:00'),

-- Project 24 (UX Research) - 3 likes
(1, 24, '2024-07-19 11:30:00'),
(2, 24, '2024-07-20 14:45:00'),
(6, 24, '2024-07-21 10:20:00'),

-- Project 25 (Mockup Generator) - 4 likes
(1, 25, '2024-06-29 09:45:00'),
(2, 25, '2024-06-30 13:20:00'),
(3, 25, '2024-07-01 11:30:00'),
(4, 25, '2024-07-02 15:45:00'),

-- Project 26 (DL Framework) - 5 likes
(1, 26, '2024-03-16 10:30:00'),
(2, 26, '2024-03-17 14:15:00'),
(3, 26, '2024-03-18 11:45:00'),
(4, 26, '2024-03-19 09:30:00'),
(5, 26, '2024-03-20 15:20:00'),

-- Project 27 (Federated Learning) - 5 likes
(1, 27, '2024-05-21 09:30:00'),
(2, 27, '2024-05-22 11:45:00'),
(3, 27, '2024-05-23 14:20:00'),
(4, 27, '2024-05-24 10:15:00'),
(5, 27, '2024-05-25 15:30:00'),

-- Project 28 (XAI Dashboard) - 4 likes
(1, 28, '2024-07-09 10:20:00'),
(2, 28, '2024-07-10 14:35:00'),
(3, 28, '2024-07-11 11:45:00'),
(5, 28, '2024-07-12 09:20:00'),

-- Project 29 (Paper Summarizer) - 4 likes
(1, 29, '2024-08-17 11:30:00'),
(2, 29, '2024-08-18 14:45:00'),
(3, 29, '2024-08-19 10:20:00'),
(4, 29, '2024-08-20 15:35:00'),

-- Project 30 (Quantum Simulator) - 3 likes
(1, 30, '2024-04-13 09:45:00'),
(2, 30, '2024-04-14 13:20:00'),
(5, 30, '2024-04-15 11:30:00');

-- =============================================
-- UPDATE likes_count in projects table
-- =============================================

UPDATE projects SET likes_count = (SELECT COUNT(*) FROM likes WHERE likes.project_id = projects.project_id);

-- =============================================
-- UPDATE usage_count in tags table
-- =============================================

UPDATE tags SET usage_count = (SELECT COUNT(*) FROM project_tags WHERE project_tags.tag_id = tags.tag_id);

-- =============================================
-- VERIFICATION QUERIES (Optional - for testing)
-- =============================================

-- Check total users
-- SELECT COUNT(*) as total_users FROM users;

-- Check total projects
-- SELECT COUNT(*) as total_projects FROM projects;

-- Check projects per user
-- SELECT u.username, COUNT(p.project_id) as project_count
-- FROM users u LEFT JOIN projects p ON u.user_id = p.user_id
-- GROUP BY u.user_id;

-- Check total likes
-- SELECT COUNT(*) as total_likes FROM likes;

-- Check most liked projects
-- SELECT p.title, p.likes_count
-- FROM projects p
-- ORDER BY p.likes_count DESC
-- LIMIT 10;

-- Check most used tags
-- SELECT t.tag_name, t.usage_count
-- FROM tags t
-- ORDER BY t.usage_count DESC;

-- =============================================
-- END OF SAMPLE DATA
-- =============================================
