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
$sort = isset($_GET['sort']) ? sanitizeInput($_GET['sort']) : 'desc';
$yearFrom = isset($_GET['year_from']) ? (int)$_GET['year_from'] : null;
$yearTo = isset($_GET['year_to']) ? (int)$_GET['year_to'] : null;

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 20;
$offset = ($page - 1) * $perPage;

// Build WHERE clause
$whereClause = "p.visibility = 'public'";
$searchQuery = "";
$categoryQuery = "";
$yearQuery = "";

if ($search) {
    $searchTerm = mysqli_real_escape_string($conn, $search);
    $searchQuery = " AND (p.title LIKE '%$searchTerm%' 
                     OR p.description LIKE '%$searchTerm%' 
                     OR u.full_name LIKE '%$searchTerm%'
                     OR p.project_id IN (
                         SELECT DISTINCT pt.project_id 
                         FROM project_tags pt 
                         JOIN tags t ON pt.tag_id = t.tag_id 
                         WHERE t.tag_name LIKE '%$searchTerm%'
                     ))";
}

if ($category) {
    $categoryQuery = " AND p.category = '" . mysqli_real_escape_string($conn, $category) . "'";
}

if ($yearFrom && $yearTo) {
    $yearQuery = " AND YEAR(p.created_at) BETWEEN " . (int)$yearFrom . " AND " . (int)$yearTo;
} elseif ($yearFrom) {
    $yearQuery = " AND YEAR(p.created_at) >= " . (int)$yearFrom;
} elseif ($yearTo) {
    $yearQuery = " AND YEAR(p.created_at) <= " . (int)$yearTo;
}

// Order by clause based on filter
$orderBy = "p.created_at DESC"; // Default: Latest

if ($filter === 'popular') {
    $orderBy = "p.likes_count DESC";
} elseif ($filter === 'oldest') {
    $orderBy = "p.created_at ASC";
} elseif ($filter === 'latest') {
    $orderBy = "p.created_at DESC";
}

// Get projects
$query = "SELECT p.*, u.full_name, u.profile_image,
                 GROUP_CONCAT(t.tag_name ORDER BY t.tag_name ASC SEPARATOR ',') as tags
          FROM projects p
          JOIN users u ON p.user_id = u.user_id
          LEFT JOIN project_tags pt ON p.project_id = pt.project_id
          LEFT JOIN tags t ON pt.tag_id = t.tag_id
          WHERE $whereClause $searchQuery $categoryQuery $yearQuery
          GROUP BY p.project_id
          ORDER BY $orderBy
          LIMIT $perPage OFFSET $offset";

$projects = mysqli_query($conn, $query);

// Get total count
$countQuery = "SELECT COUNT(DISTINCT p.project_id) as total 
               FROM projects p 
               JOIN users u ON p.user_id = u.user_id 
               LEFT JOIN project_tags pt ON p.project_id = pt.project_id
               LEFT JOIN tags t ON pt.tag_id = t.tag_id
               WHERE $whereClause $searchQuery $categoryQuery $yearQuery";
$countResult = mysqli_query($conn, $countQuery);
$totalProjects = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalProjects / $perPage);
?>

