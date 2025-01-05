<!DOCTYPE html>
<html>
<head>
    @include('admin.dash_head')
    <title>Admin - POS</title>
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
                <h2 class="h5 no-margin-bottom">Sales / POS</h2>
            </div>
        </div>
        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block table-responsive" style="min-height: 500px">
                            <div class="row p-3">
                                <div class="col-lg-8 col-md-6">
                                    <h3 class="">POS Table</h3>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <!-- Search Form -->
                                    <form action="{{ route('product.search') }}" method="GET">
                                        <div class="input-group position-relative">
                                            <input type="text" id="search-input" name="query" class="form-control" placeholder="Search product name/category/brand" autocomplete="off">
                                            <!-- Search Results Dropdown -->
                                            <div id="search-results" class="list-group position-absolute w-100" style="display: none;"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <table class="table table-hover table-striped">
                                <thead>
                                  <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Batch No</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Sub Total</th>
                                    <th scope="col">Remove</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @php $totalValue = 0; @endphp
                                    @foreach ($p_o_s as $posItem)
                                        <tr>
                                            <th>{{ $posItem->product->title }} <br> <span style="font-size: 13px">In Stock: {{ $posItem->total_quantity }}</span></th>
                                            <td>&#2547; {{ $posItem->selling_price }}</td>
                                            <td>{{ $posItem->batch_no }}</td>
                                            <td>
                                                <div class="d-flex justify-content-left align-items-center">
                                                    <!-- Decrement Quantity Button -->
                                                    <form action="{{ url('pos_decrement_quantity', $posItem->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-warning btn-sm"
                                                                {{ $posItem->quantity <= 1 ? 'disabled' : '' }}>
                                                                -
                                                        </button>
                                                    </form>

                                                    <!-- Display Current Quantity -->
                                                    <span class="px-3">{{ $posItem->quantity }}</span>

                                                    <!-- Increment Quantity Button -->
                                                    <form action="{{ url('pos_increment_quantity', $posItem->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success btn-sm"
                                                                {{ $posItem->quantity >= $posItem->total_quantity ? 'disabled' : '' }}>
                                                                +
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td>&#2547; {{ $posItem->selling_price * $posItem->quantity }}</td>
                                            <td>
                                                <a href="{{ url('remove_pos', $posItem->id) }}" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>

                                        @php
                                            $totalValue += $posItem->selling_price * $posItem->quantity;
                                        @endphp
                                    @endforeach

                                    <!-- Display the Total Value at the end -->
                                    <tr>
                                        <td colspan="6" class="text-right">
                                            <strong>Total: &#2547; <span id="totalValueDisplay">{{ $totalValue }}</span></strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-left my-2">
                                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#cashModal"><i class="fas fa-money-bill-wave"></i> Cash</button>
                                <button class="btn btn-outline-warning" data-toggle="modal" data-target="#editModal"><i class="fas fa-credit-card"></i> Card</button>
                                <button class="btn btn-outline-danger" data-toggle="modal" data-target="#editModal"><i class="fas fa-times"></i> Cancel</button>
                            </div>
                            <!-- Cash Modal -->
                            <div class="modal fade" id="cashModal" tabindex="-1" role="dialog" aria-labelledby="cashModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{url('confirm_payment')}}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Finalize Payment</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-left">
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label">Customer Name</label>
                                                        <input type="text" class="form-control py-2 px-3 mx-auto" name="customer_name" placeholder="Default: Walking Customer">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Total Amount</label>
                                                        <input type="number" class="form-control py-2 px-3 mx-auto" id="totalAmount" name="total_amount" readonly>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Paid Amount</label>
                                                        <input type="number" class="form-control py-2 px-3 mx-auto" id="paidAmount" name="paid_amount">
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label">Payment Note</label>
                                                        <textarea class="form-control py-2 px-3 mx-auto" name="payment_note" rows="3" placeholder="Write a payment note!"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-outline-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer Sections -->
        @include('admin.dash_footer')

    </div>
    </div>

    @include('admin.dash_script')
    <!-- JavaScript for Live Search -->
    <script>
        $(document).ready(function () {
            $('#search-input').on('keyup', function () {
                let query = $(this).val();

                if (query.length > 0) {
                    $.ajax({
                        url: "{{ route('product.search') }}",
                        type: "GET",
                        data: { query: query },
                        success: function (data) {
                            let searchResults = $('#search-results');
                            searchResults.empty().show(); // Clear and show the results container

                            if (data.length === 0) {
                                searchResults.append('<p class="list-group-item">No products found.</p>');
                            } else {
                                data.forEach(product => {
                                    searchResults.append(`
                                        <a href="/add_pos/${product.id}" class="list-group-item list-group-item-action">
                                            ${product.title} - ${product.category} <span>(In Stock: ${product.total_quantity}, Batch No: ${product.batch_no})</span>
                                        </a>
                                    `);
                                });
                            }
                        }
                    });
                } else {
                    $('#search-results').hide();
                }
            });

            // Hide search results when clicking outside
            $(document).click(function (e) {
                if (!$(e.target).closest('#search-input').length && !$(e.target).closest('#search-results').length) {
                    $('#search-results').hide();
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // When the modal is triggered
            $('#cashModal').on('show.bs.modal', function (event) {
                // Get the total value from the table and set it to the modal
                var totalValue = $('#totalValueDisplay').text().trim(); // Get the Total value from the display span

                // Set the Total Amount and Paid Amount in the modal
                $('#totalAmount').val(totalValue); // Set Total Amount
                $('#paidAmount').val(totalValue);  // Optionally, set Paid Amount to the same value initially

                // Check if totalValue is 0 and disable the submit button if true
                if (totalValue === "0" || totalValue === "") {
                    $('#cashModal').find('button[type="submit"]').prop('disabled', true); // Disable submit button
                } else {
                    $('#cashModal').find('button[type="submit"]').prop('disabled', false); // Enable submit button
                }
            });
        });
    </script>
</body>
</html>

