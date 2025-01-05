<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>Admin - Orders</title>
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
            <h2 class="h5 no-margin-bottom">Sales / Orders List</h2>
          </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block table-responsive text-center">
                            <h3 class="py-4">Online Order Table</h3>
                            <table class="datatable table table-striped table-hover">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">S.No</th>
                                        <th scope="col">Customer Name</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Order date</th>
                                        <th scope="col">Product Title</th>
                                        <th scope="col">Batch No</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Payment Status</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Change Status</th>
                                        <th scope="col">Print</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $data)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->rec_address}}</td>
                                        <td>{{$data->phone}}</td>
                                        <td>{{$data->created_at}}</td>
                                        <td>{{$data->product->title}}</td>
                                        <td>{{$data->batch_no}}</td>
                                        <td>{{$data->quantity}}</td>
                                        <td>&#2547; {{$data->selling_price}}</td>
                                        <td><img src="products/{{$data->product->image}}" height="80px" width="auto" alt=""></td>
                                        <td>{{$data->payment_status}}</td>
                                        <td>
                                            @if ($data->status == 'in progress')
                                                <span class="text-danger">{{ $data->status }}</span>
                                            @elseif ($data->status == 'On the way')
                                                <span class="text-info">{{ $data->status }}</span>
                                            @elseif ($data->status == 'Delivered')
                                                <span class="text-success">{{ $data->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{url('on_the_way', $data->id)}}" class="btn btn-outline-info btn-sm m-1">On the way</a>
                                            <a href="{{url('delivered', $data->id)}}" class="btn btn-outline-success btn-sm m-1">Delivered</a>
                                        </td>
                                        <td><a href="{{url('print_pdf', $data->id)}}" class="btn btn-outline-secondary btn-sm m-1">PDF</a></td>
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
    <!-- JavaScript files-->
    @include('admin.dash_script')
  </body>
</html>
