    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- About Section -->
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-2xl font-bold mb-4">UIUArchive</h3>
                    <p class="text-gray-400 mb-4">
                        A platform for United International University students to showcase their academic, 
                        creative, and technical projects. Built by UIU Minds.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-facebook text-2xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-twitter text-2xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-instagram text-2xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-github text-2xl"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="index.php?filter=trending" class="text-gray-400 hover:text-white transition">Trending</a></li>
                        <li><a href="index.php?filter=featured" class="text-gray-400 hover:text-white transition">Featured</a></li>
                        <li><a href="events.php" class="text-gray-400 hover:text-white transition">Events</a></li>
                        <li><a href="about.php" class="text-gray-400 hover:text-white transition">About Us</a></li>
                    </ul>
                </div>
                
                <!-- Categories -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Categories</h4>
                    <ul class="space-y-2">
                        <li><a href="index.php?category=WebApp" class="text-gray-400 hover:text-white transition">Web Apps</a></li>
                        <li><a href="index.php?category=AI" class="text-gray-400 hover:text-white transition">AI & ML</a></li>
                        <li><a href="index.php?category=IoT" class="text-gray-400 hover:text-white transition">IoT</a></li>
                        <li><a href="index.php?category=Design" class="text-gray-400 hover:text-white transition">Design</a></li>
                        <li><a href="index.php?category=Research" class="text-gray-400 hover:text-white transition">Research</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400">
                    &copy; <?php echo date('Y'); ?> UIUArchive. All rights reserved. 
                    <span class="mx-2">|</span>
                    <a href="privacy.php" class="hover:text-white transition">Privacy Policy</a>
                    <span class="mx-2">|</span>
                    <a href="terms.php" class="hover:text-white transition">Terms of Service</a>
                </p>
                <p class="text-gray-500 mt-3 text-sm">
                    <a href="https://github.com/neyamulhasan" target="_blank" rel="noopener noreferrer" 
                       class="text-orange-500 hover:text-orange-400 transition inline-flex items-center">
                        <i class="fab fa-github mr-1"></i>neyamulhasan
                    </a>
                </p>
            </div>
        </div>
    </footer>
    
    <!-- Custom JavaScript -->
    <script src="../assets/js/main.js"></script>
</body>
</html>
<?php closeConnection(); ?>
