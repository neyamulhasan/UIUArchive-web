<?php
/**
 * User Profile Page
 * UIUArchive - Built by UIU Minds
 */

$pageTitle = 'User Profile';
require_once '../includes/header.php';

// Get user ID from URL, or use current logged-in user
$profileUserId = isset($_GET['id']) ? (int)$_GET['id'] : ($isLoggedIn ? $currentUserId : 0);

if ($profileUserId <= 0) {
    $_SESSION['error'] = 'Please login to view profiles.';
    header('Location: login.php');
    exit();
}

// Fetch user details
$query = "SELECT * FROM users WHERE user_id = $profileUserId";
$result = mysqli_query($conn, $query);
$profileUser = mysqli_fetch_assoc($result);

if (!$profileUser) {
    echo '<div class="max-w-4xl mx-auto px-4 py-12 text-center">';
    echo '<h1 class="text-2xl font-bold text-gray-700 mb-4">User Not Found</h1>';
    echo '<a href="index.php" class="text-orange-600 hover:text-orange-700">← Back to Home</a>';
    echo '</div>';
    require_once '../includes/footer.php';
    exit();
}

// Get user's projects
$projectsQuery = "SELECT * FROM projects WHERE user_id = $profileUserId AND visibility = 'public' ORDER BY created_at DESC";
$projects = mysqli_query($conn, $projectsQuery);
$projectCount = mysqli_num_rows($projects);

// Get stats
$likesQuery = mysqli_query($conn, "SELECT SUM(likes_count) as total FROM projects WHERE user_id = $profileUserId");
$totalLikes = mysqli_fetch_assoc($likesQuery)['total'] ?? 0;

// Get total views across all projects
$viewsQuery = mysqli_query($conn, "SELECT SUM(views_count) as total FROM projects WHERE user_id = $profileUserId");
$totalViews = mysqli_fetch_assoc($viewsQuery)['total'] ?? 0;

// Get recommendations count
$recommendationsCount = $profileUser['recommendations_count'] ?? 0;
?>

