<!-- Footer Section -->
<footer class="footer">
    <div class="footer__top">
        <div class="container">
            <div class="footer__grid">
                <!-- Company Info -->
                <div class="footer__column">
                    <h3 class="footer__title">SyntaxStore</h3>
                    <p class="footer__description">
                        Your favorite store for high-quality products.
                    </p>

                </div>

                <!-- Quick Links -->
                <div class="footer__column">
                    <h3 class="footer__title">Quick Links</h3>
                    <ul class="footer__links">
                        <li><a href="/about-us">About</a></li>
                        <li><a href="/contact-us">Contact</a></li>
                        <li><a href="/faq">FAQ</a></li>

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer__bottom">
        <div class="container">
            <p class="footer__copyright">© 2024 SyntaxStore. All rights reserved.</p>
        </div>
    </div>
</footer>


<style>
    .footer {
        background-color: #1a1a1a;
        color: #ffffff;
        font-family: 'Inter', sans-serif;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .footer__top {
        padding: 3rem 0;
    }

    .footer__grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
    }

    .footer__title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .footer__description {
        color: #a3a3a3;
        font-size: 0.875rem;
        line-height: 1.6;
    }

    .footer__links {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .footer__links a {
        color: #a3a3a3;
        text-decoration: none;
        font-size: 0.875rem;
    }

    .footer__links a:hover {
        color: #ffffff;
    }

    .footer__social {
        display: flex;
        gap: 1rem;
    }

    .social__link {
        color: #a3a3a3;
        transition: color 0.3s ease;
    }

    .social__link:hover {
        color: #ffffff;
    }

    .footer__bottom {
        padding: 1rem 0;
        border-top: 1px solid #333;
        text-align: center;
    }

    .footer__copyright {
        color: #a3a3a3;
        font-size: 0.875rem;
        margin: 0;
    }
</style>
