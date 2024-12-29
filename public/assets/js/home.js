
$(document).ready(function() {
    $('.hero__slider').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        autoplay: true,
        autoplaySpeed: 3000,
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const bannerSlider = {
        track: document.querySelector('.banner-track'),
        slides: document.querySelectorAll('.banner-slide'),
        prevBtn: document.querySelector('.banner-prev'),
        nextBtn: document.querySelector('.banner-next'),
        indicators: document.querySelector('.banner-indicators'),
        currentIndex: 0,
        slideDuration: 6000, // 6 seconds per slide

        initialize() {
            // Create indicators
            this.slides.forEach((_, index) => {
                const dot = document.createElement('button');
                dot.className = 'banner-dot';
                dot.setAttribute('aria-label', `Go to slide ${index + 1}`);
                dot.addEventListener('click', () => this.goToSlide(index));
                this.indicators.appendChild(dot);
            });

            // Show initial slide
            this.showSlide(0);

            // Add event listeners
            this.prevBtn.addEventListener('click', () => this.previousSlide());
            this.nextBtn.addEventListener('click', () => this.nextSlide());

            // Start autoplay
            this.startAutoplay();

            // Pause autoplay on hover
            this.track.addEventListener('mouseenter', () => this.pauseAutoplay());
            this.track.addEventListener('mouseleave', () => this.startAutoplay());
        },

        showSlide(index) {
            this.slides.forEach(slide => slide.classList.remove('active'));
            document.querySelectorAll('.banner-dot').forEach(dot => dot.classList.remove('active'));

            this.slides[index].classList.add('active');
            document.querySelectorAll('.banner-dot')[index].classList.add('active');
            this.currentIndex = index;
        },

        nextSlide() {
            const next = (this.currentIndex + 1) % this.slides.length;
            this.showSlide(next);
        },

        previousSlide() {
            const prev = (this.currentIndex - 1 + this.slides.length) % this.slides.length;
            this.showSlide(prev);
        },

        goToSlide(index) {
            this.showSlide(index);
        },

        startAutoplay() {
            this.autoplayInterval = setInterval(() => this.nextSlide(), this.slideDuration);
        },

        pauseAutoplay() {
            clearInterval(this.autoplayInterval);
        }
    };

    bannerSlider.initialize();
});