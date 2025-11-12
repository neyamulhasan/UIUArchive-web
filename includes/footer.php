    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Support Column - Left Side -->
                <div class="lg:col-span-9">
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-8">
                        <!-- Support Column -->
                        <div>
                            <h4 class="text-gray-900 font-semibold text-sm uppercase tracking-wider mb-4">Support</h4>
                            <ul class="space-y-3">
                                <li><a href="https://www.uiu.ac.bd/" class="text-gray-600 hover:text-gray-900 text-sm transition">Home</a></li>
                                <li><a href="https://www.uiu.ac.bd/contact-us/" class="text-gray-600 hover:text-gray-900 text-sm transition">Help Center</a></li>
                                <li><a href="https://www.uiu.ac.bd/about-uiu/general-information/" class="text-gray-600 hover:text-gray-900 text-sm transition">General Information</a></li>
                                <li><a href="https://www.uiu.ac.bd/research/" class="text-gray-600 hover:text-gray-900 text-sm transition">Research</a></li>
                                <li><a href="https://www.uiu.ac.bd/event/" class="text-gray-600 hover:text-gray-900 text-sm transition">Events</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Logo & Brand Section - Right Side -->
                <div class="lg:col-span-3">
                    <div class="flex space-x-4 mb-6">
                        <a href="#" class="text-gray-700 hover:text-gray-900 transition">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-700 hover:text-gray-900 transition">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-700 hover:text-gray-900 transition">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-700 hover:text-gray-900 transition">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                        <a href="https://github.com/neyamulhasan" target="_blank" class="text-gray-700 hover:text-gray-900 transition">
                            <i class="fab fa-github text-xl"></i>
                        </a>
                    </div>
                    <div class="mb-6">
                        <img src="../assets/images/UIU-Logo.png" alt="UIU Logo" class="h-10 w-auto object-contain mb-4">
                    </div>
                    <p class="text-gray-700 text-sm font-medium leading-relaxed mb-2">
                        United International University
                    </p>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        School of Science and Engineering
                    </p>
                    <a href="https://www.uiu.ac.bd/about-uiu/" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-gray-900 text-sm transition">About</a>
                </div>
            </div>
            
            <!-- Bottom Bar -->
            <div class="border-t border-gray-200 mt-12 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-500 text-sm">
                        &copy; <?php echo date('Y'); ?> UIUArchive. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Custom JavaScript -->
    <script src="../assets/js/main.js"></script>
</body>
</html>
<?php closeConnection(); ?>
