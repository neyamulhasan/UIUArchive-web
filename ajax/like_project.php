<?php
/**
 * AJAX Handler - Like/Unlike Project
 * UIUArchive - Built by UIU Minds
 */

session_start();
require_once '../includes/config.php';
require_once '../includes/db.php';

// Set JSON header
header('Content-Type: application/json');

// Debug logging
error_log("=== LIKE PROJECT DEBUG ===");
error_log("REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD']);
error_log("POST data: " . print_r($_POST, true));
error_log("Session user_id: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'NOT SET'));

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    error_log("ERROR: User not logged in");
    echo json_encode([
        'success' => false,
        'message' => 'Please login to like projects'
    ]);
    exit();
}

// Check if request is POST and has project_id
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['project_id'])) {
    error_log("ERROR: Invalid request - POST: " . print_r($_POST, true));
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request - missing project_id'
    ]);
    exit();
}

$userId = (int)$_SESSION['user_id'];
$projectId = (int)$_POST['project_id'];

error_log("User ID: $userId, Project ID: $projectId");

// Check if project exists
$projectCheck = mysqli_query($conn, "SELECT project_id FROM projects WHERE project_id = $projectId");
if (mysqli_num_rows($projectCheck) === 0) {
    error_log("ERROR: Project not found - ID: $projectId");
    echo json_encode([
        'success' => false,
        'message' => 'Project not found'
    ]);
    exit();
}

error_log("Project exists");

// Check if user already liked this project
$likeCheck = mysqli_query($conn, "SELECT like_id FROM likes WHERE user_id = $userId AND project_id = $projectId");
$alreadyLiked = mysqli_num_rows($likeCheck) > 0;

error_log("Already liked: " . ($alreadyLiked ? 'YES' : 'NO'));

// Start transaction
mysqli_begin_transaction($conn);

try {
    if ($alreadyLiked) {
        // Unlike - Remove like
        $deleteLike = mysqli_query($conn, "DELETE FROM likes WHERE user_id = $userId AND project_id = $projectId");
        if (!$deleteLike) {
            throw new Exception('Failed to remove like');
        }
        
        // Decrement likes count
        $updateProject = mysqli_query($conn, "UPDATE projects SET likes_count = GREATEST(likes_count - 1, 0) WHERE project_id = $projectId");
        if (!$updateProject) {
            throw new Exception('Failed to update likes count');
        }
        
        $liked = false;
        $message = 'Project unliked';
    } else {
        // Like - Add like
        $insertLike = mysqli_query($conn, "INSERT INTO likes (user_id, project_id, created_at) VALUES ($userId, $projectId, NOW())");
        if (!$insertLike) {
            throw new Exception('Failed to add like');
        }
        
        // Increment likes count
        $updateProject = mysqli_query($conn, "UPDATE projects SET likes_count = likes_count + 1 WHERE project_id = $projectId");
        if (!$updateProject) {
            throw new Exception('Failed to update likes count');
        }
        
        $liked = true;
        $message = 'Project liked';
    }
    
    // Get updated likes count
    $countResult = mysqli_query($conn, "SELECT likes_count FROM projects WHERE project_id = $projectId");
    $countRow = mysqli_fetch_assoc($countResult);
    $likesCount = (int)$countRow['likes_count'];
    
    // Commit transaction
    mysqli_commit($conn);
    
    error_log("SUCCESS: Liked=$liked, Count=$likesCount");
    
    echo json_encode([
        'success' => true,
        'liked' => $liked,
        'likes_count' => $likesCount,
        'message' => $message
    ]);
    
} catch (Exception $e) {
    // Rollback on error
    mysqli_rollback($conn);
    
    error_log("ERROR: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred: ' . $e->getMessage()
    ]);
}

error_log("=== END LIKE PROJECT DEBUG ===");

mysqli_close($conn);
?>
