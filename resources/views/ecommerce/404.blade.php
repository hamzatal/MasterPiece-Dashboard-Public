<x-ecommerce-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ('404 Error') }}
        </h2>
    </x-slot>


    <main class="main__content_wrapper">

        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Error 404</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="/home">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Error 404</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->
        <section class="not-found">
    <div class="stars">
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
    </div>

    <div class="center">
        <div class="error">
            <div class="number">4</div>
            <div class="illustration">
                <div class="circle"></div>
                <div class="clip">
                    <div class="paper">
                        <div class="face">
                            <div class="eyes">
                                <div class="eye eye-left"></div>
                                <div class="eye eye-right"></div>
                            </div>
                            <div class="rosyCheeks"></div>
                            <div class="mouth"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="number">4</div>
        </div>

        <div class="text">
            <h1>Oops! Page Not Found</h1>
            <p>The page you're looking for doesn't exist or has been moved.</p>
            <a href="/" class="button">Return Home</a>
        </div>
    </div>
</section>

<style>
.not-found {
    position: relative;
    min-height: 100vh;
    background: linear-gradient(to bottom,rgba(26, 26, 46, 0.77), #16213e);
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Arial', sans-serif;
}

.stars {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.star {
    position: absolute;
    background: white;
    border-radius: 50%;
    animation: twinkle 2s infinite;
}

.star:nth-child(1) { left: 10%; top: 20%; width: 3px; height: 3px; }
.star:nth-child(2) { left: 30%; top: 40%; width: 2px; height: 2px; animation-delay: 0.3s; }
.star:nth-child(3) { left: 50%; top: 25%; width: 4px; height: 4px; animation-delay: 0.5s; }
.star:nth-child(4) { left: 70%; top: 60%; width: 3px; height: 3px; animation-delay: 0.7s; }
.star:nth-child(5) { left: 85%; top: 30%; width: 2px; height: 2px; animation-delay: 0.9s; }

.center {
    text-align: center;
    position: relative;
    z-index: 2;
}

.error {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 40px;
}

.number {
    font-size: 150px;
    font-weight: bold;
    color: #fff;
    text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
    animation: bounce 2s ease infinite;
}

.illustration {
    width: 150px;
    height: 150px;
    margin: 0 20px;
    position: relative;
    animation: float 6s ease-in-out infinite;
}

.circle {
    position: absolute;
    width: 140px;
    height: 140px;
    background: #fff;
    border-radius: 50%;
    z-index: 1;
}

.face {
    position: absolute;
    width: 100%;
    height: 100%;
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding-top: 20px;
}

.eyes {
    display: flex;
    justify-content: space-around;
    width: 80px;
    margin-bottom: 10px;
}

.eye {
    width: 20px;
    height: 20px;
    background: #1a1a2e;
    border-radius: 50%;
    animation: blink 3s ease-in-out infinite;
}

.mouth {
    width: 40px;
    height: 20px;
    border: 4px solid #1a1a2e;
    border-radius: 0 0 20px 20px;
    border-top: 0;
}

.text {
    color: #fff;
    max-width: 600px;
    margin: 0 auto;
    padding: 0 20px;
}

.text h1 {
    font-size: 32px;
    margin-bottom: 20px;
    color: #fff;
}

.text p {
    font-size: 18px;
    margin-bottom: 30px;
    color: rgba(255, 255, 255, 0.8);
}

.button {
    display: inline-block;
    padding: 15px 30px;
    background: linear-gradient(45deg, #4facfe, #00f2fe);
    color: #fff;
    text-decoration: none;
    border-radius: 30px;
    font-weight: bold;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 242, 254, 0.3);
}

.button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 242, 254, 0.4);
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

@keyframes blink {
    0%, 45%, 55%, 100% { transform: scaleY(1); }
    50% { transform: scaleY(0.1); }
}

@keyframes twinkle {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}

@media (max-width: 768px) {
    .number {
        font-size: 100px;
    }

    .illustration {
        width: 120px;
        height: 120px;
    }

    .text h1 {
        font-size: 24px;
    }

    .text p {
        font-size: 16px;
    }

    .button {
        padding: 12px 25px;
    }
}
</style>


    </main>

</x-ecommerce-app-layout>
