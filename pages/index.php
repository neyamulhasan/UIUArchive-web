<?php
/**
 * Homepage - Project Feed
 * UIUArchive - Built by UIU Minds
 */

$pageTitle = 'Home';
require_once '../includes/header.php';

// Get filter parameters
$filter = isset($_GET['filter']) ? sanitizeInput($_GET['filter']) : 'latest';
$search = isset($_GET['search']) ? sanitizeInput($_GET['search']) : '';
$category = isset($_GET['category']) ? sanitizeInput($_GET['category']) : '';
$department = isset($_GET['department']) ? sanitizeInput($_GET['department']) : '';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 12;
$offset = ($page - 1) * $perPage;

// Build query
$whereConditions = ["p.visibility = 'public'"];
$params = [];
$types = "";

if ($search) {
    $whereConditions[] = "(p.title LIKE ? OR p.description LIKE ? OR u.full_name LIKE ?)";
    $searchTerm = "%$search%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $types .= "sss";
}

if ($category) {
    $whereConditions[] = "p.category = ?";
    $params[] = $category;
    $types .= "s";
}

if ($department) {
    $whereConditions[] = "p.department = ?";
    $params[] = $department;
    $types .= "s";
}

$whereClause = implode(" AND ", $whereConditions);

// Order by clause
$orderBy = "p.created_at DESC";
if ($filter === 'trending') {
    $orderBy = "(p.likes_count * 3 + p.comments_count * 2 + p.views_count) DESC";
} elseif ($filter === 'featured') {
    $whereConditions[] = "p.is_featured = 1";
    $whereClause = implode(" AND ", $whereConditions);
} elseif ($filter === 'popular') {
    $orderBy = "p.likes_count DESC";
}

// Get projects
$query = "SELECT p.*, u.full_name, u.profile_image, u.department as user_department
          FROM projects p
          JOIN users u ON p.user_id = u.user_id
          WHERE $whereClause
          ORDER BY $orderBy
          LIMIT ? OFFSET ?";

$stmt = mysqli_prepare($conn, $query);
$params[] = $perPage;
$params[] = $offset;
$types .= "ii";

if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$projects = mysqli_stmt_get_result($stmt);

// Get total count for pagination
$countQuery = "SELECT COUNT(*) as total FROM projects p JOIN users u ON p.user_id = u.user_id WHERE $whereClause";
$countStmt = mysqli_prepare($conn, $countQuery);
if (!empty($types) && strlen($types) > 2) {
    $countTypes = substr($types, 0, -2);
    $countParams = array_slice($params, 0, -2);
    if (!empty($countParams)) {
        mysqli_stmt_bind_param($countStmt, $countTypes, ...$countParams);
    }
}
mysqli_stmt_execute($countStmt);
$totalProjects = mysqli_fetch_assoc(mysqli_stmt_get_result($countStmt))['total'];
$totalPages = ceil($totalProjects / $perPage);

// Get popular tags
$tagsQuery = "SELECT * FROM tags ORDER BY usage_count DESC LIMIT 10";
$popularTags = mysqli_query($conn, $tagsQuery);
?>

