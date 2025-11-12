<?php
/**
 * Project Details Page
 * UIUArchive - Built by UIU Minds
 */

$pageTitle = 'Project Details';
require_once '../includes/header.php';

// Get project ID from URL
$projectId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($projectId <= 0) {
    header('Location: index.php');
    exit();
}

// Fetch project details with tags
$query = "SELECT p.*, u.full_name, u.profile_image, u.department,
                 GROUP_CONCAT(t.tag_name ORDER BY t.tag_name ASC SEPARATOR ',') as tags
          FROM projects p 
          JOIN users u ON p.user_id = u.user_id 
          LEFT JOIN project_tags pt ON p.project_id = pt.project_id
          LEFT JOIN tags t ON pt.tag_id = t.tag_id
          WHERE p.project_id = $projectId
          GROUP BY p.project_id";
$result = mysqli_query($conn, $query);
$project = mysqli_fetch_assoc($result);

if (!$project) {
    echo '<div class="max-w-4xl mx-auto px-4 py-12 text-center">';
    echo '<h1 class="text-2xl font-bold text-gray-700 mb-4">Project Not Found</h1>';
    echo '<a href="index.php" class="text-orange-600 hover:text-orange-700">← Back to Home</a>';
    echo '</div>';
    require_once '../includes/footer.php';
    exit();
}

// Update view count
mysqli_query($conn, "UPDATE projects SET views_count = views_count + 1 WHERE project_id = $projectId");

// Check if user has liked this project
$hasLiked = false;
if ($isLoggedIn) {
    $likeQuery = "SELECT 1 FROM likes WHERE user_id = {$_SESSION['user_id']} AND project_id = $projectId";
    $likeResult = mysqli_query($conn, $likeQuery);
    $hasLiked = mysqli_num_rows($likeResult) > 0;
}
?>

