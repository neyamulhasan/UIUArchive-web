<?php
/**
 * Header Component
 * UIUArchive - Built by UIU Minds
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

$currentPage = basename($_SERVER['PHP_SELF']);
$isLoggedIn = isLoggedIn();
$currentUserId = getCurrentUserId();

// Check if user needs to complete profile setup
if ($isLoggedIn && $currentPage !== 'setup_profile.php' && $currentPage !== 'logout.php') {
    $stmt = mysqli_prepare($conn, "SELECT department FROM users WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $currentUserId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $userCheck = mysqli_fetch_assoc($result);
    
    if (empty($userCheck['department'])) {
        header('Location: setup_profile.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="no-referrer-when-downgrade">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>UIUArchive</title>
    <meta name="description" content="UIUArchive - A platform for UIU students to showcase their projects">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        orange: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            500: '#d97706',  // Darker, more muted orange
                            600: '#c2410c',  // Professional dark orange
                            700: '#9a3412',  // Very dark orange
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- SweetAlert2 for beautiful alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js for interactive components -->
    <!-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> -->
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../assets/images/favicon.png">
</head>
<body style="background-color: #ebeff2ff;">
    <!-- Navigation -->
    <nav class="bg-gray-800 shadow-lg sticky top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo and Brand -->
                <div class="flex items-center">
                                        <a href="<?php echo BASE_URL; ?>/pages/" class="flex items-center space-x-2">
                        <span class="text-2xl font-bold text-orange-600">UIUArchive</span>
                    </a>
                </div>
                
                <!-- Search Bar (Desktop) -->
                <div class="hidden md:flex items-center flex-1 max-w-lg mx-8">
                    <form action="index.php" method="GET" class="w-full">
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   placeholder="Search projects, tags, or students..." 
                                   class="w-full px-4 py-2 pr-10 bg-gray-700 border border-gray-600 text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-600"
                                   value="<?php echo isset($_GET['search']) ? escape($_GET['search']) : ''; ?>">
                            <button type="submit" class="absolute right-2 top-2 text-gray-400 hover:text-orange-600">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Navigation Links -->
                <div class="flex items-center space-x-4">
                    <?php if ($isLoggedIn): ?>
                        <!-- Upload Project -->
                        <a href="upload_project.php" class="hidden sm:flex items-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-semibold">
                            <i class="fas fa-plus mr-2"></i>
                            <span>Upload</span>
                        </a>
                        
                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <button onclick="toggleDropdown()" class="flex items-center space-x-2 focus:outline-none">
                                <?php 
                                    // Use session profile image directly
                                    $profileImage = $_SESSION['profile_image'] ?? null;
                                    $fullName = $_SESSION['full_name'] ?? 'User';
                                    
                                    // If profile image is a Google URL, use it directly and resize
                                    if (!empty($profileImage) && (strpos($profileImage, 'http://') === 0 || strpos($profileImage, 'https://') === 0)) {
                                        // Replace Google image size parameter (26px for header)
                                        $imgSrc = preg_replace('/=s\d+-c$/', '=s26-c', $profileImage);
                                    } else {
                                        // Generate initials avatar
                                        $imgSrc = getProfileImageUrl($profileImage, $fullName);
                                    }
                                ?>
                                <img src="<?php echo htmlspecialchars($imgSrc); ?>" 
                                     alt="Profile" 
                                     referrerpolicy="no-referrer"
                                     class="h-8 w-8 rounded-full object-cover border-2 border-orange-600"
                                     onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($fullName); ?>&background=c2410c&color=fff&size=32';">
                                <i class="fas fa-chevron-down text-gray-300"></i>
                            </button>
                            
                            <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                                <a href="profile.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i>My Profile
                                </a>
                                <a href="my_projects.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                    <i class="fas fa-folder mr-2"></i>My Projects
                                </a>
                                <hr class="my-2">
                                <a href="logout.php" class="block px-4 py-2 text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </a>
                            </div>
                        </div>
                        <script>
                        function toggleDropdown() {
                            document.getElementById('profileDropdown').classList.toggle('hidden');
                        }
                        // Close dropdown when clicking outside
                        document.addEventListener('click', function(event) {
                            const dropdown = document.getElementById('profileDropdown');
                            const button = event.target.closest('button');
                            if (dropdown && !dropdown.contains(event.target) && !button) {
                                dropdown.classList.add('hidden');
                            }
                        });
                        </script>
                    <?php else: ?>
                        <!-- Google Sign-In -->
                        <a href="login.php" class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition inline-flex items-center font-semibold">
                            <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            Sign in with Google
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Mobile Search Bar -->
        <div class="md:hidden px-4 pb-3">
            <form action="index.php" method="GET">
                <input type="text" 
                       name="search" 
                       placeholder="Search projects..." 
                       class="w-full px-4 py-2 bg-gray-700 border border-gray-600 text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-600">
            </form>
        </div>
    </nav>
    
    <!-- Flash Messages -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '<?php echo addslashes($_SESSION['success_message']); ?>',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
        </script>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error_message'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '<?php echo addslashes($_SESSION['error_message']); ?>',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true
                });
            });
        </script>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
    
    <!-- Main Content -->
    <main class="min-h-screen">