<div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8 py-4 sm:py-8">
    <!-- Mobile Filters & Tags Combined Dropdown -->
    <div class="block lg:hidden mb-4 w-full">
        <details class="bg-white rounded-lg shadow-lg w-full">
            <summary class="flex items-center justify-between p-4 hover:bg-gray-50 transition cursor-pointer">
                <div class="flex items-center">
                    <i class="fas fa-filter text-orange-600 mr-2"></i>
                    <h3 class="font-bold text-base">Filters & Tags</h3>
                </div>
                <i class="fas fa-chevron-down transition-transform duration-200"></i>
            </summary>
            <div class="border-t bg-white w-full">
                <!-- Filters Section -->
                <div class="px-4 py-3 border-b bg-gray-50">
                    <h4 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                        <i class="fas fa-sliders-h text-orange-600 mr-2"></i>Filters
                    </h4>
                    <div class="space-y-1">
                        <a href="index.php?filter=latest" 
                           class="block px-3 py-2 rounded text-sm <?php echo $filter === 'latest' ? 'bg-orange-600 text-white' : 'bg-white text-gray-700 hover:bg-orange-50'; ?> transition">
                            <i class="fas fa-clock mr-2"></i>Latest
                        </a>
                        <a href="index.php?filter=trending" 
                           class="block px-3 py-2 rounded text-sm <?php echo $filter === 'trending' ? 'bg-orange-600 text-white' : 'bg-white text-gray-700 hover:bg-orange-50'; ?> transition">
                            <i class="fas fa-fire mr-2"></i>Trending
                        </a>
                        <a href="index.php?filter=popular" 
                           class="block px-3 py-2 rounded text-sm <?php echo $filter === 'popular' ? 'bg-orange-600 text-white' : 'bg-white text-gray-700 hover:bg-orange-50'; ?> transition">
                            <i class="fas fa-heart mr-2"></i>Popular
                        </a>
                        <a href="index.php?filter=featured" 
                           class="block px-3 py-2 rounded text-sm <?php echo $filter === 'featured' ? 'bg-orange-600 text-white' : 'bg-white text-gray-700 hover:bg-orange-50'; ?> transition">
                            <i class="fas fa-star mr-2"></i>Featured
                        </a>
                    </div>
                </div>
                
                <!-- Popular Tags Section -->
                <div class="px-4 py-3">
                    <h4 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                        <i class="fas fa-tags text-orange-600 mr-2"></i>Popular Tags
                    </h4>
                    <div class="flex flex-wrap gap-2">
                        <?php 
                        mysqli_data_seek($popularTags, 0); // Reset pointer for mobile
                        while ($tag = mysqli_fetch_assoc($popularTags)): 
                        ?>
                            <a href="index.php?category=<?php echo urlencode($tag['tag_name']); ?>" 
                               class="px-2.5 py-1 bg-gray-100 text-gray-700 rounded-full text-xs hover:bg-orange-100 hover:text-orange-600 transition">
                                #<?php echo escape($tag['tag_name']); ?>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </details>
    </div>

    <div class="w-full">
        <div class="flex flex-col lg:flex-row gap-4 sm:gap-8">
            <!-- Desktop Sidebar -->
            <aside class="hidden lg:block lg:w-64 flex-shrink-0 space-y-6">
            <!-- Filters -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-lg mb-4">Filters</h3>
                
                <div class="space-y-2">
                    <a href="index.php?filter=latest" 
                       class="block px-4 py-2 rounded <?php echo $filter === 'latest' ? 'bg-orange-100 text-orange-600' : 'hover:bg-gray-100'; ?>">
                        <i class="fas fa-clock mr-2"></i>Latest
                    </a>
                    <a href="index.php?filter=trending" 
                       class="block px-4 py-2 rounded <?php echo $filter === 'trending' ? 'bg-orange-100 text-orange-600' : 'hover:bg-gray-100'; ?>">
                        <i class="fas fa-fire mr-2"></i>Trending
                    </a>
                    <a href="index.php?filter=popular" 
                       class="block px-4 py-2 rounded <?php echo $filter === 'popular' ? 'bg-orange-100 text-orange-600' : 'hover:bg-gray-100'; ?>">
                        <i class="fas fa-heart mr-2"></i>Popular
                    </a>
                    <a href="index.php?filter=featured" 
                       class="block px-4 py-2 rounded <?php echo $filter === 'featured' ? 'bg-orange-100 text-orange-600' : 'hover:bg-gray-100'; ?>">
                        <i class="fas fa-star mr-2"></i>Featured
                    </a>
                </div>
            </div>
            
            <!-- Popular Tags -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-lg mb-4">Popular Tags</h3>
                <div class="flex flex-wrap gap-2">
                    <?php 
                    // Re-fetch tags for desktop sidebar
                    $desktopTagsQuery = "SELECT * FROM tags ORDER BY usage_count DESC LIMIT 10";
                    $desktopTags = mysqli_query($conn, $desktopTagsQuery);
                    while ($tag = mysqli_fetch_assoc($desktopTags)): 
                    ?>
                        <a href="index.php?category=<?php echo urlencode($tag['tag_name']); ?>" 
                           class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-orange-100 hover:text-orange-600 transition">
                            #<?php echo escape($tag['tag_name']); ?>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>
            
            <!-- Events (if logged in) -->
            <?php if ($isLoggedIn): ?>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-lg mb-4">Upcoming Events</h3>
                <div class="text-sm text-gray-600 space-y-3">
                    <?php
                    $eventsQuery = "SELECT * FROM events WHERE event_date >= CURDATE() AND is_active = 1 ORDER BY event_date ASC LIMIT 3";
                    $events = mysqli_query($conn, $eventsQuery);
                    while ($event = mysqli_fetch_assoc($events)):
                    ?>
                    <div class="border-l-4 border-orange-500 pl-3">
                        <p class="font-semibold text-gray-800"><?php echo escape($event['event_name']); ?></p>
                        <p class="text-xs text-gray-500">
                            <i class="far fa-calendar mr-1"></i><?php echo formatDate($event['event_date']); ?>
                        </p>
                    </div>
                    <?php endwhile; ?>
                </div>
                <a href="events.php" class="block mt-4 text-orange-600 hover:underline text-sm">View all events →</a>
            </div>
            <?php endif; ?>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 min-w-0">
            <!-- Active Filters Display -->
            <?php if ($search || $category || $department): ?>
            <div class="bg-white rounded-lg shadow p-3 sm:p-4 mb-4 sm:mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-gray-600 text-sm sm:text-base">Active filters:</span>
                        <?php if ($search): ?>
                            <span class="px-2 sm:px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-xs sm:text-sm">
                                Search: <?php echo escape(substr($search, 0, 20)) . (strlen($search) > 20 ? '...' : ''); ?>
                            </span>
                        <?php endif; ?>
                        <?php if ($category): ?>
                            <span class="px-2 sm:px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-xs sm:text-sm">
                                #<?php echo escape($category); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <a href="index.php" class="text-red-600 hover:underline text-xs sm:text-sm font-medium">Clear all</a>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Projects Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-3 sm:gap-4 lg:gap-6">
                <?php if (mysqli_num_rows($projects) > 0): ?>
                    <?php while ($project = mysqli_fetch_assoc($projects)): ?>
                        <div class="bg-white rounded-lg shadow hover:shadow-xl transition overflow-hidden">
                            <!-- Project Thumbnail -->
                            <a href="project_details.php?id=<?php echo $project['project_id']; ?>">
                                <div class="h-40 sm:h-48 bg-gradient-to-br from-orange-500 to-orange-700 relative overflow-hidden">
                                    <?php if ($project['thumbnail']): ?>
                                        <img src="<?php echo BASE_URL; ?>/uploads/projects/<?php echo $project['thumbnail']; ?>" 
                                             alt="<?php echo escape($project['title']); ?>"
                                             class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="flex items-center justify-center h-full text-white text-3xl sm:text-4xl">
                                            <i class="fas fa-project-diagram"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($project['is_featured']): ?>
                                        <span class="absolute top-2 right-2 bg-yellow-400 text-yellow-900 px-2 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-star mr-1"></i>Featured
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </a>
                            
                            <!-- Project Info -->
                            <div class="p-3 sm:p-4">
                                <a href="project_details.php?id=<?php echo $project['project_id']; ?>">
                                    <h3 class="font-bold text-base sm:text-lg mb-2 hover:text-orange-600 transition line-clamp-2">
                                        <?php echo escape($project['title']); ?>
                                    </h3>
                                </a>
                                
                                <p class="text-gray-600 text-xs sm:text-sm mb-3 sm:mb-4 line-clamp-2">
                                    <?php echo escape(substr($project['description'], 0, 100)) . '...'; ?>
                                </p>
                                
                                <!-- Author Info -->
                                <div class="flex items-center mb-4">
                                    <?php 
                                        $authorImg = $project['profile_image'];
                                        $authorImgSrc = (strpos($authorImg, 'http') === 0) ? $authorImg : BASE_URL . '/uploads/profiles/' . $authorImg;
                                    ?>
                                    <img src="<?php echo $authorImgSrc; ?>" 
                                         alt="<?php echo escape($project['full_name']); ?>"
                                         class="w-8 h-8 rounded-full object-cover mr-2"
                                         onerror="this.src='<?php echo BASE_URL; ?>/uploads/profiles/default.jpg'">
                                    <div class="flex-1">
                                        <a href="profile.php?id=<?php echo $project['user_id']; ?>" 
                                           class="text-sm font-semibold hover:text-orange-600">
                                            <?php echo escape($project['full_name']); ?>
                                        </a>
                                        <p class="text-xs text-gray-500"><?php echo timeAgo($project['created_at']); ?></p>
                                    </div>
                                </div>
                                
                                <!-- Stats -->
                                <div class="flex items-center justify-between text-gray-600 text-xs sm:text-sm border-t pt-2 sm:pt-3">
                                    <span><i class="fas fa-heart mr-1 text-orange-500"></i><?php echo $project['likes_count']; ?></span>
                                    <span><i class="fas fa-comment mr-1 text-orange-500"></i><?php echo $project['comments_count']; ?></span>
                                    <span><i class="fas fa-eye mr-1 text-orange-500"></i><?php echo $project['views_count']; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-span-full text-center py-8 sm:py-12">
                        <i class="fas fa-search text-4xl sm:text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg sm:text-xl font-semibold text-gray-600 mb-2">No projects found</h3>
                        <p class="text-sm sm:text-base text-gray-500">Try adjusting your filters or search terms</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
            <div class="mt-6 sm:mt-8 flex justify-center px-2">
                <nav class="flex flex-wrap justify-center gap-1 sm:gap-2">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>&filter=<?php echo $filter; ?>&search=<?php echo urlencode($search); ?>" 
                           class="px-3 sm:px-4 py-2 bg-white border rounded-lg hover:bg-gray-50 text-xs sm:text-sm">
                            <i class="fas fa-chevron-left sm:hidden"></i>
                            <span class="hidden sm:inline">Previous</span>
                        </a>
                    <?php endif; ?>
                    
                    <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                        <a href="?page=<?php echo $i; ?>&filter=<?php echo $filter; ?>&search=<?php echo urlencode($search); ?>" 
                           class="px-3 sm:px-4 py-2 <?php echo $i === $page ? 'bg-orange-600 text-white' : 'bg-white hover:bg-gray-50'; ?> border rounded-lg text-xs sm:text-sm font-medium">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                    
                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?php echo $page + 1; ?>&filter=<?php echo $filter; ?>&search=<?php echo urlencode($search); ?>" 
                           class="px-3 sm:px-4 py-2 bg-white border rounded-lg hover:bg-gray-50 text-xs sm:text-sm">
                            <i class="fas fa-chevron-right sm:hidden"></i>
                            <span class="hidden sm:inline">Next</span>
                        </a>
                    <?php endif; ?>
                </nav>
            </div>
            <?php endif; ?>

            <!-- Mobile Events (if logged in) - Below Projects -->
            <?php if ($isLoggedIn): ?>
            <div class="lg:hidden mt-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="font-bold text-base mb-3 flex items-center">
                        <i class="fas fa-calendar-alt text-orange-600 mr-2"></i>
                        Upcoming Events
                    </h3>
                    <div class="text-sm text-gray-600 space-y-3">
                        <?php
                        $mobileEventsQuery = "SELECT * FROM events WHERE event_date >= CURDATE() AND is_active = 1 ORDER BY event_date ASC LIMIT 3";
                        $mobileEvents = mysqli_query($conn, $mobileEventsQuery);
                        if (mysqli_num_rows($mobileEvents) > 0):
                            while ($event = mysqli_fetch_assoc($mobileEvents)):
                        ?>
                        <div class="border-l-4 border-orange-500 pl-3 py-2">
                            <p class="font-semibold text-gray-800 text-sm"><?php echo escape($event['event_name']); ?></p>
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="far fa-calendar mr-1"></i><?php echo formatDate($event['event_date']); ?>
                            </p>
                        </div>
                        <?php 
                            endwhile;
                        else:
                        ?>
                        <p class="text-gray-500 text-sm">No upcoming events at the moment.</p>
                        <?php endif; ?>
                    </div>
                    <a href="events.php" class="block mt-4 text-orange-600 hover:text-orange-700 font-medium text-sm flex items-center">
                        View all events <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
