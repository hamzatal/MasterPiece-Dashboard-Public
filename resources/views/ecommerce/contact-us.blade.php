<x-ecommerce-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ('Contact Us') }}
        </h2>
    </x-slot>

    <main class="main__content_wrapper">

        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Contact Us</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="/home">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Contact Us</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <!-- Start contact section -->
        <section class="contact__section section--padding">
            <div class="container">
                <div class="section__heading text-center mb-40">
                    <h2 class="section__heading--maintitle">Get In Touch</h2>
                </div>
                <div class="main__contact--area position__relative">

                    <div class="contact__form">
                        <h3 class="contact__form--title mb-40">Contact Me</h3>
                        <form class="contact__form--inner" action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="contact__form--list mb-20">
                                        <label class="contact__form--label" for="input1">Name <span class="contact__form--label__star">*</span></label>
                                        <input class="contact__form--input" name="name" id="input1" placeholder="Your Name" type="text" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="contact__form--list mb-20">
                                        <label class="contact__form--label" for="input3">Phone Number <span class="contact__form--label__star">*</span></label>
                                        <input class="contact__form--input" name="phone" id="input3" placeholder="Phone number" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="contact__form--list mb-20">
                                        <label class="contact__form--label" for="input4">Email <span class="contact__form--label__star">*</span></label>
                                        <input class="contact__form--input" name="email" id="input4" placeholder="Email" type="email" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="contact__form--list mb-20">
                                        <label class="contact__form--label" for="input6">Subject <span class="contact__form--label__star">*</span></label>
                                        <input class="contact__form--input" name="subject" id="input6" placeholder="Subject" type="text" required>
                                    </div>
                                </div>



                                <div class="col-12">
                                    <div class="contact__form--list mb-15">
                                        <label class="contact__form--label" for="input5">Write Your Message <span class="contact__form--label__star">*</span></label>
                                        <textarea class="contact__form--textarea" name="message" id="input5" placeholder="Write Your Message" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <button class="contact__form--btn primary__btn" type="submit">Submit Now</button>
                        </form>
                    </div>

                    <div class="contact__info border-radius-5">
                        <div class="contact__info--items">
                            <h3 class="contact__info--content__title text-white mb-15">Contact Us</h3>
                            <div class="contact__info--items__inner d-flex">
                                <div class="contact__info--icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31.568" height="31.128" viewBox="0 0 31.568 31.128">
                                        <path id="ic_phone_forwarded_24px" d="M26.676,16.564l7.892-7.782L26.676,1V5.669H20.362v6.226h6.314Zm3.157,7a18.162,18.162,0,0,1-5.635-.887,1.627,1.627,0,0,0-1.61.374l-3.472,3.424a23.585,23.585,0,0,1-10.4-10.257l3.472-3.44a1.48,1.48,0,0,0,.395-1.556,17.457,17.457,0,0,1-.9-5.556A1.572,1.572,0,0,0,10.1,4.113H4.578A1.572,1.572,0,0,0,3,5.669,26.645,26.645,0,0,0,29.832,32.128a1.572,1.572,0,0,0,1.578-1.556V25.124A1.572,1.572,0,0,0,29.832,23.568Z" transform="translate(-3 -1)" fill="currentColor" />
                                    </svg>
                                </div>
                                <div class="contact__info--content">
                                    <p class="contact__info--content__desc text-white"><a href="tel:+01234-567890">0772372187</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="contact__info--items">
                            <h3 class="contact__info--content__title text-white mb-15">Email Address</h3>
                            <div class="contact__info--items__inner d-flex">
                                <div class="contact__info--icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31.57" height="31.13" viewBox="0 0 31.57 31.13">
                                        <path id="ic_email_24px" d="M30.413,4H5.157C3.421,4,2.016,5.751,2.016,7.891L2,31.239c0,2.14,1.421,3.891,3.157,3.891H30.413c1.736,0,3.157-1.751,3.157-3.891V7.891C33.57,5.751,32.149,4,30.413,4Zm0,7.783L17.785,21.511,5.157,11.783V7.891l12.628,9.728L30.413,7.891Z" transform="translate(-2 -4)" fill="currentColor" />
                                    </svg>
                                </div>
                                <div class="contact__info--content">
                                    <p class="contact__info--content__desc text-white"> <a href="mailto:info@example.com">DevStore@Company.com</a> </p>
                                </div>
                            </div>
                        </div>
                        <div class="contact__info--items">
                            <h3 class="contact__info--content__title text-white mb-15">Office Location</h3>
                            <div class="contact__info--items__inner d-flex">
                                <div class="contact__info--icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31.57" height="31.13" viewBox="0 0 31.57 31.13">
                                        <path id="ic_account_balance_24px" d="M5.323,14.341V24.718h4.985V14.341Zm9.969,0V24.718h4.985V14.341ZM2,32.13H33.57V27.683H2ZM25.262,14.341V24.718h4.985V14.341ZM17.785,1,2,8.412v2.965H33.57V8.412Z" transform="translate(-2 -1)" fill="currentColor" />
                                    </svg>
                                </div>
                                <div class="contact__info--content">
                                    <p class="contact__info--content__desc text-white"> Orange Coding Academy</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- End contact section -->

        <!-- Start contact map area -->
        <div class="contact__map--area section--padding pt-0">
            <iframe class="contact__map--iframe" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3384.665315434545!2d35.91179572525339!3d31.969975224792982!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151ca12ce1b9c62b%3A0x21b9b701f3f4ee86!2sOrange%20Coding%20Academy!5e0!3m2!1sar!2sjo!4v1734599928623!5m2!1sar!2sjo" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
        <!-- End contact map area -->

        <!-- HTML for the card alerts container -->
        <div id="cardAlertContainer" class="card-alert-container"></div>

        <style>
            .card-alert-container {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .card-alert {
                width: 300px;
                padding: 16px;
                border-radius: 8px;
                background: white;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                display: flex;
                align-items: flex-start;
                gap: 12px;
                animation: slideIn 0.3s ease-out;
                position: relative;
                overflow: hidden;
            }

            .card-alert.success {
                border-left: 4px solid #10B981;
            }

            .card-alert.error {
                border-left: 4px solid #EF4444;
            }

            .card-alert.info {
                border-left: 4px solid #3B82F6;
            }

            .card-alert.warning {
                border-left: 4px solid #F59E0B;
            }

            .card-alert-icon {
                flex-shrink: 0;
                width: 24px;
                height: 24px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
            }

            .card-alert.success .card-alert-icon {
                background-color: #D1FAE5;
                color: #059669;
            }

            .card-alert.error .card-alert-icon {
                background-color: #FEE2E2;
                color: #DC2626;
            }

            .card-alert.info .card-alert-icon {
                background-color: #DBEAFE;
                color: #2563EB;
            }

            .card-alert.warning .card-alert-icon {
                background-color: #FEF3C7;
                color: #D97706;
            }

            .card-alert-content {
                flex-grow: 1;
            }

            .card-alert-title {
                margin: 0 0 4px 0;
                font-size: 16px;
                font-weight: 600;
                color: #1F2937;
            }

            .card-alert-message {
                margin: 0;
                font-size: 14px;
                color: #6B7280;
                line-height: 1.5;
            }

            .card-alert-close {
                position: absolute;
                top: 8px;
                right: 8px;
                background: none;
                border: none;
                color: #9CA3AF;
                cursor: pointer;
                padding: 4px;
                border-radius: 4px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: background-color 0.2s;
            }

            .card-alert-close:hover {
                background-color: #F3F4F6;
            }

            .card-alert-progress {
                position: absolute;
                bottom: 0;
                left: 0;
                height: 3px;
                background: rgba(0, 0, 0, 0.1);
                width: 100%;
            }

            .card-alert-progress-bar {
                height: 100%;
                width: 100%;
                transform-origin: left;
                animation: progress 5s linear;
            }

            .card-alert.success .card-alert-progress-bar {
                background-color: #10B981;
            }

            .card-alert.error .card-alert-progress-bar {
                background-color: #EF4444;
            }

            .card-alert.info .card-alert-progress-bar {
                background-color: #3B82F6;
            }

            .card-alert.warning .card-alert-progress-bar {
                background-color: #F59E0B;
            }

            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }

                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }

            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }

                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }

            @keyframes progress {
                from {
                    transform: scaleX(1);
                }

                to {
                    transform: scaleX(0);
                }
            }
        </style>

        <script>
            class CardAlert {
                constructor() {
                    this.container = document.getElementById('cardAlertContainer');
                    if (!this.container) {
                        this.container = document.createElement('div');
                        this.container.id = 'cardAlertContainer';
                        this.container.className = 'card-alert-container';
                        document.body.appendChild(this.container);
                    }
                }

                show(type, title, message, duration = 5000) {
                    const alert = document.createElement('div');
                    alert.className = `card-alert ${type}`;

                    const icons = {
                        success: '✓',
                        error: '✕',
                        info: 'ℹ',
                        warning: '!'
                    };

                    alert.innerHTML = `
            <div class="card-alert-icon">${icons[type] || 'ℹ'}</div>
            <div class="card-alert-content">
                <h4 class="card-alert-title">${title}</h4>
                <p class="card-alert-message">${message}</p>
            </div>
            <button class="card-alert-close">✕</button>
            <div class="card-alert-progress">
                <div class="card-alert-progress-bar"></div>
            </div>
        `;

                    this.container.appendChild(alert);

                    const closeBtn = alert.querySelector('.card-alert-close');
                    closeBtn.addEventListener('click', () => this.close(alert));

                    // Auto close after duration
                    setTimeout(() => {
                        if (alert.parentNode) {
                            this.close(alert);
                        }
                    }, duration);

                    // Remove alert after animation
                    alert.addEventListener('animationend', (e) => {
                        if (e.animationName === 'slideOut') {
                            alert.remove();
                        }
                    });
                }

                close(alert) {
                    alert.style.animation = 'slideOut 0.3s ease-out forwards';
                }
            }

            // Initialize the card alert system
            const cardAlert = new CardAlert();

            // Modify your form submission code
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.querySelector('.contact__form--inner');

                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(form);

                    fetch("{{ route('contact.store') }}", {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                cardAlert.show('success', 'Success!', 'Your message has been sent successfully.');
                                form.reset();
                            } else {
                                cardAlert.show('error', 'Error!', 'Failed to send message. Please try again.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            cardAlert.show('error', 'Error!', 'An error occurred while sending the message.');
                        });
                });
            });
        </script>



</x-ecommerce-app-layout>
