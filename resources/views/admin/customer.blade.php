<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>DEV POS - Customer</title>
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
            <h2 class="h5 no-margin-bottom">Customer Settings / Customer</h2>
          </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block table-responsive">
                            <div class="text-right">
                                <button type="button" data-toggle="modal" data-target="#addCustomer" class="btn btn-primary ms-auto">Add Customer</button>
                            </div>
                            <table class="datatable table table-hover" id="">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">SL.</th>
                                        <th scope="col">Customer Name</th>
                                        <th scope="col">Customer Type</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Mobile Number</th>
                                        <th scope="col">Points</th>
                                        <th scope="col">Due(&#2547;)</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$customer->name}} <br> ({{$customer->member_code}})</td>
                                            <td>{{$customer->type}}</td>
                                            <td>{{$customer->address}}</td>
                                            <td>{{$customer->phone}}</td>
                                            <td>{{$customer->points}}</td>
                                            <td>{{$customer->due}}</td>
                                            <td>
                                                <button class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#editCustomer{{$customer->id}}">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <a onclick="confirmation(event)" href="{{url('delete_customer', $customer->id)}}" class="btn btn-outline-danger btn-xs">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editCustomer{{$customer->id}}" tabindex="-1" role="dialog" aria-labelledby="editCustomerLabel{{$customer->id}}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <form class="validate_form" action="{{url('edit_customer', $customer->id)}}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Customer</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-left">
                                                            <div class="row">
                                                                <div class="col-md-4 mb-4">
                                                                    <label class="required-label">Member ID</label>
                                                                    <div class="d-flex">
                                                                        <input type="number" class="form-control form-control-sm me-2" id="member_id2" name="member_code" value="{{$customer->member_code}}" required>
                                                                        <button class="btn btn-outline-info btn-sm member_id_generate2"><i class="fas fa-sync-alt me-2"></i></button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 mb-4">
                                                                    <label class="required-label">Customer Type</label>
                                                                    <select class="form-control form-control-sm form-select" name="c_type" aria-label="Default select example" required>
                                                                        <option value="{{$customer->type}}" selected>{{$customer->type}}</option>
                                                                        <option value="Basic">Basic</option>

                                                                        @foreach ($customer_types as $customer_type)
                                                                            <option value="{{$customer_type->type_name}}">{{$customer_type->type_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4 mb-4">
                                                                    <label class="required-label">Full Name</label>
                                                                    <input type="text" class="form-control form-control-sm" name="c_name" value="{{$customer->name}}" required>
                                                                </div>
                                                                <div class="col-md-4 mb-4">
                                                                    <label class="mt-1">Email</label>
                                                                    <input type="email" class="form-control form-control-sm" name="c_email" value="{{$customer->email}}">
                                                                </div>
                                                                <div class="col-md-4 mb-4">
                                                                    <label class="required-label">Phone</label>
                                                                    <input type="text" class="form-control form-control-sm" name="c_phone"  value="{{$customer->phone}}" required>
                                                                </div>
                                                                <div class="col-md-4 mb-4">
                                                                    <label class="mt-1">Gender</label>
                                                                    <select class="form-control form-control-sm form-select" name="c_gender" aria-label="Default select example">
                                                                        <option value="{{$customer->gender}}" selected>{{$customer->gender}}</option>
                                                                        <option value="male">Male</option>
                                                                        <option value="female">Female</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3 mb-4">
                                                                    <label class="mt-1">Date of Birth</label>
                                                                    <input type="date" class="form-control form-control-sm" name="dob" value="{{$customer->dob}}">
                                                                </div>
                                                                <div class="col-md-3 mb-4">
                                                                    <label class="mt-1">Marital Status</label>
                                                                    <select class="form-control form-control-sm form-select" name="m_status" aria-label="Default select example">
                                                                        <option value="{{$customer->merital_st}}" selected>{{$customer->merital_st}}</option>
                                                                        <option value="married">Married</option>
                                                                        <option value="unmarried">Unmarried</option>
                                                                        <option value="divorced">Divorced</option>
                                                                        <option value="widowed">Widowed</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3 mb-4">
                                                                    <label class="mt-1">Anniversary Date</label>
                                                                    <input type="date" class="form-control form-control-sm" name="anniversary" value="{{$customer->anv_date}}">
                                                                </div>
                                                                <div class="col-md-3 mb-4">
                                                                    <label class="mt-1">Address Type</label>
                                                                    <select class="form-control form-control-sm form-select" name="adrs_type" aria-label="Default select example">
                                                                        <option value="{{$customer->adrs_type}}" selected>{{$customer->adrs_type}}</option>
                                                                        <option value="present_address">Present Address</option>
                                                                        <option value="permanent_address">Permanent Address</option>
                                                                        <option value="shipping_address">Shipping Address</option>
                                                                        <option value="billing_address">Billing Address</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-5 mb-4">
                                                                    <label class="mt-1">Address</label>
                                                                    <textarea class="form-control form-control-sm" name="address" rows="1">{{$customer->address}}</textarea>
                                                                </div>
                                                                <div class="col-lg-4 mb-2">
                                                                    <label class="mt-1">Photo/Logo</label>
                                                                    <input type="file" class="form-control form-control-sm" id="image" name="image" value="{{$customer->image}}">
                                                                    <p class="text-primary text-bold" style="font-size: 12px">Use jpg,jpeg,png,gif only.</p>
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

    <!-- Add Customer Modal -->
    <div id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="validate_form" action="{{url('add_customer')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header"><strong id="exampleModalLabel" class="modal-title">Add Customer</strong>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label class="required-label">Membership ID</label>
                                <div class="d-flex">
                                    <input type="number" class="form-control form-control-sm me-2" id="member_id" name="member_code" required>
                                    <button class="btn btn-outline-info btn-sm member_id_generate"><i class="fas fa-sync-alt me-2"></i></button>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="required-label">Customer Type</label>
                                <select class="form-control form-control-sm form-select" name="c_type" aria-label="Default select example" required>
                                    <option value="" selected>Select One</option>
                                    <option value="Basic">Basic</option>

                                    @foreach ($customer_types as $customer_type)
                                        <option value="{{$customer_type->type_name}}">{{$customer_type->type_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="required-label">Full Name</label>
                                <input type="text" class="form-control form-control-sm" name="c_name" required>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="mt-1">Email</label>
                                <input type="email" class="form-control form-control-sm" name="c_email">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="required-label">Phone</label>
                                <input type="text" class="form-control form-control-sm" name="c_phone" required>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="mt-1">Gender</label>
                                <select class="form-control form-control-sm form-select" name="c_gender" aria-label="Default select example">
                                    <option value="" selected>Select One</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-4">
                                <label class="mt-1">Date of Birth</label>
                                <input type="date" class="form-control form-control-sm" name="dob">
                            </div>
                            <div class="col-md-3 mb-4">
                                <label class="mt-1">Marital Status</label>
                                <select class="form-control form-control-sm form-select" name="m_status" aria-label="Default select example">
                                    <option value="" selected>Select One</option>
                                    <option value="married">Married</option>
                                    <option value="unmarried">Unmarried</option>
                                    <option value="divorced">Divorced</option>
                                    <option value="widowed">Widowed</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-4">
                                <label class="mt-1">Anniversary Date</label>
                                <input type="date" class="form-control form-control-sm" name="anniversary">
                            </div>
                            <div class="col-md-3 mb-4">
                                <label class="mt-1">Address Type</label>
                                <select class="form-control form-control-sm form-select" name="adrs_type" aria-label="Default select example">
                                    <option value="" selected>Select One</option>
                                    <option value="present_address">Present Address</option>
                                    <option value="permanent_address">Permanent Address</option>
                                    <option value="shipping_address">Shipping Address</option>
                                    <option value="billing_address">Billing Address</option>
                                </select>
                            </div>
                            <div class="col-md-5 mb-4">
                                <label class="mt-1">Address</label>
                                <textarea class="form-control form-control-sm" name="address" rows="1"></textarea>
                            </div>
                            <div class="col-lg-4 mb-2">
                                <label class="mt-1">Photo/Logo</label>
                                <input type="file" class="form-control form-control-sm" id="image" name="image">
                                <p class="text-primary text-bold" style="font-size: 12px">Use jpg,jpeg,png,gif only.</p>
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
    <!-- JS for generating barcode for Member ID -->
    <script>
        $(document).ready(function() {
            $('.member_id_generate').click(function(e) {
                e.preventDefault();
                let barcode = Date.now();
                $('input[id="member_id"]').val(barcode);
            });
            $('.member_id_generate2').click(function(e) {
                e.preventDefault();
                let barcode = Date.now();
                $('input[id="member_id2"]').val(barcode);
            });
        });
    </script>
  </body>
</html>
