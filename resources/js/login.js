const themeToggle = document.getElementById("theme-toggle");
const body = document.body;
let isSubmitting = false;

// Theme Toggle Logic
function initTheme() {
    if (localStorage.getItem("theme") === "dark") {
        body.classList.add("dark");
        themeToggle.textContent = "🌜";
    } else {
        body.classList.remove("dark");
        themeToggle.textContent = "🌞";
    }
}

themeToggle.addEventListener("click", () => {
    body.classList.toggle("dark");
    if (body.classList.contains("dark")) {
        localStorage.setItem("theme", "dark");
        themeToggle.textContent = "🌜";
    } else {
        localStorage.setItem("theme", "light");
        themeToggle.textContent = "🌞";
    }
});

// Form Validation Function
function validateForm(event) {
    // Reset previous error messages
    const emailError = document.getElementById("email-error");
    const passwordError = document.getElementById("password-error");

    if (emailError) emailError.textContent = "";
    if (passwordError) passwordError.textContent = "";

    // Prevent multiple submissions
    if (isSubmitting) {
        event.preventDefault();
        return false;
    }

    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    let valid = true;

    // Email validation
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/;
    if (!emailPattern.test(emailInput.value)) {
        if (emailError) {
            emailError.textContent = "Please enter a valid email address.";
        }
        valid = false;
    }

    // Password validation
    if (passwordInput.value.length < 6) {
        if (passwordError) {
            passwordError.textContent = "Password must be at least 6 characters long.";
        }
        valid = false;
    }

    // If form is valid, prevent multiple submissions
    if (valid) {
        isSubmitting = true;
        setTimeout(() => {
            isSubmitting = false;
        }, 2000);
    }

    return valid;
}

document.addEventListener('DOMContentLoaded', initTheme);

const loginForm = document.querySelector('form');
if (loginForm) {
    loginForm.addEventListener('submit', validateForm);
}
