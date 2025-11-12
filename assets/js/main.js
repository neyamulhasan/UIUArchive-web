/**
 * Main JavaScript for UIUArchive
 * Lightweight version - Built by UIU Minds
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('UIUArchive - Built by UIU Minds');
    console.log('Initializing components...');
    
    // Only initialize essential components
    initLikeButtons();
    initCommentForms();
    initRecommendButtons();
    
    console.log('Recommend buttons found:', document.querySelectorAll('.recommend-btn').length);
});

/**
 * Prevent Image Blinking - Smooth Image Loading
 */
function initImageLoading() {
    // Select all images except small profile images in cards
    const images = document.querySelectorAll('img:not(.rounded-full)');
    
    images.forEach(img => {
        // Skip if it's a profile image
        if (img.classList.contains('w-8') && img.classList.contains('h-8')) {
            img.style.opacity = '1';
            return;
        }
        
        // If image is already loaded (cached)
        if (img.complete) {
            img.style.opacity = '1';
        } else {
            // Set initial opacity to 0
            img.style.opacity = '0';
            
            // When image loads, fade it in
            img.addEventListener('load', function() {
                this.style.transition = 'opacity 0.2s ease-in';
                this.style.opacity = '1';
            });
            
            // Handle error
            img.addEventListener('error', function() {
                this.style.opacity = '1';
            });
        }
    });
    
    // Profile images - always visible, no transition
    const profileImages = document.querySelectorAll('img.rounded-full');
    profileImages.forEach(img => {
        img.style.opacity = '1';
    });
}

/**
 * Recommend User Button Functionality (AJAX) - Toggle recommend/unrecommend
 */
function initRecommendButtons() {
    const recommendButtons = document.querySelectorAll('.recommend-btn');
    
    recommendButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const userId = this.dataset.userId;
            const buttonText = this.querySelector('span');
            const icon = this.querySelector('i');
            const isRecommended = this.dataset.recommended === '1';
            
            // Send AJAX request
            fetch('recommend_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'user_id=' + userId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Toggle button state
                    if (data.recommended) {
                        // Changed to recommended
                        this.classList.remove('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
                        this.classList.add('bg-yellow-100', 'text-yellow-700', 'hover:bg-yellow-200');
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        buttonText.textContent = 'Recommended';
                        this.dataset.recommended = '1';
                    } else {
                        // Changed to not recommended
                        this.classList.remove('bg-yellow-100', 'text-yellow-700', 'hover:bg-yellow-200');
                        this.classList.add('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        buttonText.textContent = 'Recommend';
                        this.dataset.recommended = '0';
                    }
                    
                    // Update recommendation count in the stats
                    const recCountElement = document.querySelector('.recommendations-count');
                    if (recCountElement) {
                        recCountElement.textContent = data.new_count;
                    }
                    
                    // Animation
                    icon.classList.add('animate-pulse');
                    setTimeout(() => {
                        icon.classList.remove('animate-pulse');
                    }, 500);
                    
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message || 'Failed to update recommendation', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred', 'error');
            });
        });
    });
}

/**
 * Like Button Functionality (AJAX)
 */
function initLikeButtons() {
    const likeButtons = document.querySelectorAll('.like-btn');
    
    likeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const projectId = this.dataset.projectId;
            const icon = this.querySelector('i');
            const countSpan = this.querySelector('.like-count');
            
            // Send AJAX request
            fetch('../ajax/like_project.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ project_id: projectId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Toggle like state
                    if (data.liked) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        this.classList.add('liked');
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        this.classList.remove('liked');
                    }
                    
                    // Update count
                    countSpan.textContent = data.likes_count;
                    
                    // Animation
                    this.classList.add('animate-pulse');
                    setTimeout(() => {
                        this.classList.remove('animate-pulse');
                    }, 500);
                } else {
                    showToast(data.message || 'Please login to like projects', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred', 'error');
            });
        });
    });
}

/**
 * Comment Form Functionality (AJAX)
 */
function initCommentForms() {
    const commentForms = document.querySelectorAll('.comment-form');
    
    commentForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Posting...';
            
            fetch('../ajax/add_comment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add comment to list
                    const commentsList = document.querySelector('.comments-list');
                    const newComment = createCommentElement(data.comment);
                    commentsList.insertAdjacentHTML('afterbegin', newComment);
                    
                    // Clear form
                    this.reset();
                    
                    // Update comment count
                    const countElement = document.querySelector('.comments-count');
                    if (countElement) {
                        countElement.textContent = parseInt(countElement.textContent) + 1;
                    }
                    
                    showToast('Comment added successfully', 'success');
                } else {
                    showToast(data.message || 'Failed to add comment', 'error');
                }
                
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred', 'error');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    });
}

/**
 * Create comment HTML element
 */
