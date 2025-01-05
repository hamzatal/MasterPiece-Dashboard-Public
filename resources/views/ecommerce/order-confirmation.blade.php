<x-ecommerce-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Orders') }}
        </h2>
    </x-slot>

    <main class="main__content_wrapper">
        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">My Orders</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="/home">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">My Orders</span></li>
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
                <div class="empty__orders">
                    <i class="fas fa-shopping-bag empty__icon"></i>
                    <h3>You have not placed any orders yet.</h3>
                    <a href="/shop" class="shop__now__btn">
                        <i class="fas fa-shopping-cart"></i>
                        Start Shopping
                    </a>
                </div>
                @else
                <div class="orders__grid">
                    @foreach($orders as $order)
                    <div class="order__card">
                        <div class="order__header">
                            <div class="order__number">
                                <i class="fas fa-box-open"></i>
                                <h4>Order #{{ $order->id }}</h4>
                            </div>
                            <div class="order__meta">
                                <span class="order__date">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ $order->created_at->format('M d, Y') }}
                                </span>
                                <span class="order__status status--{{ $order->status }}">
                                    <i class="fas fa-circle"></i>
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="order__content">
                            <h5 class="items__title">
                                <i class="fas fa-shopping-basket"></i>
                                Order Items
                            </h5>
                            <ul class="items__list">
                                @foreach($order->items as $item)
                                <li class="item">
                                    <i class="fas fa-check"></i>
                                    <span class="item__name">{{ $item->product->name ?? 'Product not found' }}</span>
                                    <span class="item__quantity">x{{ $item->quantity }}</span>
                                    <span class="item__color">Color: {{ $item->color ?? 'N/A' }}</span>
                                    <span class="item__size">Size: {{ $item->size ?? 'N/A' }}</span>
                                    <span class="item__price">JD {{ number_format($item->price * $item->quantity, 2) }}</span>
                                </li>
                                @endforeach
                            </ul>
                            <div class="order__total">
                                <i class="fas fa-receipt"></i>
                                <span>Total:</span>
                                <strong>JD {{ number_format($order->total_price, 2) }}</strong>
                            </div>
                        </div>

                        <div class="order__footer">
                            <a href="{{ route('site.orders.show', $order->id) }}" class="details__btn">
                                <i class="fas fa-eye"></i>
                                View Details
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Pagination Links -->
                <div class="pagination">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>
        </section>

        <style>
            /* Modern CSS Reset */
            *,
            *::before,
            *::after {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            /* Variables */
            :root {
                --primary-color: #4f46e5;
                --primary-hover: #4338ca;
                --success-color: #10b981;
                --warning-color: #f59e0b;
                --info-color: #3b82f6;
                --text-primary: #1f2937;
                --text-secondary: #4b5563;
                --background-light: #ffffff;
                --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                --transition: all 0.3s ease;
            }

            /* Orders Grid */
            .orders__grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 2rem;
                padding: 1rem;
            }

            /* Order Card */
            .order__card {
                background: var(--background-light);
                border-radius: 1rem;
                box-shadow: var(--card-shadow);
                transition: var(--transition);
                overflow: hidden;
            }

            /* Pagination Styles */
            .pagination {
                margin-top: 2rem;
                display: flex;
                justify-content: center;
                gap: 0.5rem;
            }

            .pagination .page-item {
                list-style: none;
            }

            .pagination .page-link {
                padding: 0.5rem 1rem;
                background: var(--background-light);
                border: 1px solid #e5e7eb;
                border-radius: 0.5rem;
                color: var(--text-primary);
                text-decoration: none;
                transition: var(--transition);
            }

            .pagination .page-link:hover {
                background: var(--primary-color);
                color: white;
                border-color: var(--primary-color);
            }

            .pagination .page-item.active .page-link {
                background: var(--primary-color);
                color: white;
                border-color: var(--primary-color);
            }

            .order__card:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            }

            /* Order Header */
            .order__header {
                padding: 1.5rem;
                border-bottom: 1px solid #e5e7eb;
                background: linear-gradient(145deg, #f9fafb, #f3f4f6);
            }

            .order__number {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                margin-bottom: 1rem;
            }

            .order__number h4 {
                font-size: 1.25rem;
                color: var(--text-primary);
                font-weight: 600;
            }

            .order__meta {
                display: flex;
                justify-content: space-between;
                align-items: center;
                color: var(--text-secondary);
                font-size: 0.875rem;
            }

            /* Status Badges */
            .order__status {
                padding: 0.25rem 0.75rem;
                border-radius: 9999px;
                font-size: 0.875rem;
                font-weight: 500;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .status--delivered {
                background-color: rgba(16, 185, 129, 0.1);
                color: var(--success-color);
            }

            .status--processing {
                background-color: rgba(59, 130, 246, 0.1);
                color: var(--info-color);
            }

            .status--pending {
                background-color: rgba(245, 158, 11, 0.1);
                color: var(--warning-color);
            }

            /* Order Content */
            .order__content {
                padding: 1.5rem;
            }

            .items__title {
                font-size: 1rem;
                color: var(--text-primary);
                margin-bottom: 1rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .items__list {
                list-style: none;
            }

            .item {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.75rem 0;
                border-bottom: 1px solid #e5e7eb;
                color: var(--text-secondary);
            }

            .item__name {
                flex: 1;
            }

            .item__quantity {
                color: var(--text-primary);
                font-weight: 500;
            }

            .item__price {
                font-weight: 600;
                color: var(--primary-color);
            }

            .order__total {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                margin-top: 1.5rem;
                padding-top: 1rem;
                border-top: 1px solid #e5e7eb;
                font-size: 1.125rem;
                color: var(--text-primary);
            }

            /* Order Footer */
            .order__footer {
                padding: 1.5rem;
                background: linear-gradient(145deg, #f9fafb, #f3f4f6);
                border-top: 1px solid #e5e7eb;
            }

            .details__btn {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                width: 100%;
                padding: 0.75rem;
                background: var(--primary-color);
                color: white;
                border: none;
                border-radius: 0.5rem;
                font-weight: 500;
                text-decoration: none;
                transition: var(--transition);
            }

            .details__btn:hover {
                background: var(--primary-hover);
            }

            /* Empty Orders */
            .empty__orders {
                text-align: center;
                padding: 4rem 2rem;
            }

            .empty__icon {
                font-size: 4rem;
                color: var(--text-secondary);
                margin-bottom: 1.5rem;
            }

            .shop__now__btn {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.75rem 1.5rem;
                background: var(--primary-color);
                color: white;
                text-decoration: none;
                border-radius: 0.5rem;
                margin-top: 1.5rem;
                transition: var(--transition);
            }

            .shop__now__btn:hover {
                background: var(--primary-hover);
            }

            /* Pagination */
            .pagination {
                margin-top: 2rem;
                display: flex;
                justify-content: center;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .breadcrumb__title {
                    font-size: 2rem;
                }

                .orders__grid {
                    grid-template-columns: 1fr;
                }

                .order__meta {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 0.5rem;
                }
            }
        </style>

    </main>
</x-ecommerce-app-layout>