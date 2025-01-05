<!DOCTYPE html>
<html>

<head>
    @include('home.head')
    <title>Shop - Search-results</title>
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
            <!-- Category Column with Navigation -->
            <div class="col-md-3">
                <div class="text-center mb-4 mt-3">
                    <h4 style="color: #007bff">Categories</h4>
                </div>
                <ul class="category-nav list-group sticky-nav">
                    @foreach ($category_all as $category_all)
                    <a href="{{ url('category_details', $category_all->id) }}">
                        <li class="list-group-item">
                            {{$category_all->category_name}}
                        </li>
                    </a>
                    @endforeach
                </ul>
            </div>
            <!-- Products Column -->
            <div class="col-md-9">
                <div class="heading_container heading_center">
                    <h2>Search Results</h2>
                </div>
                <div class="row mb-3">
                    @if ($message)
                        <div class="alert alert-warning mx-auto">
                            {{ $message }}
                        </div>
                    @endif
                    @foreach ($products as $product)
                        <div class="col-lg-3 col-md-4 m-0 p-0">
                            <div class="card product-card text-center p-4">
                                <a href="{{ url('product_details', $product->id) }}" class="text-decoration-none text-dark">
                                    <div class="img-box mx-auto mb-3">
                                        <img src="{{ asset('products/' . $product->image) }}" alt="{{ $product->title }}" class="product-image">
                                    </div>
                                    <div class="detail-box">
                                        <h6>{{ $product->title }}</h6>
                                        <h6>
                                            <span>&#2547; {{ $product->selling_price ?? 'N/A' }}</span> <!-- Selling price from inventory -->
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
                                    @else
                                        <a href="{{ url('add_cart', $product->id) }}"
                                        class="btn btn-outline-primary btn-sm my-1 {{ Auth::check() && Auth::user()->usertype === 'admin' ? 'd-none' : '' }}">
                                            Add to cart
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center">
                    <div class="d-flex justify-content-center">
                        {{ $products->links() }}
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
