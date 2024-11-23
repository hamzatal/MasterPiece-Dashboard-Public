const themeToggle = document.getElementById("theme-toggle");
const body = document.body;

if (localStorage.getItem("theme") === "dark") {
    body.classList.add("dark");
    themeToggle.textContent = "🌜";
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

function validateForm() {
    let valid = true;

    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");

    // Email validation
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/;
    if (!emailPattern.test(emailInput.value)) {
        const emailError = document.getElementById("email-error");
        emailError.textContent = "Please enter a valid email address.";
        valid = false;
    }

    // Password validation
    if (passwordInput.value.length < 6) {
        const passwordError = document.getElementById("password-error");
        passwordError.textContent =
            "Password must be at least 6 characters long.";
        valid = false;
    }

    return valid;
}
