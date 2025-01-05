<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>Admin - Stock In List</title>
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
                <h2 class="h5 no-margin-bottom">Stock / Stock List</h2>
            </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block table-responsive">
                            <div class="text-right">
                                <a href="{{ url('add_stock') }}">
                                    <button type="button" class="btn btn-primary">Add Stock</button>
                                </a>
                            </div>
                            <table class="datatable table table-hover">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">Invoive No</th>
                                        <th scope="col">Stock In Date</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Stock In Note</th>
                                        <th scope="col">Document</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stock_details as $stock_detail)
                                    <tr>
                                        <td><a href="{{ url('invoice_details', $stock_detail->id) }}" style="text-decoration: none;">{{$stock_detail->stock_invoice}}</a></td>
                                        <td>{{$stock_detail->stock_date}}</td>
                                        <td>{{$stock_detail->user}}</td>
                                        <td>{{$stock_detail->stock_note}}</td>
                                        <td>{{$stock_detail->image_path}}</td>
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
