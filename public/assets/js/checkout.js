document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("checkout-form");

    form.addEventListener("submit", function (e) {
        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.innerHTML =
            '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Processing...';
    });

    // Form validation
    const inputs = form.querySelectorAll("input[required]");
    inputs.forEach((input) => {
        input.addEventListener("invalid", function (e) {
            e.preventDefault();
            this.classList.add("is-invalid");
        });

        input.addEventListener("input", function () {
            if (this.validity.valid) {
                this.classList;
                this.classList.remove("is-invalid");
            }
        });
    });

    // Add loading states for form submission
    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        if (!form.checkValidity()) {
            return;
        }

        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML =
            '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

        try {
            await this.submit();
        } catch (error) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = "Place Order";
            alert("An error occurred. Please try again.");
        }
    });

    // Auto-format ZIP code
    const zipInput = document.getElementById("zip_code");
    zipInput.addEventListener("input", function (e) {
        this.value = this.value.replace(/[^0-9-]/g, "");
    });
});
