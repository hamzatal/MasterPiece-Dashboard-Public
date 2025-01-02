document.addEventListener('DOMContentLoaded', function() {
    // Quantity increment/decrement functionality
    const quantityBox = document.querySelector('.quantity__box');
    const quantityInput = quantityBox.querySelector('.quantity__number');

    quantityBox.querySelector('.decrease').addEventListener('click', function() {
        let value = parseInt(quantityInput.value);
        if (value > 1) {
            quantityInput.value = value - 1;
        }
    });

    quantityBox.querySelector('.increase').addEventListener('click', function() {
        let value = parseInt(quantityInput.value);
        if (value < maxQuantity) {
            quantityInput.value = value + 1;
        }
    });

    // Validate quantity on manual input
    quantityInput.addEventListener('change', function() {
        let value = parseInt(this.value);
        if (value < 1) this.value = 1;
        if (value > maxQuantity) this.value = maxQuantity;
    });
});
