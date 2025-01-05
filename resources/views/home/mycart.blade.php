<!DOCTYPE html>
<html>

<head>
    @include('home.head')
    <title>Shop - My Cart</title>
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
    @include('home.header_2')
  </div>

    <!-- View cart section start -->
    <section>
        <div class="my-4" style="padding: 0 45px;">
            <div class="row">
                <div class="col-lg-7 col-md-12">
                    <div class="container px-0 py-4">
                        <div class="heading_container ">
                            <h2 class="text-center">
                                Your Added Carts
                            </h2>
                        </div>
                    </div>
                    <div class="card shadow p-4 table-responsive text-center">
                        <?php $value = 0; ?>
                        <table class="table table-hover">
                            <thead>
                              <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Image</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                @php $totalValue = 0; @endphp
                                @foreach ($cart as $cartItem)
                                    <tr>
                                        <!-- Display the Product Title -->
                                        <th>{{ $cartItem->product->title }}</th>

                                        <!-- Display the Selling Price from Inventory -->
                                        <td>&#2547; {{ $cartItem->selling_price }}</td>

                                        <!-- Display Product Image -->
                                        <td>
                                            <img src="/products/{{ $cartItem->product->image }}" width="auto" height="80px" alt="Product Image">
                                        </td>

                                        <!-- Quantity Controls -->
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center">
                                                <!-- Decrement Quantity Button -->
                                                <form action="{{ url('decrement_quantity', $cartItem->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-warning btn-sm"
                                                            {{ $cartItem->quantity <= 1 ? 'disabled' : '' }}>-</button>
                                                </form>

                                                <!-- Display Current Quantity -->
                                                <span class="px-3">{{ $cartItem->quantity }}</span>

                                                <!-- Increment Quantity Button -->
                                                <form action="{{ url('increment_quantity', $cartItem->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success btn-sm"
                                                            {{ $cartItem->quantity >= $cartItem->total_quantity ? 'disabled' : '' }}>+</button>
                                                </form>
                                            </div>
                                        </td>

                                        <!-- Remove Button -->
                                        <td>
                                            <a href="{{ url('remove_cart', $cartItem->id) }}" class="btn btn-danger">Remove</a>
                                        </td>
                                    </tr>

                                    <!-- Calculate total value for the cart -->
                                    @php
                                        $totalValue += $cartItem->selling_price * $cartItem->quantity;
                                    @endphp
                                @endforeach

                                <!-- Display the Total Value at the end -->
                                <tr>
                                    <td colspan="5" class="text-right">
                                        <strong>Total: &#2547; {{ $totalValue }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12">
                    <div class="container px-0 py-4">
                        <div class="heading_container ">
                            <h2 class="text-center">
                                Order Product
                            </h2>
                        </div>
                    </div>
                    <div class="card shadow p-4">
                        <form action="{{url('confirm_order')}}" method="POST" class="py-2 px-4" onsubmit="confirmation(event)">
                            @csrf
                            <div class="mb-4">
                                <label>Reciever Name</label>
                                <input type="text" class="form-control" name="name" value="{{Auth::user()->name}}">
                            </div>
                            <div class="mb-4">
                                <label>Address</label>
                                <input type="text" class="form-control" name="address" value="{{Auth::user()->address}}">
                            </div>
                            <div class="mb-4">
                                <label>Phone</label>
                                <input type="text" class="form-control" name="phone" value="{{Auth::user()->phone}}">
                            </div>
                            <div class="mb-4">
                              <input type="submit" class="btn btn-primary" value="Cash on delivery">
                              <a href="{{url('stripe', $value)}}" class="btn btn-warning">Pay using cards</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- View cart section end -->


  <!-- footer section -->
  @include('home.footer')

    <!-- Order confirmation JS -->
    <script type="text/javascript">
        function confirmation(ev) {
            ev.preventDefault();

            swal({
                title: "Are you sure to order these products?",
                text: "You cannot revert this choice!",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then((willConfirm) => {
                if (willConfirm) {
                    ev.target.submit();
                }
            });
        }
    </script>

  <!-- Code JS Files -->
  @include('home.script')

</body>

</html>
