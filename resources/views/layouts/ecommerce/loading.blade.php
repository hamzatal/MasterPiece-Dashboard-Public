<!-- Start preloader -->
<div id="preloader">
    <div id="ctn-preloader" class="ctn-preloader">
        <div class="animation-preloader">
        <!-- Start preloader -->
<div id="modern-preloader">
    <div class="modern-preloader-container">
        <div class="modern-spinner"></div>
        <div class="modern-loading-text">
            <span>L</span>
            <span>O</span>
            <span>A</span>
            <span>D</span>
            <span>I</span>
            <span>N</span>
            <span>G</span>
        </div>
    </div>
</div>
<!-- End preloader -->

        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
</div>
<!-- End preloader -->
<style>
    /* Modern Preloader Styles */
    #modern-preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .modern-preloader-container {
        text-align: center;
    }

    .modern-spinner {
        width: 50px;
        height: 50px;
        border: 4px solid #3b82f6;
        border-top: 4px solid transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 20px;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .modern-loading-text {
        font-size: 24px;
        font-weight: bold;
        color: #3b82f6;
        display: flex;
        gap: 5px;
    }

    .modern-loading-text span {
        animation: bounce 1.4s infinite ease-in-out;
        animation-delay: calc(0.1s * var(--i));
    }

    @keyframes bounce {

        0%,
        40%,
        100% {
            transform: translateY(0);
        }

        20% {
            transform: translateY(-15px);
        }
    }
</style>
