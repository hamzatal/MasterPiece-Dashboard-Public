document.addEventListener("DOMContentLoaded", () => {
    initializeSearch();
    initializeNavigation();
});

function initializeSearch() {
    const searchInput = document.getElementById("searchInput");
    const searchResults = document.getElementById("searchResults");
    const clearButton = document.querySelector(".nx-search-clear");
    let searchTimeout = null;

    const performSearch = async (query) => {
        if (query.length < 2) {
            hideSearchResults();
            return;
        }

        showLoadingState();

        try {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(async () => {
                const response = await fetch(
                    `/search?q=${encodeURIComponent(query)}`,
                    {
                        method: "GET",
                        headers: {
                            Accept: "application/json",
                        },
                    }
                );

                if (!response.ok) {
                    throw new Error("Failed to fetch search results");
                }

                const result = await response.json();
                updateSearchResults(result);
            }, 300);
        } catch (error) {
            console.error("Search error:", error);
            showErrorState();
        }
    };

    const updateSearchResults = (result) => {
        if (result.status === "success" && result.data.length > 0) {
            const resultHtml = result.data
                .map(
                    (product) => `
                    <a href="/product-details/${
                        product.id
                    }" class="nx-search-result-item">
                        <div class="nx-result-image-wrapper">
                            <img src="/storage/${product.image}" alt="${
                        product.name
                    }" loading="lazy" />
                        </div>
                        <div class="nx-result-content">
                            <strong>${highlightSearchTerm(
                                product.name,
                                searchInput.value
                            )}</strong>
                            <p class="nx-price">JD ${parseFloat(
                                product.price
                            ).toFixed(2)}</p>
                            ${
                                product.category
                                    ? `<span class="nx-category">${product.category}</span>`
                                    : ""
                            }
                        </div>
                    </a>`
                )
                .join("");

            searchResults.innerHTML = `
                <div class="nx-results-header">
                    <span>${result.data.length} results found</span>
                </div>
                <div class="nx-results-container">
                    ${resultHtml}
                </div>`;
        } else {
            showEmptyState();
        }
        searchResults.style.display = "block";
    };

    const highlightSearchTerm = (text, searchTerm) => {
        if (!searchTerm) return text;
        const regex = new RegExp(`(${escapeRegExp(searchTerm)})`, "gi");
        return text.replace(regex, "<mark>$1</mark>");
    };

    const escapeRegExp = (string) => {
        return string.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
    };

    const showLoadingState = () => {
        searchResults.innerHTML = `
            <div class="nx-loading-state">
                <div class="nx-spinner"></div>
                <p>Searching...</p>
            </div>`;
        searchResults.style.display = "block";
    };

    const showEmptyState = () => {
        searchResults.innerHTML = `
            <div class="nx-empty-state">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <p>No results found</p>
            </div>`;
    };

    const showErrorState = () => {
        searchResults.innerHTML = `
            <div class="nx-error-state">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
                <p>An error occurred. Please try again.</p>
            </div>`;
    };

    const hideSearchResults = () => {
        searchResults.style.display = "none";
        searchResults.innerHTML = "";
    };

    // Enhanced event listeners
    searchInput.addEventListener("input", (e) => {
        const query = e.target.value.trim();
        performSearch(query);
        clearButton.style.display = query.length > 0 ? "flex" : "none";
    });

    clearButton.addEventListener("click", () => {
        searchInput.value = "";
        hideSearchResults();
        clearButton.style.display = "none";
        searchInput.focus();
    });

    // Close search results when clicking outside
    document.addEventListener("click", (e) => {
        if (
            !searchResults.contains(e.target) &&
            !searchInput.contains(e.target)
        ) {
            hideSearchResults();
        }
    });

    // Handle keyboard navigation
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            hideSearchResults();
            searchInput.blur();
        }
    });
}

document.addEventListener("DOMContentLoaded", () => {
    const currentPath = window.location.pathname;

    const setActiveNavItem = (path) => {
        document.querySelectorAll(".nx-nav-link, .nx-action-btn, .nx-dropdown-link").forEach((item) => {
            item.classList.remove("nx-active");
        });

        document.querySelectorAll(".nx-nav-link, .nx-action-btn, .nx-dropdown-link").forEach((item) => {
            const href = item.getAttribute("href");
            if (href && path === href) {
                item.classList.add("nx-active");
            }
        });

        if (path.startsWith("/shop")) {
            document.querySelector('a[href="/shop"]')?.classList.add("nx-active");
        }

        if (path.includes("profile") || path.includes("orders")) {
            document.querySelector(".nx-account-dropdown .nx-action-btn")?.classList.add("nx-active");
            document.querySelectorAll(".nx-dropdown-link").forEach((link) => {
                if (link.getAttribute("href") === path) {
                    link.classList.add("nx-active");
                }
            });
        }

        if (path.includes("cart")) {
            document.querySelector('a[href="/cart"]')?.classList.add("nx-active");
        }

        if (path.includes("wishlist")) {
            document.querySelector('a[href="/wishlist"]')?.classList.add("nx-active");
        }
    };

    setActiveNavItem(currentPath);

    document.addEventListener("navigation", (e) => {
        setActiveNavItem(e.detail.path);
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const accountBtn = document.querySelector(".nx-account-dropdown .nx-action-btn");
    const dropdownMenu = document.querySelector(".nx-dropdown-menu");

    accountBtn.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        dropdownMenu.classList.toggle("visible");

        accountBtn.classList.toggle("nx-active", dropdownMenu.classList.contains("visible"));
    });

    document.addEventListener("click", (e) => {
        if (!dropdownMenu.contains(e.target) && !accountBtn.contains(e.target)) {
            dropdownMenu.classList.remove("visible");
            accountBtn.classList.remove("nx-active");
        }
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && dropdownMenu.classList.contains("visible")) {
            dropdownMenu.classList.remove("visible");
            accountBtn.classList.remove("nx-active");
        }
    });

    dropdownMenu.addEventListener("click", (e) => {
        e.stopPropagation();
    });

    const dropdownLinks = dropdownMenu.querySelectorAll(".nx-dropdown-link");
    dropdownLinks.forEach((link) => {
        link.addEventListener("click", () => {
            dropdownMenu.classList.remove("visible");
            accountBtn.classList.remove("nx-active");
        });
    });
});
