// script.js
const loadingOverlay = document.getElementById('loadingOverlay');

function showLoading() {
    loadingOverlay.classList.add('show'); // Show loading overlay
}

function hideLoading() {
    loadingOverlay.classList.remove('show'); // Hide loading overlay
}

// Simulate loading time on page load
window.addEventListener('load', () => {
    hideLoading(); // Hide loading overlay after page load
});