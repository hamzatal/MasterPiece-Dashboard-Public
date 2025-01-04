document.addEventListener("DOMContentLoaded", function () {
    // Search functionality
    const searchInput = document.querySelector(".product__view--search__input");
    const searchResults = document.createElement("div");
    searchResults.className =
        "search-results absolute w-full bg-white shadow-lg rounded-b border mt-1 max-h-96 overflow-y-auto z-50";
    searchInput.parentElement.appendChild(searchResults);

    let debounceTimer;

    // Handle search input with debounce
    searchInput.addEventListener("input", function () {
        clearTimeout(debounceTimer);
        const searchTerm = this.value;

        // Hide results if search term is too short
        if (searchTerm.length < 2) {
            searchResults.innerHTML = "";
            searchResults.style.display = "none";
            return;
        }

        // Fetch search results after 300ms delay
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

                    // Display error message if any
                    if (data.status === "error") {
                        searchResults.innerHTML = `<div class="p-4 text-gray-500">${data.message}</div>`;
                        searchResults.style.display = "block";
                        return;
                    }

                    const { products, categories } = data.data;

                    // Display "No results found" if no data
                    if (products.length === 0 && categories.length === 0) {
                        searchResults.innerHTML =
                            '<div class="p-4 text-gray-500">No results found</div>';
                        searchResults.style.display = "block";
                        return;
                    }

                    // Display categories
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

                    // Display products
                    if (products.length > 0) {
                        searchResults.innerHTML += `<div class="p-4 text-gray-700 font-bold">Products</div>`;
                        products.forEach((product) => {
                            const productElement = document.createElement("a");
                            productElement.href = `/product-details/${product.id}`;
                            productElement.className =
                                "flex items-center p-4 hover:bg-gray-100 border-b last:border-b-0";
                            productElement.innerHTML = `
                                <div class="flex items-center space-x-4">
                                    <img src="/storage/${product.image}" alt="${
                                product.name
                            }" class="w-12 h-12 object-cover rounded">
                                    <div>
                                        <div class="font-medium">${
                                            product.name
                                        }</div>
                                        <div class="text-sm text-gray-600">JD ${parseFloat(
                                            product.price
                                        ).toFixed(2)}</div>
                                    </div>
                                </div>
                            `;
                            searchResults.appendChild(productElement);
                        });
                    }

                    searchResults.style.display = "block";
                })
                .catch((error) => {
                    // Display error message if fetch fails
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

    // Add to Cart functionality
    document.querySelectorAll(".cart-button").forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            const form = this.closest("form");
            const url = form.action;
            const formData = new FormData(form);

            fetch(url, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "success") {
                        // Show success notification
                        showSuccessMessage(data.message);

                        // Update cart count
                        const cartCountElement =
                            document.querySelector(".cart-count");
                        if (cartCountElement) {
                            cartCountElement.textContent = data.cart_count;
                        }

                        // Reload the page after 1 second
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        });
    });

    // Wishlist functionality
    document.querySelectorAll(".wishlist-button").forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            const form = this.closest("form");
            const url = form.action;
            const heartIcon = this.querySelector(".heart-icon");

            fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({}),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "success") {
                        heartIcon.classList.add("heart-added");
                        this.querySelector(".tooltip").textContent =
                            "In Wishlist";

                        // Show success notification
                        showSuccessMessage(data.message);
                    }
                })
                .catch((error) => console.error("Error:", error));
        });
    });

    // Function to show success notification
    function showSuccessMessage(message) {
        const successMessage = document.createElement("div");
        successMessage.className = "success-notification";
        successMessage.textContent = message;
        document.body.appendChild(successMessage);

        // Hide the message after 3 seconds
        setTimeout(() => {
            successMessage.remove();
        }, 3000);
    }
});

// Image loading enhancement
document.querySelectorAll(".sp-image").forEach((img) => {
    img.addEventListener("load", function () {
        this.classList.add("loaded");
    });

    // Add loading animation if image takes time to load
    if (!img.complete) {
        img.closest(".sp-card").classList.add("loading");
    }
});

// Lazy loading images
if ("IntersectionObserver" in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove("lazy");
                observer.unobserve(img);
            }
        });
    });

    document.querySelectorAll(".sp-image[data-src]").forEach((img) => {
        imageObserver.observe(img);
    });
}



// Add required styles for animations
const style = document.createElement("style");
style.textContent = `
    .success-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #2ecc71;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        z-index: 1000;
        animation: slideIn 0.5s ease, fadeOut 0.5s ease 2.5s;
    }

    @keyframes slideIn {
        from { transform: translateX(100%); }
        to { transform: translateX(0); }
    }

    @keyframes fadeOut {
        to { opacity: 0; }
    }
`;
document.head.appendChild(style);
