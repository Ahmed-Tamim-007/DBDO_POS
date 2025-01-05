<!DOCTYPE html>
<html>

<head>
    @include('home.head')
    <title>Shop - My Review</title>
</head>

<body>
    <div class="hero_area">
        <!-- header section strats -->
        @include('home.header_2')
    </div>

    <!-- View cart section start -->
    <section>
        <div class="container my-4">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="container px-0 py-4">
                        <div class="heading_container ">
                            <h2 class="text-center">
                                Review Us!
                            </h2>
                        </div>
                    </div>
                    <div class="card shadow p-4">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- View cart section end -->


    <!-- footer section -->
    @include('home.footer')

    <!-- Code JS Files -->
    @include('home.script')

</body>

</html>
