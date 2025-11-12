<?php
/**
 * Test Delete Functionality
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Delete</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6">Test Delete Confirmation</h1>
        
        <button onclick="testDelete()" 
                class="flex items-center gap-2 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
            <i class="fas fa-trash"></i>
            <span>Test Delete Modal</span>
        </button>
        
        <div id="result" class="mt-6"></div>
    </div>

    <script>
    function testDelete() {
        console.log('testDelete called');
        
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
            console.log('Result:', result);
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
                
                // Simulate deletion
                setTimeout(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Project has been deleted successfully.',
                        confirmButtonColor: '#059669'
                    });
                }, 2000);
            } else if (result.isDismissed) {
                document.getElementById('result').innerHTML = '<p class="text-green-600">Deletion cancelled!</p>';
            }
        });
    }
    </script>
</body>
</html>
