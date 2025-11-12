<?php
/**
 * Upload Project Page
 * UIUArchive - Built by UIU Minds
 */

// Start session and connect to database FIRST
session_start();
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Check if user is logged in
$isLoggedIn = isLoggedIn();
if (!$isLoggedIn) {
    header('Location: login.php');
    exit();
}

// Handle form submission BEFORE including header
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $title = sanitizeInput($_POST['title']);
    $description = sanitizeInput($_POST['description']);
    $projectBlueprint = isset($_POST['project_blueprint']) ? $_POST['project_blueprint'] : '';
    $category = sanitizeInput($_POST['category']);
    $department = sanitizeInput($_POST['department']);
    $semester = sanitizeInput($_POST['semester']);
    $githubLink = sanitizeInput($_POST['github_link']);
    $demoLink = sanitizeInput($_POST['demo_link']);
    $visibility = sanitizeInput($_POST['visibility']);
    $tags = isset($_POST['tags']) ? $_POST['tags'] : [];
    
    // Validation
    $errors = [];
    
    if (empty($title)) {
        $errors[] = "Project title is required";
    }
    
    if (empty($description)) {
        $errors[] = "Project description is required";
    }
    
    if (empty($category)) {
        $errors[] = "Project category is required";
    }
    
    // Handle thumbnail upload
    $thumbnailPath = null;
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        $fileType = $_FILES['thumbnail']['type'];
        
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Thumbnail must be an image (JPEG, PNG, or WebP)";
        } else {
            $maxSize = 5 * 1024 * 1024; // 5MB
            if ($_FILES['thumbnail']['size'] > $maxSize) {
                $errors[] = "Thumbnail size must be less than 5MB";
            } else {
                // Create upload directory if it doesn't exist
                $uploadDir = '../uploads/projects/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                // Generate unique filename
                $extension = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
                $thumbnailPath = uniqid() . '_' . time() . '.' . $extension;
                $fullPath = $uploadDir . $thumbnailPath;
                
                if (!move_uploaded_file($_FILES['thumbnail']['tmp_name'], $fullPath)) {
                    $errors[] = "Failed to upload thumbnail";
                    $thumbnailPath = null;
                }
            }
        }
    }
    
    // If no errors, insert project
    if (empty($errors)) {
        mysqli_begin_transaction($conn);
        
        try {
            // Insert project
            $stmt = mysqli_prepare($conn, 
                "INSERT INTO projects (user_id, title, description, project_blueprint, category, department, semester, github_link, demo_link, thumbnail, visibility, created_at) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())"
            );
            
            mysqli_stmt_bind_param($stmt, "issssssssss", 
                $_SESSION['user_id'],
                $title,
                $description,
                $projectBlueprint,
                $category,
                $department,
                $semester,
                $githubLink,
                $demoLink,
                $thumbnailPath,
                $visibility
            );
            
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Failed to insert project");
            }
            
            $projectId = mysqli_insert_id($conn);
            
            // Insert tags
            if (!empty($tags)) {
                foreach ($tags as $tagName) {
                    $tagName = trim($tagName);
                    if (empty($tagName)) continue;
                    
                    // Check if tag exists
                    $tagCheckQuery = mysqli_query($conn, "SELECT tag_id FROM tags WHERE tag_name = '" . mysqli_real_escape_string($conn, $tagName) . "'");
                    
                    if (mysqli_num_rows($tagCheckQuery) > 0) {
                        $tagRow = mysqli_fetch_assoc($tagCheckQuery);
                        $tagId = $tagRow['tag_id'];
                        
                        // Update usage count
                        mysqli_query($conn, "UPDATE tags SET usage_count = usage_count + 1 WHERE tag_id = $tagId");
                    } else {
                        // Create new tag
                        mysqli_query($conn, "INSERT INTO tags (tag_name, usage_count) VALUES ('" . mysqli_real_escape_string($conn, $tagName) . "', 1)");
                        $tagId = mysqli_insert_id($conn);
                    }
                    
                    // Link tag to project
                    mysqli_query($conn, "INSERT INTO project_tags (project_id, tag_id) VALUES ($projectId, $tagId)");
                }
            }
            
            mysqli_commit($conn);
            
            $_SESSION['success_message'] = "Project uploaded successfully!";
            header("Location: project_details.php?id=" . $projectId);
            exit();
            
        } catch (Exception $e) {
            mysqli_rollback($conn);
            
            // Delete uploaded thumbnail if project insertion failed
            if ($thumbnailPath && file_exists($uploadDir . $thumbnailPath)) {
                unlink($uploadDir . $thumbnailPath);
            }
            
            $errors[] = "Failed to upload project: " . $e->getMessage();
        }
    }
}

