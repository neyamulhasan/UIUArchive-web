<?php
/**
 * Common Functions
 * UIUArchive - Built by UIU Minds
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Get current user ID
 */
function getCurrentUserId() {
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}

/**
 * Get profile image URL - handles NULL, Google URLs, and generates initials avatar
 */
function getProfileImageUrl($profileImage, $fullName) {
    // If it's a Google URL or external URL, return it directly
    if (!empty($profileImage) && strpos($profileImage, 'http') === 0) {
        return $profileImage;
    }
    
    // If NULL or empty, generate initials avatar using UI Avatars API
    // Extract first letters of first and last name
    $nameParts = explode(' ', trim($fullName));
    $initials = '';
    
    if (count($nameParts) >= 2) {
        // First name initial + Last name initial
        $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[count($nameParts) - 1], 0, 1));
    } else {
        // Just first 2 letters of single name
        $initials = strtoupper(substr($nameParts[0], 0, 2));
    }
    
    // Generate avatar URL with orange theme colors
    $colors = ['c2410c', 'd97706', '9a3412', 'ea580c', 'f97316'];
    $randomColor = $colors[array_rand($colors)];
    
    // Use smaller size (48px) for better performance and proper display
    return 'https://ui-avatars.com/api/?name=' . urlencode($initials) . 
           '&background=' . $randomColor . 
           '&color=fff&size=48&font-size=0.5&bold=true';
}

/**
 * Redirect to another page
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Sanitize input data
 */
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Escape output for HTML
 */
function escape($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * Format date for display
 */
function formatDate($date) {
    return date('M d, Y', strtotime($date));
}

/**
 * Time ago function
 */
function timeAgo($datetime) {
    $timestamp = strtotime($datetime);
    $difference = time() - $timestamp;
    
    $periods = array("second", "minute", "hour", "day", "week", "month", "year");
    $lengths = array("60", "60", "24", "7", "4.35", "12");
    
    for ($i = 0; $difference >= $lengths[$i] && $i < count($lengths) - 1; $i++) {
        $difference /= $lengths[$i];
    }
    
    $difference = round($difference);
    
    if ($difference != 1) {
        $periods[$i] .= "s";
    }
    
    return "$difference $periods[$i] ago";
}

/**
 * Generate random string for file names
 */
function generateRandomString($length = 10) {
    return bin2hex(random_bytes($length));
}

/**
 * Upload file handler
 */
function uploadFile($file, $targetDir, $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf']) {
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    
    // Check for errors
    if ($fileError !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'File upload error'];
    }
    
    // Get file extension
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    // Check if file type is allowed
    if (!in_array($fileExt, $allowedTypes)) {
        return ['success' => false, 'message' => 'Invalid file type'];
    }
    
    // Check file size (10MB max)
    if ($fileSize > 10485760) {
        return ['success' => false, 'message' => 'File size exceeds 10MB'];
    }
    
    // Generate unique file name
    $newFileName = generateRandomString(16) . '.' . $fileExt;
    $targetPath = $targetDir . $newFileName;
    
    // Create directory if it doesn't exist
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    // Move uploaded file
    if (move_uploaded_file($fileTmpName, $targetPath)) {
        return ['success' => true, 'filename' => $newFileName];
    } else {
        return ['success' => false, 'message' => 'Failed to move uploaded file'];
    }
}

/**
 * Send notification to user
 */
