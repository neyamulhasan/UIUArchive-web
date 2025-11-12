<?php
/**
 * Recommend User Handler
 * UIUArchive - Built by UIU Minds
 */

session_start();
require_once '../includes/db.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login to recommend users']);
    exit();
}

// Check if request is POST and has user_id
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

$currentUserId = (int)$_SESSION['user_id'];
$recommendedUserId = (int)$_POST['user_id'];

// Prevent self-recommendation
if ($currentUserId === $recommendedUserId) {
    echo json_encode(['success' => false, 'message' => 'You cannot recommend yourself']);
    exit();
}

// Check if user has already recommended this user
$checkQuery = "SELECT 1 FROM user_recommendations 
               WHERE recommender_user_id = $currentUserId 
               AND recommended_user_id = $recommendedUserId";
$checkResult = mysqli_query($conn, $checkQuery);
$hasRecommended = mysqli_num_rows($checkResult) > 0;

// Start transaction
mysqli_begin_transaction($conn);

try {
    if ($hasRecommended) {
        // Remove recommendation
        $deleteQuery = "DELETE FROM user_recommendations 
                       WHERE recommender_user_id = $currentUserId 
                       AND recommended_user_id = $recommendedUserId";
        
        if (!mysqli_query($conn, $deleteQuery)) {
            throw new Exception('Failed to remove recommendation');
        }
        
        // Decrement recommendations_count
        $updateQuery = "UPDATE users 
                        SET recommendations_count = GREATEST(recommendations_count - 1, 0) 
                        WHERE user_id = $recommendedUserId";
        
        if (!mysqli_query($conn, $updateQuery)) {
            throw new Exception('Failed to update recommendation count');
        }
        
        $action = 'removed';
        $message = 'Recommendation removed';
        
    } else {
        // Add recommendation
        $insertQuery = "INSERT INTO user_recommendations (recommender_user_id, recommended_user_id) 
                        VALUES ($currentUserId, $recommendedUserId)";
        
        if (!mysqli_query($conn, $insertQuery)) {
            throw new Exception('Failed to record recommendation');
        }
        
        // Increment recommendations_count
        $updateQuery = "UPDATE users 
                        SET recommendations_count = recommendations_count + 1 
                        WHERE user_id = $recommendedUserId";
        
        if (!mysqli_query($conn, $updateQuery)) {
            throw new Exception('Failed to update recommendation count');
        }
        
        $action = 'added';
        $message = 'User recommended successfully!';
    }
    
    // Get updated count
    $countQuery = "SELECT recommendations_count FROM users WHERE user_id = $recommendedUserId";
    $countResult = mysqli_query($conn, $countQuery);
    $countData = mysqli_fetch_assoc($countResult);
    $newCount = $countData['recommendations_count'];
    
    // Commit transaction
    mysqli_commit($conn);
    
    echo json_encode([
        'success' => true, 
        'message' => $message,
        'action' => $action,
        'new_count' => $newCount,
        'recommended' => !$hasRecommended
    ]);
    
} catch (Exception $e) {
    // Rollback on error
    mysqli_rollback($conn);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

mysqli_close($conn);
?>
