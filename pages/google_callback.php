<?php
/**
 * Google OAuth Callback Handler
 * UIUArchive - Built by UIU Minds
 */

require_once '../includes/db.php';
require_once '../includes/functions.php';
require_once '../includes/google_oauth.php';

session_start();

// Check if user denied authorization
if (isset($_GET['error'])) {
    $_SESSION['error'] = 'Google login was cancelled or denied.';
    redirect('login.php');
}

// Check if we have an authorization code
if (!isset($_GET['code'])) {
    $_SESSION['error'] = 'Google login failed. Authorization code not received.';
    redirect('login.php');
}

$code = $_GET['code'];

// Exchange code for access token
$accessToken = getGoogleAccessToken($code);

if (!$accessToken) {
    $_SESSION['error'] = 'Failed to get access token from Google.';
    redirect('login.php');
}

// Get user information from Google
$googleUser = getGoogleUserInfo($accessToken);

if (!$googleUser) {
    $_SESSION['error'] = 'Failed to get user information from Google.';
    redirect('login.php');
}

// Validate that we have required fields
if (!isset($googleUser['email']) || !isset($googleUser['name'])) {
    $_SESSION['error'] = 'Failed to get required user information from Google.';
    redirect('login.php');
}

// Check if user exists in database
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $googleUser['email']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($user = mysqli_fetch_assoc($result)) {
    // User exists - log them in
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['profile_image'] = $user['profile_image'];
    
    // Update last login (you can add this field to users table if needed)
    // mysqli_query($conn, "UPDATE users SET last_login = NOW() WHERE user_id = {$user['user_id']}");
    
    redirect('index.php');
} else {
    // User doesn't exist - create new account
    $fullName = $googleUser['name'];
    $email = $googleUser['email'];
    $profilePicture = isset($googleUser['picture']) ? $googleUser['picture'] : 'default.jpg';
    
    // Generate a unique username from email
    $emailParts = explode('@', $email);
    $baseUsername = strtolower(str_replace('.', '_', $emailParts[0]));
    $username = $baseUsername;
    
    // Check if username exists, add number if needed
    $counter = 1;
    while (true) {
        $checkStmt = mysqli_prepare($conn, "SELECT user_id FROM users WHERE username = ?");
        mysqli_stmt_bind_param($checkStmt, "s", $username);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);
        if (mysqli_num_rows($checkResult) == 0) {
            break;
        }
        $username = $baseUsername . $counter;
        $counter++;
    }
    
    // Create random password (not used for Google login but required by database)
    $randomPassword = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT);
    
    // Store Google ID for future reference
    $googleId = isset($googleUser['id']) ? $googleUser['id'] : null;
    
    // Determine role - check if UIU email, otherwise default to student
    $role = (strpos($email, '@student.uiu.ac.bd') !== false || strpos($email, '@uiu.ac.bd') !== false) ? 
            (strpos($email, '@student.uiu.ac.bd') !== false ? 'student' : 'faculty') : 'student';
    
    // Insert new user
    $stmt = mysqli_prepare($conn, 
        "INSERT INTO users (username, full_name, email, password, role, profile_image, google_id, is_verified) 
         VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
    
    mysqli_stmt_bind_param($stmt, "sssssss", 
        $username, $fullName, $email, $randomPassword, $role, $profilePicture, $googleId);
    
    if (mysqli_stmt_execute($stmt)) {
        $userId = mysqli_insert_id($conn);
        
        // Log them in
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['full_name'] = $fullName;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;
        $_SESSION['profile_image'] = $profilePicture;
        
        // Redirect to profile setup page for new users
        redirect('setup_profile.php');
    } else {
        $_SESSION['error'] = 'Failed to create account. Please try again.';
        redirect('login.php');
    }
}
?>
