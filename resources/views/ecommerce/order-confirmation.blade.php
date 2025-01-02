<x-ecommerce-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Orders') }}
        </h2>
        <link rel="stylesheet" href="css/order-confirmation.css">
    </x-slot>

    <main class="main__content_wrapper">
        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">My Order</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="/home">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">My Order</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End breadcrumb section -->

        <!-- Start Orders Section -->
        <section class="orders section--padding">
            <div class="container">
                @if($orders->isEmpty())
                <div class="text-center">
                    <h3>You have not placed any orders yet.</h3>
                    <a href="/shop" class="btn btn-primary mt-4">Start Shopping</a>
                </div>
                @else
                <div class="row g-4">
                    @foreach($orders as $order)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="order__card">
                            <div class="order__header">
                                <h4><i class="bi bi-box"></i> Order #{{ $order->id }}</h4>
                                <p><i class="bi bi-calendar"></i> {{ $order->created_at->format('M d, Y') }}</p>
                                <p>
                                    <i class="bi bi-info-circle"></i> Status:
                                    <span class="badge badge-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'processing' ? 'info' : 'warning') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </p>
                            </div>
                            <div class="order__details">
                                <h5><i class="bi bi-cart4"></i> Items:</h5>
                                <ul>
                                    @foreach($order->items as $item)
                                    <li>
                                        <i class="bi bi-dot"></i> {{ $item->product->name ?? 'Product not found' }}
                                        (x{{ $item->quantity }})
                                        - JD {{ number_format($item->price * $item->quantity, 2) }}
                                    </li>
                                    @endforeach
                                </ul>
                                <p><strong><i class="bi bi-currency-exchange"></i> Total: JD {{ number_format($order->total_price, 2) }}</strong></p>
                            </div>
                            <div class="order__actions">
                                <a href="{{ route('order.details', $order->id) }}" class="btn btn-secondary btn-sm">
                                    <i class="bi bi-eye"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    {{ $orders->links() }} <!-- Pagination links -->
                </div>
                @endif
            </div>
        </section>

        <!-- End Orders Section -->

        <style>
            .orders {
                margin-top: 0px;
            }

            .order__card {
                border: 1px solid #ddd;
                border-radius: 10px;
                padding: 20px;
                background: linear-gradient(145deg, #ffffff, #f3f3f3);
                box-shadow: 5px 5px 15px #cccccc, -5px -5px 15px #ffffff;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                height: 100%;
            }

            .order__card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            }

            .order__header h4 {
                font-size: 2rem;
                margin-bottom: 10px;
                color: #333;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .order__header p {
                font-size: 1.2rem;
                color: #666;
                margin: 5px 0;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .order__details h5 {
                margin-top: 15px;
                font-size: 1.2rem;
                margin-bottom: 10px;
                color: #555;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .order__details ul {
                list-style: none;
                padding: 0;
                font-size: 1.2rem;
                color: #444;
            }

            .order__details ul li {
                margin-bottom: 5px;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .order__actions .btn {
                margin-top: 10px;
                text-transform: uppercase;
                font-size: 1.2rem;
                background: linear-gradient(145deg, rgb(20, 14, 130), #5a54e8);
                color: #fff;
                border: none;
                border-radius: 8px;
                padding: 8px 12px;
                transition: background 0.3s ease;
            }

            .order__actions .btn:hover {
                background: linear-gradient(145deg, rgb(6, 3, 88), rgb(32, 25, 174));
            }

            .badge-success {
                background-color: #28a745;
                color: #fff;
                padding: 5px 10px;
                border-radius: 5px;
            }

            .badge-warning {
                background-color: #ffc107;
                color: #fff;
                padding: 5px 10px;
                border-radius: 5px;
            }

            .badge-info {
                background-color: #17a2b8;
                color: #fff;
                padding: 5px 10px;
                border-radius: 5px;
            }
        </style>
    </main>

</x-ecommerce-app-layout>
