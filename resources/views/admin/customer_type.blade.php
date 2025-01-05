<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>Admin - Customer Type</title>
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
            <h2 class="h5 no-margin-bottom">Customer Settings / Customer Type</h2>
          </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block table-responsive">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="text-center">List of Customer Type</h3>
                                <button type="button" data-toggle="modal" data-target="#addCustomertype" class="btn btn-primary ms-auto">Add Customer Type</button>
                            </div>
                            <table class="datatable table table-hover" id="">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">SL.</th>
                                        <th scope="col">Customer Type</th>
                                        <th scope="col">Discount (%)</th>
                                        <th scope="col">Target Sale (&#2547;)</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customer_types as $customer_type)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$customer_type->type_name}}</td>
                                            <td>{{$customer_type->discount}}</td>
                                            <td>{{$customer_type->target_sale}}</td>
                                            <td>
                                                <button class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#editCustomerType{{$customer_type->id}}">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <a onclick="confirmation(event)" href="{{url('delete_customer_type', $customer_type->id)}}" class="btn btn-outline-danger btn-xs">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editCustomerType{{$customer_type->id}}" tabindex="-1" role="dialog" aria-labelledby="editCustomerTypeLabel{{$customer_type->id}}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form class="validate_form" action="{{url('edit_customer_type', $customer_type->id)}}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Customer Type</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-left">
                                                            <div class="row">
                                                                <div class="col-md-12 mb-4">
                                                                    <label class="required-label">Type Name</label>
                                                                    <input type="text" class="form-control form-control-sm" name="cus_type" value="{{$customer_type->type_name}}" required>
                                                                </div>
                                                                <div class="col-md-12 mb-4">
                                                                    <label class="mt-1">Dis. (%)</label>
                                                                    <input type="text" class="form-control form-control-sm" name="dis_amt" value="{{$customer_type->discount}}">
                                                                </div>
                                                                <div class="col-md-12 mb-4">
                                                                    <label class="">Target Sale (&#2547;)</label>
                                                                    <input type="text" class="form-control form-control-sm" name="tgt_sale" value="{{$customer_type->target_sale}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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

    <!-- Add Customer Type Modal -->
    <div id="addCustomertype" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <form class="validate_form" action="{{url('add_customer_type')}}" method="POST">
                    @csrf
                    <div class="modal-header"><strong id="exampleModalLabel" class="modal-title">Add Customer Type</strong>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="required-label">Type Name</label>
                                <input type="text" class="form-control form-control-sm" name="cus_type" required>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="mt-1">Dis. (%)</label>
                                <input type="text" class="form-control form-control-sm" name="dis_amt">
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="">Target Sale (&#2547;)</label>
                                <input type="text" class="form-control form-control-sm" name="tgt_sale">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS Delete Confirmation -->
    <script type="text/javascript">
        function confirmation(ev) {
            ev.preventDefault();

            var urlToRedirect = ev.currentTarget.getAttribute('href');
            console.log(urlToRedirect);

            swal({
                title: "Are you sure to delete this?",
                text: "This delete will be permanent!",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then((willCancel) => {
                if (willCancel) {
                    window.location.href = urlToRedirect;
                }
            });
        }
    </script>
    <!-- Sweetalert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- All JS Files -->
    @include('admin.dash_script')
  </body>
</html>
