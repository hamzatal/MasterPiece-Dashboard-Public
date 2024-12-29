// public/js/cart.js
document.addEventListener("DOMContentLoaded", function () {
    const quantityControls = document.querySelectorAll(".quantity-controls");
    const applyCouponBtn = document.getElementById("apply-coupon");

    // Handle quantity changes
    quantityControls.forEach((control) => {
        const decreaseBtn = control.querySelector(".quantity-decrease");
        const increaseBtn = control.querySelector(".quantity-increase");
        const input = control.querySelector(".quantity-input");
        const row = control.closest("tr");
        const productId = row.dataset.productId;

        decreaseBtn.addEventListener("click", () =>
            updateQuantity(input, -1, productId)
        );
        increaseBtn.addEventListener("click", () =>
            updateQuantity(input, 1, productId)
        );
        input.addEventListener("change", () =>
            updateQuantity(input, 0, productId)
        );
    });

    // Handle quantity updates
    function updateQuantity(input, change, productId) {
        let newValue = parseInt(input.value) + change;
        if (newValue < 1) newValue = 1;
        input.value = newValue;

        fetch("/cart/update", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: newValue,
            }),
        })
            .then((response) => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error("Failed to apply coupon");
                }
            })
            .then((data) => {
                if (data.success) {
                    // Update display
                    document.querySelector(
                        ".discount-amount"
                    ).textContent = `JD ${data.discount_amount.toFixed(2)}`;
                    document.querySelector(
                        ".cart-total"
                    ).textContent = `JD ${data.total.toFixed(2)}`;
                    showMessage(data.message, "success");
                } else {
                    showMessage(data.message, "error");
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                showMessage("Error applying coupon", "error");
            });
    }
   
    // Update prices in the UI
    function updatePrices(data) {
        // Update product totals
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

        // Update cart totals
        document.querySelector(
            ".subtotal-amount"
        ).textContent = `JD ${data.subtotal.toFixed(2)}`;
        document.querySelector(
            ".discount-amount"
        ).textContent = `JD ${data.discount.toFixed(2)}`;
        document.querySelector(
            ".cart-total"
        ).textContent = `JD ${data.total.toFixed(2)}`;
    }

    // Show message
    function showMessage(message, type) {
        const existingMessage = document.querySelector(".alert");
        if (existingMessage) {
            existingMessage.remove();
        }

        const messageDiv = document.createElement("div");
        messageDiv.className = `alert alert-${type}`;
        messageDiv.textContent = message;

        const container = document.querySelector(".cart__section--inner");
        container.insertBefore(messageDiv, container.firstChild);

        setTimeout(() => messageDiv.remove(), 3000);
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const applyCouponBtn = document.getElementById("apply-coupon");

    if (applyCouponBtn) {
        applyCouponBtn.addEventListener("click", function () {
            const couponCode = document.getElementById("coupon-code").value;
            const messageDiv = document.getElementById("coupon-message");

            fetch("/cart/apply-coupon", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                body: JSON.stringify({
                    coupon_code: couponCode,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        // Update display
                        document.querySelector(
                            ".subtotal-amount"
                        ).textContent = `JD ${data.subtotal.toFixed(2)}`;
                        document.querySelector(
                            ".discount-amount"
                        ).textContent = `JD ${data.discount_amount.toFixed(2)}`;
                        document.querySelector(
                            ".cart-total"
                        ).textContent = `JD ${data.total.toFixed(2)}`;

                        // Show success message
                        messageDiv.className = "alert alert-success";
                        messageDiv.textContent = data.message;
                    } else {
                        // Show error message
                        messageDiv.className = "alert alert-danger";
                        messageDiv.textContent = data.message;
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    messageDiv.className = "alert alert-danger";
                    messageDiv.textContent = "Error applying coupon";
                });
        });
    }
});
