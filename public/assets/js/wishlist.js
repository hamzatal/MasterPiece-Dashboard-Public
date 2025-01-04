// Add to wishlist
document.addEventListener("DOMContentLoaded", () => {
    const wishlistButtons = document.querySelectorAll(".wishlist-button");

    wishlistButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            const form = this.closest("form");
            const url = form.action;
            const heartIcon = this.querySelector(".heart-icon");
            const isInWishlist = heartIcon.classList.contains("heart-added");

            fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify({}),
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.status === "success") {
                        if (isInWishlist) {
                            heartIcon.classList.remove("heart-added");
                            this.querySelector(".tooltip").textContent = "Add to Wishlist";
                            showNotification("Product removed from wishlist.", "notification-success");
                        } else {
                            heartIcon.classList.add("heart-added");
                            this.querySelector(".tooltip").textContent = "In Wishlist";
                            showNotification("Product added to wishlist.", "notification-success");
                        }
                        window.location.reload();
                    } else if (data.status === "info") {
                        showNotification(data.message, "notification-info");
                    } else if (data.status === "error") {
                        showNotification(data.message, "notification-error");
                    }
                })
                .catch((error) => {
                    showNotification("An error occurred while processing your request.", "notification-error");
                });
        });
    });
});

// Remove from wishlist with custom confirmation dialog
document.addEventListener("DOMContentLoaded", () => {
    const removeButtons = document.querySelectorAll(".btn-action--remove");

    removeButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            const form = this.closest("form");
            const url = form.action;

            const confirmationDialog = document.getElementById("confirmation-dialog");
            const confirmBtn = document.getElementById("confirm-btn");
            const cancelBtn = document.getElementById("cancel-btn");

            confirmationDialog.style.display = "flex";

            confirmBtn.addEventListener("click", () => {
                confirmationDialog.style.display = "none";

                fetch(url, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error("Network response was not ok");
                        }
                        return response.json();
                    })
                    .then((data) => {
                        if (data.status === "success") {
                            showNotification(data.message, "notification-success");
                            window.location.reload();
                        } else if (data.status === "error") {
                            showNotification(data.message, "notification-error");
                        }
                    })
                    .catch((error) => {
                        showNotification("An error occurred while processing your request.", "notification-error");
                    });
            });

            cancelBtn.addEventListener("click", () => {
                confirmationDialog.style.display = "none";
            });
        });
    });
});

// Clear Wishlist with custom confirmation dialog
document.addEventListener("DOMContentLoaded", () => {
    const clearWishlistBtn = document.getElementById("clear-wishlist-btn");
    const clearWishlistForm = document.getElementById("clear-wishlist-form");

    if (clearWishlistBtn && clearWishlistForm) {
        clearWishlistBtn.addEventListener("click", function (e) {
            e.preventDefault();

            const confirmationDialog = document.getElementById("confirmation-dialog");
            const confirmBtn = document.getElementById("confirm-btn");
            const cancelBtn = document.getElementById("cancel-btn");

            confirmationDialog.style.display = "flex";

            confirmBtn.addEventListener("click", () => {
                confirmationDialog.style.display = "none";
                clearWishlistForm.submit();
            });

            cancelBtn.addEventListener("click", () => {
                confirmationDialog.style.display = "none";
            });
        });
    }
});
