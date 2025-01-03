//? Add to wishlist
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
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
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
                    console.log("Server Response:", data); // Debugging: Log the server response

                    if (data.status === "success") {
                        if (isInWishlist) {
                            heartIcon.classList.remove("heart-added");
                            this.querySelector(".tooltip").textContent =
                                "Add to Wishlist";
                            showNotification(
                                "Product removed from wishlist.",
                                "notification-success"
                            );
                        } else {
                            heartIcon.classList.add("heart-added");
                            this.querySelector(".tooltip").textContent =
                                "In Wishlist";
                            showNotification(
                                "Product added to wishlist.",
                                "notification-success"
                            );
                        }

                        // Reload the page to reflect changes
                        window.location.reload();
                    } else if (data.status === "info") {
                        showNotification(data.message, "notification-info");
                    } else if (data.status === "error") {
                        showNotification(data.message, "notification-error");
                    }
                })
                .catch((error) => {
                    console.error("Error:", error); // Debugging: Log any errors
                    showNotification(
                        "An error occurred while processing your request.",
                        "notification-error"
                    );
                });
        });
    });
});

//? Remove from wishlist with custom confirmation dialog
document.addEventListener("DOMContentLoaded", () => {
    const removeButtons = document.querySelectorAll(".btn-action--remove");

    removeButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            // Get the form and URL
            const form = this.closest("form");
            const url = form.action;

            // Show the custom confirmation dialog
            const confirmationDialog = document.getElementById(
                "confirmation-dialog"
            );
            const confirmBtn = document.getElementById("confirm-btn");
            const cancelBtn = document.getElementById("cancel-btn");

            confirmationDialog.style.display = "flex";

            // Handle confirm button click
            confirmBtn.addEventListener("click", () => {
                confirmationDialog.style.display = "none";

                fetch(url, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
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
                        console.log("Server Response:", data); // Debugging: Log the server response

                        if (data.status === "success") {
                            showNotification(
                                data.message,
                                "notification-success"
                            );

                            // Reload the page to reflect changes
                            window.location.reload();
                        } else if (data.status === "error") {
                            showNotification(
                                data.message,
                                "notification-error"
                            );
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error); // Debugging: Log any errors
                        showNotification(
                            "An error occurred while processing your request.",
                            "notification-error"
                        );
                    });
            });

            // Handle cancel button click
            cancelBtn.addEventListener("click", () => {
                confirmationDialog.style.display = "none";
            });
        });
    });
});

//? Clear Wishlist with custom confirmation dialog
document.addEventListener("DOMContentLoaded", () => {
    const clearWishlistBtn = document.getElementById("clear-wishlist-btn");
    const clearWishlistForm = document.getElementById("clear-wishlist-form");

    if (clearWishlistBtn && clearWishlistForm) {
        clearWishlistBtn.addEventListener("click", function (e) {
            e.preventDefault();

            // Show the custom confirmation dialog
            const confirmationDialog = document.getElementById(
                "confirmation-dialog"
            );
            const confirmBtn = document.getElementById("confirm-btn");
            const cancelBtn = document.getElementById("cancel-btn");

            confirmationDialog.style.display = "flex";

            // Handle confirm button click
            confirmBtn.addEventListener("click", () => {
                confirmationDialog.style.display = "none";

                // Submit the form
                clearWishlistForm.submit();
            });

            // Handle cancel button click
            cancelBtn.addEventListener("click", () => {
                confirmationDialog.style.display = "none";
            });
        });
    }
});