<div class="w-full px-4 py-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Profile Header Section -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row gap-6 items-start">
                <!-- Profile Image -->
                <?php 
                    $profileImgSrc = getProfileImageUrl($profileUser['profile_image'], $profileUser['full_name']);
                ?>
                <div class="flex-shrink-0">
                    <img src="<?php echo $profileImgSrc; ?>" 
                         alt="<?php echo escape($profileUser['full_name']); ?>"
                         referrerpolicy="no-referrer"
                         class="w-32 h-32 rounded-full object-cover border-4 border-orange-600"
                         onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($profileUser['full_name']); ?>&background=c2410c&color=fff&size=128';">
                </div>
                
                <!-- Profile Info -->
                <div class="flex-1">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-1"><?php echo escape($profileUser['full_name']); ?></h1>
                            <p class="text-base text-gray-600 mb-1">
                                <?php echo escape($profileUser['department']); ?>
                                <?php if (!empty($profileUser['semester'])): ?>
                                    • Batch <?php echo escape($profileUser['semester']); ?>
                                <?php endif; ?>
                            </p>
                        </div>
                        <?php if ($isLoggedIn && $currentUserId == $profileUserId): ?>
                        <a href="edit_profile.php" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition flex items-center gap-2">
                            <i class="fas fa-edit"></i>
                            <span>Edit Profile</span>
                        </a>
                        <?php elseif ($isLoggedIn): ?>
                        <?php
                            // Check if current user already recommended this user
                            $checkRecQuery = "SELECT 1 FROM user_recommendations WHERE recommender_user_id = $currentUserId AND recommended_user_id = $profileUserId";
                            $checkRecResult = mysqli_query($conn, $checkRecQuery);
                            $hasRecommended = mysqli_num_rows($checkRecResult) > 0;
                        ?>
                        <button class="recommend-btn px-4 py-2 rounded-lg transition flex items-center gap-2 <?php echo $hasRecommended ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'; ?>" 
                                data-user-id="<?php echo $profileUserId; ?>"
                                data-recommended="<?php echo $hasRecommended ? '1' : '0'; ?>">
                            <i class="<?php echo $hasRecommended ? 'fas' : 'far'; ?> fa-star"></i>
                            <span><?php echo $hasRecommended ? 'Recommended' : 'Recommend'; ?></span>
                        </button>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Bio -->
                    <?php if (!empty($profileUser['bio'])): ?>
                    <div class="mb-3">
                        <p class="text-gray-700 leading-relaxed"><?php echo nl2br(escape($profileUser['bio'])); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Stats Section -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-orange-600"><?php echo $totalLikes; ?></div>
                <div class="text-sm text-gray-500">Likes</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-600"><?php echo $totalViews; ?></div>
                <div class="text-sm text-gray-500">Views</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-green-600">
                    <?php echo !empty($profileUser['semester']) ? escape($profileUser['semester']) : 'N/A'; ?>
                </div>
                <div class="text-sm text-gray-500">Batch</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-purple-600"><?php echo strtoupper(substr($profileUser['department'], 0, 3)); ?></div>
                <div class="text-sm text-gray-500">Department</div>
            </div>
        </div>
        
        <!-- Project Links Section -->
        <?php if (!empty($profileUser['github_url']) || !empty($profileUser['linkedin_url'])): ?>
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Project Links</h3>
            <div class="flex flex-wrap gap-3">
                <?php if (!empty($profileUser['github_url'])): ?>
                <a href="<?php echo escape($profileUser['github_url']); ?>" 
                   target="_blank" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg transition-colors">
                    <i class="fab fa-github"></i>
                    View on GitHub
                    <i class="fas fa-external-link-alt text-xs"></i>
                </a>
                <?php endif; ?>
                
                <?php if (!empty($profileUser['linkedin_url'])): ?>
                <a href="<?php echo escape($profileUser['linkedin_url']); ?>" 
                   target="_blank" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <i class="fab fa-linkedin"></i>
                    LinkedIn Profile
                    <i class="fas fa-external-link-alt text-xs"></i>
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- User Details -->
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div class="bg-gray-200 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">User Information</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Created:</span>
                        <span class="font-medium"><?php echo date('M j, Y', strtotime($profileUser['created_at'])); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Last Updated:</span>
                        <span class="font-medium"><?php echo date('M j, Y', strtotime($profileUser['updated_at'])); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Department:</span>
                        <span class="font-medium"><?php echo escape($profileUser['department']); ?></span>
                    </div>
                    <?php if (!empty($profileUser['semester'])): ?>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Semester:</span>
                        <span class="font-medium"><?php echo escape($profileUser['semester']); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Role:</span>
                        <span class="px-2 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-medium">
                            <?php echo ucfirst($profileUser['role']); ?>
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-200 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Engagement & Stats</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Views:</span>
                        <span class="font-medium"><?php echo number_format($totalViews); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Likes:</span>
                        <span class="font-medium"><?php echo number_format($totalLikes); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Recommendations:</span>
                        <span class="font-medium recommendations-count"><?php echo number_format($recommendationsCount); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Project ID:</span>
                        <span class="font-medium">#<?php echo $profileUserId; ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">GitHub:</span>
                        <span class="font-medium">
                            <?php if (!empty($profileUser['github_url'])): ?>
                                <i class="fab fa-github text-green-600"></i> Available
                            <?php else: ?>
                                <i class="fas fa-times text-red-500"></i> Not provided
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">LinkedIn:</span>
                        <span class="font-medium">
                            <?php if (!empty($profileUser['linkedin_url'])): ?>
                                <i class="fab fa-linkedin text-blue-600"></i> Available
                            <?php else: ?>
                                <i class="fas fa-times text-red-500"></i> Not provided
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Projects Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">
                <i class="fas fa-folder-open mr-2 text-orange-600"></i>
                Projects (<?php echo $projectCount; ?>)
            </h2>
            
            <?php if ($projectCount > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php while ($project = mysqli_fetch_assoc($projects)): ?>
                <a href="project_details.php?id=<?php echo $project['project_id']; ?>" 
                   class="block bg-white border border-gray-300 rounded-lg overflow-hidden hover:border-orange-500 hover:shadow-lg transition-all duration-300">
                    <!-- Thumbnail -->
                    <div class="aspect-video bg-gradient-to-br from-orange-400 to-orange-600">
                        <?php if ($project['thumbnail']): ?>
                        <img src="<?php echo BASE_URL; ?>/uploads/projects/<?php echo $project['thumbnail']; ?>" 
                             alt="<?php echo escape($project['title']); ?>"
                             class="w-full h-full object-cover">
                        <?php else: ?>
                        <div class="flex items-center justify-center h-full text-white text-4xl">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Project Info -->
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 mb-2 line-clamp-1 text-lg">
                            <?php echo escape($project['title']); ?>
                        </h3>
                        
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                            <?php echo escape($project['description']); ?>
                        </p>
                        
                        <!-- Project Meta -->
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                            <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded">
                                <?php echo escape($project['category']); ?>
                            </span>
                            <span>
                                <i class="fas fa-calendar"></i>
                                <?php echo date('M Y', strtotime($project['created_at'])); ?>
                            </span>
                        </div>
                        
                        <!-- Stats -->
                        <div class="flex items-center gap-4 text-sm">
                            <span class="flex items-center gap-1 text-red-500">
                                <i class="fas fa-heart"></i>
                                <?php echo $project['likes_count']; ?>
                            </span>
                            <span class="flex items-center gap-1 text-gray-500">
                                <i class="fas fa-eye"></i>
                                <?php echo $project['views_count']; ?>
                            </span>
                        </div>
                    </div>
                </a>
                <?php endwhile; ?>
            </div>
            <?php else: ?>
            <div class="text-center py-16">
                <i class="fas fa-folder-open text-gray-300 text-6xl mb-4"></i>
                <p class="text-gray-500 text-lg mb-2">No projects yet</p>
                <p class="text-gray-400 text-sm mb-6">
                    <?php if ($isLoggedIn && $currentUserId == $profileUserId): ?>
                    Start sharing your amazing work with the community!
                    <?php else: ?>
                    This user hasn't uploaded any projects yet.
                    <?php endif; ?>
                </p>
                <?php if ($isLoggedIn && $currentUserId == $profileUserId): ?>
                <a href="upload_project.php" class="inline-flex items-center gap-2 px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                    <i class="fas fa-plus"></i>
                    <span>Upload Your First Project</span>
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
