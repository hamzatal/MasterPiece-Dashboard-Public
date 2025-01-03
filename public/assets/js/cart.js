class NotificationManager {
    static show(message, type = "info") {
        const notification = document.createElement("div");
        notification.className = `notification notification-${type} notification-slide`;

        notification.innerHTML = `
            <div class="notification-content">
                <span class="notification-message">${message}</span>
                <button class="notification-close">&times;</button>
            </div>
        `;

        document.body.appendChild(notification);

        // Trigger slide-in animation
        setTimeout(() => notification.classList.add("show"), 100);

        // Auto-close after 5 seconds
        setTimeout(() => {
            notification.classList.remove("show");
            setTimeout(() => notification.remove(), 300);
        }, 5000);

        // Close button handler
        notification
            .querySelector(".notification-close")
            .addEventListener("click", () => {
                notification.classList.remove("show");
                setTimeout(() => notification.remove(), 300);
            });
    }
}

class ConfirmationDialog {
    static async show(message) {
        return new Promise((resolve) => {
            const dialog = document.createElement("div");
            dialog.className = "confirmation-dialog";

            dialog.innerHTML = `
                <div class="confirmation-content">
                    <p class="confirmation-message">${message}</p>
                    <div class="confirmation-buttons">
                        <button class="confirm-btn">Confirm</button>
                        <button class="cancel-btn">Cancel</button>
                    </div>
                </div>
            `;

            document.body.appendChild(dialog);

            const handleResponse = (confirmed) => {
                dialog.remove();
                resolve(confirmed);
            };

            dialog
                .querySelector(".confirm-btn")
                .addEventListener("click", () => handleResponse(true));
            dialog
                .querySelector(".cancel-btn")
                .addEventListener("click", () => handleResponse(false));
        });
    }
}

class ShoppingCart {
    constructor() {
        this.initializeElements();
        this.initializeEventListeners();
        this.csrfToken = document.querySelector(
            'meta[name="csrf-token"]'
        )?.content;
        this.debounceTimeout = null;
    }

    initializeElements() {
        this.quantityControls = document.querySelectorAll(".quantity-controls");
        this.couponForm = document.getElementById("coupon-form");
        this.couponInput = document.getElementById("coupon-code");
        this.applyCouponBtn = document.getElementById("apply-coupon");
        this.removeCouponBtn = document.getElementById("remove-coupon");
        this.clearCartBtn = document.getElementById("clear-cart");
    }

    initializeEventListeners() {
        this.setupQuantityControls();
        this.setupCouponControls();
        this.setupRemoveItemButtons();
        this.setupClearCartButton();
    }

    setupQuantityControls() {
        this.quantityControls.forEach((control) => {
            const decreaseBtn = control.querySelector(".quantity-decrease");
            const increaseBtn = control.querySelector(".quantity-increase");
            const input = control.querySelector(".quantity-input");
            const productId = control.closest("tr").dataset.productId;

            decreaseBtn?.addEventListener("click", () =>
                this.handleQuantityChange(input, -1, productId)
            );
            increaseBtn?.addEventListener("click", () =>
                this.handleQuantityChange(input, 1, productId)
            );
            input?.addEventListener("change", (e) =>
                this.handleQuantityInput(e, productId)
            );
        });
    }

    setupCouponControls() {
        this.applyCouponBtn?.addEventListener("click", () =>
            this.handleCouponApplication()
        );
        this.couponInput?.addEventListener("keypress", (e) => {
            if (e.key === "Enter") {
                e.preventDefault();
                this.handleCouponApplication();
            }
        });
        this.removeCouponBtn?.addEventListener("click", (e) =>
            this.handleCouponRemoval(e)
        );
    }

    setupRemoveItemButtons() {
        document.querySelectorAll(".remove-item-btn").forEach((btn) => {
            btn.addEventListener("click", (e) => this.handleItemRemoval(e));
        });
    }

    setupClearCartButton() {
        this.clearCartBtn?.addEventListener("click", () =>
            this.handleClearCart()
        );
    }

    async handleQuantityChange(input, change, productId) {
        const newValue = Math.max(1, parseInt(input.value) + change);
        input.value = newValue;
        this.debounceUpdateCart(productId, newValue);
    }

    handleQuantityInput(event, productId) {
        const newValue = Math.max(1, parseInt(event.target.value) || 1);
        event.target.value = newValue;
        this.debounceUpdateCart(productId, newValue);
    }

    debounceUpdateCart(productId, quantity) {
        clearTimeout(this.debounceTimeout);
        this.debounceTimeout = setTimeout(() => {
            this.updateCart(productId, quantity);
        }, 500);
    }

