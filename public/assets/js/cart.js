// public/js/cart.js
class ShoppingCart {
    constructor() {
        this.quantityControls = document.querySelectorAll(".quantity-controls");
        this.couponForm = document.getElementById("coupon-form");
        this.couponInput = document.getElementById("coupon-code");
        this.applyCouponBtn = document.getElementById("apply-coupon");
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        this.debounceTimeout = null;
        this.initializeEventListeners();
    }

    initializeEventListeners() {
        // Initialize quantity controls
        this.quantityControls.forEach(control => {
            const decreaseBtn = control.querySelector(".quantity-decrease");
            const increaseBtn = control.querySelector(".quantity-increase");
            const input = control.querySelector(".quantity-input");
            const productId = control.closest("tr").dataset.productId;

            decreaseBtn?.addEventListener("click", () => this.handleQuantityChange(input, -1, productId));
            increaseBtn?.addEventListener("click", () => this.handleQuantityChange(input, 1, productId));
            input?.addEventListener("change", (e) => this.handleQuantityInput(e, productId));
        });

        // Initialize coupon controls
        this.applyCouponBtn?.addEventListener("click", () => this.handleCouponApplication());
        this.couponInput?.addEventListener("keypress", (e) => {
            if (e.key === "Enter") {
                e.preventDefault();
                this.handleCouponApplication();
            }
        });

        // Initialize remove item buttons
        document.querySelectorAll(".remove-item-btn").forEach(btn => {
            btn.addEventListener("click", (e) => this.handleItemRemoval(e));
        });
    }

    handleQuantityChange(input, change, productId) {
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

    async updateCart(productId, quantity) {
        try {
            const response = await this.makeRequest("/cart/update", {
                product_id: productId,
                quantity: quantity
            });

            if (response.success) {
                this.updateUI(response);
                this.showNotification("Cart updated successfully", "success");
            }
        } catch (error) {
            console.error("Error updating cart:", error);
            this.showNotification("Failed to update cart", "error");
        }
    }

    async handleCouponApplication() {
        const couponCode = this.couponInput.value.trim();
        if (!couponCode) {
            this.showNotification("Please enter a coupon code", "warning");
            return;
        }

        try {
            const response = await this.makeRequest("/cart/apply-coupon", {
                coupon_code: couponCode
            });

            if (response.success) {
                this.updateUI(response);
                this.showNotification("Coupon applied successfully!", "success");
                this.couponInput.value = "";
            }
        } catch (error) {
            this.showNotification(error.message || "Failed to apply coupon", "error");
        }
    }

    async handleItemRemoval(event) {
        event.preventDefault();
        const row = event.target.closest("tr");
        const productId = row.dataset.productId;

        if (confirm("Are you sure you want to remove this item?")) {
            try {
                const response = await this.makeRequest("/cart/remove/" + productId, {}, "DELETE");
                if (response.success) {
                    row.remove();
                    this.updateUI(response);
                    this.showNotification("Item removed successfully", "success");
                    this.checkEmptyCart();
                }
            } catch (error) {
                this.showNotification("Failed to remove item", "error");
            }
        }
    }

    async makeRequest(url, data, method = "POST") {
        const response = await fetch(url, {
            method: method,
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": this.csrfToken,
                "Accept": "application/json"
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            throw new Error(response.statusText);
        }

        return await response.json();
    }

    updateUI(data) {
        // Update product totals
        if (data.products) {
            data.products.forEach(product => {
                const row = document.querySelector(`tr[data-product-id="${product.id}"]`);
                if (row) {
                    row.querySelector(".product-total").textContent = `JD ${product.total.toFixed(2)}`;
                }
            });
        }

        // Update cart totals
        const elements = {
            subtotal: document.querySelector(".subtotal-amount"),
            discount: document.querySelector(".discount-amount"),
            total: document.querySelector(".cart-total")
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

    showNotification(message, type) {
        const notificationDiv = document.createElement("div");
        notificationDiv.className = `alert alert-${type} notification`;
        notificationDiv.textContent = message;

        const container = document.querySelector(".cart__section--inner");
        container.insertBefore(notificationDiv, container.firstChild);

        setTimeout(() => notificationDiv.remove(), 3000);
    }

    checkEmptyCart() {
        const cartItems = document.querySelectorAll("tr[data-product-id]");
        if (cartItems.length === 0) {
            location.reload();
        }
    }
}

// Initialize cart functionality when DOM is loaded
document.addEventListener("DOMContentLoaded", () => new ShoppingCart());
