<!DOCTYPE html>
<html>

<head>
    @include('home.head')
    <title>Shop - Category Details</title>
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
    @include('home.header_2')
  </div>

  <!-- Product details section start -->
  <section class="shop_section">
    <div class="container my-4">
        <div class="row">
            <!-- Category-Price Filter Navigation -->
            <div class="col-md-3">
                <!-- Sticky Container for Category Nav and Filter -->
                <div class="sticky-nav-wrapper sticky-nav">
                    <!-- Category Navigation -->
                    <div class="text-center mb-4 mt-3">
                        <h4 style="color: #007bff">Categories</h4>
                    </div>
                    <ul class="category-nav list-group">
                        @foreach ($category_all as $category)
                        <a href="{{ url('category_details', $category->id) }}">
                            <li class="list-group-item">
                                {{$category->category_name}}
                            </li>
                        </a>
                        @endforeach
                    </ul>

                    <!-- Price Filter Section -->
                    <div class="filter-nav mt-4">
                        <div class="text-center mb-3">
                            <h5>Filter By Price</h5>
                        </div>
                        <div class="filter-group mb-3">
                            <h6>Price Range (৳)</h6>
                            <input type="number" class="form-control mb-2" id="min-price" placeholder="Min Price">
                            <input type="number" class="form-control mb-2" id="max-price" placeholder="Max Price">
                        </div>
                        <button class="btn btn-primary w-100" id="apply-price-filter">Apply Filter</button>
                    </div>
                </div>
                <script>
                    document.getElementById('apply-price-filter').addEventListener('click', function() {
                        const minPrice = document.getElementById('min-price').value;
                        const maxPrice = document.getElementById('max-price').value;

                        // Redirect to shop page with price filter parameters
                        const url = new URL(window.location.href);
                        url.searchParams.set('min_price', minPrice);
                        url.searchParams.set('max_price', maxPrice);

                        window.location.href = url.toString();
                    });
                </script>
            </div>

            <!-- Products Column -->
            <div class="col-md-9">
                <div class="heading_container heading_center">
                    <h2>{{$categories->category_name}} Details</h2>
                </div>
                <div class="row mb-5">
                    @foreach ($products as $product)
                        @if($categories->category_name == $product->category)
                        <div class="col-lg-3 col-md-4 m-0 p-0">
                            <div class="card product-card text-center p-4">
                                <a href="{{ url('product_details', $product->id) }}"
                                    class="text-decoration-none text-dark">
                                    <div class="img-box mx-auto mb-3">
                                        <img src="/products/{{ $product->image  ?? 'no-image.png'}}"
                                            class="product-image">
                                    </div>
                                    <div class="detail-box">
                                        <h6>{{ $product->title }}</h6>
                                        <h6>
                                            <span>&#2547; {{ $product->sale_price ?? 'N/A' }}</span>
                                            <!-- Selling price from inventory -->
                                        </h6>
                                    </div>
                                </a>
                                @if($product->isNew)
                                    <div class="badge new-badge">
                                        <span>New</span>
                                    </div>
                                @endif
                                <div class="mt-3">
                                    @if ($product->total_quantity == 0)
                                        <p class="text-danger my-2">Out Of Stock</p>
                                    @elseif ($product->total_quantity > 0)
                                        <p class="text-primary my-2">{{ $product->total_quantity }} In Stock</p>
                                        @if (!(Auth::check() && Auth::user()->usertype === 'admin'))
                                            <a href="{{ url('add_cart', $product->id) }}" class="btn btn-outline-primary btn-sm my-1">
                                                Add to cart
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
                {{-- Pagination --}}
                <div class="pagination-container">
                    <div class="pagination-info">
                        @if ($products->total() > 0)
                            Showing
                            {{ $products->firstItem() }}
                            to
                            {{ $products->lastItem() }}
                            of
                            {{ $products->total() }}
                            products
                        @else
                            No products available.
                        @endif
                    </div>

                    <div class="pagination-wrapper">
                        <ul class="pagination">
                            <!-- First Page Button -->
                            <li class="{{ $products->onFirstPage() ? 'disabled' : '' }}">
                                <a href="{{ $products->url(1) }}"><<</a>
                            </li>

                            <!-- Previous Page Button -->
                            <li class="{{ $products->previousPageUrl() ? '' : 'disabled' }}">
                                <a href="{{ $products->previousPageUrl() }}"><</a>
                            </li>

                            <!-- Page Number Links -->
                            @php
                                $currentPage = $products->currentPage();
                                $lastPage = $products->lastPage();
                            @endphp

                            @for ($page = 1; $page <= $lastPage; $page++)
                                @if ($page == 1 || $page == $lastPage || ($page >= $currentPage - 2 && $page <= $currentPage + 2))
                                    <li class="{{ $page == $currentPage ? 'active' : '' }}">
                                        <a href="{{ $products->url($page) }}">{{ $page }}</a>
                                    </li>
                                @elseif ($page == 2 && $currentPage > 4)
                                    <li class="disabled"><span>...</span></li>
                                @elseif ($page == $lastPage - 1 && $currentPage < $lastPage - 3)
                                    <li class="disabled"><span>...</span></li>
                                @endif
                            @endfor

                            <!-- Next Page Button -->
                            <li class="{{ $products->nextPageUrl() ? '' : 'disabled' }}">
                                <a href="{{ $products->nextPageUrl() }}">></a>
                            </li>

                            <!-- Last Page Button -->
                            <li class="{{ $products->hasMorePages() ? '' : 'disabled' }}">
                                <a href="{{ $products->url($lastPage) }}">>></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
  </section>
  <!-- Product details section end -->


  <!-- footer section -->
  @include('home.footer')

  <!-- Code JS Files -->
  @include('home.script')

</body>

</html>