<div class="min-h-screen">
    <div class="px-4 py-8">
        <div class="flex">
            <!-- Left Column - Projects List -->
            <div class="flex-1 min-w-0 pr-6">
                <!-- Filter Tabs (Mobile) -->
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-200 overflow-x-auto lg:hidden px-4">
                <a href="index.php?filter=latest" 
                   class="px-5 py-2 rounded-full text-sm font-medium whitespace-nowrap <?php echo $filter === 'latest' ? 'bg-orange-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'; ?>">
                    Latest
                </a>
                <a href="index.php?filter=popular" 
                   class="px-5 py-2 rounded-full text-sm font-medium whitespace-nowrap <?php echo $filter === 'popular' ? 'bg-orange-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'; ?>">
                    Popular
                </a>
                <a href="index.php?filter=oldest" 
                   class="px-5 py-2 rounded-full text-sm font-medium whitespace-nowrap <?php echo $filter === 'oldest' ? 'bg-orange-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'; ?>">
                    Oldest
                </a>
            </div>

            <!-- Active Filters -->
            <?php if ($search || $category || $yearFrom || $yearTo): ?>
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r mx-4 lg:mx-0">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div class="flex items-center gap-2 flex-wrap">
                        <i class="fas fa-filter text-blue-600 text-sm"></i>
                        <span class="text-blue-800 font-medium text-sm">Active filters:</span>
                        <?php if ($search): ?>
                            <span class="px-3 py-1 bg-blue-200 text-blue-800 rounded-full text-xs font-medium">
                                Search: <?php echo escape($search); ?>
                            </span>
                        <?php endif; ?>
                        <?php if ($category): ?>
                            <span class="px-3 py-1 bg-purple-200 text-purple-800 rounded-full text-xs font-medium">
                                #<?php echo escape($category); ?>
                            </span>
                        <?php endif; ?>
                        <?php if ($yearFrom || $yearTo): ?>
                            <span class="px-3 py-1 bg-green-200 text-green-800 rounded-full text-xs font-medium">
                                Year: <?php echo $yearFrom ?: '2000'; ?> - <?php echo $yearTo ?: date('Y'); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <a href="index.php" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        <i class="fas fa-times mr-1"></i>Clear
                    </a>
                </div>
            </div>
            <?php endif; ?>

            <!-- Projects Section -->
            <div class="mb-8 px-4 lg:px-0">
                <h2 class="text-sm font-normal text-gray-500 uppercase tracking-wide">Projects</h2>
            </div>

            <!-- Projects List -->
            <div class="space-y-0">
        <?php if ($projects && mysqli_num_rows($projects) > 0): ?>
            <?php while ($project = mysqli_fetch_assoc($projects)): ?>
                <article class="border-b border-gray-200 hover:bg-gray-200 transition-colors px-4 lg:px-0">
                    <div class="py-8">
                        <div class="flex gap-6">
                            <!-- Thumbnail -->
                            <a href="project_details.php?id=<?php echo $project['project_id']; ?>" class="flex-shrink-0">
                                <div class="w-40 h-40 bg-gradient-to-br from-orange-400 to-orange-600 overflow-hidden">
                                    <?php if ($project['thumbnail']): ?>
                                        <img src="<?php echo BASE_URL; ?>/uploads/projects/<?php echo $project['thumbnail']; ?>" 
                                             alt="<?php echo escape($project['title']); ?>"
                                             class="w-full h-full object-cover"
                                             loading="eager"
                                             style="opacity: 1 !important; display: block; transition: none;"
                                             onerror="this.style.display='none';this.parentElement.innerHTML='<div class=\'flex items-center justify-center h-full text-white text-2xl\'><i class=\'fas fa-project-diagram\'></i></div>';">
                                    <?php else: ?>
                                        <div class="flex items-center justify-center h-full text-white text-3xl">
                                            <i class="fas fa-project-diagram"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </a>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <!-- Label -->
                                <div class="text-sm text-gray-500 mb-2">Project</div>
                                
                                <!-- Title -->
                                <a href="project_details.php?id=<?php echo $project['project_id']; ?>">
                                    <h3 class="font-bold text-2xl text-gray-900 hover:text-orange-600 mb-3 line-clamp-1 leading-tight">
                                        <?php echo escape($project['title']); ?>
                                    </h3>
                                </a>
                                
                                <!-- Description -->
                                <p class="text-gray-600 text-base mb-4 line-clamp-2 leading-relaxed">
                                    <?php echo escape(substr($project['description'], 0, 250)); ?>
                                </p>
                                
                                <!-- Meta Info -->
                                <div class="flex items-center flex-wrap gap-2 text-sm text-gray-500">
                                    <span class="text-gray-500 font-normal">in</span>
                                    <a href="profile.php?id=<?php echo $project['user_id']; ?>" 
                                       class="text-gray-600 hover:text-orange-600 font-normal">
                                        <?php echo escape($project['full_name']); ?>
                                    </a>
                                    <span class="text-gray-400">•</span>
                                    <span class="text-gray-500"><?php echo escape($project['category']); ?></span>
                                </div>
                                
                                <!-- Tags -->
                                <?php if (!empty($project['tags'])): ?>
                                <div class="flex flex-wrap gap-2 mt-3">
                                    <?php 
                                    $tags = explode(',', $project['tags']);
                                    foreach ($tags as $tag): 
                                    ?>
                                        <span class="text-xs text-gray-500">
                                            #<?php echo trim(escape($tag)); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else: ?>
            <!-- No Projects -->
            <div class="rounded-lg p-16 text-center">
                <i class="fas fa-inbox text-7xl text-gray-300 mb-6"></i>
                <h3 class="text-2xl font-bold text-gray-800 mb-3 tracking-tight">No projects found</h3>
                <p class="text-gray-600 text-base mb-8">Try adjusting your filters or search terms</p>
                <a href="index.php" class="inline-flex items-center px-8 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-semibold text-base">
                    <i class="fas fa-refresh mr-2"></i>
                    Reset Filters
                </a>
            </div>
        <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
            <div class="mt-8 flex justify-center">
                <nav class="flex items-center gap-1">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>&filter=<?php echo $filter; ?>&search=<?php echo urlencode($search); ?>&category=<?php echo urlencode($category); ?>&year_from=<?php echo $yearFrom; ?>&year_to=<?php echo $yearTo; ?>" 
                           class="px-3 py-2 bg-gray-200 border border-gray-300 rounded hover:bg-gray-300 text-sm">
                            <i class="fas fa-chevron-left text-xs"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                        <a href="?page=<?php echo $i; ?>&filter=<?php echo $filter; ?>&search=<?php echo urlencode($search); ?>&category=<?php echo urlencode($category); ?>&year_from=<?php echo $yearFrom; ?>&year_to=<?php echo $yearTo; ?>" 
                           class="px-4 py-2 rounded text-sm font-medium <?php echo $i === $page ? 'bg-orange-600 text-white' : 'bg-gray-200 border border-gray-300 text-gray-700 hover:bg-gray-300'; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                    
                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?php echo $page + 1; ?>&filter=<?php echo $filter; ?>&search=<?php echo urlencode($search); ?>&category=<?php echo urlencode($category); ?>&year_from=<?php echo $yearFrom; ?>&year_to=<?php echo $yearTo; ?>" 
                           class="px-3 py-2 bg-gray-200 border border-gray-300 rounded hover:bg-gray-300 text-sm">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    <?php endif; ?>
                </nav>
            </div>
            <?php endif; ?>
        </div>

        <!-- Right Sidebar - Filters -->
        <aside class="hidden lg:block w-80 flex-shrink-0 border-l border-gray-200 pl-6 pt-6">
            <div class="sticky top-20">
                <!-- Show Section -->
                <div class="mb-8">
                    <h4 class="text-sm font-normal text-gray-500 uppercase tracking-wide mb-4">Show:</h4>
                    <div class="space-y-1">
                        <a href="index.php?filter=latest" 
                           class="block text-sm text-gray-700 hover:text-orange-600 py-1 <?php echo $filter === 'latest' ? 'font-semibold' : ''; ?>">
                            <i class="fas fa-clock w-4"></i> Latest
                        </a>
                        <a href="index.php?filter=popular" 
                           class="block text-sm text-gray-700 hover:text-orange-600 py-1 <?php echo $filter === 'popular' ? 'font-semibold' : ''; ?>">
                            <i class="fas fa-heart w-4"></i> Popular
                        </a>
                        <a href="index.php?filter=oldest" 
                           class="block text-sm text-gray-700 hover:text-orange-600 py-1 <?php echo $filter === 'oldest' ? 'font-semibold' : ''; ?>">
                            <i class="fas fa-history w-4"></i> Oldest
                        </a>
                    </div>
                </div>

                <!-- Filter by -->
                <div class="mb-8">
                    <h4 class="text-sm font-normal text-gray-500 uppercase tracking-wide mb-4">Filter by:</h4>
                    
                    <!-- Year -->
                    <form method="GET" action="index.php" class="mb-4">
                        <input type="hidden" name="filter" value="<?php echo escape($filter); ?>">
                        <?php if ($search): ?>
                            <input type="hidden" name="search" value="<?php echo escape($search); ?>">
                        <?php endif; ?>
                        <?php if ($category): ?>
                            <input type="hidden" name="category" value="<?php echo escape($category); ?>">
                        <?php endif; ?>
                        
                        <label class="text-sm text-gray-700 block mb-2">Year</label>
                        <div class="flex items-center gap-2">
                            <select name="year_from" class="text-sm border-gray-300 rounded px-2 py-1 text-gray-700">
                                <option value="">From</option>
                                <?php 
                                // Show only key years to make list shorter
                                $keyYears = [2000, 2005, 2010, 2015, 2020, 2021, 2022, 2023, 2024, 2025];
                                foreach ($keyYears as $y): ?>
                                    <option value="<?php echo $y; ?>" <?php echo ($yearFrom == $y) ? 'selected' : ''; ?>>
                                        <?php echo $y; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="text-gray-500">to</span>
                            <select name="year_to" class="text-sm border-gray-300 rounded px-2 py-1 text-gray-700">
                                <option value="">To</option>
                                <?php 
                                // Show only key years to make list shorter
                                foreach ($keyYears as $y): ?>
                                    <option value="<?php echo $y; ?>" <?php echo ($yearTo == $y) ? 'selected' : ''; ?>>
                                        <?php echo $y; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="mt-2 text-sm text-gray-600 hover:text-orange-600">
                            Apply
                        </button>
                    </form>
                </div>

                <!-- Tags (Combined Categories and Tags) -->
                <div>
                    <h4 class="text-sm font-normal text-gray-500 uppercase tracking-wide mb-4">Related to:</h4>
                    <div class="flex flex-wrap gap-2">
                        <?php
                        // Get categories as tags
                        $categoriesQuery = "SELECT category as tag_name, COUNT(*) as usage_count, 'category' as type
                                         FROM projects 
                                         WHERE visibility = 'public' AND category IS NOT NULL AND category != ''
                                         GROUP BY category";
                        
                        // Get actual tags (including unused ones)
                        $tagsQuery = "SELECT t.tag_name, t.usage_count, 'tag' as type
                                     FROM tags t 
                                     LEFT JOIN project_tags pt ON t.tag_id = pt.tag_id 
                                     LEFT JOIN projects p ON pt.project_id = p.project_id AND p.visibility = 'public'
                                     GROUP BY t.tag_id, t.tag_name, t.usage_count";
                        
                        // Combine both queries
                        $combinedQuery = "($categoriesQuery) UNION ($tagsQuery) ORDER BY usage_count DESC, tag_name ASC";
                        $allTagsResult = mysqli_query($conn, $combinedQuery);
                        
                        if ($allTagsResult && mysqli_num_rows($allTagsResult) > 0): ?>
                            <?php while ($tag = mysqli_fetch_assoc($allTagsResult)): ?>
                                <a href="index.php?search=<?php echo urlencode($tag['tag_name']); ?>" 
                                   class="inline-block bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-600 px-3 py-1 rounded-full text-sm transition-colors">
                                    #<?php echo escape($tag['tag_name']); ?>
                                    <span class="text-xs text-gray-400 ml-1"><?php echo $tag['usage_count']; ?></span>
                                </a>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-sm text-gray-500">No tags available</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>

<?php 
// Ensure no PHP errors prevent footer
if (file_exists('../includes/footer.php')) {
    require_once '../includes/footer.php'; 
} else {
    echo "<!-- Footer file not found -->";
    echo "<footer class='bg-gray-800 text-white p-4 mt-8'><div class='text-center'>© 2024 UIU Archive</div></footer>";
}
?>
