<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.dash_head')
</head>
<body>
    <section class="no-padding-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="text-dark text-center bg-light p-4 shadow" style="border-radius: 5px;">
                        <h2 class="py-2">Customer Name: {{$data->name}}</h2>
                        <img src="products/{{$data->product->image}}" height="160px" width="auto" alt="Product Image">
                        <h5 class="py-2">Address: {{$data->rec_address}}</h5>
                        <h5 class="py-2">Phone: {{$data->phone}}</h5>
                        <h5 class="py-2">Product Name: {{$data->product->title}}</h5>
                        <h5 class="py-2">Product Quantity: {{$data->quantity}}</h5>
                        <h5 class="py-2">Product Price: ${{$data->selling_price}}</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript files-->
    @include('admin.dash_script')
</body>
</html>
