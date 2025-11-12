<?php
/**
 * My Projects Page
 * UIUArchive - Built by UIU Minds
 */

$pageTitle = 'My Projects';
require_once '../includes/header.php';

// Check if user is logged in
if (!$isLoggedIn) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch user info
$userQuery = "SELECT full_name, profile_image FROM users WHERE user_id = $userId";
$userResult = mysqli_query($conn, $userQuery);
$user = mysqli_fetch_assoc($userResult);

// Fetch public projects
$publicQuery = "SELECT p.*, 
                       (SELECT COUNT(*) FROM likes WHERE project_id = p.project_id) as likes_count,
                       GROUP_CONCAT(t.tag_name ORDER BY t.tag_name ASC SEPARATOR ',') as tags
                FROM projects p
                LEFT JOIN project_tags pt ON p.project_id = pt.project_id
                LEFT JOIN tags t ON pt.tag_id = t.tag_id
                WHERE p.user_id = $userId AND p.visibility = 'public'
                GROUP BY p.project_id
                ORDER BY p.created_at DESC";
$publicProjects = mysqli_query($conn, $publicQuery);
$publicCount = mysqli_num_rows($publicProjects);

// Fetch private projects
$privateQuery = "SELECT p.*, 
                        (SELECT COUNT(*) FROM likes WHERE project_id = p.project_id) as likes_count,
                        GROUP_CONCAT(t.tag_name ORDER BY t.tag_name ASC SEPARATOR ',') as tags
                 FROM projects p
                 LEFT JOIN project_tags pt ON p.project_id = pt.project_id
                 LEFT JOIN tags t ON pt.tag_id = t.tag_id
                 WHERE p.user_id = $userId AND p.visibility = 'private'
                 GROUP BY p.project_id
                 ORDER BY p.created_at DESC";
$privateProjects = mysqli_query($conn, $privateQuery);
$privateCount = mysqli_num_rows($privateProjects);

