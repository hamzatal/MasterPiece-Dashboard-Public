<x-ecommerce-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Info') }}
        </h2>
    </x-slot>

    <main class="main__content_wrapper">
        <!-- Your existing breadcrumb section remains unchanged -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Order Info</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="/home">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Order Info</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Start Order Details Section -->
        <section class="order-details">
            <div class="container mx-auto px-4">
                @if(isset($order))
                <div class="order-wrapper">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Order Details -->
                        <div class="order-details__content">
                            <div class="info-card">
                                <h3 class="info-card__title">
                                    <i class="fas fa-box-open"></i>
                                    Order #{{ $order->id }}
                                </h3>
                                <ul class="info-list">
                                    <li>
                                        <i class="far fa-calendar-alt"></i>
                                        <span>Order Date:</span>
                                        <strong>{{ $order->created_at->format('d M, Y') }}</strong>
                                    </li>
                                    <li>
                                        <i class="fas fa-circle"></i>
                                        <span>Status:</span>
                                        <span class="status-badge status--{{ $order->status }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </li>
                                    <li>
                                        <i class="fas fa-dollar-sign"></i>
                                        <span>Total Amount:</span>
                                        <strong>${{ number_format($order->total_price, 2) }}</strong>
                                    </li>
                                    <li>
                                        <i class="fas fa-credit-card"></i>
                                        <span>Payment Method:</span>
                                        <strong>{{ ucfirst($order->payment_method) }}</strong>
                                    </li>
                                </ul>
                            </div>

                            <div class="info-card mt-8">
                                <h4 class="info-card__title">
                                    <i class="fas fa-truck"></i>
                                    Shipping Address
                                </h4>
                                @if($order->shippingAddress)
                                <address class="shipping-address">
                                    <p class="name">{{ $order->shippingAddress->name }}</p>
                                    <p>{{ $order->shippingAddress->street_address }}</p>
                                    <p>{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }}</p>
                                    <p>{{ $order->shippingAddress->zip_code }}</p>
                                    <p>{{ $order->shippingAddress->country }}</p>
                                </address>
                                @else
                                <p class="no-address">No shipping address available.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="order-summary">
                            <h3 class="summary-title">
                                <i class="fas fa-receipt"></i>
                                Order Summary
                            </h3>
                            <ul class="summary-list">
                                <li>
                                    <span>Subtotal</span>
                                    <span>${{ number_format($order->subtotal, 2) }}</span>
                                </li>
                                <li>
                                    <span>Discount</span>
                                    <span class="discount">-${{ number_format($order->discount, 2) }}</span>
                                </li>
                                <li class="total">
                                    <span>Total</span>
                                    <span>${{ number_format($order->total_price, 2) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="order-items">
                        <h4 class="items-title">
                            <i class="fas fa-shopping-basket"></i>
                            Order Items
                        </h4>
                        <div class="table-responsive">
                            <table class="items-table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product->name ?? 'Product not found' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @else
                <div class="empty-state">
                    <i class="fas fa-box-open"></i>
                    <p>No orders found.</p>
                </div>
                @endif
            </div>
        </section>
    </main>

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #818cf8;
            --success: #10b981;
            --warning: #f59e0b;
            --info: #3b82f6;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        body {
            background-color: #f8fafc;
        }

        .order-details {
            padding: 2rem 0;
        }

        .order-wrapper {
            background: white;
            border-radius: 1rem;
            box-shadow: var(--shadow-lg);
            padding: 2.5rem;
            margin-top: 2rem;
        }

        .info-card {
            background: var(--gray-50);
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: var(--shadow);
            transition: transform 0.2s ease-in-out;
        }

        .info-card:hover {
            transform: translateY(-2px);
        }

        .info-card__title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-800);
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .info-card__title i {
            color: var(--primary);
            font-size: 1.75rem;
        }

        .info-list {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .info-list li {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: var(--gray-700);
            padding: 0.75rem;
            background: white;
            border-radius: 0.75rem;
            box-shadow: var(--shadow-sm);
        }

        .info-list i {
            color: var(--primary);
            width: 1.5rem;
            font-size: 1.25rem;
        }

        .info-list strong {
            margin-left: auto;
            font-weight: 600;
            color: var(--gray-800);
        }

        .status-badge {
            padding: 0.5rem 1.25rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status--delivered {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .status--processing {
            background-color: rgba(59, 130, 246, 0.1);
            color: var(--info);
        }

        .status--pending {
            background-color: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .shipping-address {
            color: var(--gray-700);
            line-height: 1.8;
            background: white;
            padding: 1.5rem;
            border-radius: 0.75rem;
            box-shadow: var(--shadow-sm);
        }

        .shipping-address .name {
            font-weight: 700;
            color: var(--gray-800);
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .order-summary {
            background: linear-gradient(145deg, var(--primary), var(--primary-dark));
            border-radius: 1rem;
            padding: 2rem;
            color: white;
            box-shadow: var(--shadow-lg);
        }

        .summary-title {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            color: white;
        }

        .summary-list {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .summary-list li {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            font-size: 1.1rem;
        }

        .summary-list .total {
            font-weight: 700;
            font-size: 1.25rem;
            background: rgba(255, 255, 255, 0.2);
            margin-top: 1rem;
            padding: 1rem;
        }

        .discount {
            color: #a7f3d0;
        }

        .order-items {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 2px solid var(--gray-100);
        }

        .items-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-800);
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .items-title i {
            color: var(--primary);
        }

        .items-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.5rem;
        }

        .items-table th {
            background: var(--gray-100);
            padding: 1.25rem 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--gray-800);
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.05em;
        }

        .items-table td {
            padding: 1.25rem 1rem;
            color: var(--gray-700);
            background: white;
            border-bottom: 1px solid var(--gray-100);
        }

        .items-table tr:hover td {
            background: var(--gray-50);
        }

        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            background: white;
            border-radius: 1rem;
            box-shadow: var(--shadow);
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        .empty-state p {
            font-size: 1.25rem;
            color: var(--gray-700);
        }

        @media (max-width: 768px) {
            .order-wrapper {
                padding: 1.5rem;
            }

            .info-card,
            .order-summary {
                padding: 1.5rem;
            }

            .items-table {
                display: block;
                width: 100%;
                overflow-x: auto;
            }

            .info-list li {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .info-list strong {
                margin-left: 0;
            }

            .status-badge {
                margin-left: 2.5rem;
            }
        }

        @media (max-width: 640px) {
            .order-wrapper {
                padding: 1rem;
            }

            .info-card__title,
            .summary-title,
            .items-title {
                font-size: 1.25rem;
            }

            .summary-list li {
                padding: 0.5rem;
                font-size: 1rem;
            }
        }
    </style>
</x-ecommerce-app-layout>
