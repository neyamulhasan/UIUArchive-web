<?php
/**
 * Edit Project Page
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

// Get project ID
$projectId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($projectId <= 0) {
    $_SESSION['error_message'] = "Invalid project ID";
    header('Location: index.php');
    exit();
}

// Fetch project details
$query = "SELECT p.*, GROUP_CONCAT(t.tag_name SEPARATOR ',') as tags
          FROM projects p
          LEFT JOIN project_tags pt ON p.project_id = pt.project_id
          LEFT JOIN tags t ON pt.tag_id = t.tag_id
          WHERE p.project_id = $projectId
          GROUP BY p.project_id";
$result = mysqli_query($conn, $query);
$project = mysqli_fetch_assoc($result);

if (!$project) {
    $_SESSION['error_message'] = "Project not found";
    header('Location: index.php');
    exit();
}

// Check if user owns this project
if ($project['user_id'] != $_SESSION['user_id']) {
    $_SESSION['error_message'] = "You don't have permission to edit this project";
    header('Location: project_details.php?id=' . $projectId);
    exit();
}

// Get selected tags
$selectedTags = !empty($project['tags']) ? explode(',', $project['tags']) : [];

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
    $thumbnailPath = $project['thumbnail']; // Keep existing thumbnail by default
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
                
                // Delete old thumbnail
                if (!empty($project['thumbnail']) && file_exists($uploadDir . $project['thumbnail'])) {
                    unlink($uploadDir . $project['thumbnail']);
                }
                
                // Generate unique filename
                $extension = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
                $thumbnailPath = uniqid() . '_' . time() . '.' . $extension;
                $fullPath = $uploadDir . $thumbnailPath;
                
                if (!move_uploaded_file($_FILES['thumbnail']['tmp_name'], $fullPath)) {
                    $errors[] = "Failed to upload thumbnail";
                    $thumbnailPath = $project['thumbnail']; // Keep old thumbnail
                }
            }
        }
    }
    
    // If no errors, update project
    if (empty($errors)) {
        mysqli_begin_transaction($conn);
        
        try {
            // Update project
            $stmt = mysqli_prepare($conn, 
                "UPDATE projects SET title = ?, description = ?, project_blueprint = ?, category = ?, 
                 department = ?, semester = ?, github_link = ?, demo_link = ?, thumbnail = ?, 
                 visibility = ?, updated_at = NOW() 
                 WHERE project_id = ?"
            );
            
            mysqli_stmt_bind_param($stmt, "ssssssssssi", 
                $title,
                $description,
                $projectBlueprint,
                $category,
                $department,
                $semester,
                $githubLink,
                $demoLink,
                $thumbnailPath,
                $visibility,
                $projectId
            );
            
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Failed to update project");
            }
            
            // Delete existing tags
            mysqli_query($conn, "DELETE FROM project_tags WHERE project_id = $projectId");
            
            // Insert new tags
            if (!empty($tags)) {
                foreach ($tags as $tagName) {
                    $tagName = trim($tagName);
                    if (empty($tagName)) continue;
                    
                    // Get tag ID
                    $tagCheckQuery = mysqli_query($conn, "SELECT tag_id FROM tags WHERE tag_name = '" . mysqli_real_escape_string($conn, $tagName) . "'");
                    
                    if (mysqli_num_rows($tagCheckQuery) > 0) {
                        $tagRow = mysqli_fetch_assoc($tagCheckQuery);
                        $tagId = $tagRow['tag_id'];
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
            
            $_SESSION['success_message'] = "Project updated successfully!";
            header("Location: project_details.php?id=" . $projectId);
            exit();
            
        } catch (Exception $e) {
            mysqli_rollback($conn);
            $errors[] = "Failed to update project: " . $e->getMessage();
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
$pageTitle = 'Edit Project';
require_once '../includes/header.php';
?>

<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Project</h1>
        <p class="text-gray-600">Update your project details</p>
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

    <!-- Edit Form -->
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
                   value="<?php echo escape($project['title']); ?>"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
        </div>

        <!-- Project Description -->
        <div>
            <label class="block text-sm font-semibold text-gray-900 mb-2">
                Project Description <span class="text-red-500">*</span>
            </label>
            <textarea name="description" 
                      required 
                      rows="5"
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"><?php echo escape($project['description']); ?></textarea>
        </div>

        <!-- Project Blueprint -->
        <div>
            <label class="block text-sm font-semibold text-gray-900 mb-2">
                Project Blueprint (Markdown supported)
            </label>
            <textarea name="project_blueprint" 
                      rows="10"
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent font-mono text-sm"><?php echo escape($project['project_blueprint']); ?></textarea>
        </div>

        <!-- Category and Department -->
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Category <span class="text-red-500">*</span>
                </label>
                <select name="category" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Select Category</option>
                    <?php
                    $categories = ['WebApp', 'MobileApp', 'AI', 'MachineLearning', 'IoT', 'Hardware', 'Design', 'Research', 'DataScience', 'GameDev', 'Blockchain', 'CyberSecurity', 'CloudComputing'];
                    foreach ($categories as $cat) {
                        $selected = ($project['category'] == $cat) ? 'selected' : '';
                        echo "<option value=\"$cat\" $selected>$cat</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Department
                </label>
                <select name="department" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Select Department</option>
                    <?php
                    $departments = ['CSE', 'EEE', 'CE', 'BBA', 'Economics', 'English', 'Law'];
                    foreach ($departments as $dept) {
                        $selected = ($project['department'] == $dept) ? 'selected' : '';
                        echo "<option value=\"$dept\" $selected>$dept</option>";
                    }
                    ?>
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
                   value="<?php echo escape($project['semester']); ?>"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
        </div>

        <!-- Links -->
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    <i class="fab fa-github mr-1"></i> GitHub Repository
                </label>
                <input type="url" 
                       name="github_link"
                       value="<?php echo escape($project['github_link']); ?>"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    <i class="fas fa-external-link-alt mr-1"></i> Live Demo
                </label>
                <input type="url" 
                       name="demo_link"
                       value="<?php echo escape($project['demo_link']); ?>"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
            </div>
        </div>

        <!-- Thumbnail -->
        <div>
            <label class="block text-sm font-semibold text-gray-900 mb-2">
                Project Thumbnail
            </label>
            
            <?php if (!empty($project['thumbnail'])): ?>
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-2">Current thumbnail:</p>
                <img src="<?php echo BASE_URL; ?>/uploads/projects/<?php echo $project['thumbnail']; ?>" 
                     alt="Current thumbnail" 
                     class="max-h-32 rounded-lg">
            </div>
            <?php endif; ?>
            
            <input type="file" 
                   name="thumbnail" 
                   accept="image/*"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                   onchange="previewThumbnail(this)">
            <p class="mt-1 text-sm text-gray-500">Leave empty to keep current thumbnail. PNG, JPG, WebP up to 5MB</p>
            
            <div id="thumbnail-preview" class="mt-4 hidden">
                <p class="text-sm text-gray-600 mb-2">New thumbnail preview:</p>
                <img src="" alt="New thumbnail preview" class="max-h-64 rounded-lg">
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
                           <?php echo in_array($tag, $selectedTags) ? 'checked' : ''; ?>
                           class="w-4 h-4 text-orange-600 focus:ring-orange-500 rounded">
                    <span class="ml-2 text-sm text-gray-700"><?php echo escape($tag); ?></span>
                </label>
                <?php endforeach; ?>
            </div>
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
                           <?php echo ($project['visibility'] == 'public') ? 'checked' : ''; ?>
                           class="w-4 h-4 text-orange-600 focus:ring-orange-500">
                    <span class="ml-2 text-gray-700">
                        <i class="fas fa-globe mr-1"></i> Public
                    </span>
                </label>
                <label class="flex items-center">
                    <input type="radio" 
                           name="visibility" 
                           value="private"
                           <?php echo ($project['visibility'] == 'private') ? 'checked' : ''; ?>
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
                <i class="fas fa-save mr-2"></i>
                Update Project
            </button>
            <a href="project_details.php?id=<?php echo $projectId; ?>"
               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
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
