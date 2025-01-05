<!DOCTYPE html>
<html>

<head>
    @include('home.head')
    <title>Shop - Home</title>
    <style>

    </style>
</head>

<body>
    <div class="hero_area">
        <!-- header section strats -->
        @include('home.header_2')

        <!-- slider section -->
        @include('home.slider')
    </div>

    <!-- product section -->
    <section class="shop_section layout_padding">
        <div id="category_cont" class="container">
            <div class="heading_container heading_center py-4">
                <h2>Top Categories</h2>
            </div>
            <div class="row">
                @foreach ($category as $category)
                    @if ($category->highlight == "yes")
                        <div class="col-md-4 m-0 p-0">
                            <a href="{{ url('category_details', $category->id) }}" class="text-decoration-none">
                                <div class="category-card" style="background-image: url('{{ asset('uploads/'.$category->image) }}');">
                                    <div class="category-content">
                                        <div class="category-title">{{ $category->category_name }}</div>
                                        <div class="category-tags">{{ $category->category_tags }}</div>
                                        <div class="btn category-btn">Shop Now</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- aboutus section -->
    @include('home.about')

    <!-- Team section -->
    @include('home.team')

    <!-- testimonials section -->
    @include('home.testimony')

    <!-- footer section -->
    @include('home.footer')

    <!-- Code JS Files -->
    @include('home.script')

</body>

</html>
