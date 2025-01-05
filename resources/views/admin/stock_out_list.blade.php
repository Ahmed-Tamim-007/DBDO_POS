<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>Admin - Stock Out List</title>
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
                <h2 class="h5 no-margin-bottom">Stock / Stock Out List</h2>
            </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block table-responsive">
                            <div class="text-right">
                                <a href="{{ url('stock_out') }}">
                                    <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Stock Out</button>
                                </a>
                            </div>
                            <table class="datatable table table-hover">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">Invoive No</th>
                                        <th scope="col">Stock Out Date</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Stock Out Note</th>
                                        <th scope="col">Document</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stock_out_details as $stock_out_detail)
                                        <tr>
                                            <td><a href="{{ url('invoice_so_details', $stock_out_detail->id) }}" style="text-decoration: none;">{{$stock_out_detail->stock_invoice}}</a></td>
                                            <td>{{$stock_out_detail->stock_date}}</td>
                                            <td>{{$stock_out_detail->user}}</td>
                                            <td>{{$stock_out_detail->stock_note}}</td>
                                            <td>{{$stock_out_detail->image_path}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
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
  </body>
</html>
