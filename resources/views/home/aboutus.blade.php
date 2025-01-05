<!DOCTYPE html>
<html>

<head>
    @include('home.head')
    <title>Shop - About Us</title>
</head>

<body>
    <div class="hero_area">
        <!-- header section strats -->
        @include('home.header_2')
    </div>

    <!-- About us section -->
    <section class="pt-5 my-4">
        <div class="container px-0">
            <div class="heading_container ">
                <h2 class="text-center">
                About Us
                </h2>
            </div>
        </div>
        <div class="container py-5">
            <div class="row align-items-center">
                <!-- Text Section -->
                <div class="col-md-7">
                    <p class="lead" style="font-size: 1.2rem; color: #555;">
                        Welcome to <strong style="color: #019bee">Shop</strong>, where passion meets quality. For over <strong style="color: #019bee">7</strong>,
                        we have been committed to providing our customers with the finest <em>products and services</em>.
                        Our mission is to offer an exceptional shopping experience that inspires and delights every visitor.
                    </p>
                    <p style="font-size: 1.1rem; line-height: 1.8; color: #666;">
                        Whether you're looking for specific product, or seeking services,
                        we take pride in being a trusted destination for <strong style="color: #019bee">E-Commerce</strong>.
                        Your satisfaction is our priority, and we are constantly striving to bring you the best.
                    </p>
                    <p style="font-size: 1.1rem; font-style: italic; color: #777;">
                        Thank you for choosing us. We look forward to serving you for many more years to come!
                    </p>
                </div>
                <!-- Image Section -->
                <div class="col-md-5">
                    <img src="{{asset('images/pet-10.jpg')}}" alt="About Our Shop" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </section>

    <!-- Team section -->
    @include('home.team')

    <!-- Why Us section -->
    @include('home.about')


    <!-- footer section -->
    @include('home.footer')

    <!-- Code JS Files -->
    @include('home.script')
</body>

</html>