// Get all available tags from database
$tagsQuery = "SELECT tag_name FROM tags ORDER BY usage_count DESC, tag_name ASC";
$tagsResult = mysqli_query($conn, $tagsQuery);
$availableTags = [];
while ($row = mysqli_fetch_assoc($tagsResult)) {
    $availableTags[] = $row['tag_name'];
}

// NOW include header after all redirects
$pageTitle = 'Upload Project';
require_once '../includes/header.php';
?>

<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Upload Your Project</h1>
        <p class="text-gray-600">Share your amazing work with the UIU community</p>
    </div>

    <!-- Error Messages -->
    <?php if (!empty($errors)): ?>
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-500"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo escape($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Upload Form -->
    <form method="POST" enctype="multipart/form-data" class="space-y-6">
        
        <!-- Project Title -->
        <div>
            <label class="block text-sm font-semibold text-gray-900 mb-2">
                Project Title <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   name="title" 
                   required 
                   maxlength="200"
                   value="<?php echo isset($_POST['title']) ? escape($_POST['title']) : ''; ?>"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                   placeholder="e.g., Smart Home Automation System">
        </div>

        <!-- Project Description -->
        <div>
            <label class="block text-sm font-semibold text-gray-900 mb-2">
                Project Description <span class="text-red-500">*</span>
            </label>
            <textarea name="description" 
                      required 
                      rows="5"
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                      placeholder="Describe your project in detail..."><?php echo isset($_POST['description']) ? escape($_POST['description']) : ''; ?></textarea>
            <p class="mt-1 text-sm text-gray-500">Provide a clear description of what your project does</p>
        </div>

        <!-- Project Blueprint (Markdown) -->
        <div>
            <label class="block text-sm font-semibold text-gray-900 mb-2">
                Project Blueprint (Markdown supported)
            </label>
            <textarea name="project_blueprint" 
                      rows="10"
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent font-mono text-sm"
                      placeholder="# Architecture&#10;&#10;## Features&#10;- Feature 1&#10;- Feature 2&#10;&#10;## Technologies&#10;- React&#10;- Node.js&#10;&#10;![Image](image-url)"><?php echo isset($_POST['project_blueprint']) ? escape($_POST['project_blueprint']) : ''; ?></textarea>
            <p class="mt-1 text-sm text-gray-500">You can use Markdown syntax including images, headers, lists, and code blocks</p>
        </div>

        <!-- Category and Department Row -->
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Category -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Category <span class="text-red-500">*</span>
                </label>
                <select name="category" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Select Category</option>
                    <option value="WebApp">Web Application</option>
                    <option value="MobileApp">Mobile Application</option>
                    <option value="AI">Artificial Intelligence</option>
                    <option value="MachineLearning">Machine Learning</option>
                    <option value="IoT">Internet of Things</option>
                    <option value="Hardware">Hardware</option>
                    <option value="Design">Design</option>
                    <option value="Research">Research</option>
                    <option value="DataScience">Data Science</option>
                    <option value="GameDev">Game Development</option>
                    <option value="Blockchain">Blockchain</option>
                    <option value="CyberSecurity">Cyber Security</option>
                    <option value="CloudComputing">Cloud Computing</option>
                </select>
            </div>

            <!-- Department -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Department
                </label>
                <select name="department"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Select Department</option>
                    <option value="CSE">Computer Science & Engineering</option>
                    <option value="EEE">Electrical & Electronic Engineering</option>
                    <option value="CE">Civil Engineering</option>
                    <option value="BBA">Business Administration</option>
                    <option value="Economics">Economics</option>
                    <option value="English">English</option>
                    <option value="Law">Law</option>
                </select>
            </div>
        </div>

        <!-- Semester -->
        <div>
            <label class="block text-sm font-semibold text-gray-900 mb-2">
                Semester
            </label>
            <input type="text" 
                   name="semester" 
                   maxlength="20"
                   value="<?php echo isset($_POST['semester']) ? escape($_POST['semester']) : ''; ?>"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                   placeholder="e.g., Spring 2025">
        </div>

        <!-- Links Row -->
        <div class="grid md:grid-cols-2 gap-6">
            <!-- GitHub Link -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    <i class="fab fa-github mr-1"></i> GitHub Repository
                </label>
                <input type="url" 
                       name="github_link"
                       value="<?php echo isset($_POST['github_link']) ? escape($_POST['github_link']) : ''; ?>"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                       placeholder="https://github.com/username/repo">
            </div>

            <!-- Demo Link -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    <i class="fas fa-external-link-alt mr-1"></i> Live Demo
                </label>
                <input type="url" 
                       name="demo_link"
                       value="<?php echo isset($_POST['demo_link']) ? escape($_POST['demo_link']) : ''; ?>"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                       placeholder="https://your-demo.com">
            </div>
        </div>

        <!-- Thumbnail Upload -->
        <div>
            <label class="block text-sm font-semibold text-gray-900 mb-2">
                Project Thumbnail
            </label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-orange-500 transition-colors">
                <div class="space-y-1 text-center">
                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                    <div class="flex text-sm text-gray-600">
                        <label class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-700 focus-within:outline-none">
                            <span>Upload a file</span>
                            <input type="file" 
                                   name="thumbnail" 
                                   accept="image/*"
                                   class="sr-only"
                                   onchange="previewThumbnail(this)">
                        </label>
                        <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500">PNG, JPG, WebP up to 5MB</p>
                </div>
            </div>
            <div id="thumbnail-preview" class="mt-4 hidden">
                <img src="" alt="Thumbnail preview" class="max-h-64 rounded-lg mx-auto">
            </div>
        </div>

        <!-- Tags -->
        <div>
            <label class="block text-sm font-semibold text-gray-900 mb-3">
                Tags (Select all that apply)
            </label>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 max-h-64 overflow-y-auto p-4 border border-gray-300 rounded-lg">
                <?php foreach ($availableTags as $tag): ?>
                <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                    <input type="checkbox" 
                           name="tags[]" 
                           value="<?php echo escape($tag); ?>"
                           class="w-4 h-4 text-orange-600 focus:ring-orange-500 rounded">
                    <span class="ml-2 text-sm text-gray-700"><?php echo escape($tag); ?></span>
                </label>
                <?php endforeach; ?>
            </div>
            <p class="mt-2 text-sm text-gray-500">Select relevant tags to help others discover your project</p>
        </div>

        <!-- Visibility -->
        <div>
            <label class="block text-sm font-semibold text-gray-900 mb-2">
                Visibility
            </label>
            <div class="flex gap-4">
                <label class="flex items-center">
                    <input type="radio" 
                           name="visibility" 
                           value="public" 
                           checked
                           class="w-4 h-4 text-orange-600 focus:ring-orange-500">
                    <span class="ml-2 text-gray-700">
                        <i class="fas fa-globe mr-1"></i> Public
                    </span>
                </label>
                <label class="flex items-center">
                    <input type="radio" 
                           name="visibility" 
                           value="private"
                           class="w-4 h-4 text-orange-600 focus:ring-orange-500">
                    <span class="ml-2 text-gray-700">
                        <i class="fas fa-lock mr-1"></i> Private
                    </span>
                </label>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex gap-4 pt-6 border-t">
            <button type="submit"
                    class="flex-1 bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-orange-700 transition-colors">
                <i class="fas fa-upload mr-2"></i>
                Upload Project
            </button>
            <a href="index.php"
               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
// Thumbnail preview
function previewThumbnail(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        const preview = document.getElementById('thumbnail-preview');
        
        reader.onload = function(e) {
            preview.querySelector('img').src = e.target.result;
            preview.classList.remove('hidden');
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php require_once '../includes/footer.php'; ?>
