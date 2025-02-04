<!DOCTYPE html>
<html>

<head>
    @include('home.head')
    <title>Shop - Product Details</title>
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
                    @foreach ($categories as $category)
                    <a href="{{ url('category_details', $category->id) }}">
                        <li class="list-group-item">
                            {{$category->category_name}}
                        </li>
                    </a>
                    @endforeach
                </ul>
            </div>
            <!-- Products Column -->
            <div class="col-md-9">
                <div class="heading_container heading_center">
                    <h2>Product Details</h2>
                </div>
                <div class="card shadow" style="border: none;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="/products/{{$product->image  ?? 'no-image.png'}}" class="p-5 w-100 h-auto" alt="Product Image">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-5">
                                <h4 class="card-title">{{$product->title}}</h4>
                                <p class="card-text"><strong>Price:</strong> &#2547; {{ $product->sale_price ?? 'N/A' }}</p>
                                <p class="card-text">{{$product->description}}</p>
                                <p class="card-text"><strong>Category:</strong> {{$product->category}}</p>
                                <p class="card-text"><strong>Brand:</strong> {{$product->brand}}</p>
                                <p class="card-text"><strong>In stock:</strong> {{$product->total_quantity}} available</p>

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
