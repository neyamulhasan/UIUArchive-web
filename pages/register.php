<?php
/**
 * Registration - Redirects to Google Login
 * MadeInUIU - Built by UIU Minds
 */

// Redirect to login page (Google only authentication)
header('Location: login.php');
exit();

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = sanitizeInput($_POST['student_id']);
    $fullName = sanitizeInput($_POST['full_name']);
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $department = sanitizeInput($_POST['department']);
    $semester = sanitizeInput($_POST['semester']);
    
    // Validation
    if (empty($studentId)) {
        $errors[] = "Student ID is required";
    }
    
    if (empty($fullName)) {
        $errors[] = "Full name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    } elseif (!isValidUIUEmail($email)) {
        $errors[] = "Please use your UIU email (@uiu.ac.bd or @student.uiu.ac.bd)";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }
    
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match";
    }
    
    // Check if email or student ID already exists
    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, "SELECT user_id FROM users WHERE email = ? OR student_id = ?");
        mysqli_stmt_bind_param($stmt, "ss", $email, $studentId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            $errors[] = "Email or Student ID already registered";
        }
    }
    
    // Register user
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = mysqli_prepare($conn, "INSERT INTO users (student_id, full_name, email, password, department, semester) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssss", $studentId, $fullName, $email, $hashedPassword, $department, $semester);
        
        if (mysqli_stmt_execute($stmt)) {
            $userId = mysqli_insert_id($conn);
            
            // Award "Early Adopter" badge if user is among first 100
            $userCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"))['count'];
            if ($userCount <= 100) {
                awardBadge($conn, $userId, 8); // Early Adopter badge
            }
            
            $success = "Registration successful! You can now login.";
            
            // Auto login
            session_start();
            $_SESSION['user_id'] = $userId;
            $_SESSION['student_id'] = $studentId;
            $_SESSION['full_name'] = $fullName;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = 'student';
            $_SESSION['profile_image'] = 'default.jpg';
            
            // Redirect to profile completion or homepage
            header("Location: index.php");
            exit();
        } else {
            $errors[] = "Registration failed. Please try again.";
        }
    }
}

$pageTitle = 'Register';
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
        <!-- Logo -->
                <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">UIUArchive</h1>
            <p class="text-xl text-gray-200">Join our community of creators</p>
        
        <!-- Registration Form -->
        <div class="bg-white rounded-lg shadow-xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Create Your Account</h2>
            
            <?php if (!empty($errors)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" class="space-y-4">
                <!-- Student ID -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Student ID</label>
                    <input type="text" 
                           name="student_id" 
                           placeholder="e.g., 011221001" 
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="<?php echo isset($_POST['student_id']) ? escape($_POST['student_id']) : ''; ?>">
                </div>
                
                <!-- Full Name -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Full Name</label>
                    <input type="text" 
                           name="full_name" 
                           placeholder="Your full name" 
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="<?php echo isset($_POST['full_name']) ? escape($_POST['full_name']) : ''; ?>">
                </div>
                
                <!-- Email -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">UIU Email</label>
                    <input type="email" 
                           name="email" 
                           placeholder="yourname@student.uiu.ac.bd" 
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="<?php echo isset($_POST['email']) ? escape($_POST['email']) : ''; ?>">
                    <p class="text-sm text-gray-500 mt-1">Use your UIU email address</p>
                </div>
                
                <!-- Department -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Department</label>
                    <select name="department" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Department</option>
                        <option value="CSE">Computer Science & Engineering</option>
                        <option value="EEE">Electrical & Electronic Engineering</option>
                        <option value="CE">Civil Engineering</option>
                        <option value="BBA">Business Administration</option>
                        <option value="Economics">Economics</option>
                        <option value="LLB">Law</option>
                        <option value="English">English</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                
                <!-- Semester -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Current Semester</label>
                    <select name="semester" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Semester</option>
                        <option value="Spring 2025">Spring 2025</option>
                        <option value="Fall 2024">Fall 2024</option>
                        <option value="Summer 2024">Summer 2024</option>
                        <option value="Spring 2024">Spring 2024</option>
                    </select>
                </div>
                
                <!-- Password -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Password</label>
                    <input type="password" 
                           name="password" 
                           placeholder="At least 6 characters" 
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <!-- Confirm Password -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Confirm Password</label>
                    <input type="password" 
                           name="confirm_password" 
                           placeholder="Re-enter password" 
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Register
                </button>
            </form>
            
            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Or sign up with</span>
                </div>
            </div>
            
            <!-- Google Sign Up Button -->
            <?php 
            require_once '../includes/google_oauth.php';
            $googleLoginUrl = getGoogleLoginUrl();
            ?>
            <a href="<?php echo $googleLoginUrl; ?>" 
               class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span class="text-gray-700 font-semibold">Sign up with Google</span>
            </a>
            
            <!-- Login Link -->
            <p class="text-center mt-6 text-gray-600">
                Already have an account? 
                <a href="login.php" class="text-blue-600 hover:underline font-semibold">Login here</a>
            </p>
        </div>
        
        <!-- Back to Home -->
        <div class="text-center mt-6">
            <a href="index.php" class="text-white hover:underline">
                <i class="fas fa-arrow-left mr-2"></i>Back to Home
            </a>
        </div>
    </div>
</body>
</html>
