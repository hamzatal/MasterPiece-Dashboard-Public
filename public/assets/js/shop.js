document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.querySelector(".product__view--search__input");
    const searchResults = document.createElement("div");
    searchResults.className =
        "search-results absolute w-full bg-white shadow-lg rounded-b border mt-1 max-h-96 overflow-y-auto z-50";
    searchInput.parentElement.appendChild(searchResults);

    let debounceTimer;

    searchInput.addEventListener("input", function () {
        clearTimeout(debounceTimer);
        const searchTerm = this.value;

        if (searchTerm.length < 2) {
            searchResults.innerHTML = "";
            searchResults.style.display = "none";
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`/search-products?q=${encodeURIComponent(searchTerm)}`)
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then((data) => {
                    searchResults.innerHTML = "";

                    if (data.status === "error") {
                        searchResults.innerHTML = `<div class="p-4 text-gray-500">${data.message}</div>`;
                        searchResults.style.display = "block";
                        return;
                    }

                    const { products, categories } = data.data;

                    if (products.length === 0 && categories.length === 0) {
                        searchResults.innerHTML =
                            '<div class="p-4 text-gray-500">No results found</div>';
                        searchResults.style.display = "block";
                        return;
                    }

                    if (categories.length > 0) {
                        searchResults.innerHTML += `<div class="p-4 text-gray-700 font-bold">Categories</div>`;
                        categories.forEach((category) => {
                            const categoryElement = document.createElement("a");
                            categoryElement.href = `/category/${category.id}`;
                            categoryElement.className =
                                "flex items-center p-4 hover:bg-gray-100 border-b last:border-b-0";
                            categoryElement.innerHTML = `
                                <div class="flex items-center space-x-4">
                                    <img src="/storage/${category.image}" alt="${category.name}" class="w-12 h-12 object-cover rounded">
                                    <div>
                                        <div class="font-medium">${category.name}</div>
                                    </div>
                                </div>
                            `;
                            searchResults.appendChild(categoryElement);
                        });
                    }

                    if (products.length > 0) {
                        searchResults.innerHTML += `<div class="p-4 text-gray-700 font-bold">Products</div>`;
                        products.forEach((product) => {
                            const productElement = document.createElement("a");
                            productElement.href = `/product-details/${product.id}`;
                            productElement.className =
                                "flex items-center p-4 hover:bg-gray-100 border-b last:border-b-0";
                            productElement.innerHTML = `
                                <div class="flex items-center space-x-4">
                                    <img src="/storage/${product.image}" alt="${product.name}" class="w-12 h-12 object-cover rounded">
                                    <div>
                                        <div class="font-medium">${product.name}</div>
                                        <div class="text-sm text-gray-600">JD ${parseFloat(product.price).toFixed(2)}</div>
                                    </div>
                                </div>
                            `;
                            searchResults.appendChild(productElement);
                        });
                    }

                    searchResults.style.display = "block";
                })
                .catch((error) => {
                    console.error("Error:", error);
                    searchResults.innerHTML =
                        '<div class="p-4 text-red-500">An error occurred while searching</div>';
                    searchResults.style.display = "block";
                });
        }, 300); // Debounce delay of 300ms
    });

    // Close search results when clicking outside
    document.addEventListener("click", function (e) {
        if (
            !searchInput.contains(e.target) &&
            !searchResults.contains(e.target)
        ) {
            searchResults.style.display = "none";
        }
    });
});



// Add to Cart Button Animation
document.querySelectorAll('.cart-button').forEach(button => {
    button.addEventListener('click', function(e) {
        // Don't prevent form submission, just add animation
        const buttonContent = this.querySelector('.button-content');
        const buttonFeedback = this.querySelector('.button-feedback');

        // Slide out content
        buttonContent.style.transform = 'translateY(-100%)';
        // Slide in feedback
        buttonFeedback.style.transform = 'translateY(0)';

        // Reset after animation (and form submission)
        setTimeout(() => {
            buttonContent.style.transform = '';
            buttonFeedback.style.transform = '';
        }, 2000);
    });
});

