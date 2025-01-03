document.addEventListener("DOMContentLoaded", function () {
    // Gallery functionality
    const mainGallery = document.getElementById("mainGallery");
    const prevButton = document.getElementById("prevImage");
    const nextButton = document.getElementById("nextImage");
    const galleryThumbs = document.getElementById("galleryThumbs");

    let currentIndex = 0;
    const images = mainGallery.getElementsByTagName("img");

    // Create thumbnails
    Array.from(images).forEach((img, index) => {
        const thumb = document.createElement("img");
        thumb.src = img.src;
        thumb.classList.add("gallery__thumbnail");
        if (index === 0) thumb.classList.add("gallery__thumbnail--active");
        thumb.addEventListener("click", () => showImage(index));
        galleryThumbs.appendChild(thumb);
    });

    function showImage(index) {
        Array.from(images).forEach((img) =>
            img.classList.remove("gallery__image--active")
        );
        Array.from(galleryThumbs.children).forEach((thumb) =>
            thumb.classList.remove("gallery__thumbnail--active")
        );

        images[index].classList.add("gallery__image--active");
        galleryThumbs.children[index].classList.add(
            "gallery__thumbnail--active"
        );
        currentIndex = index;
    }

    function showNext() {
        currentIndex = (currentIndex + 1) % images.length;
        showImage(currentIndex);
    }

    function showPrev() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        showImage(currentIndex);
    }

    prevButton.addEventListener("click", showPrev);
    nextButton.addEventListener("click", showNext);

    // Quantity selector functionality
    const quantityInput = document.getElementById("quantityInput");
    const decreaseBtn = document.getElementById("decreaseQuantity");
    const increaseBtn = document.getElementById("increaseQuantity");

    function updateQuantity(change) {
        let currentValue = parseInt(quantityInput.value);
        let newValue = currentValue + change;
        let maxValue = parseInt(quantityInput.getAttribute("max"));

        if (newValue >= 1 && newValue <= maxValue) {
            quantityInput.value = newValue;
        }
    }

    decreaseBtn.addEventListener("click", () => updateQuantity(-1));
    increaseBtn.addEventListener("click", () => updateQuantity(1));

    // Review form toggle
    const writeReviewBtn = document.getElementById("writeReviewBtn");
    const reviewForm = document.getElementById("reviewForm");

    writeReviewBtn.addEventListener("click", () => {
        console.log("Write Review button clicked!"); // Debugging
        if (reviewForm.style.display === "none" || !reviewForm.style.display) {
            reviewForm.style.display = "block";
        } else {
            reviewForm.style.display = "none";
        }
    });

    // Wishlist functionality
    const wishlistBtn = document.querySelector(".btn--secondary");
    wishlistBtn.addEventListener("click", function (e) {
        e.preventDefault();
        const productId = this.dataset.product;

        fetch(`/wishlist/add/${productId}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
                Accept: "application/json",
                "Content-Type": "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    // Update wishlist icon
                    const icon = this.querySelector("i");
                    icon.classList.toggle("far");
                    icon.classList.toggle("fas");

                    // Reload the page to reflect changes
                    window.location.reload();
                }
            })
            .catch((error) => console.error("Error:", error));
    });
});
