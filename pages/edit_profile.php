<?php
/**
 * Edit Profile Page
 * UIUArchive - Built by UIU Minds
 */

$pageTitle = 'Edit Profile';
require_once '../includes/header.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('login.php');
}

$userId = getCurrentUserId();
$errors = [];
$success = '';

// Get current user data
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$currentUser = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = sanitizeInput($_POST['full_name']);
    $bio = sanitizeInput($_POST['bio']);
    $batchNumber = sanitizeInput($_POST['batch_number']);
    $department = sanitizeInput($_POST['department']);
    $githubUrl = sanitizeInput($_POST['github_url']);
    $linkedinUrl = sanitizeInput($_POST['linkedin_url']);
    
    // Validation
    if (empty($fullName)) {
        $errors[] = "Full name is required";
    }
    
    if (empty($department)) {
        $errors[] = "Department is required";
    }
    
    // Validate URLs if provided
    if (!empty($githubUrl) && !filter_var($githubUrl, FILTER_VALIDATE_URL)) {
        $errors[] = "Invalid GitHub URL format";
    }
    
    if (!empty($linkedinUrl) && !filter_var($linkedinUrl, FILTER_VALIDATE_URL)) {
        $errors[] = "Invalid LinkedIn URL format";
    }
    
    // Update user profile
    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, 
            "UPDATE users SET full_name = ?, bio = ?, semester = ?, department = ?, github_url = ?, linkedin_url = ? WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt, "ssssssi", $fullName, $bio, $batchNumber, $department, $githubUrl, $linkedinUrl, $userId);
        
        if (mysqli_stmt_execute($stmt)) {
            // Update session
            $_SESSION['full_name'] = $fullName;
            $success = "Profile updated successfully!";
            
            // Refresh current user data
            $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE user_id = ?");
            mysqli_stmt_bind_param($stmt, "i", $userId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $currentUser = mysqli_fetch_assoc($result);
        } else {
            $errors[] = "Failed to update profile. Please try again.";
        }
    }
}
?>

<div class="w-full px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Your Profile</h1>
            <p class="text-gray-600">Update your information and social links</p>
        </div>

        <?php if ($success): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            <i class="fas fa-check-circle mr-2"></i><?php echo $success; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <!-- Edit Form -->
        <form method="POST" class="bg-white border border-gray-300 rounded-lg p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Full Name -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 font-semibold mb-2">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="full_name" 
                       value="<?php echo escape($currentUser['full_name']); ?>"
                       required
                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
            </div>

            <!-- Bio -->
            <div class="md:col-span-2">
                <label class="block text-gray-700 font-semibold mb-2">
                    Bio
                </label>
                <textarea name="bio" 
                          rows="4"
                          placeholder="Tell us about yourself..."
                          class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"><?php echo escape($currentUser['bio'] ?? ''); ?></textarea>
                <p class="text-sm text-gray-500 mt-1">Maximum 500 characters</p>
            </div>

            <!-- Department -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    Department <span class="text-red-500">*</span>
                </label>
                <select name="department" 
                        required
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Select Department</option>
                    <option value="CSE" <?php echo ($currentUser['department'] == 'CSE') ? 'selected' : ''; ?>>Computer Science & Engineering</option>
                    <option value="EEE" <?php echo ($currentUser['department'] == 'EEE') ? 'selected' : ''; ?>>Electrical & Electronic Engineering</option>
                    <option value="CE" <?php echo ($currentUser['department'] == 'CE') ? 'selected' : ''; ?>>Civil Engineering</option>
                    <option value="BBA" <?php echo ($currentUser['department'] == 'BBA') ? 'selected' : ''; ?>>Business Administration</option>
                    <option value="Economics" <?php echo ($currentUser['department'] == 'Economics') ? 'selected' : ''; ?>>Economics</option>
                    <option value="LLB" <?php echo ($currentUser['department'] == 'LLB') ? 'selected' : ''; ?>>Law</option>
                    <option value="English" <?php echo ($currentUser['department'] == 'English') ? 'selected' : ''; ?>>English</option>
                    <option value="Pharmacy" <?php echo ($currentUser['department'] == 'Pharmacy') ? 'selected' : ''; ?>>Pharmacy</option>
                    <option value="Other" <?php echo ($currentUser['department'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>

            <!-- Batch Number -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    Batch Number
                </label>
                <input type="text" 
                       name="batch_number" 
                       value="<?php echo escape($currentUser['semester'] ?? ''); ?>"
                       placeholder="e.g., 52, 53, 54"
                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
            </div>

            <!-- GitHub URL -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fab fa-github mr-1"></i> GitHub Profile
                </label>
                <input type="url" 
                       name="github_url" 
                       value="<?php echo escape($currentUser['github_url'] ?? ''); ?>"
                       placeholder="https://github.com/username"
                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
            </div>

            <!-- LinkedIn URL -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    <i class="fab fa-linkedin mr-1"></i> LinkedIn Profile
                </label>
                <input type="url" 
                       name="linkedin_url" 
                       value="<?php echo escape($currentUser['linkedin_url'] ?? ''); ?>"
                       placeholder="https://linkedin.com/in/username"
                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
            </div>
        </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 mt-8">
                <button type="submit" 
                        class="px-8 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition-all duration-300 font-semibold">
                    <i class="fas fa-save mr-2"></i>Save Changes
                </button>
                <a href="profile.php" 
                   class="px-8 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-all duration-300 font-semibold">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