// Wishlist Button Animation
document.querySelectorAll('.wishlist-button').forEach(button => {
    button.addEventListener('click', function(e) {
        // Add pop animation
        this.style.transform = 'scale(0.8)';
        setTimeout(() => {
            this.style.transform = '';
        }, 150);
    });
});

// Details Button Ripple Effect
document.querySelectorAll('.details-button').forEach(button => {
    button.addEventListener('click', function(e) {
        const rect = this.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const ripple = document.createElement('span');
        ripple.style.cssText = `
            position: absolute;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 50%;
            pointer-events: none;
            width: 100px;
            height: 100px;
            left: ${x - 50}px;
            top: ${y - 50}px;
            transform: scale(0);
            animation: ripple 0.6s linear;
        `;

        this.appendChild(ripple);

        setTimeout(() => ripple.remove(), 600);
    });
});

// Add necessary keyframes to the stylesheet
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);



// Image Loading Enhancement
document.querySelectorAll('.sp-image').forEach(img => {
    img.addEventListener('load', function() {
        this.classList.add('loaded');
    });

    // Add loading animation if image takes time to load
    if (!img.complete) {
        img.closest('.sp-card').classList.add('loading');
    }
});

// Smooth Scroll to Top after Pagination Click
document.querySelectorAll('.pagination .page-link').forEach(link => {
    link.addEventListener('click', function(e) {
        // Don't prevent default navigation
        setTimeout(() => {
            window.scrollTo({
                top: document.querySelector('.shop__product--wrapper').offsetTop - 100,
                behavior: 'smooth'
            });
        }, 100);
    });
});

// Lazy Loading Images
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                observer.unobserve(img);
            }
        });
    });

    document.querySelectorAll('.sp-image[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// Price Animation on Load
document.querySelectorAll('.sp-current-price').forEach(price => {
    price.style.opacity = '0';
    price.style.transform = 'translateY(10px)';

    setTimeout(() => {
        price.style.transition = 'all 0.5s ease';
        price.style.opacity = '1';
        price.style.transform = 'translateY(0)';
    }, 300);
});

// Category Tag Hover Effect
document.querySelectorAll('.sp-category').forEach(category => {
    category.addEventListener('mouseenter', function() {
        this.style.transform = 'scale(1.05)';
    });

    category.addEventListener('mouseleave', function() {
        this.style.transform = 'scale(1)';
    });
});

// Add to Cart Success Feedback
document.querySelectorAll('.action-button').forEach(button => {
    button.addEventListener('click', function() {
        const feedback = document.createElement('div');
        feedback.className = 'cart-feedback';
        feedback.textContent = 'Added to Cart!';

        this.appendChild(feedback);
        setTimeout(() => feedback.remove(), 2000);
    });
});

// Add Required Styles for Animations
const style = document.createElement('style');
style.textContent = `
    .sp-image.loaded {
        animation: fadeIn 0.5s ease;
    }

    .cart-feedback {
        position: absolute;
        top: -30px;
        left: 50%;
        transform: translateX(-50%);
        background: #2ecc71;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        animation: slideUp 0.3s ease, fadeOut 0.3s ease 1.7s;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { transform: translate(-50%, 10px); opacity: 0; }
        to { transform: translate(-50%, 0); opacity: 1; }
    }

    @keyframes fadeOut {
        to { opacity: 0; }
    }
`;
document.head.appendChild(style);




document.addEventListener("DOMContentLoaded", () => {
    const wishlistButtons = document.querySelectorAll(".wishlist-button");

    wishlistButtons.forEach(button => {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            const form = this.closest("form");
            const url = form.action;
            const heartIcon = this.querySelector(".heart-icon");

            fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({}),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        heartIcon.classList.add("heart-added");
                        this.querySelector(".tooltip").textContent = "In Wishlist";
                    } else if (data.status === "info") {
                        alert(data.message);
                    }
                })
                .catch(error => console.error("Error:", error));
        });
    });
});
