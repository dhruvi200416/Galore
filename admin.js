// Sidebar toggle (mobile)
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('show'); // Changed from 'active' to 'show'
}

document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar');
    const menuBtn = document.querySelector('.menu-btn'); // Changed from '.menu-toggle' to '.menu-btn'
    
    if (window.innerWidth <= 992) {
        if (sidebar && !sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
            sidebar.classList.remove('show'); // Changed from 'active' to 'show'
        }
    }
});

// Optional: Close sidebar when clicking on a nav link (for better UX)
document.querySelectorAll('.sidebar a, .dropdown-toggle, .dropdown-menu-custom a').forEach(item => {
    item.addEventListener('click', function() {
        if (window.innerWidth <= 992) {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.remove('show');
        }
    });
});

// Handle window resize - hide sidebar on desktop
window.addEventListener('resize', function() {
    const sidebar = document.getElementById('sidebar');
    if (window.innerWidth > 992) {
        sidebar.classList.remove('show');
    }
});