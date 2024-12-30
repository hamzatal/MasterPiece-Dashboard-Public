<x-ecommerce-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $category->name }}
        </h2>
    </x-slot>
    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title text-white mb-25">Category</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items"><a class="text-white" href="/home">Home</a></li>
                            <li class="breadcrumb__content--menu__items"><span class="text-white">Category</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->
    <section class="category-showcase">
  <div class="category-grid">
    @foreach($categories as $category)
    <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="category-item">
      <div class="category-circle">
        <img
          src="{{ Storage::url($category->image) }}"
          alt="{{ $category->name }}"
          class="category-image"
          onerror="this.src='/assets/img/categories/default.jpg'"
        >
      </div>
      <span class="category-name">{{ $category->name }}</span>
    </a>
    @endforeach
  </div>
</section>

</x-ecommerce-app-layout>
