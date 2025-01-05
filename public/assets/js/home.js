$(document).ready(function () {
    $(".hero__slider").slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        autoplay: true,
        autoplaySpeed: 3000,
    });
});

//? Banner slider
document.addEventListener("DOMContentLoaded", function () {
    const bannerSlider = {
        track: document.querySelector(".banner-track"),
        slides: document.querySelectorAll(".banner-slide"),
        prevBtn: document.querySelector(".banner-prev"),
        nextBtn: document.querySelector(".banner-next"),
        indicators: document.querySelector(".banner-indicators"),
        currentIndex: 0,
        slideDuration: 6000, // 6 seconds per slide

        initialize() {
            // Create indicators
            this.slides.forEach((_, index) => {
                const dot = document.createElement("button");
                dot.className = "banner-dot";
                dot.setAttribute("aria-label", `Go to slide ${index + 1}`);
                dot.addEventListener("click", () => this.goToSlide(index));
                this.indicators.appendChild(dot);
            });

            // Show initial slide
            this.showSlide(0);

            // Add event listeners
            this.prevBtn.addEventListener("click", () => this.previousSlide());
            this.nextBtn.addEventListener("click", () => this.nextSlide());

            // Start autoplay
            this.startAutoplay();

            // Pause autoplay on hover
            this.track.addEventListener("mouseenter", () =>
                this.pauseAutoplay()
            );
            this.track.addEventListener("mouseleave", () =>
                this.startAutoplay()
            );
        },

        showSlide(index) {
            this.slides.forEach((slide) => slide.classList.remove("active"));
            document
                .querySelectorAll(".banner-dot")
                .forEach((dot) => dot.classList.remove("active"));

            this.slides[index].classList.add("active");
            document
                .querySelectorAll(".banner-dot")
                [index].classList.add("active");
            this.currentIndex = index;
        },

        nextSlide() {
            const next = (this.currentIndex + 1) % this.slides.length;
            this.showSlide(next);
        },

        previousSlide() {
            const prev =
                (this.currentIndex - 1 + this.slides.length) %
                this.slides.length;
            this.showSlide(prev);
        },

        goToSlide(index) {
            this.showSlide(index);
        },

        startAutoplay() {
            this.autoplayInterval = setInterval(
                () => this.nextSlide(),
                this.slideDuration
            );
        },

        pauseAutoplay() {
            clearInterval(this.autoplayInterval);
        },
    };

    bannerSlider.initialize();
});

//? Swiper
document.addEventListener("DOMContentLoaded", () => {
    const swiper = new Swiper(".swiper-container", {
        slidesPerView: 7,
        spaceBetween: 10,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            1200: {
                slidesPerView: 7,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 15,
            },
            480: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
        },
    });
});

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
                        showNotification(data.message, "notification-success");

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



//? Coupon popup
document.addEventListener("DOMContentLoaded", function () {
    const popup = document.getElementById("coupon-popup");
    const closePopup = document.querySelector(".close-popup");

    if (popup) {
        setTimeout(() => {
            popup.style.display = "block";
        }, 2000);

        closePopup.addEventListener("click", () => {
            popup.style.display = "none";
        });

        window.addEventListener("click", (event) => {
            if (event.target === popup) {
                popup.style.display = "none";
            }
        });
    }
});

//? Notification system
function showNotification(message, type) {
    const notification = document.createElement("div");
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span>${message}</span>
            <button class="notification-close">&times;</button>
        </div>
    `;
    document.body.appendChild(notification);

    // Show notification
    setTimeout(() => {
        notification.classList.add("show");
    }, 100);

    // Auto-remove notification after 5 seconds
    setTimeout(() => {
        notification.remove();
    }, 5000);

    // Close button
    notification
        .querySelector(".notification-close")
        .addEventListener("click", () => {
            notification.remove();
        });
}