$totalCount = $publicCount + $privateCount;
?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">My Projects</h1>
            <p class="text-gray-600">Manage all your projects in one place</p>
        </div>
        <a href="upload_project.php" 
           class="flex items-center gap-2 px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-semibold transition-colors">
            <i class="fas fa-plus"></i>
            <span>New Project</span>
        </a>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm mb-1">Total Projects</p>
                    <p class="text-3xl font-bold"><?php echo $totalCount; ?></p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-project-diagram text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm mb-1">Public Projects</p>
                    <p class="text-3xl font-bold"><?php echo $publicCount; ?></p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-globe text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm mb-1">Private Projects</p>
                    <p class="text-3xl font-bold"><?php echo $privateCount; ?></p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-lock text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Public Projects Section -->
    <div class="mb-12">
        <div class="flex items-center gap-2 mb-6">
            <i class="fas fa-globe text-green-600 text-xl"></i>
            <h2 class="text-2xl font-bold text-gray-900">Public Projects</h2>
            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold"><?php echo $publicCount; ?></span>
        </div>

        <?php if ($publicCount > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while ($project = mysqli_fetch_assoc($publicProjects)): ?>
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                <!-- Thumbnail -->
                <div class="h-48 bg-gradient-to-br from-orange-400 to-orange-600 overflow-hidden relative group">
                    <?php if ($project['thumbnail']): ?>
                        <img src="<?php echo BASE_URL; ?>/uploads/projects/<?php echo $project['thumbnail']; ?>" 
                             alt="<?php echo escape($project['title']); ?>"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <?php else: ?>
                        <div class="flex items-center justify-center h-full text-white text-4xl">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Visibility Badge -->
                    <div class="absolute top-3 right-3 bg-green-500 text-white px-2 py-1 rounded-full text-xs font-semibold flex items-center gap-1">
                        <i class="fas fa-globe"></i>
                        <span>Public</span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-1">
                        <?php echo escape($project['title']); ?>
                    </h3>
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                        <?php echo escape(substr($project['description'], 0, 100)); ?>...
                    </p>

                    <!-- Stats -->
                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                        <span class="flex items-center gap-1">
                            <i class="fas fa-heart text-red-500"></i>
                            <?php echo $project['likes_count']; ?>
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="fas fa-eye text-blue-500"></i>
                            <?php echo $project['views_count']; ?>
                        </span>
                        <span class="text-gray-400">•</span>
                        <span><?php echo timeAgo($project['created_at']); ?></span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <a href="project_details.php?id=<?php echo $project['project_id']; ?>"
                           class="flex-1 text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                            <i class="fas fa-eye mr-1"></i> View
                        </a>
                        <a href="edit_project.php?id=<?php echo $project['project_id']; ?>"
                           class="flex-1 text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <button type="button" onclick="confirmDelete(<?php echo $project['project_id']; ?>, '<?php echo addslashes($project['title']); ?>')"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php else: ?>
        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-12 text-center">
            <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No Public Projects Yet</h3>
            <p class="text-gray-500 mb-6">Start sharing your work with the community</p>
            <a href="upload_project.php" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-semibold transition-colors">
                <i class="fas fa-plus"></i>
                <span>Upload Your First Project</span>
            </a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Private Projects Section -->
    <div class="mb-12">
        <div class="flex items-center gap-2 mb-6">
            <i class="fas fa-lock text-purple-600 text-xl"></i>
            <h2 class="text-2xl font-bold text-gray-900">Private Projects</h2>
            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold"><?php echo $privateCount; ?></span>
        </div>

        <?php if ($privateCount > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while ($project = mysqli_fetch_assoc($privateProjects)): ?>
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                <!-- Thumbnail -->
                <div class="h-48 bg-gradient-to-br from-purple-400 to-purple-600 overflow-hidden relative group">
                    <?php if ($project['thumbnail']): ?>
                        <img src="<?php echo BASE_URL; ?>/uploads/projects/<?php echo $project['thumbnail']; ?>" 
                             alt="<?php echo escape($project['title']); ?>"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <?php else: ?>
                        <div class="flex items-center justify-center h-full text-white text-4xl">
                            <i class="fas fa-lock"></i>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Visibility Badge -->
                    <div class="absolute top-3 right-3 bg-purple-500 text-white px-2 py-1 rounded-full text-xs font-semibold flex items-center gap-1">
                        <i class="fas fa-lock"></i>
                        <span>Private</span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-1">
                        <?php echo escape($project['title']); ?>
                    </h3>
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                        <?php echo escape(substr($project['description'], 0, 100)); ?>...
                    </p>

                    <!-- Stats -->
                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                        <span class="flex items-center gap-1">
                            <i class="fas fa-heart text-red-500"></i>
                            <?php echo $project['likes_count']; ?>
                        </span>
                        <span class="flex items-center gap-1">
                            <i class="fas fa-eye text-blue-500"></i>
                            <?php echo $project['views_count']; ?>
                        </span>
                        <span class="text-gray-400">•</span>
                        <span><?php echo timeAgo($project['created_at']); ?></span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <a href="project_details.php?id=<?php echo $project['project_id']; ?>"
                           class="flex-1 text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                            <i class="fas fa-eye mr-1"></i> View
                        </a>
                        <a href="edit_project.php?id=<?php echo $project['project_id']; ?>"
                           class="flex-1 text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <button type="button" onclick="confirmDelete(<?php echo $project['project_id']; ?>, '<?php echo addslashes($project['title']); ?>')"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php else: ?>
        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-12 text-center">
            <i class="fas fa-lock text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No Private Projects</h3>
            <p class="text-gray-500 mb-6">Keep your work private until you're ready to share</p>
            <a href="upload_project.php" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-semibold transition-colors">
                <i class="fas fa-plus"></i>
                <span>Create Private Project</span>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>

<script>
// Ensure Swal is loaded before defining the function
if (typeof Swal === 'undefined') {
    console.error('SweetAlert2 is not loaded!');
}

function confirmDelete(projectId, projectTitle) {
    console.log('confirmDelete called with projectId:', projectId, 'projectTitle:', projectTitle);
    
    if (typeof Swal === 'undefined') {
        alert('Error: SweetAlert2 library not loaded. Please refresh the page.');
        return;
    }
    
    Swal.fire({
        title: 'Delete Project?',
        html: `
            <div class="text-left">
                <p class="text-gray-700 mb-3">You are about to delete:</p>
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4 rounded">
                    <p class="font-semibold text-red-900">${projectTitle}</p>
                </div>
                <p class="text-gray-600 mb-2">This will permanently delete:</p>
                <ul class="text-sm text-gray-600 list-disc list-inside space-y-1 mb-4">
                    <li>All project information</li>
                    <li>Project thumbnail and media</li>
                    <li>All likes and engagement data</li>
                    <li>All tags and associations</li>
                </ul>
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-3 rounded">
                    <p class="text-sm text-yellow-800">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        <strong>Warning:</strong> This action cannot be undone!
                    </p>
                </div>
            </div>
        `,
        icon: 'warning',
        iconColor: '#dc2626',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash mr-2"></i>Yes, Delete It',
        cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancel',
        customClass: {
            popup: 'rounded-lg',
            title: 'text-2xl font-bold text-gray-900',
            confirmButton: 'px-6 py-3 rounded-lg font-semibold',
            cancelButton: 'px-6 py-3 rounded-lg font-semibold'
        },
        width: '600px',
        backdrop: 'rgba(0,0,0,0.4)',
        focusCancel: true
    }).then((result) => {
        console.log('Swal result:', result);
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Deleting Project...',
                text: 'Please wait while we delete your project',
                icon: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Redirect to delete handler
            console.log('Redirecting to delete_project.php?id=' + projectId);
            window.location.href = 'delete_project.php?id=' + projectId;
        }
    }).catch((error) => {
        console.error('Swal error:', error);
    });
}

// Log that script is loaded
console.log('My Projects delete confirmation script loaded');
</script>