function sendNotification($conn, $userId, $type, $message, $relatedId = null) {
    $stmt = mysqli_prepare($conn, "INSERT INTO notifications (user_id, type, message, related_id) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "issi", $userId, $type, $message, $relatedId);
    return mysqli_stmt_execute($stmt);
}

/**
 * Get unread notification count
 */
function getUnreadNotificationCount($conn, $userId) {
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) as count FROM notifications WHERE user_id = ? AND is_read = 0");
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

/**
 * Check if user has liked a project
 */
function hasUserLikedProject($conn, $userId, $projectId) {
    $stmt = mysqli_prepare($conn, "SELECT like_id FROM likes WHERE user_id = ? AND project_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $userId, $projectId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_num_rows($result) > 0;
}

/**
 * Check if user is following a project
 */
function isUserFollowingProject($conn, $userId, $projectId) {
    $stmt = mysqli_prepare($conn, "SELECT follow_id FROM follows WHERE user_id = ? AND project_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $userId, $projectId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_num_rows($result) > 0;
}

/**
 * Get trending projects (based on likes, comments, views in last 7 days)
 */
function getTrendingProjects($conn, $limit = 10) {
    $query = "SELECT p.*, u.full_name, u.profile_image,
              (p.likes_count * 3 + p.comments_count * 2 + p.views_count) as trending_score
              FROM projects p
              JOIN users u ON p.user_id = u.user_id
              WHERE p.visibility = 'public' 
              AND p.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
              ORDER BY trending_score DESC
              LIMIT ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $limit);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

/**
 * Award badge to user
 */
function awardBadge($conn, $userId, $badgeId) {
    $stmt = mysqli_prepare($conn, "INSERT IGNORE INTO user_badges (user_id, badge_id) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ii", $userId, $badgeId);
    if (mysqli_stmt_execute($stmt)) {
        // Send notification
        $badgeQuery = mysqli_query($conn, "SELECT badge_name FROM badges WHERE badge_id = $badgeId");
        $badge = mysqli_fetch_assoc($badgeQuery);
        sendNotification($conn, $userId, 'badge', "You earned the '{$badge['badge_name']}' badge!", $badgeId);
        return true;
    }
    return false;
}

/**
 * Check and award badges based on user activity
 */
function checkAndAwardBadges($conn, $userId) {
    // First Project badge
    $projectCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM projects WHERE user_id = $userId"))['count'];
    if ($projectCount == 1) {
        awardBadge($conn, $userId, 1);
    }
    
    // Prolific badge (5 projects)
    if ($projectCount == 5) {
        awardBadge($conn, $userId, 4);
    }
    
    // Rising Star badge (10 likes on single project)
    $topProject = mysqli_query($conn, "SELECT likes_count FROM projects WHERE user_id = $userId ORDER BY likes_count DESC LIMIT 1");
    if ($topProject && mysqli_num_rows($topProject) > 0) {
        $likes = mysqli_fetch_assoc($topProject)['likes_count'];
        if ($likes >= 10) {
            awardBadge($conn, $userId, 2);
        }
    }
    
    // Popular Creator badge (50+ total likes)
    $totalLikes = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(likes_count) as total FROM projects WHERE user_id = $userId"))['total'];
    if ($totalLikes >= 50) {
        awardBadge($conn, $userId, 3);
    }
}

/**
 * Increment project view count
 */
function incrementProjectViews($conn, $projectId) {
    $query = "UPDATE projects SET views_count = views_count + 1 WHERE project_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $projectId);
    return mysqli_stmt_execute($stmt);
}

/**
 * Validate UIU email
 */
function isValidUIUEmail($email) {
    return preg_match('/@(student\.)?uiu\.ac\.bd$/i', $email);
}

/**
 * Generate shareable portfolio link
 */
function generatePortfolioLink($userId) {
    return "profile.php?id=" . $userId;
}

/**
 * Simple Markdown parser for basic markdown formatting
 */
function parseMarkdown($text) {
    if (empty($text)) {
        return '';
    }
    
    // First, store and process images and links to avoid HTML escaping issues
    $htmlTags = array();
    $counter = 0;
    
    // Process images ![alt text](url "title") - must be before links
    $text = preg_replace_callback('/!\[([^\]]*)\]\(([^\s)]+)(?:\s+"([^"]*)")?\)/', function($matches) use (&$htmlTags, &$counter) {
        $alt = htmlspecialchars($matches[1], ENT_QUOTES, 'UTF-8');
        $src = htmlspecialchars($matches[2], ENT_QUOTES, 'UTF-8');
        $title = isset($matches[3]) && !empty($matches[3]) ? htmlspecialchars($matches[3], ENT_QUOTES, 'UTF-8') : '';
        $imgTag = '<img src="' . $src . '" alt="' . $alt . '" title="' . $title . '" class="max-w-full h-auto rounded-lg my-4 shadow-sm" loading="lazy">';
        $placeholder = "HTMLTAG_" . $counter . "_HTMLTAG";
        $htmlTags[$placeholder] = $imgTag;
        $counter++;
        return $placeholder;
    }, $text);
    
    // Process links (must be after images to avoid conflicts)
    $text = preg_replace_callback('/\[(.+?)\]\((.+?)\)/', function($matches) use (&$htmlTags, &$counter) {
        $linkText = htmlspecialchars($matches[1], ENT_QUOTES, 'UTF-8');
        $url = htmlspecialchars($matches[2], ENT_QUOTES, 'UTF-8');
        $linkTag = '<a href="' . $url . '" class="text-blue-600 hover:text-blue-800 underline" target="_blank">' . $linkText . '</a>';
        $placeholder = "HTMLTAG_" . $counter . "_HTMLTAG";
        $htmlTags[$placeholder] = $linkTag;
        $counter++;
        return $placeholder;
    }, $text);
    
    // Now escape HTML to prevent XSS
    $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    
    // Headers
    $text = preg_replace('/^### (.+)$/m', '<h3 class="text-lg font-semibold text-gray-900 mt-4 mb-2">$1</h3>', $text);
    $text = preg_replace('/^## (.+)$/m', '<h2 class="text-xl font-semibold text-gray-900 mt-6 mb-3">$1</h2>', $text);
    $text = preg_replace('/^# (.+)$/m', '<h1 class="text-2xl font-bold text-gray-900 mt-8 mb-4">$1</h1>', $text);
    
    // Bold and italic
    $text = preg_replace('/\*\*(.+?)\*\*/', '<strong class="font-semibold">$1</strong>', $text);
    $text = preg_replace('/\*(.+?)\*/', '<em class="italic">$1</em>', $text);
    
    // Code blocks
    $text = preg_replace('/```(.+?)```/s', '<pre class="bg-gray-100 p-3 rounded-lg overflow-x-auto my-3"><code>$1</code></pre>', $text);
    
    // Inline code
    $text = preg_replace('/`(.+?)`/', '<code class="bg-gray-100 px-1 py-0.5 rounded text-sm">$1</code>', $text);
    
    // Lists
    $text = preg_replace('/^\* (.+)$/m', '<li class="ml-4">• $1</li>', $text);
    $text = preg_replace('/^\- (.+)$/m', '<li class="ml-4">• $1</li>', $text);
    $text = preg_replace('/^(\d+)\. (.+)$/m', '<li class="ml-4">$1. $2</li>', $text);
    
    // Wrap lists in ul tags
    $text = preg_replace('/(<li[^>]*>.*<\/li>)/s', '<ul class="space-y-1 my-3">$1</ul>', $text);
    
    // Line breaks and paragraphs
    $text = preg_replace('/\n\n/', '</p><p class="mb-3">', $text);
    $text = preg_replace('/\n/', '<br>', $text);
    
    // Wrap in paragraph tags
    $text = '<p class="mb-3">' . $text . '</p>';
    
    // Clean up empty paragraphs
    $text = preg_replace('/<p class="mb-3"><\/p>/', '', $text);
    
    // Restore HTML tags (images and links)
    foreach ($htmlTags as $placeholder => $htmlTag) {
        $text = str_replace($placeholder, $htmlTag, $text);
    }
    
    return $text;
}
?>
