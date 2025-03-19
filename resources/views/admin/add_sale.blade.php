<!DOCTYPE html>
<html>
<head>
    @include('admin.dash_head')
    <title>DEV POS - Add Sale</title>
    <style>
        input[type="text"] {
            border-radius: 5px;
        }

        .div_bg {
            background: #2d3035;
        }
    </style>
</head>
<body>
    <!-- Header -->
    @include('admin.dash_header')

    <div class="d-flex align-items-stretch">
    <!-- Sidebar Navigation-->
    @include('admin.dash_sidebar')
    <!-- Sidebar Navigation end-->
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h2 class="h5 no-margin-bottom">Sales / Add Sale</h2>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row my-4 mx-1">
                <div class="col-md-12">

                </div>
                <div class="col-md-12">
                    <div class="div_bg table-responsive p-3">
                        <div class="d-flex justify-content-between align-items-center py-4 px-5">
                            <h3 class="text-center mx-auto">Add Sale</h3>
                        </div>

                        <form action="{{ route('sales.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="customer_name">Customer Name</label>
                                    <input type="text" name="customer_name" id="customer_name" placeholder="Default: Walking Customer" class="form-control" style="border-radius: 0px">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter phone number (Optional)" style="border-radius: 0px">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="product_id">Product</label>
                                    <select name="product_id" id="product_id" class="form-control">
                                        <option value="">Select a product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="batch_no">Batch No</label>
                                    <select name="batch_no" id="batch_no" class="form-control" disabled>
                                        <option value="">Select a batch</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" min="1">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="selling_price">Selling Price</label>
                                    <input type="number" name="selling_price" id="selling_price" class="form-control">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="payment_method">Payment Method</label>
                                    <select name="payment_method" id="payment_method" class="form-control">
                                        <option value="">Select a method</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Card">Card</option>
                                        <option value="Mobile Banking">Mobile Banking</option>
                                    </select>
                                </div>

                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-outline-primary mt-3 mx-auto">Add Sale</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Sections -->
        @include('admin.dash_footer')

    </div>
    </div>

    <!-- Sweetalert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @include('admin.dash_script')
    <script>
        $(document).ready(function() {
            $('#product_id').change(function() {
                const productId = $(this).val();
                $('#batch_no').prop('disabled', true).html('<option value="">Loading...</option>');
                $('#selling_price').val('');  // Clear selling price field

                if (productId) {
                    $.ajax({
                        url: '{{ route("sales.get_batches") }}',
                        type: 'GET',
                        data: { product_id: productId },
                        success: function(data) {
                            let options = '<option value="">Select a batch</option>';
                            data.forEach(function(batch) {
                                options += `<option value="${batch.batch_no}" data-price="${batch.selling_price}">${batch.batch_no}</option>`;
                            });
                            $('#batch_no').html(options).prop('disabled', false);
                        }
                    });
                } else {
                    $('#batch_no').html('<option value="">Select a product first</option>').prop('disabled', true);
                }
            });

            $('#batch_no').change(function() {
                const selectedBatch = $(this).find(':selected');
                const sellingPrice = selectedBatch.data('price');
                $('#selling_price').val(sellingPrice ? sellingPrice : ''); // Set selling price, allowing manual edits
            });
        });
    </script>
</body>
</html>

