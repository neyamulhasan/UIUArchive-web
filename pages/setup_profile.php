<?php
/**
 * Profile Setup Page
 * MadeInUIU - Built by UIU Minds
 */

require_once '../includes/db.php';
require_once '../includes/functions.php';

session_start();

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('login.php');
}

$userId = getCurrentUserId();

// Check if profile is already set up
$stmt = mysqli_prepare($conn, "SELECT department FROM users WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// If department is already set, redirect to home
if (!empty($user['department'])) {
    redirect('index.php');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $batchNumber = sanitizeInput($_POST['batch_number']);
    $department = sanitizeInput($_POST['department']);
    
    // Validation
    if (empty($batchNumber)) {
        $errors[] = "Batch number is required";
    }
    
    if (empty($department)) {
        $errors[] = "Department is required";
    }
    
    // Update user profile
    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, 
            "UPDATE users SET semester = ?, department = ? WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt, "ssi", $batchNumber, $department, $userId);
        
        if (mysqli_stmt_execute($stmt)) {
            redirect('index.php');
        } else {
            $errors[] = "Failed to update profile. Please try again.";
        }
    }
}

// Get current user data
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$currentUser = mysqli_fetch_assoc($result);

$pageTitle = 'Setup Your Profile';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - UIUArchive</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-500 to-purple-600 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-5xl font-bold text-white mb-3">Welcome! 🎉</h1>
            <p class="text-white text-xl opacity-90">Just 2 quick things to get started...</p>
        </div>
        
        <!-- Setup Form -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <div class="flex items-center mb-6 pb-6 border-b">
                <img src="<?php echo escape($currentUser['profile_image']); ?>" 
                     alt="Profile" 
                     class="w-16 h-16 rounded-full object-cover mr-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800"><?php echo escape($currentUser['full_name']); ?></h2>
                    <p class="text-gray-600 text-sm"><?php echo escape($currentUser['email']); ?></p>
                </div>
            </div>
            
            <?php if (!empty($errors)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside text-sm">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" class="space-y-6">
                <!-- Batch Number -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        Batch Number <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="batch_number" 
                           placeholder="e.g., 52, 53, 54" 
                           required
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           value="<?php echo isset($_POST['batch_number']) ? escape($_POST['batch_number']) : ''; ?>">
                    <p class="text-sm text-gray-500 mt-1">Enter your batch number</p>
                </div>
                
                <!-- Department -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        Department <span class="text-red-500">*</span>
                    </label>
                    <select name="department" 
                            required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Your Department</option>
                        <option value="CSE">Computer Science & Engineering</option>
                        <option value="EEE">Electrical & Electronic Engineering</option>
                        <option value="CE">Civil Engineering</option>
                        <option value="BBA">Business Administration</option>
                        <option value="Economics">Economics</option>
                        <option value="LLB">Law</option>
                        <option value="English">English</option>
                        <option value="Pharmacy">Pharmacy</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                
                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" 
                    <button type="submit" class="w-full px-8 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition-all duration-300 font-medium text-lg shadow-md hover:shadow-lg">
                        Continue to UIUArchive 🚀
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    <i class="fas fa-shield-alt mr-1"></i>
                    You can update this anytime from your profile settings
                </p>
            </div>
        </div>
        
        <!-- Logout Option -->
        <div class="text-center mt-6">
            <a href="logout.php" class="text-white hover:underline text-sm">
                <i class="fas fa-sign-out-alt mr-1"></i>Logout
            </a>
        </div>
    </div>
</body>
</html>
