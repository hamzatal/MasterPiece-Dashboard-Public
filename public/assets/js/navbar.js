    // Function to perform dynamic search
    function searchProducts() {
        var searchQuery = document.getElementById('searchInput').value;
        if (searchQuery.length >= 3) { // Trigger search only when 3 or more characters are typed
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "/search-api?query=" + encodeURIComponent(searchQuery), true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    // Display search results
                    document.getElementById('searchResults').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        } else {
            document.getElementById('searchResults').innerHTML = ''; // Clear results if search query is too short
        }
    }
    // Function to update cart and wishlist counts
    function updateCounts() {
        fetch('/counts')
            .then(response => response.json())
            .then(data => {
                document.querySelector('.wishlist .badge').textContent = data.wishlistCount;
                document.querySelector('.cart-icon .badge').textContent = data.cartCount;
            })
            .catch(error => console.error('Error fetching counts:', error));
    }

    // Call this function when the page loads or after an action
    updateCounts();

    // Add active class dynamically to navbar links
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.nav-link');
        const currentUrl = window.location.pathname;

        navLinks.forEach(link => {
            const linkUrl = new URL(link.href).pathname; // Extract pathname
            if (currentUrl === linkUrl) {
                navLinks.forEach(link => link.classList.remove('active')); // Remove active from all
                link.classList.add('active'); // Add active to the current link
            }
        });
    });
