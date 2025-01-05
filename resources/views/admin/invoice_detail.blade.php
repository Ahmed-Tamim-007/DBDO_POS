<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>Admin - Invoice Detail</title>
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
                <h2 class="h5 no-margin-bottom">Stock / Stock In / Invoice Detail</h2>
            </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block">
                            <div class="row">
                                <div class="col-lg-2">
                                    <p><span class="font-weight-bold">Invoice No</span><br>{{$invoice->stock_invoice}}</p>
                                </div>
                                <div class="col-lg-2">
                                    <p><span class="font-weight-bold">Stock In Date</span><br>{{$invoice->stock_date}}</p>
                                </div>
                                <div class="col-lg-2">
                                    <p><span class="font-weight-bold">User</span><br>{{$invoice->user}}</p>
                                </div>
                                <div class="col-lg-2">
                                    <p><span class="font-weight-bold">Stock In Note</span><br>{{$invoice->stock_note}}</p>
                                </div>
                                <div class="col-lg-2">
                                    <p><span class="font-weight-bold">Document</span><br>{{$invoice->image_path}}</p>
                                </div>
                                <div class="col-lg-2">
                                    <button class="btn btn-primary">Print</button>
                                    <button class="btn btn-warning">PDF</button>
                                </div>
                            </div>
                        </div>
                        <div class="block table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">SL.</th>
                                        <th scope="col">Product Code</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Batch</th>
                                        <th scope="col">Supplier</th>
                                        <th scope="col">Expiration Date</th>
                                        <th scope="col">Purchase (&#2547;)</th>
                                        <th scope="col">Sale (&#2547;)</th>
                                        <th scope="col">QTY</th>
                                        <th scope="col">Purchase Total</th>
                                        <th scope="col">Sale Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$product->barcode}}</td>
                                        <td>{{$product->product_name}}</td>
                                        <td>{{$product->batch_no}}</td>
                                        <td>{{$product->supplier}}</td>
                                        <td>{{$product->expiration_date ?? 'N/A'}}</td>
                                        <td>{{$product->purchase_price}}</td>
                                        <td>{{$product->sale_price}}</td>
                                        <td>{{$product->quantity}}</td>
                                        <td>{{number_format($product->purchase_price * $product->quantity, 2)}}</td>
                                        <td>{{number_format($product->sale_price * $product->quantity, 2)}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="text-primary">
                                        <th scope="col" colspan="8" class="text-right">Total:</th>
                                        <th id="t_qty" scope="col">0</th>
                                        <th id="t_purchase" scope="col">0.00</th>
                                        <th id="t_sale" scope="col">0.00</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
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

    {{-- tfoor Total count script --}}
    <script>
        $(document).ready(function () {
            function calculateTotals() {
                let totalQuantity = 0;
                let totalPurchase = 0;
                let totalSale = 0;

                // Loop through each row in the tbody
                $('table tbody tr').each(function () {
                    const quantity = parseFloat($.trim($(this).find('td:nth-child(9)').text())) || 0; // Quantity (9th column)
                    const purchaseTotal = parseFloat($.trim($(this).find('td:nth-child(10)').text().replace(/,/g, ''))) || 0; // Purchase Total (10th column)
                    const saleTotal = parseFloat($.trim($(this).find('td:nth-child(11)').text().replace(/,/g, ''))) || 0; // Sale Total (11th column)

                    totalQuantity += quantity;
                    totalPurchase += purchaseTotal;
                    totalSale += saleTotal;
                });

                // Update the tfoot section
                $('#t_qty').text(totalQuantity);
                $('#t_purchase').text(totalPurchase.toFixed(2));
                $('#t_sale').text(totalSale.toFixed(2));
            }

            // Calculate totals on page load
            calculateTotals();
        });
    </script>
  </body>
</html>
