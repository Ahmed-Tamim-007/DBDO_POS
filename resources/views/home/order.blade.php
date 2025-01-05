<!DOCTYPE html>
<html>

<head>
    @include('home.head')
    <title>Shop - My Orders</title>
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
                            Your Order History
                            </h2>
                        </div>
                    </div>
                    <div class="card shadow p-4 table-responsive text-center">
                        <table class="datatable table table-hover">
                            <thead>
                              <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Category</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Delivery Status</th>
                                <th scope="col">Image</th>
                                <th scope="col">Order Date</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($order as $order)
                                <tr>
                                    <th>{{$loop->iteration}}</th>
                                    <th>{{$order->product->title}}</th>
                                    <td>&#2547; {{$order->selling_price}}</td>
                                    <td>{{$order->product->category}}</td>
                                    <td>{{$order->quantity}}</td>
                                    <td>{{$order->status}}</td>
                                    <td><img src="/products/{{$order->product->image}}" width="auto" height="80px" alt="Product Image"></td>
                                    <td>{{$order->created_at}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