    async handleCouponApplication() {
        const couponCode = this.couponInput.value.trim();
        if (!couponCode) {
            NotificationManager.show("Please enter a coupon code", "warning");
            return;
        }

        try {
            const response = await this.makeRequest("/cart/apply-coupon", {
                coupon_code: couponCode,
            });
            if (response.success) {
                NotificationManager.show(
                    "Coupon applied successfully!",
                    "success"
                );
                this.couponInput.value = "";
                setTimeout(() => location.reload(), 1000);
            }
        } catch (error) {
            NotificationManager.show(
                error.message || "Failed to apply coupon",
                "error"
            );
        }
    }
    // Add this method to the ShoppingCart class
    async handleCouponRemoval(event) {
        event.preventDefault();
        const confirmed = await ConfirmationDialog.show(
            "Are you sure you want to remove the coupon?"
        );

        if (confirmed) {
            try {
                const response = await this.makeRequest(
                    "/cart/remove-coupon",
                    {},
                    "DELETE"
                );
                if (response.success) {
                    // Update cart totals immediately
                    this.updateCartTotals({
                        subtotal: response.subtotal,
                        discount: 0,
                        total: response.total,
                    });

                    // Remove the applied coupon display
                    const appliedCouponDiv =
                        document.querySelector(".applied-coupon");
                    if (appliedCouponDiv) {
                        appliedCouponDiv.remove();
                    }

                    // Show coupon input form
                    const couponForm = document.createElement("div");
                    couponForm.className = "coupon-form";
                    couponForm.innerHTML = `
                    <input type="text" id="coupon-code" placeholder="Enter coupon code" class="form-control">
                    <button type="button" id="apply-coupon" class="btn btn-primary">Apply Coupon</button>
                `;

                    document
                        .querySelector(".coupon-section")
                        .appendChild(couponForm);

                    // Reinitialize coupon controls
                    this.couponInput = document.getElementById("coupon-code");
                    this.applyCouponBtn =
                        document.getElementById("apply-coupon");
                    this.setupCouponControls();

                    NotificationManager.show(
                        "Coupon removed successfully",
                        "success"
                    );
                }
            } catch (error) {
                NotificationManager.show("Failed to remove coupon", "error");
            }
        }
    }

    async handleItemRemoval(event) {
        event.preventDefault();
        const row = event.target.closest("tr");
        const productId = row.dataset.productId;

        const confirmed = await ConfirmationDialog.show(
            "Are you sure you want to remove this item?"
        );

        if (confirmed) {
            try {
                const response = await this.makeRequest(
                    `/cart/remove/${productId}`,
                    {},
                    "DELETE"
                );
                if (response.success) {
                    row.remove();
                    this.updateUI(response);
                    NotificationManager.show(
                        "Item removed successfully",
                        "success"
                    );
                    this.checkEmptyCart();
                }
            } catch (error) {
                NotificationManager.show("Failed to remove item", "error");
            }
        }
    }

    async handleClearCart() {
        const confirmed = await ConfirmationDialog.show(
            "Are you sure you want to clear your cart?"
        );

        if (confirmed) {
            try {
                const response = await this.makeRequest(
                    "/cart/clear",
                    {},
                    "POST"
                );
                if (response.success) {
                    NotificationManager.show(
                        "Cart cleared successfully",
                        "success"
                    );
                    setTimeout(() => location.reload(), 1000);
                }
            } catch (error) {
                NotificationManager.show("Failed to clear cart", "error");
            }
        }
    }

    async updateCart(productId, quantity) {
        try {
            const response = await this.makeRequest("/cart/update", {
                product_id: productId,
                quantity: quantity,
            });

            if (response.success) {
                this.updateUI(response);
                NotificationManager.show(
                    "Cart updated successfully",
                    "success"
                );
            }
        } catch (error) {
            NotificationManager.show("Failed to update cart", "error");
        }
    }

    async makeRequest(url, data, method = "POST") {
        const response = await fetch(url, {
            method: method,
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": this.csrfToken,
                Accept: "application/json",
            },
            body: JSON.stringify(data),
        });

        if (!response.ok) {
            throw new Error(response.statusText);
        }

        return await response.json();
    }

    updateUI(data) {
        this.updateProductTotals(data);
        this.updateCartTotals(data);
    }

    updateProductTotals(data) {
        if (data.products) {
            data.products.forEach((product) => {
                const row = document.querySelector(
                    `tr[data-product-id="${product.id}"]`
                );
                if (row) {
                    row.querySelector(
                        ".product-total"
                    ).textContent = `JD ${product.total.toFixed(2)}`;
                }
            });
        }
    }

    updateCartTotals(data) {
        const elements = {
            subtotal: document.querySelector(".subtotal-amount"),
            discount: document.querySelector(".discount-amount"),
            total: document.querySelector(".cart-total"),
        };

        if (data.subtotal !== undefined && elements.subtotal) {
            elements.subtotal.textContent = `JD ${data.subtotal.toFixed(2)}`;
        }
        if (data.discount !== undefined && elements.discount) {
            elements.discount.textContent = `JD ${data.discount.toFixed(2)}`;
        }
        if (data.total !== undefined && elements.total) {
            elements.total.textContent = `JD ${data.total.toFixed(2)}`;
        }
    }

    checkEmptyCart() {
        const cartItems = document.querySelectorAll("tr[data-product-id]");
        if (cartItems.length === 0) {
            location.reload();
        }
    }
}

// Initialize cart functionality when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
    new ShoppingCart();

    // Initialize coupon notification
    const couponNotification = document.querySelector(".coupon-notification");
    const closeButton = document.querySelector(".coupon-notification-close");

    if (couponNotification && closeButton) {
        closeButton.addEventListener("click", () => {
            couponNotification.style.display = "none";
        });

        setTimeout(() => {
            couponNotification.style.display = "none";
        }, 10000);
    }
});