function createCommentElement(comment) {
    return `
        <div class="comment border-l-4 border-gray-200 pl-4 mb-4">
            <div class="flex items-start space-x-3">
                <img src="../uploads/profiles/${comment.profile_image}" 
                     alt="${comment.full_name}" 
                     class="w-10 h-10 rounded-full object-cover">
                <div class="flex-1">
                    <div class="bg-gray-100 rounded-lg p-3">
                        <p class="font-semibold text-sm">${comment.full_name}</p>
                        <p class="text-gray-700 mt-1">${comment.comment_text}</p>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Just now</p>
                </div>
            </div>
        </div>
    `;
}

/**
 * File Upload with Drag & Drop
 */
function initFileUpload() {
    const uploadAreas = document.querySelectorAll('.file-upload-area');
    
    uploadAreas.forEach(area => {
        const input = area.querySelector('input[type="file"]');
        
        // Click to upload
        area.addEventListener('click', () => {
            input.click();
        });
        
        // Drag and drop
        area.addEventListener('dragover', (e) => {
            e.preventDefault();
            area.classList.add('dragging');
        });
        
        area.addEventListener('dragleave', () => {
            area.classList.remove('dragging');
        });
        
        area.addEventListener('drop', (e) => {
            e.preventDefault();
            area.classList.remove('dragging');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                input.files = files;
                handleFileSelect(input);
            }
        });
        
        // File input change
        input.addEventListener('change', function() {
            handleFileSelect(this);
        });
    });
}

/**
 * Handle file selection
 */
function handleFileSelect(input) {
    const files = input.files;
    const previewContainer = document.querySelector('.file-preview');
    
    if (previewContainer) {
        previewContainer.innerHTML = '';
        
        Array.from(files).forEach(file => {
            const fileElement = document.createElement('div');
            fileElement.className = 'bg-blue-50 border border-blue-200 rounded p-3 flex items-center justify-between';
            fileElement.innerHTML = `
                <div class="flex items-center space-x-2">
                    <i class="fas fa-file text-blue-600"></i>
                    <span class="text-sm">${file.name}</span>
                    <span class="text-xs text-gray-500">(${formatFileSize(file.size)})</span>
                </div>
                <button type="button" class="text-red-600 hover:text-red-800 remove-file">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            previewContainer.appendChild(fileElement);
        });
    }
}

/**
 * Format file size
 */
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
}

/**
 * Image Preview
 */
function initImagePreview() {
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    
    imageInputs.forEach(input => {
        input.addEventListener('change', function() {
            const file = this.files[0];
            const preview = document.querySelector('.image-preview');
            
            if (file && preview) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="max-w-full h-auto rounded-lg">`;
                };
                
                reader.readAsDataURL(file);
            }
        });
    });
}

/**
 * Show Toast Notification
 */
function showToast(message, type = 'info') {
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        info: 'bg-blue-500',
        warning: 'bg-yellow-500'
    };
    
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        info: 'fa-info-circle',
        warning: 'fa-exclamation-triangle'
    };
    
    const toast = document.createElement('div');
    toast.className = `toast ${colors[type]} text-white flex items-center space-x-3`;
    toast.innerHTML = `
        <i class="fas ${icons[type]}"></i>
        <span>${message}</span>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}

/**
 * Initialize Tooltips
 */
function initTooltips() {
    const tooltips = document.querySelectorAll('[data-tooltip]');
    
    tooltips.forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltipText = this.dataset.tooltip;
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip-popup absolute bg-gray-800 text-white text-xs rounded py-1 px-2 z-50';
            tooltip.textContent = tooltipText;
            tooltip.style.top = (this.offsetTop - 30) + 'px';
            tooltip.style.left = this.offsetLeft + 'px';
            
            this.appendChild(tooltip);
        });
        
        element.addEventListener('mouseleave', function() {
            const tooltip = this.querySelector('.tooltip-popup');
            if (tooltip) {
                tooltip.remove();
            }
        });
    });
}

/**
 * Confirm Delete Action
 */
function confirmDelete(message = 'Are you sure you want to delete this?') {
    return confirm(message);
}

/**
 * Copy to Clipboard
 */
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showToast('Copied to clipboard!', 'success');
    }).catch(err => {
        showToast('Failed to copy', 'error');
    });
}

/**
 * Share Project
 */
function shareProject(projectId, title) {
    const url = window.location.origin + '/pages/project_details.php?id=' + projectId;
    
    if (navigator.share) {
        navigator.share({
            title: title,
            url: url
        }).then(() => {
            showToast('Shared successfully!', 'success');
        }).catch(() => {
            copyToClipboard(url);
        });
    } else {
        copyToClipboard(url);
    }
}

// Slideout animation for toast
const style = document.createElement('style');
style.textContent = `
    @keyframes slideOut {
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
