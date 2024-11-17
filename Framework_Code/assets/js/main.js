// This should be in a separate JavaScript file, e.g., functions.js
function callAPI(endpoint, method = 'GET', data = null) {
    let url = `/api/${endpoint}`;
    
    const options = {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    };

    // Handle GET requests with data by appending query parameters to the URL
    if (data && method === 'GET') {
        const queryParams = new URLSearchParams(data).toString();
        url += `?${queryParams}`;
    }

    // Handle POST and PUT requests with data by adding it to the body
    if (data && (method === 'POST' || method === 'PUT')) {
        options.body = JSON.stringify(data);
    }

    return fetch(url, options)
        .then(response => {
            // You can uncomment this if you want to handle non-2xx status codes as errors
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        });
}

document.addEventListener('DOMContentLoaded', function() {
    const mainContent = document.getElementById('main-content');
    const toastContainer = document.getElementById('toast-container');

    // Function to position the toast container
    function positionToastContainer() {
        const rect = mainContent.getBoundingClientRect();
        toastContainer.style.top = `${rect.top}px`;
        toastContainer.style.left = `${rect.left}px`;
        toastContainer.style.width = `${rect.width}px`;
    }

    // Position the toast container initially and on window resize
    positionToastContainer();
    window.addEventListener('resize', positionToastContainer);

    // Toast creation and management
    function createToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast ${type} show`;
        toast.innerHTML = `
            <div class="toast-content">
                ${message}
                <button class="toast-close">&times;</button>
            </div>
        `;

        // Add dismiss functionality
        const closeButton = toast.querySelector('.toast-close');
        closeButton.addEventListener('click', function() {
            removeToast(toast);
        });

        toastContainer.appendChild(toast);

        // Auto-dismiss after 5 seconds
        setTimeout(() => removeToast(toast), 5000);
    }

    function removeToast(toast) {
        toast.classList.add('hiding');
        toast.addEventListener('transitionend', function() {
            toast.remove();
        });
    }

    // Expose these functions globally
    window.showSuccess = function(message) {
        createToast(message, 'success');
    };

    window.showError = function(message) {
        createToast(message, 'error');
    };
});



   
    var currentPage = "<?php echo $currentPage; ?>";
    var userEmail = "<?php echo $_SESSION['email'] ?? ''; ?>";
