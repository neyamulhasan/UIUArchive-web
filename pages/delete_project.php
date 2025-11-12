<?php
/**
 * Delete Project Handler
 * UIUArchive - Built by UIU Minds
 */

session_start();
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Log deletion attempt
error_log("Delete attempt - User ID: " . ($_SESSION['user_id'] ?? 'not set') . ", Project ID: " . ($_GET['id'] ?? 'not set'));

// Check if user is logged in
if (!isLoggedIn()) {
    error_log("Delete failed - User not logged in");
    $_SESSION['error_message'] = "Please log in to delete projects";
    header('Location: login.php');
    exit();
}

// Get project ID
$projectId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($projectId <= 0) {
    error_log("Delete failed - Invalid project ID: " . $projectId);
    $_SESSION['error_message'] = "Invalid project ID";
    header('Location: index.php');
    exit();
}

// Fetch project to verify ownership using prepared statement
$stmt = mysqli_prepare($conn, "SELECT user_id, thumbnail FROM projects WHERE project_id = ?");
mysqli_stmt_bind_param($stmt, "i", $projectId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$project = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$project) {
    error_log("Delete failed - Project not found: " . $projectId);
    $_SESSION['error_message'] = "Project not found";
    header('Location: index.php');
    exit();
}

// Check if user owns this project
if ($project['user_id'] != $_SESSION['user_id']) {
    error_log("Delete failed - Permission denied. User " . $_SESSION['user_id'] . " tried to delete project " . $projectId . " owned by " . $project['user_id']);
    $_SESSION['error_message'] = "You don't have permission to delete this project";
    header('Location: project_details.php?id=' . $projectId);
    exit();
}

error_log("Delete proceeding - User " . $_SESSION['user_id'] . " deleting project " . $projectId);

// Start transaction
mysqli_begin_transaction($conn);

try {
    // Delete project tags using prepared statement
    $stmt = mysqli_prepare($conn, "DELETE FROM project_tags WHERE project_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $projectId);
    $deleteTags = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if (!$deleteTags) {
        throw new Exception("Failed to delete project tags: " . mysqli_error($conn));
    }
    
    // Delete likes using prepared statement
    $stmt = mysqli_prepare($conn, "DELETE FROM likes WHERE project_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $projectId);
    $deleteLikes = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if (!$deleteLikes) {
        throw new Exception("Failed to delete likes: " . mysqli_error($conn));
    }
    
    // Delete project media using prepared statement
    $stmt = mysqli_prepare($conn, "DELETE FROM project_media WHERE project_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $projectId);
    $deleteMedia = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if (!$deleteMedia) {
        throw new Exception("Failed to delete media: " . mysqli_error($conn));
    }
    
    // Delete the project itself using prepared statement
    $stmt = mysqli_prepare($conn, "DELETE FROM projects WHERE project_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $projectId);
    $deleteProject = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    if (!$deleteProject) {
        throw new Exception("Failed to delete project: " . mysqli_error($conn));
    }
    
    // Delete thumbnail file if exists
    if (!empty($project['thumbnail'])) {
        $thumbnailPath = '../uploads/projects/' . $project['thumbnail'];
        if (file_exists($thumbnailPath)) {
            unlink($thumbnailPath);
        }
    }
    
    mysqli_commit($conn);
    
    error_log("Delete successful - Project " . $projectId . " deleted by user " . $_SESSION['user_id']);
    $_SESSION['success_message'] = "Project deleted successfully! 🗑️";
    header('Location: my_projects.php');
    exit();
    
} catch (Exception $e) {
    mysqli_rollback($conn);
    
    error_log("Delete failed - Exception: " . $e->getMessage());
    $_SESSION['error_message'] = "Failed to delete project: " . $e->getMessage();
    header('Location: my_projects.php');
    exit();
}
?>
