-- this is with all sample data of uiuarchive web
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 05, 2026 at 01:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uiuarchive`
--

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `project_blueprint` text DEFAULT NULL,
  `category` varchar(50) NOT NULL,
  `department` varchar(50) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `github_link` varchar(255) DEFAULT NULL,
  `demo_link` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `visibility` enum('public','private') DEFAULT 'public',
  `views_count` int(11) DEFAULT 0,
  `likes_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `user_id`, `title`, `description`, `project_blueprint`, `category`, `department`, `semester`, `github_link`, `demo_link`, `thumbnail`, `visibility`, `views_count`, `likes_count`, `created_at`, `updated_at`) VALUES
(1, 1, 'Smart Healthcare Diagnosis System', 'An AI-powered medical diagnosis assistant that uses machine learning to predict diseases based on symptoms. Achieved 92% accuracy using Random Forest classifier.', '# Smart Healthcare Diagnosis System\r\n\r\n## Overview\r\nAn intelligent healthcare diagnosis system that leverages machine learning algorithms to assist in preliminary disease diagnosis. The system analyzes patient symptoms and medical history to provide accurate predictions.\r\n\r\n## Features\r\n- Multi-disease prediction (Diabetes, Heart Disease, Parkinson\'s)\r\n- User-friendly web interface\r\n- Real-time prediction with confidence scores\r\n- Historical data tracking\r\n- Export reports as PDF\r\n\r\n## Technologies Used\r\n- Python 3.9\r\n- Scikit-learn\r\n- Flask\r\n- React.js\r\n- PostgreSQL\r\n- TensorFlow\r\n\r\n## Installation\r\n```bash\r\n# Clone the repository\r\ngit clone https://github.com/sarah-ahmed/smart-healthcare-diagnosis\r\n\r\n# Install backend dependencies\r\ncd backend\r\npip install -r requirements.txt\r\n\r\n# Install frontend dependencies\r\ncd ../frontend\r\nnpm install\r\n```\r\n\r\n## Usage\r\n```bash\r\n# Start backend server\r\npython app.py\r\n\r\n# Start frontend (in new terminal)\r\nnpm start\r\n```\r\n\r\n## Notes\r\n- Trained on 10,000+ medical records\r\n- Model updated quarterly with new data\r\n- Not a replacement for professional medical advice', 'AI', 'Computer Science', 'Fall 2024', 'https://github.com/sarah-ahmed/smart-healthcare-diagnosis', 'https://healthcare-diagnosis-demo.vercel.app', NULL, 'public', 245, 0, '2024-09-15 04:30:00', '2024-09-15 04:30:00'),
(2, 1, 'Natural Language Processing Chatbot', 'Advanced conversational AI chatbot using transformer models. Supports context-aware responses and multi-turn conversations with sentiment analysis.', '# NLP Chatbot\r\n\r\n## Overview\r\nA sophisticated chatbot built using state-of-the-art NLP techniques and transformer architecture. Capable of understanding context, maintaining conversation history, and providing intelligent responses.\r\n\r\n## Features\r\n- Context-aware conversations\r\n- Sentiment analysis\r\n- Multi-language support (English, Bengali)\r\n- Intent recognition\r\n- Custom training on domain-specific data\r\n\r\n## Technologies Used\r\n- Python\r\n- Transformers (Hugging Face)\r\n- BERT\r\n- FastAPI\r\n- Redis (for session management)\r\n- Docker\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/sarah-ahmed/nlp-chatbot\r\ncd nlp-chatbot\r\ndocker-compose up\r\n```\r\n\r\n## Usage\r\nAccess the API at `http://localhost:8000`\r\n\r\nExample request:\r\n```python\r\nimport requests\r\nresponse = requests.post(\"http://localhost:8000/chat\", \r\n    json={\"message\": \"Hello, how are you?\"})\r\n```\r\n\r\n## Notes\r\n- Pre-trained on 1M+ conversation pairs\r\n- Supports fine-tuning for specific domains\r\n- GPU recommended for optimal performance', 'AI', 'Computer Science', 'Fall 2024', 'https://github.com/sarah-ahmed/nlp-chatbot', NULL, NULL, 'public', 190, 0, '2024-08-22 08:20:00', '2026-01-05 12:25:41'),
(3, 1, 'Image Classification Mobile App', 'Mobile application for real-time image classification using deep learning. Identifies objects, animals, and plants with 95% accuracy using MobileNetV2.', '# Image Classification Mobile App\r\n\r\n## Overview\r\nA cross-platform mobile application that uses deep learning models to classify images in real-time. Perfect for educational purposes and quick identification needs.\r\n\r\n## Features\r\n- Real-time camera classification\r\n- Gallery image upload\r\n- 1000+ object categories\r\n- Offline mode support\r\n- Classification history\r\n- Share results on social media\r\n\r\n## Technologies Used\r\n- React Native\r\n- TensorFlow Lite\r\n- MobileNetV2\r\n- Expo\r\n- AsyncStorage\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/sarah-ahmed/image-classifier-app\r\ncd image-classifier-app\r\nnpm install\r\nexpo start\r\n```\r\n\r\n## Usage\r\n1. Open the app\r\n2. Point camera at object or upload image\r\n3. View classification results with confidence scores\r\n\r\n## Notes\r\n- Model size: 14MB (optimized for mobile)\r\n- Works offline after initial download\r\n- Supports both iOS and Android', 'MobileApp', 'Computer Science', 'Fall 2024', 'https://github.com/sarah-ahmed/image-classifier-app', 'https://expo.dev/@sarah/image-classifier', NULL, 'public', 312, 0, '2024-07-10 03:45:00', '2024-07-10 03:45:00'),
(4, 1, 'Facial Recognition Attendance System', 'Automated attendance tracking system using facial recognition technology. Reduces manual attendance time by 90% with 98% accuracy.', '# Facial Recognition Attendance System\r\n\r\n## Overview\r\nAn automated attendance management system that uses facial recognition to mark student attendance. Eliminates proxy attendance and streamlines the process.\r\n\r\n## Features\r\n- Face detection and recognition\r\n- Real-time attendance marking\r\n- Admin dashboard\r\n- Attendance reports and analytics\r\n- Email notifications\r\n- Anti-spoofing protection\r\n\r\n## Technologies Used\r\n- Python\r\n- OpenCV\r\n- dlib\r\n- Face Recognition library\r\n- Django\r\n- MySQL\r\n- Bootstrap\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/sarah-ahmed/face-attendance\r\ncd face-attendance\r\npip install -r requirements.txt\r\npython manage.py migrate\r\npython manage.py runserver\r\n```\r\n\r\n## Usage\r\n1. Admin registers students with face images\r\n2. System captures faces during class\r\n3. Automatic attendance marking\r\n4. Generate reports from dashboard\r\n\r\n## Notes\r\n- Requires good lighting for accuracy\r\n- Supports multiple faces in one frame\r\n- GDPR compliant with encrypted storage', 'AI', 'Computer Science', 'Fall 2024', 'https://github.com/sarah-ahmed/face-attendance', NULL, NULL, 'public', 428, 0, '2024-06-18 05:30:00', '2024-06-18 05:30:00'),
(5, 1, 'Predictive Text Generator', 'AI-powered text generation tool using GPT-style architecture. Generates coherent text continuations for creative writing and content creation.', '# Predictive Text Generator\r\n\r\n## Overview\r\nA neural network-based text generation system that predicts and generates coherent text continuations. Useful for creative writing assistance and content generation.\r\n\r\n## Features\r\n- Context-aware text generation\r\n- Multiple writing styles\r\n- Temperature control for creativity\r\n- Batch generation\r\n- Fine-tuning on custom datasets\r\n\r\n## Technologies Used\r\n- Python\r\n- PyTorch\r\n- Transformers\r\n- Streamlit\r\n- CUDA\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/sarah-ahmed/text-generator\r\ncd text-generator\r\npip install -r requirements.txt\r\nstreamlit run app.py\r\n```\r\n\r\n## Usage\r\nEnter seed text and adjust parameters to generate continuations.\r\n\r\n## Notes\r\n- Trained on diverse text corpus\r\n- GPU acceleration supported\r\n- Avoid using for misinformation', 'AI', 'Computer Science', 'Fall 2024', 'https://github.com/sarah-ahmed/text-generator', 'https://text-gen-demo.streamlit.app', NULL, 'public', 156, 0, '2024-05-25 07:15:00', '2024-05-25 07:15:00'),
(6, 2, 'E-Commerce Platform with Microservices', 'Scalable e-commerce platform built with microservices architecture. Handles 10,000+ concurrent users with load balancing and auto-scaling.', '# E-Commerce Microservices Platform\r\n\r\n## Overview\r\nA modern e-commerce platform designed with microservices architecture for scalability and maintainability. Features include product catalog, shopping cart, payment processing, and order management.\r\n\r\n## Features\r\n- Product catalog with search and filters\r\n- User authentication (JWT)\r\n- Shopping cart and wishlist\r\n- Payment gateway integration (Stripe)\r\n- Order tracking\r\n- Admin dashboard\r\n- RESTful APIs\r\n\r\n## Technologies Used\r\n- Node.js & Express\r\n- React.js\r\n- MongoDB\r\n- Redis\r\n- Docker & Kubernetes\r\n- AWS (EC2, S3, RDS)\r\n- Nginx\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/rafid-khan/ecommerce-microservices\r\ncd ecommerce-microservices\r\ndocker-compose up\r\n```\r\n\r\n## Usage\r\nAccess the platform at `http://localhost:3000`\r\nAdmin panel: `http://localhost:3000/admin`\r\n\r\n## Notes\r\n- Follows 12-factor app methodology\r\n- CI/CD pipeline with GitHub Actions\r\n- Monitoring with Prometheus and Grafana', 'WebApp', 'Computer Science', 'Spring 2024', 'https://github.com/rafid-khan/ecommerce-microservices', 'https://ecommerce-demo.rafidkhan.com', NULL, 'public', 567, 0, '2024-10-05 09:40:00', '2024-10-05 09:40:00'),
(7, 2, 'Real-Time Collaboration Tool', 'Web-based collaborative workspace similar to Notion. Features real-time editing, comments, and team collaboration with WebSocket integration.', '# Real-Time Collaboration Tool\r\n\r\n## Overview\r\nA collaborative workspace application that enables teams to work together in real-time. Features include document editing, task management, and team chat.\r\n\r\n## Features\r\n- Real-time collaborative editing\r\n- Rich text editor\r\n- Task boards (Kanban style)\r\n- Team chat and mentions\r\n- File sharing\r\n- Version history\r\n- Workspace management\r\n\r\n## Technologies Used\r\n- React.js & TypeScript\r\n- Node.js\r\n- Socket.io\r\n- PostgreSQL\r\n- Quill.js (editor)\r\n- Tailwind CSS\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/rafid-khan/collab-tool\r\ncd collab-tool\r\nnpm install\r\nnpm run dev\r\n```\r\n\r\n## Usage\r\n1. Create workspace\r\n2. Invite team members\r\n3. Start collaborating in real-time\r\n\r\n## Notes\r\n- Operational Transform for conflict resolution\r\n- End-to-end encryption for sensitive data\r\n- Offline support with sync', 'WebApp', 'Computer Science', 'Spring 2024', 'https://github.com/rafid-khan/collab-tool', 'https://collab.rafidkhan.com', NULL, 'public', 389, 0, '2024-09-12 04:20:00', '2024-09-12 04:20:00'),
(8, 2, 'Cloud Storage Service', 'Dropbox-like cloud storage solution with file synchronization, sharing, and version control. Supports 5GB free storage per user.', '# Cloud Storage Service\r\n\r\n## Overview\r\nA personal cloud storage service that allows users to upload, store, and share files securely. Features automatic synchronization across devices.\r\n\r\n## Features\r\n- File upload/download\r\n- Folder synchronization\r\n- File sharing with permissions\r\n- Version control\r\n- File preview (images, PDFs, docs)\r\n- Search functionality\r\n- Storage analytics\r\n\r\n## Technologies Used\r\n- Python & Flask\r\n- AWS S3\r\n- PostgreSQL\r\n- Celery (background tasks)\r\n- Redis\r\n- Vue.js\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/rafid-khan/cloud-storage\r\ncd cloud-storage\r\npip install -r requirements.txt\r\npython app.py\r\n```\r\n\r\n## Usage\r\nRegister account → Upload files → Access from any device\r\n\r\n## Notes\r\n- Files encrypted at rest and in transit\r\n- Incremental backup support\r\n- Rate limiting to prevent abuse', 'CloudComputing', 'Computer Science', 'Spring 2024', 'https://github.com/rafid-khan/cloud-storage', NULL, NULL, 'public', 423, 0, '2024-08-30 08:50:00', '2024-08-30 08:50:00'),
(9, 2, 'Social Media Analytics Dashboard', 'Comprehensive analytics dashboard for social media insights. Tracks engagement, sentiment, and trends across multiple platforms.', '# Social Media Analytics Dashboard\r\n\r\n## Overview\r\nAn analytics platform that aggregates data from multiple social media platforms and provides actionable insights through interactive visualizations.\r\n\r\n## Features\r\n- Multi-platform integration (Twitter, Instagram, Facebook)\r\n- Engagement metrics\r\n- Sentiment analysis\r\n- Trend detection\r\n- Custom reports\r\n- Schedule posts\r\n- Competitor analysis\r\n\r\n## Technologies Used\r\n- React.js & D3.js\r\n- Node.js & Express\r\n- MongoDB\r\n- Python (data processing)\r\n- Twitter API, Instagram API\r\n- Chart.js\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/rafid-khan/social-analytics\r\ncd social-analytics\r\nnpm install\r\nnpm start\r\n```\r\n\r\n## Usage\r\n1. Connect social media accounts\r\n2. View analytics dashboard\r\n3. Generate reports\r\n\r\n## Notes\r\n- OAuth 2.0 authentication\r\n- Real-time data updates\r\n- Export reports as PDF/CSV', 'WebApp', 'Computer Science', 'Spring 2024', 'https://github.com/rafid-khan/social-analytics', 'https://analytics.rafidkhan.com', NULL, 'public', 298, 0, '2024-07-15 03:30:00', '2024-07-15 03:30:00'),
(10, 2, 'GraphQL API Gateway', 'Unified GraphQL API gateway that aggregates multiple REST APIs. Reduces over-fetching and improves client-side performance.', '# GraphQL API Gateway\r\n\r\n## Overview\r\nA GraphQL API gateway that provides a unified interface for multiple backend services. Optimizes data fetching and reduces network overhead.\r\n\r\n## Features\r\n- Schema stitching\r\n- Query batching\r\n- Caching layer\r\n- Authentication & authorization\r\n- Rate limiting\r\n- API documentation (GraphiQL)\r\n- Monitoring and logging\r\n\r\n## Technologies Used\r\n- Node.js\r\n- Apollo Server\r\n- GraphQL\r\n- Redis\r\n- Docker\r\n- Prometheus\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/rafid-khan/graphql-gateway\r\ncd graphql-gateway\r\nnpm install\r\nnpm start\r\n```\r\n\r\n## Usage\r\nAccess GraphiQL playground at `http://localhost:4000/graphql`\r\n\r\n## Notes\r\n- Supports subscriptions for real-time data\r\n- DataLoader for batching and caching\r\n- Schema-first development approach', 'WebApp', 'Computer Science', 'Spring 2024', 'https://github.com/rafid-khan/graphql-gateway', NULL, NULL, 'public', 167, 0, '2024-06-20 10:10:00', '2024-06-20 10:10:00'),
(11, 3, 'Smart Home Automation System', 'IoT-based home automation system controlling lights, temperature, and security. Accessible via mobile app with voice control integration.', '# Smart Home Automation System\r\n\r\n## Overview\r\nA comprehensive IoT solution for home automation that allows users to control various home appliances remotely. Features include scheduling, automation rules, and voice control.\r\n\r\n## Features\r\n- Remote appliance control\r\n- Temperature and humidity monitoring\r\n- Motion detection and alerts\r\n- Voice control (Alexa/Google Home)\r\n- Energy consumption tracking\r\n- Automation rules and scheduling\r\n- Mobile app (iOS/Android)\r\n\r\n## Technologies Used\r\n- Arduino/ESP8266\r\n- MQTT protocol\r\n- Node.js backend\r\n- React Native\r\n- Firebase\r\n- Sensors: DHT22, PIR, Relay modules\r\n\r\n## Installation\r\n```bash\r\n# Flash Arduino code\r\narduino-cli upload -p /dev/ttyUSB0\r\n\r\n# Setup backend\r\ngit clone https://github.com/nadia-islam/smart-home\r\ncd smart-home\r\nnpm install\r\nnpm start\r\n```\r\n\r\n## Usage\r\n1. Connect devices to WiFi\r\n2. Register devices in mobile app\r\n3. Control via app or voice commands\r\n\r\n## Notes\r\n- Supports 2.4GHz WiFi only\r\n- Low power consumption mode available\r\n- Local network operation for privacy', 'IoT', 'Electrical Engineering', 'Fall 2023', 'https://github.com/nadia-islam/smart-home', NULL, NULL, 'public', 513, 0, '2024-10-20 05:25:00', '2026-01-05 12:25:34'),
(12, 3, 'IoT Weather Station', 'Advanced weather monitoring station with IoT capabilities. Tracks temperature, humidity, pressure, and air quality with data visualization.', '# IoT Weather Station\r\n\r\n## Overview\r\nA DIY weather station that collects environmental data and transmits it to the cloud for real-time monitoring and historical analysis.\r\n\r\n## Features\r\n- Temperature and humidity sensing\r\n- Barometric pressure measurement\r\n- Air quality index (PM2.5, PM10)\r\n- Wind speed and direction\r\n- Rainfall detection\r\n- Solar-powered option\r\n- Web dashboard with graphs\r\n\r\n## Technologies Used\r\n- Raspberry Pi\r\n- Python\r\n- BME280, MQ135 sensors\r\n- InfluxDB\r\n- Grafana\r\n- MQTT\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/nadia-islam/weather-station\r\ncd weather-station\r\npip install -r requirements.txt\r\npython main.py\r\n```\r\n\r\n## Usage\r\nAccess dashboard at `http://raspberry-pi-ip:3000`\r\n\r\n## Notes\r\n- 5-minute data logging interval\r\n- Battery backup for power outages\r\n- Weather API integration for forecasts', 'IoT', 'Electrical Engineering', 'Fall 2023', 'https://github.com/nadia-islam/weather-station', 'https://weather.nadiaislam.com', NULL, 'public', 345, 0, '2024-09-08 07:40:00', '2024-09-08 07:40:00'),
(13, 3, 'Automated Plant Watering System', 'Smart irrigation system using soil moisture sensors. Automatically waters plants based on soil conditions and weather forecasts.', '# Automated Plant Watering System\r\n\r\n## Overview\r\nAn intelligent plant care system that monitors soil moisture and automatically waters plants when needed. Prevents over-watering and under-watering.\r\n\r\n## Features\r\n- Soil moisture monitoring\r\n- Automatic watering\r\n- Weather forecast integration\r\n- Water level alerts\r\n- Schedule override\r\n- Multiple plant zones\r\n- Mobile notifications\r\n\r\n## Technologies Used\r\n- Arduino Uno\r\n- Soil moisture sensors\r\n- Water pump and relay\r\n- ESP8266 (WiFi)\r\n- Blynk platform\r\n- OpenWeather API\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/nadia-islam/auto-watering\r\n# Upload Arduino sketch via Arduino IDE\r\n# Configure Blynk app with auth token\r\n```\r\n\r\n## Usage\r\n1. Insert sensors in soil\r\n2. Set moisture thresholds in app\r\n3. System waters automatically\r\n\r\n## Notes\r\n- Solar panel compatible\r\n- Adjustable watering duration\r\n- Works offline with basic features', 'IoT', 'Electrical Engineering', 'Fall 2023', 'https://github.com/nadia-islam/auto-watering', NULL, NULL, 'public', 289, 0, '2024-08-14 04:15:00', '2024-08-14 04:15:00'),
(14, 3, 'Smart Energy Meter', 'IoT energy monitoring device that tracks real-time power consumption. Helps reduce electricity bills by 20% through usage insights.', '# Smart Energy Meter\r\n\r\n## Overview\r\nA smart electricity meter that monitors power consumption in real-time and provides detailed analytics to help reduce energy waste.\r\n\r\n## Features\r\n- Real-time power monitoring\r\n- Daily/monthly consumption reports\r\n- Appliance-level tracking\r\n- Cost estimation\r\n- Peak usage alerts\r\n- Energy saving tips\r\n- Historical data analysis\r\n\r\n## Technologies Used\r\n- ESP32\r\n- ACS712 current sensor\r\n- PZEM-004T module\r\n- Node-RED\r\n- InfluxDB\r\n- Grafana\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/nadia-islam/smart-energy-meter\r\n# Flash ESP32 with provided firmware\r\n# Import Node-RED flow\r\n# Configure Grafana dashboards\r\n```\r\n\r\n## Usage\r\nInstall device in electrical panel → View data on dashboard\r\n\r\n## Notes\r\n- Non-invasive installation\r\n- Supports single and three-phase systems\r\n- Data exported to CSV for analysis', 'IoT', 'Electrical Engineering', 'Fall 2023', 'https://github.com/nadia-islam/smart-energy-meter', NULL, NULL, 'public', 401, 0, '2024-07-22 09:30:00', '2024-07-22 09:30:00'),
(15, 3, 'Wireless Sensor Network for Agriculture', 'Large-scale agricultural monitoring system using wireless sensor networks. Monitors crop health across vast farmlands.', '# Agricultural Wireless Sensor Network\r\n\r\n## Overview\r\nA distributed sensor network designed for precision agriculture. Monitors soil conditions, crop health, and environmental factors across large agricultural areas.\r\n\r\n## Features\r\n- Multi-sensor deployment\r\n- Mesh networking\r\n- Soil NPK levels\r\n- Crop disease detection\r\n- Irrigation recommendations\r\n- Drone integration\r\n- Farmer mobile app\r\n\r\n## Technologies Used\r\n- LoRa (Long Range)\r\n- Raspberry Pi gateway\r\n- Arduino sensor nodes\r\n- Python data processing\r\n- Machine learning (crop analysis)\r\n- MySQL database\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/nadia-islam/agri-wsn\r\ncd agri-wsn\r\npip install -r requirements.txt\r\npython gateway.py\r\n```\r\n\r\n## Usage\r\nDeploy sensor nodes → Collect data → Analyze via dashboard\r\n\r\n## Notes\r\n- 10km+ communication range\r\n- Solar powered sensor nodes\r\n- Predictive analytics for yield optimization', 'IoT', 'Electrical Engineering', 'Fall 2023', 'https://github.com/nadia-islam/agri-wsn', NULL, NULL, 'public', 278, 0, '2024-06-30 03:50:00', '2024-06-30 03:50:00'),
(16, 4, 'Network Intrusion Detection System', 'ML-based intrusion detection system that identifies malicious network traffic. Detects 95% of common attack patterns in real-time.', '# Network Intrusion Detection System (NIDS)\r\n\r\n## Overview\r\nA machine learning-based network security tool that monitors network traffic and detects potential intrusions and attacks using behavioral analysis.\r\n\r\n## Features\r\n- Real-time packet analysis\r\n- Anomaly detection\r\n- Signature-based detection\r\n- Alert system with severity levels\r\n- Traffic visualization\r\n- Attack pattern database\r\n- Integration with SIEM systems\r\n\r\n## Technologies Used\r\n- Python & Scapy\r\n- Scikit-learn\r\n- Snort (signature engine)\r\n- Elasticsearch\r\n- Kibana\r\n- Random Forest classifier\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/tahmid-hassan/nids\r\ncd nids\r\npip install -r requirements.txt\r\nsudo python nids.py -i eth0\r\n```\r\n\r\n## Usage\r\nRun with sudo/admin privileges to capture packets\r\nConfigure rules in `config.yaml`\r\n\r\n## Notes\r\n- Requires promiscuous mode\r\n- High CPU usage during peak traffic\r\n- Regular signature updates needed', 'CyberSecurity', 'Computer Science', 'Spring 2025', 'https://github.com/tahmid-hassan/nids', NULL, NULL, 'public', 470, 0, '2024-10-28 08:20:00', '2026-01-05 12:25:23'),
(17, 4, 'Password Strength Analyzer & Generator', 'Advanced password security tool that analyzes password strength and generates cryptographically secure passwords. Checks against 10M+ breached passwords.', '# Password Strength Analyzer & Generator\r\n\r\n## Overview\r\nA comprehensive password security tool that evaluates password strength, checks against known breaches, and generates secure passwords based on customizable criteria.\r\n\r\n## Features\r\n- Entropy calculation\r\n- Dictionary attack simulation\r\n- Breach database check (HIBP API)\r\n- Password generation with custom rules\r\n- Strength visualization\r\n- Security recommendations\r\n- Browser extension available\r\n\r\n## Technologies Used\r\n- Python\r\n- zxcvbn algorithm\r\n- Have I Been Pwned API\r\n- JavaScript (browser extension)\r\n- Crypto libraries\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/tahmid-hassan/password-analyzer\r\ncd password-analyzer\r\npip install -r requirements.txt\r\npython analyzer.py\r\n```\r\n\r\n## Usage\r\n```python\r\nfrom analyzer import check_password\r\nresult = check_password(\"yourpassword\")\r\nprint(result)\r\n```\r\n\r\n## Notes\r\n- Zero-knowledge architecture\r\n- Passwords never stored or transmitted\r\n- Open source and auditable', 'CyberSecurity', 'Computer Science', 'Spring 2025', 'https://github.com/tahmid-hassan/password-analyzer', 'https://passcheck.tahmidhassan.com', NULL, 'public', 367, 0, '2024-09-18 05:35:00', '2024-09-18 05:35:00'),
(18, 4, 'Vulnerability Scanner for Web Apps', 'Automated web application vulnerability scanner that detects SQL injection, XSS, CSRF, and other OWASP Top 10 vulnerabilities.', '# Web Application Vulnerability Scanner\r\n\r\n## Overview\r\nAn automated security testing tool that scans web applications for common vulnerabilities and generates detailed reports with remediation suggestions.\r\n\r\n## Features\r\n- SQL injection detection\r\n- XSS (Cross-Site Scripting) testing\r\n- CSRF vulnerability check\r\n- Security header analysis\r\n- SSL/TLS configuration audit\r\n- Directory traversal detection\r\n- Detailed HTML reports\r\n\r\n## Technologies Used\r\n- Python\r\n- Requests library\r\n- BeautifulSoup\r\n- Selenium\r\n- OWASP ZAP integration\r\n- JSON report format\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/tahmid-hassan/web-vuln-scanner\r\ncd web-vuln-scanner\r\npip install -r requirements.txt\r\npython scanner.py -u https://target.com\r\n```\r\n\r\n## Usage\r\n```bash\r\n# Basic scan\r\npython scanner.py -u https://example.com\r\n\r\n# Full scan with authentication\r\npython scanner.py -u https://example.com -a cookie.txt --full\r\n```\r\n\r\n## Notes\r\n- Only scan authorized targets\r\n- May trigger WAF/IDS alerts\r\n- False positives possible - manual verification recommended', 'CyberSecurity', 'Computer Science', 'Spring 2025', 'https://github.com/tahmid-hassan/web-vuln-scanner', NULL, NULL, 'public', 523, 0, '2024-08-25 10:45:00', '2024-08-25 10:45:00'),
(19, 4, 'Encrypted Messaging Application', 'End-to-end encrypted messaging app with perfect forward secrecy. Built with Signal protocol for maximum privacy.', '# Encrypted Messaging Application\r\n\r\n## Overview\r\nA privacy-focused messaging application that implements end-to-end encryption using the Signal protocol. No messages are stored on servers.\r\n\r\n## Features\r\n- End-to-end encryption\r\n- Perfect forward secrecy\r\n- Self-destructing messages\r\n- Screen security (screenshot prevention)\r\n- Encrypted file sharing\r\n- Group chats (encrypted)\r\n- No phone number required\r\n\r\n## Technologies Used\r\n- React Native\r\n- libsignal-protocol\r\n- WebRTC (voice/video calls)\r\n- Node.js backend\r\n- MongoDB (metadata only)\r\n- Socket.io\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/tahmid-hassan/encrypted-messenger\r\ncd encrypted-messenger\r\nnpm install\r\nexpo start\r\n```\r\n\r\n## Usage\r\n1. Install app on device\r\n2. Create account with username\r\n3. Start secure conversations\r\n\r\n## Notes\r\n- Messages deleted from server after delivery\r\n- Metadata minimization\r\n- Open source for security audits', 'CyberSecurity', 'Computer Science', 'Spring 2025', 'https://github.com/tahmid-hassan/encrypted-messenger', NULL, NULL, 'private', 234, 0, '2024-07-12 04:20:00', '2024-07-12 04:20:00'),
(20, 4, 'Phishing Detection Browser Extension', 'Chrome/Firefox extension that detects phishing websites using ML and heuristics. Protects users from credential theft.', '# Phishing Detection Browser Extension\r\n\r\n## Overview\r\nA browser extension that analyzes websites in real-time and warns users about potential phishing attempts using machine learning and heuristic rules.\r\n\r\n## Features\r\n- Real-time URL analysis\r\n- Domain reputation check\r\n- Visual similarity detection\r\n- SSL certificate verification\r\n- Suspicious form detection\r\n- Report phishing sites\r\n- Privacy-focused (local processing)\r\n\r\n## Technologies Used\r\n- JavaScript\r\n- TensorFlow.js\r\n- Chrome/Firefox Extension APIs\r\n- PhishTank API\r\n- VirusTotal API\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/tahmid-hassan/phishing-detector\r\ncd phishing-detector\r\nnpm install\r\nnpm run build\r\n# Load unpacked extension in browser\r\n```\r\n\r\n## Usage\r\nInstall extension → Browse normally → Get alerts on suspicious sites\r\n\r\n## Notes\r\n- No browsing data collected\r\n- Works offline with cached models\r\n- Regular signature updates', 'CyberSecurity', 'Computer Science', 'Spring 2025', 'https://github.com/tahmid-hassan/phishing-detector', NULL, NULL, 'public', 445, 0, '2024-06-05 07:55:00', '2024-06-05 07:55:00'),
(21, 5, 'Design System Component Library', 'Comprehensive React component library following Material Design principles. Includes 50+ customizable components with accessibility support.', '# Design System Component Library\r\n\r\n## Overview\r\nA complete design system and component library for React applications. Provides consistent, accessible, and customizable UI components.\r\n\r\n## Features\r\n- 50+ React components\r\n- Dark mode support\r\n- Accessibility (WCAG 2.1 AA)\r\n- TypeScript support\r\n- Storybook documentation\r\n- Theming system\r\n- Responsive design\r\n- Icon library\r\n\r\n## Technologies Used\r\n- React & TypeScript\r\n- Styled Components\r\n- Storybook\r\n- Jest & React Testing Library\r\n- Rollup (bundler)\r\n- Figma (design)\r\n\r\n## Installation\r\n```bash\r\nnpm install @zara/design-system\r\n```\r\n\r\n## Usage\r\n```jsx\r\nimport { Button, Card, Modal } from \"@zara/design-system\";\r\n\r\nfunction App() {\r\n  return <Button variant=\"primary\">Click me</Button>;\r\n}\r\n```\r\n\r\n## Notes\r\n- Tree-shakeable for optimal bundle size\r\n- Comprehensive documentation\r\n- Active maintenance and updates', 'Design', 'Business Administration', 'Fall 2024', 'https://github.com/zara-rahman/design-system', 'https://design-system.zararahman.com', NULL, 'public', 389, 0, '2024-10-15 03:30:00', '2024-10-15 03:30:00'),
(22, 5, 'Portfolio Website Builder', 'No-code portfolio website builder with drag-and-drop interface. Perfect for designers and creatives to showcase their work.', '# Portfolio Website Builder\r\n\r\n## Overview\r\nA user-friendly website builder that allows designers and creatives to build stunning portfolio websites without writing code. Features drag-and-drop editor and beautiful templates.\r\n\r\n## Features\r\n- Drag-and-drop editor\r\n- 20+ premium templates\r\n- Custom domain support\r\n- SEO optimization\r\n- Analytics integration\r\n- Contact forms\r\n- Gallery and lightbox\r\n- Mobile responsive\r\n\r\n## Technologies Used\r\n- React & Next.js\r\n- GrapesJS (editor)\r\n- MongoDB\r\n- AWS S3 (hosting)\r\n- Stripe (payments)\r\n- Tailwind CSS\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/zara-rahman/portfolio-builder\r\ncd portfolio-builder\r\nnpm install\r\nnpm run dev\r\n```\r\n\r\n## Usage\r\n1. Choose template\r\n2. Customize with drag-and-drop\r\n3. Publish to custom domain\r\n\r\n## Notes\r\n- Free tier available\r\n- Export HTML/CSS code\r\n- Regular template updates', 'WebApp', 'Business Administration', 'Fall 2024', 'https://github.com/zara-rahman/portfolio-builder', 'https://portfoliobuilder.zararahman.com', NULL, 'public', 567, 0, '2024-09-22 08:15:00', '2024-09-22 08:15:00'),
(23, 5, 'UI/UX Design Toolkit', 'Figma plugin with design utilities, accessibility checkers, and color palette generators. Used by 5000+ designers worldwide.', '# UI/UX Design Toolkit - Figma Plugin\r\n\r\n## Overview\r\nA comprehensive Figma plugin that provides designers with essential tools for creating accessible, beautiful, and consistent designs.\r\n\r\n## Features\r\n- Color contrast checker\r\n- Typography scale generator\r\n- Accessibility audit\r\n- Design token exporter\r\n- Lorem ipsum generator\r\n- Icon library (1000+ icons)\r\n- Spacing system helper\r\n- Component organizer\r\n\r\n## Technologies Used\r\n- TypeScript\r\n- Figma Plugin API\r\n- React (UI)\r\n- Webpack\r\n- WCAG guidelines\r\n\r\n## Installation\r\nInstall from Figma Community: \"Design Toolkit by Zara\"\r\n\r\nOr install manually:\r\n```bash\r\ngit clone https://github.com/zara-rahman/design-toolkit\r\ncd design-toolkit\r\nnpm install\r\nnpm run build\r\n```\r\n\r\n## Usage\r\nOpen plugin in Figma → Select tool → Apply to design\r\n\r\n## Notes\r\n- Free and open source\r\n- Regular updates with new features\r\n- Community-driven development', 'Design', 'Business Administration', 'Fall 2024', 'https://github.com/zara-rahman/design-toolkit', NULL, NULL, 'public', 672, 0, '2024-08-10 05:40:00', '2024-08-10 05:40:00'),
(24, 5, 'User Research and Testing Platform', 'Platform for conducting user research, usability testing, and feedback collection. Streamlines the UX research process.', '# User Research and Testing Platform\r\n\r\n## Overview\r\nA comprehensive platform for UX researchers and designers to conduct user interviews, usability tests, and collect feedback efficiently.\r\n\r\n## Features\r\n- Remote usability testing\r\n- User interview scheduling\r\n- Screen recording\r\n- Survey creation\r\n- Heatmap generation\r\n- Participant recruitment\r\n- Report generation\r\n- Collaboration tools\r\n\r\n## Technologies Used\r\n- React & Redux\r\n- Node.js & Express\r\n- PostgreSQL\r\n- WebRTC (screen sharing)\r\n- Socket.io\r\n- Chart.js\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/zara-rahman/ux-research-platform\r\ncd ux-research-platform\r\nnpm install\r\nnpm run dev\r\n```\r\n\r\n## Usage\r\n1. Create research project\r\n2. Recruit participants\r\n3. Conduct tests\r\n4. Analyze results\r\n\r\n## Notes\r\n- GDPR compliant\r\n- Video storage for 30 days\r\n- Integrates with design tools', 'WebApp', 'Business Administration', 'Fall 2024', 'https://github.com/zara-rahman/ux-research-platform', 'https://uxresearch.zararahman.com', NULL, 'public', 298, 0, '2024-07-18 09:25:00', '2024-07-18 09:25:00'),
(25, 5, 'Mobile App Mockup Generator', 'Tool for quickly generating mobile app mockups and prototypes. Exports to various formats for presentations and client pitches.', '# Mobile App Mockup Generator\r\n\r\n## Overview\r\nA fast and easy tool for creating professional mobile app mockups without design skills. Perfect for quick prototyping and client presentations.\r\n\r\n## Features\r\n- Device frame library (iOS/Android)\r\n- Screenshot upload\r\n- Background customization\r\n- Shadow and reflection effects\r\n- Batch processing\r\n- Export to PNG/PDF\r\n- Presentation mode\r\n- Custom branding\r\n\r\n## Technologies Used\r\n- React\r\n- Canvas API\r\n- TypeScript\r\n- Zustand (state)\r\n- File-saver\r\n- PDFKit\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/zara-rahman/mockup-generator\r\ncd mockup-generator\r\nnpm install\r\nnpm start\r\n```\r\n\r\n## Usage\r\n1. Upload screenshots\r\n2. Select device frame\r\n3. Customize appearance\r\n4. Export mockup\r\n\r\n## Notes\r\n- No watermarks\r\n- High resolution exports\r\n- Works offline as PWA', 'Design', 'Business Administration', 'Fall 2024', 'https://github.com/zara-rahman/mockup-generator', 'https://mockups.zararahman.com', NULL, 'public', 445, 0, '2024-06-28 04:50:00', '2024-06-28 04:50:00'),
(26, 6, 'Deep Learning Framework Comparison', 'Comprehensive research comparing TensorFlow, PyTorch, and JAX. Benchmarks performance, ease of use, and ecosystem maturity.', '# Deep Learning Framework Comparison Study\r\n\r\n## Overview\r\nAn extensive research project comparing the three major deep learning frameworks: TensorFlow, PyTorch, and JAX. Includes performance benchmarks and developer experience analysis.\r\n\r\n## Features\r\n- Performance benchmarks (training/inference)\r\n- Memory usage analysis\r\n- API usability comparison\r\n- Ecosystem evaluation\r\n- Migration guides\r\n- Best practices\r\n- Real-world use cases\r\n\r\n## Technologies Used\r\n- TensorFlow 2.x\r\n- PyTorch 2.x\r\n- JAX\r\n- CUDA\r\n- Python\r\n- Jupyter Notebooks\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/dr-karim/dl-framework-comparison\r\ncd dl-framework-comparison\r\npip install -r requirements.txt\r\njupyter notebook\r\n```\r\n\r\n## Usage\r\nRun benchmark notebooks in `/benchmarks` directory\r\nView analysis in `/reports` directory\r\n\r\n## Notes\r\n- Tested on NVIDIA RTX 3090\r\n- Results may vary with different hardware\r\n- Updated quarterly with new versions', 'Research', 'Computer Science', NULL, 'https://github.com/dr-karim/dl-framework-comparison', NULL, NULL, 'public', 789, 0, '2024-03-15 03:00:00', '2024-03-15 03:00:00'),
(27, 6, 'Federated Learning Implementation', 'Privacy-preserving machine learning system using federated learning. Enables collaborative model training without sharing raw data.', '# Federated Learning System\r\n\r\n## Overview\r\nA complete implementation of federated learning that allows multiple parties to collaboratively train machine learning models while keeping data decentralized and private.\r\n\r\n## Features\r\n- Secure aggregation protocol\r\n- Differential privacy\r\n- Client selection strategies\r\n- Model compression\r\n- Byzantine-robust aggregation\r\n- Simulation framework\r\n- Production-ready codebase\r\n\r\n## Technologies Used\r\n- Python\r\n- TensorFlow Federated\r\n- PySyft\r\n- gRPC\r\n- Docker\r\n- Kubernetes\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/dr-karim/federated-learning\r\ncd federated-learning\r\npip install -r requirements.txt\r\npython setup.py install\r\n```\r\n\r\n## Usage\r\n```python\r\nfrom fedlearn import FederatedServer, FederatedClient\r\n\r\nserver = FederatedServer(model, num_clients=10)\r\nserver.train(rounds=100)\r\n```\r\n\r\n## Notes\r\n- Supports horizontal and vertical FL\r\n- Healthcare and finance use cases\r\n- Research paper published at NeurIPS 2024', 'AI', 'Computer Science', NULL, 'https://github.com/dr-karim/federated-learning', NULL, NULL, 'public', 623, 0, '2024-05-20 04:30:00', '2024-05-20 04:30:00'),
(28, 6, 'Explainable AI Dashboard', 'Interactive dashboard for interpreting black-box machine learning models. Implements SHAP, LIME, and attention visualization.', '# Explainable AI (XAI) Dashboard\r\n\r\n## Overview\r\nA comprehensive tool for understanding and interpreting machine learning model predictions. Provides multiple explanation techniques in an intuitive interface.\r\n\r\n## Features\r\n- SHAP values visualization\r\n- LIME explanations\r\n- Feature importance ranking\r\n- Counterfactual examples\r\n- Attention heatmaps (for neural nets)\r\n- Model-agnostic methods\r\n- Export reports\r\n\r\n## Technologies Used\r\n- Python & Flask\r\n- SHAP library\r\n- LIME\r\n- Plotly & Dash\r\n- scikit-learn\r\n- TensorFlow/PyTorch\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/dr-karim/xai-dashboard\r\ncd xai-dashboard\r\npip install -r requirements.txt\r\npython app.py\r\n```\r\n\r\n## Usage\r\nUpload model → Select explanation method → Analyze predictions\r\n\r\n## Notes\r\n- Supports classification and regression\r\n- Works with tabular, text, and image data\r\n- Recommended for high-stakes applications', 'AI', 'Computer Science', NULL, 'https://github.com/dr-karim/xai-dashboard', 'https://xai-demo.drkarim.com', NULL, 'public', 534, 0, '2024-07-08 08:45:00', '2024-07-08 08:45:00'),
(29, 6, 'Automated Research Paper Summarizer', 'NLP system that automatically generates summaries of academic papers. Extracts key findings, methodology, and conclusions.', '# Research Paper Summarizer\r\n\r\n## Overview\r\nAn advanced NLP tool that automatically reads academic papers and generates concise summaries, helping researchers stay updated with the latest publications.\r\n\r\n## Features\r\n- Abstract and full-text summarization\r\n- Key finding extraction\r\n- Methodology identification\r\n- Citation graph analysis\r\n- Multi-paper comparison\r\n- PDF parsing\r\n- BibTeX export\r\n\r\n## Technologies Used\r\n- Python\r\n- BERT & SciBERT\r\n- Hugging Face Transformers\r\n- spaCy\r\n- PyMuPDF\r\n- FastAPI\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/dr-karim/paper-summarizer\r\ncd paper-summarizer\r\npip install -r requirements.txt\r\npython main.py\r\n```\r\n\r\n## Usage\r\n```bash\r\npython summarize.py --pdf path/to/paper.pdf\r\n```\r\n\r\n## Notes\r\n- Optimized for CS and engineering papers\r\n- Can process 100+ pages\r\n- Integrates with arXiv API', 'AI', 'Computer Science', NULL, 'https://github.com/dr-karim/paper-summarizer', NULL, NULL, 'public', 456, 0, '2024-08-16 05:20:00', '2024-08-16 05:20:00'),
(30, 6, 'Quantum Computing Simulator', 'Educational quantum computing simulator for learning quantum algorithms. Implements Shor\'s, Grover\'s, and other key algorithms.', '# Quantum Computing Simulator\r\n\r\n## Overview\r\nAn educational quantum computing simulator designed to help students and researchers understand quantum algorithms without needing actual quantum hardware.\r\n\r\n## Features\r\n- Quantum circuit designer\r\n- Built-in quantum algorithms\r\n- State vector visualization\r\n- Measurement simulation\r\n- Noise modeling\r\n- Jupyter notebook tutorials\r\n- Step-by-step execution\r\n\r\n## Technologies Used\r\n- Python\r\n- NumPy\r\n- Qiskit (reference)\r\n- Matplotlib\r\n- Jupyter\r\n- Qt (GUI)\r\n\r\n## Installation\r\n```bash\r\ngit clone https://github.com/dr-karim/quantum-simulator\r\ncd quantum-simulator\r\npip install -r requirements.txt\r\npython simulator.py\r\n```\r\n\r\n## Usage\r\n```python\r\nfrom qsim import QuantumCircuit\r\n\r\nqc = QuantumCircuit(2)\r\nqc.h(0)  # Hadamard gate\r\nqc.cx(0, 1)  # CNOT gate\r\nqc.measure_all()\r\nresult = qc.run()\r\n```\r\n\r\n## Notes\r\n- Supports up to 20 qubits (simulation limit)\r\n- Educational focus, not production-ready\r\n- Companion textbook available', 'Research', 'Computer Science', NULL, 'https://github.com/dr-karim/quantum-simulator', NULL, NULL, 'public', 378, 0, '2024-04-12 07:30:00', '2024-04-12 07:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `project_media`
--

CREATE TABLE `project_media` (
  `media_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` enum('image','video','pdf','slide') NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_tags`
--

CREATE TABLE `project_tags` (
  `project_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(50) NOT NULL,
  `usage_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `tag_name`, `usage_count`, `created_at`) VALUES
(1, 'WebApp', 0, '2025-11-16 07:03:52'),
(2, 'MobileApp', 0, '2025-11-16 07:03:52'),
(3, 'AI', 0, '2025-11-16 07:03:52'),
(4, 'MachineLearning', 0, '2025-11-16 07:03:52'),
(5, 'IoT', 0, '2025-11-16 07:03:52'),
(6, 'Hardware', 0, '2025-11-16 07:03:52'),
(7, 'Design', 0, '2025-11-16 07:03:52'),
(8, 'UI/UX', 0, '2025-11-16 07:03:52'),
(9, 'Research', 0, '2025-11-16 07:03:52'),
(10, 'DataScience', 0, '2025-11-16 07:03:52'),
(11, 'GameDev', 0, '2025-11-16 07:03:52'),
(12, 'Blockchain', 0, '2025-11-16 07:03:52'),
(13, 'CyberSecurity', 0, '2025-11-16 07:03:52'),
(14, 'CloudComputing', 0, '2025-11-16 07:03:52'),
(15, 'AR/VR', 0, '2025-11-16 07:03:52'),
(16, 'Robotics', 0, '2025-11-16 07:03:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `department` varchar(50) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `theme_color` varchar(20) DEFAULT '#3B82F6',
  `is_verified` tinyint(1) DEFAULT 0,
  `role` enum('student','faculty') DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `full_name`, `email`, `google_id`, `password`, `department`, `semester`, `bio`, `profile_image`, `theme_color`, `is_verified`, `role`, `created_at`, `updated_at`) VALUES
(1, 'sarah_ahmed', 'Sarah Ahmed', 'sarah.ahmed@uiu.ac', NULL, '$2y$10$YourHashedPasswordHere1', 'Computer Science', 'Fall 2024', 'Passionate about AI and machine learning. Love building intelligent systems that solve real-world problems.', NULL, '#8B5CF6', 1, 'student', '2024-01-15 04:30:00', '2024-01-15 04:30:00'),
(2, 'rafid_khan', 'Rafid Khan', 'rafid.khan@uiu.ac', NULL, '$2y$10$YourHashedPasswordHere2', 'Computer Science', 'Spring 2024', 'Full-stack developer with a keen interest in web technologies and cloud computing. Always exploring new frameworks.', NULL, '#10B981', 1, 'student', '2024-02-10 08:20:00', '2024-02-10 08:20:00'),
(3, 'nadia_islam', 'Nadia Islam', 'nadia.islam@uiu.ac', NULL, '$2y$10$YourHashedPasswordHere3', 'Electrical Engineering', 'Fall 2023', 'IoT enthusiast and hardware hacker. Building smart solutions for everyday problems.', NULL, '#F59E0B', 1, 'student', '2023-09-05 03:15:00', '2023-09-05 03:15:00'),
(4, 'tahmid_hassan', 'Tahmid Hassan', 'tahmid.hassan@uiu.ac', NULL, '$2y$10$YourHashedPasswordHere4', 'Computer Science', 'Spring 2025', 'Cybersecurity researcher and ethical hacker. Passionate about protecting digital infrastructure.', NULL, '#EF4444', 0, 'student', '2024-08-20 05:45:00', '2024-08-20 05:45:00'),
(5, 'zara_rahman', 'Zara Rahman', 'zara.rahman@uiu.ac', NULL, '$2y$10$YourHashedPasswordHere5', 'Business Administration', 'Fall 2024', 'UI/UX designer who loves creating beautiful and intuitive user experiences. Design thinking advocate.', NULL, '#EC4899', 1, 'student', '2024-03-12 10:00:00', '2024-03-12 10:00:00'),
(6, 'dr_karim', 'Dr. Mahmud Karim', 'mahmud.karim@uiu.ac', NULL, '$2y$10$YourHashedPasswordHere6', 'Computer Science', NULL, 'Professor of Computer Science specializing in artificial intelligence and data science. Mentor and researcher.', NULL, '#3B82F6', 1, 'faculty', '2020-01-10 02:00:00', '2020-01-10 02:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`),
  ADD UNIQUE KEY `unique_like` (`user_id`,`project_id`),
  ADD KEY `idx_project_id` (`project_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_visibility` (`visibility`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `project_media`
--
ALTER TABLE `project_media`
  ADD PRIMARY KEY (`media_id`),
  ADD KEY `idx_project_id` (`project_id`);

--
-- Indexes for table `project_tags`
--
ALTER TABLE `project_tags`
  ADD PRIMARY KEY (`project_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `tag_name` (`tag_name`),
  ADD KEY `idx_tag_name` (`tag_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `project_media`
--
ALTER TABLE `project_media`
  MODIFY `media_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `project_media`
--
ALTER TABLE `project_media`
  ADD CONSTRAINT `project_media_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `project_tags`
--
ALTER TABLE `project_tags`
  ADD CONSTRAINT `project_tags_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
