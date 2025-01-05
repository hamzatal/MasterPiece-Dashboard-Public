<x-ecommerce-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Info') }}
        </h2>
    </x-slot>

    <main class="main__content_wrapper">
        <!-- Breadcrumb Section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Order Details</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="/home">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Order Details</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Order Details Section -->
        <section class="order-details section--padding">
            <div class="container">
                @if(isset($order))
                <div class="order-wrapper">
                    <div class="row">
                        <!-- Order Details -->
                        <div class="col-lg-8">
                            <div class="info-card">
                                <h3 class="info-card__title">
                                    <i class="fas fa-box-open"></i>
                                    Order #{{ $order->id }}
                                </h3>
                                <ul class="info-list">
                                    <li>
                                        <div class="info-icon">
                                            <i class="far fa-calendar-alt"></i>
                                        </div>
                                        <div class="info-content">
                                            <span>Order Date</span>
                                            <strong>{{ $order->created_at->format('d M, Y') }}</strong>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="info-icon">
                                            <i class="fas fa-circle-check"></i>
                                        </div>
                                        <div class="info-content">
                                            <span>Status</span>
                                            <span class="status-badge status--{{ $order->status }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="info-icon">
                                            <i class="fas fa-dollar-sign"></i>
                                        </div>
                                        <div class="info-content">
                                            <span>Total Amount</span>
                                            <strong>JD {{ number_format($order->total_price, 2) }}</strong>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="info-icon">
                                            <i class="fas fa-credit-card"></i>
                                        </div>
                                        <div class="info-content">
                                            <span>Payment Method</span>
                                            <strong>{{ ucfirst($order->payment_method) }}</strong>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="info-card mt-4">
                                <h4 class="info-card__title">
                                    <i class="fas fa-truck"></i>
                                    Shipping Address
                                </h4>
                                @if($order->shippingAddress)
                                <address class="shipping-address">

                                    <div class="address-content">
                                        <p class="name">{{ $order->shippingAddress->name }}</p>
                                        <p>Street Address: {{ $order->shippingAddress->street_address }}</p>
                                        <p>City: {{ $order->shippingAddress->city }}</p>
                                        <p>Country: {{ $order->shippingAddress->country }}</p>
                                    </div>
                                </address>
                                @else
                                <p class="no-address">No shipping address available.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="col-lg-4">
                            <div class="order-summary">
                                <div class="section-header">
                                    <i class="fas fa-shopping-cart"></i>
                                    <h3>Order Summary</h3>
                                </div>
                                <div class="order-table">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->items as $item)
                                            <tr>
                                                <td>{{ $item->product->name ?? 'Product not found' }}</td>
                                                <td>{{ $item->color ?? 'N/A' }}</td>
                                                <td>{{ $item->size ?? 'N/A' }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>JD {{ number_format($item->price, 2) }}</td>
                                                <td>JD {{ number_format($item->quantity * $item->price, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="totals">
                                    <div class="total-row">
                                        <span>Subtotal:</span>
                                        <span>JD {{ number_format($subtotal, 2) }}</span>
                                    </div>
                                    <div class="total-row">
                                        <span>Discount:</span>
                                        <span>JD {{ number_format($discount, 2) }}</span>
                                    </div>
                                    <div class="total-row grand-total">
                                        <span>Total:</span>
                                        <span>JD {{ number_format($total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="empty-cart text-center">
                    <div class="empty-cart-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16" width="64" height="64">
                            <path d="M0 1a1 1 0 0 1 1-1h2.5a1 1 0 0 1 .96.74L5.58 4H14a1 1 0 0 1 .92 1.39l-1.5 3a1 1 0 0 1-.92.61H6.26l-.2 1H14.5a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.48-.36L4.01 5H1.5a.5.5 0 0 1 0-1h2.22l.9-3H1a1 1 0 0 1-1-1z" />
                            <path d="M7 13.5A1.5 1.5 0 1 0 8.5 15 1.5 1.5 0 0 0 7 13.5zm-3 0A1.5 1.5 0 1 0 5.5 15 1.5 1.5 0 0 0 4 13.5z" />
                        </svg>
                    </div>
                    <h3 class="empty-cart-title">No order found</h3>
                    <p class="empty-cart-message">It looks like you haven't placed any orders yet.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary">
                        Continue Shopping
                    </a>
                </div>
                @endif
            </div>
        </section>

        <style>
            :root {
                --primary: #4f46e5;
                --primary-light: #818cf8;
                --primary-dark: #3730a3;
                --primary-gradient: linear-gradient(145deg, var(--primary), var(--primary-dark));
                --success: #10b981;
                --warning: #f59e0b;
                --info: #3b82f6;
                --surface: #ffffff;
                --surface-hover: #f8fafc;
                --text-primary: #1e293b;
                --text-secondary: #64748b;
                --border: #e2e8f0;
                --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
                --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
                --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
                --radius-sm: 0.5rem;
                --radius: 1rem;
                --radius-lg: 1.5rem;
            }

            body {
                background-color: #f8fafc;
                color: var(--text-primary);
                line-height: 1.6;
            }

            .order-details {
                padding: 2rem 0;
            }

            .order-wrapper {
                background: var(--surface);
                border-radius: var(--radius-lg);
                box-shadow: var(--shadow-lg);
                padding: 2.5rem;
                margin-top: 2rem;
            }

            .info-card {
                background: var(--surface);
                border-radius: var(--radius);
                padding: 2rem;
                box-shadow: var(--shadow);
                border: 1px solid var(--border);
                transition: all 0.3s ease;
            }

            .info-card:hover {
                transform: translateY(-4px);
                box-shadow: var(--shadow-lg);
            }

            .info-card__title {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--text-primary);
                display: flex;
                align-items: center;
                gap: 1rem;
                margin-bottom: 2rem;
            }

            .info-card__title i {
                color: var(--primary);
                font-size: 1.75rem;
                background: var(--primary-light);
                background-clip: text;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .info-list {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            .info-list li {
                display: flex;
                align-items: center;
                gap: 1.5rem;
                padding: 1rem;
                background: var(--surface-hover);
                border-radius: var(--radius-sm);
                border: 1px solid var(--border);
                transition: all 0.2s ease;
            }

            .info-list li:hover {
                background: var(--surface);
                box-shadow: var(--shadow);
            }

            .info-icon {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 3rem;
                height: 3rem;
                background: var(--primary-gradient);
                border-radius: var(--radius-sm);
                color: white;
                font-size: 1.25rem;
            }

            .info-content {
                flex: 1;
                display: flex;
                flex-direction: column;
                gap: 0.25rem;
            }

            .info-content span {
                color: var(--text-secondary);
                font-size: 0.875rem;
            }

            .info-content strong {
                color: var(--text-primary);
                font-weight: 600;
                font-size: 1.125rem;
            }

            .status-badge {
                display: inline-flex;
                align-items: center;
                padding: 0.5rem 1rem;
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
                display: flex;
                gap: 1.5rem;
                color: var(--text-secondary);
                line-height: 1.8;
                background: var(--surface-hover);
                padding: 1.5rem;
                border-radius: var(--radius-sm);
                border: 1px solid var(--border);
            }

            .address-icon {
                display: flex;
                align-items: flex-start;
                justify-content: center;
                width: 3rem;
                height: 3rem;
                background: var(--primary-gradient);
                border-radius: var(--radius-sm);
                color: white;
                font-size: 1.25rem;
                padding-top: 0.75rem;
            }

            .address-content .name {
                font-weight: 700;
                color: var(--text-primary);
                font-size: 1.1rem;
                margin-bottom: 0.5rem;
            }


            .discount {
                color: #a7f3d0;
            }

            .order-items {
                margin-top: 3rem;
                padding-top: 2rem;
                border-top: 2px solid var(--border);
            }

            .items-title {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--text-primary);
                display: flex;
                align-items: center;
                gap: 1rem;
                margin-bottom: 2rem;
            }

            .items-title i {
                color: var(--primary);
                background: var(--primary-gradient);
                background-clip: text;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .items-table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0 0.75rem;
            }

            .items-table th {
                background: var(--surface-hover);
                padding: 1.25rem 1rem;
                text-align: left;
                font-weight: 600;
                color: var(--text-secondary);
                text-transform: uppercase;
                font-size: 0.875rem;
                letter-spacing: 0.05em;
                border-radius: var(--radius-sm);
            }

            .items-table td {
                padding: 1.25rem 1rem;
                color: var(--text-secondary);
                background: var(--surface);
                border: 1px solid var(--border);
                transition: all 0.2s ease;
            }

            .items-table tr td:first-child {
                border-radius: var(--radius-sm) 0 0 var(--radius-sm);
            }

            .items-table tr td:last-child {
                border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
            }

            .items-table tr:hover td {
                background: var(--surface-hover);
                transform: translateY(-2px);
                box-shadow: var(--shadow-sm);
            }

            .product-info {
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .product-icon {
                width: 2.5rem;
                height: 2.5rem;
                display: flex;
                align-items: center;
                justify-content: center;
                background: var(--primary-gradient);
                color: white;
                border-radius: var(--radius-sm);
                font-size: 1rem;
            }

            .quantity-badge {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 2.5rem;
                height: 2.5rem;
                background: var(--surface-hover);
                border: 1px solid var(--border);
                border-radius: var(--radius-sm);
                font-weight: 600;
                color: var(--text-primary);
            }

            .total-price {
                font-weight: 600;
                color: var(--text-primary);
            }

            .empty-state {
                text-align: center;
                padding: 5rem 2rem;
                background: var(--surface);
                border-radius: var(--radius);
                box-shadow: var(--shadow);
            }

            .empty-state i {
                font-size: 4rem;
                background: var(--primary-gradient);
                background-clip: text;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                margin-bottom: 1.5rem;
            }

            .empty-state p {
                font-size: 1.25rem;
                color: var(--text-secondary);
            }

            /* Animations */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .order-wrapper {
                animation: fadeIn 0.5s ease-out;
            }

            /* Responsive Styles */
            @media (max-width: 1024px) {
                .order-wrapper {
                    padding: 2rem;
                }

                .info-card,
                .order-summary {
                    padding: 1.75rem;
                }
            }

            @media (max-width: 768px) {
                .order-wrapper {
                    padding: 1.5rem;
                    margin-top: 1rem;
                }

                .info-card,
                .order-summary {
                    padding: 1.5rem;
                }

                .info-card__title,
                .summary-title,
                .items-title {
                    font-size: 1.25rem;
                }

                .info-icon,
                .address-icon {
                    width: 2.5rem;
                    height: 2.5rem;
                    font-size: 1rem;
                }

                .info-list li {
                    padding: 0.75rem;
                }

                .shipping-address {
                    padding: 1.25rem;
                }

                .table-responsive {
                    margin: 0 -1.5rem;
                    padding: 0 1.5rem;
                    overflow-x: auto;
                }

                .items-table {
                    min-width: 600px;
                }
            }

            @media (max-width: 640px) {
                .order-wrapper {
                    padding: 1rem;
                }

                .info-card,
                .order-summary {
                    padding: 1.25rem;
                }

                .info-list li {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 0.75rem;
                }

                .info-content {
                    width: 100%;
                }

                .shipping-address {
                    flex-direction: column;
                    gap: 1rem;
                }

                .summary-item {
                    padding: 0.75rem;
                    font-size: 0.875rem;
                }

                .total .summary-item {
                    padding: 1rem;
                    font-size: 1.125rem;
                }

                .status-badge {
                    padding: 0.375rem 0.75rem;
                    font-size: 0.75rem;
                }
            }

            /* Print Styles */
            @media print {
                .order-wrapper {
                    box-shadow: none;
                    margin: 0;
                    padding: 0;
                }

                .info-card,
                .order-summary,
                .shipping-address {
                    box-shadow: none;
                    border: 1px solid #ddd;
                }

                .info-icon,
                .address-icon,
                .product-icon {
                    print-color-adjust: exact;
                    -webkit-print-color-adjust: exact;
                }
            }
        </style>
</x-ecommerce-app-layout>