<div class="px-4 py-8">
    <!-- Back Button -->
    <a href="index.php" class="inline-flex items-center text-gray-600 hover:text-orange-600 mb-6">
        <i class="fas fa-arrow-left mr-2"></i>
        Back to Projects
    </a>

    <!-- Project Header -->
    <div class="p-6 mb-6">
        <div class="flex items-start justify-between mb-4">
            <h1 class="text-3xl font-bold text-gray-900"><?php echo escape($project['title']); ?></h1>
            
            <!-- Edit/Delete Buttons (only for project owner) -->
            <?php if ($isLoggedIn && $_SESSION['user_id'] == $project['user_id']): ?>
            <div class="flex gap-2">
                <a href="edit_project.php?id=<?php echo $projectId; ?>" 
                   class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-edit"></i>
                    <span>Edit</span>
                </a>
                <button type="button" 
                        onclick="confirmDelete(<?php echo $projectId; ?>)" 
                        class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <i class="fas fa-trash"></i>
                    <span>Delete</span>
                </button>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Author Info -->
        <div class="flex items-center justify-between mb-6 flex-wrap gap-4">
            <a href="profile.php?id=<?php echo $project['user_id']; ?>" class="flex items-center gap-4 hover:opacity-80 transition-opacity">
                <?php 
                    $profileImgSrc = getProfileImageUrl($project['profile_image'], $project['full_name']);
                ?>
                <img src="<?php echo $profileImgSrc; ?>" 
                     alt="<?php echo escape($project['full_name']); ?>"
                     referrerpolicy="no-referrer"
                     class="w-12 h-12 rounded-full object-cover border-2 border-orange-500"
                     onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($project['full_name']); ?>&background=c2410c&color=fff&size=48';">
                <div>
                    <h3 class="font-semibold text-gray-900 hover:text-orange-600 transition-colors whitespace-nowrap"><?php echo escape($project['full_name']); ?></h3>
                    <p class="text-sm text-gray-500"><?php echo escape($project['department']); ?> • <?php echo timeAgo($project['created_at']); ?></p>
                </div>
            </a>
            
            <!-- Like Button -->
            <?php if ($isLoggedIn): ?>
            <button class="like-btn flex items-center gap-2 px-4 py-2 rounded-lg transition-colors <?php echo $hasLiked ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'; ?>" 
                    data-project-id="<?php echo $projectId; ?>">
                <i class="<?php echo $hasLiked ? 'fas' : 'far'; ?> fa-heart"></i>
                <span class="like-count"><?php echo $project['likes_count']; ?></span>
            </button>
            <?php else: ?>
            <a href="login.php" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200">
                <i class="far fa-heart"></i>
                <span><?php echo $project['likes_count']; ?></span>
            </a>
            <?php endif; ?>
        </div>

        <!-- Project Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 p-4 bg-gray-200 rounded-lg">
            <div class="text-center">
                <div class="text-2xl font-bold text-orange-600 stats-likes-count"><?php echo $project['likes_count']; ?></div>
                <div class="text-sm text-gray-500">Likes</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600"><?php echo $project['views_count']; ?></div>
                <div class="text-sm text-gray-500">Views</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600"><?php echo date('Y', strtotime($project['created_at'])); ?></div>
                <div class="text-sm text-gray-500">Year</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600"><?php echo escape($project['category']); ?></div>
                <div class="text-sm text-gray-500">Category</div>
            </div>
        </div>

        <!-- Project Thumbnail -->
        <?php if ($project['thumbnail']): ?>
        <div class="mb-6">
            <img src="<?php echo BASE_URL; ?>/uploads/projects/<?php echo $project['thumbnail']; ?>" 
                 alt="<?php echo escape($project['title']); ?>"
                 class="w-full max-h-96 object-cover rounded-lg">
        </div>
        <?php endif; ?>

        <!-- Description -->
        <div class="prose max-w-none mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-3">About This Project</h2>
            <div class="text-gray-700 leading-relaxed whitespace-pre-line text-base"><?php echo escape($project['description']); ?></div>
        </div>

        <!-- Project Blueprint -->
        <?php if (!empty($project['project_blueprint'])): ?>
        <div class="prose max-w-none mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-3">Project Blueprint</h2>
            <div class="text-gray-700 leading-relaxed markdown-content"><?php echo parseMarkdown($project['project_blueprint']); ?></div>
        </div>
        <?php endif; ?>

        <!-- Project Links -->
        <?php if (!empty($project['github_link']) || !empty($project['demo_link'])): ?>
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Project Links</h3>
            <div class="flex flex-wrap gap-3">
                <?php if (!empty($project['github_link'])): ?>
                <a href="<?php echo escape($project['github_link']); ?>" 
                   target="_blank" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg transition-colors">
                    <i class="fab fa-github"></i>
                    View on GitHub
                    <i class="fas fa-external-link-alt text-xs"></i>
                </a>
                <?php endif; ?>
                
                <?php if (!empty($project['demo_link'])): ?>
                <a href="<?php echo escape($project['demo_link']); ?>" 
                   target="_blank" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-external-link-alt"></i>
                    Live Demo
                    <i class="fas fa-external-link-alt text-xs"></i>
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Project Tags -->
        <?php if (!empty($project['tags'])): ?>
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Technologies & Tags</h3>
            <div class="flex flex-wrap gap-2">
                <?php 
                $tags = explode(',', $project['tags']);
                foreach ($tags as $tag): 
                ?>
                    <a href="index.php?search=<?php echo urlencode(trim($tag)); ?>" 
                       class="inline-block bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded-full text-sm font-medium transition-colors">
                        #<?php echo trim(escape($tag)); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Project Details -->
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-gray-200 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Project Information</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Created:</span>
                        <span class="font-medium"><?php echo date('M j, Y', strtotime($project['created_at'])); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Last Updated:</span>
                        <span class="font-medium"><?php echo date('M j, Y', strtotime($project['updated_at'])); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Category:</span>
                        <span class="font-medium"><?php echo escape($project['category']); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Department:</span>
                        <span class="font-medium"><?php echo escape($project['department']); ?></span>
                    </div>
                    <?php if (!empty($project['semester'])): ?>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Semester:</span>
                        <span class="font-medium"><?php echo escape($project['semester']); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Visibility:</span>
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                            <?php echo ucfirst($project['visibility']); ?>
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-200 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Engagement & Stats</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Views:</span>
                        <span class="font-medium"><?php echo number_format($project['views_count']); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Likes:</span>
                        <span class="font-medium"><?php echo number_format($project['likes_count']); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Project ID:</span>
                        <span class="font-medium">#<?php echo $project['project_id']; ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">GitHub:</span>
                        <span class="font-medium">
                            <?php if (!empty($project['github_link'])): ?>
                                <i class="fab fa-github text-green-600"></i> Available
                            <?php else: ?>
                                <i class="fas fa-times text-red-500"></i> Not provided
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Live Demo:</span>
                        <span class="font-medium">
                            <?php if (!empty($project['demo_link'])): ?>
                                <i class="fas fa-link text-blue-600"></i> Available
                            <?php else: ?>
                                <i class="fas fa-times text-red-500"></i> Not provided
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tags:</span>
                        <span class="font-medium">
                            <?php 
                            $tagCount = !empty($project['tags']) ? count(explode(',', $project['tags'])) : 0;
                            echo $tagCount . ' tags';
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>

<script>
// Ensure Swal is loaded before defining the function
if (typeof Swal === 'undefined') {
    console.error('SweetAlert2 is not loaded!');
}

function confirmDelete(projectId) {
    console.log('confirmDelete called with projectId:', projectId);
    
    if (typeof Swal === 'undefined') {
        alert('Error: SweetAlert2 library not loaded. Please refresh the page.');
        return;
    }
    
    Swal.fire({
        title: 'Delete This Project?',
        html: `
            <div class="text-left">
                <p class="text-gray-700 mb-4">You are about to permanently delete this project.</p>
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4 rounded">
                    <p class="text-sm text-red-900 font-semibold mb-2">This will permanently delete:</p>
                    <ul class="text-sm text-red-800 list-disc list-inside space-y-1">
                        <li>All project information and details</li>
                        <li>Project thumbnail and uploaded media</li>
                        <li>All likes and engagement data</li>
                        <li>All tags and associations</li>
                    </ul>
                </div>
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-3 rounded">
                    <p class="text-sm text-yellow-800">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        <strong>Warning:</strong> This action is permanent and cannot be undone!
                    </p>
                </div>
            </div>
        `,
        icon: 'warning',
        iconColor: '#dc2626',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash mr-2"></i>Yes, Delete Project',
        cancelButtonText: '<i class="fas fa-times mr-2"></i>Keep Project',
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
console.log('Delete confirmation script loaded');
</script>

