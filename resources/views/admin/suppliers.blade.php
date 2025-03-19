<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>DEV POS - Suppliers</title>
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
                <h2 class="h5 no-margin-bottom">Suppliers / Suppliers</h2>
            </div>
        </div>

        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block table-responsive">
                            <div class="text-right">
                                <button type="button" data-toggle="modal" data-target="#addSupplier" class="btn btn-primary ms-auto">Add Supplier</button>
                            </div>
                            <table class="datatable table table-hover" id="">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">SL.</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Dues</th>
                                        <th scope="col">Advance</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($suppliers as $supplier)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$supplier->supplier_name}}</td>
                                            <td>{{$supplier->phone}}</td>
                                            <td>{{$supplier->email}}</td>
                                            <td>{{$supplier->address}}</td>
                                            <td>N/A</td>
                                            <td>N/A</td>
                                            <td>
                                                <button class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#editSupplier{{$supplier->id}}">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <a onclick="confirmation(event)" href="{{url('delete_supplier', $supplier->id)}}" class="btn btn-outline-danger btn-xs">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editSupplier{{$supplier->id}}" tabindex="-1" role="dialog" aria-labelledby="editSupplierLabel{{$supplier->id}}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <form class="validate_form" action="{{url('edit_supplier', $supplier->id)}}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Supplier</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-left">
                                                            <div class="row">
                                                                <div class="col-md-4 mb-4">
                                                                    <label class="mt-1">Supplier Code</label>
                                                                    <div class="d-flex">
                                                                        <input type="number" class="form-control form-control-sm me-2" id="supplier_code2" name="supplier_code" value="{{$supplier->supplier_code}}">
                                                                        <button class="btn btn-outline-info btn-sm supplier_code_generate2"><i class="fas fa-sync-alt me-2"></i></button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 mb-4">
                                                                    <label class="required-label">Supplier Name</label>
                                                                    <input type="text" class="form-control form-control-sm" name="name" value="{{$supplier->supplier_name}}" required>
                                                                </div>
                                                                <div class="col-md-4 mb-4">
                                                                    <label class="required-label">Contact Person</label>
                                                                    <input type="text" class="form-control form-control-sm" name="contact" value="{{$supplier->contact_person}}" required>
                                                                </div>
                                                                <div class="col-md-4 mb-4">
                                                                    <label class="mt-1">Email</label>
                                                                    <input type="email" class="form-control form-control-sm" name="email" value="{{$supplier->email}}">
                                                                </div>
                                                                <div class="col-md-4 mb-4">
                                                                    <label class="required-label">Phone</label>
                                                                    <input type="text" class="form-control form-control-sm" name="phone" value="{{$supplier->phone}}" required>
                                                                </div>
                                                                <div class="col-md-4 mb-4">
                                                                    <label class="mt-1">Address</label>
                                                                    <textarea class="form-control form-control-sm" name="address" rows="1"> {{$supplier->address}}</textarea>
                                                                </div>
                                                                <div class="col-md-4 mb-4">
                                                                    <label class="mt-1">Vat Registration Number</label>
                                                                    <input type="text" class="form-control form-control-sm" name="vat_reg" value="{{$supplier->vat_reg_num}}">
                                                                </div>
                                                                <div class="col-lg-4 mb-2">
                                                                    <label class="mt-1">Supplier Photo</label>
                                                                    <input type="file" class="form-control form-control-sm" id="image" name="image" value="{{$supplier->image}}">
                                                                    <p class="text-primary text-bold" style="font-size: 12px">Use jpg,jpeg,png,gif only.</p>
                                                                </div>
                                                                <div class="col-md-4 mb-4">
                                                                    <label class="mt-1">Note</label>
                                                                    <textarea class="form-control form-control-sm" name="note" rows="1">{{$supplier->note}}</textarea>
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

    <!-- Add Supplier Modal -->
    <div id="addSupplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="validate_form" action="{{url('add_supplier')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header"><strong id="exampleModalLabel" class="modal-title">Add Supplier</strong>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label class="mt-1">Supplier Code</label>
                                <div class="d-flex">
                                    <input type="number" class="form-control form-control-sm me-2" id="supplier_code" name="supplier_code">
                                    <button class="btn btn-outline-info btn-sm supplier_code_generate"><i class="fas fa-sync-alt me-2"></i></button>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="required-label">Supplier Name</label>
                                <input type="text" class="form-control form-control-sm" name="name" required>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="required-label">Contact Person</label>
                                <input type="text" class="form-control form-control-sm" name="contact" required>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="mt-1">Email</label>
                                <input type="email" class="form-control form-control-sm" name="email">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="required-label">Phone</label>
                                <input type="text" class="form-control form-control-sm" name="phone" required>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="mt-1">Address</label>
                                <textarea class="form-control form-control-sm" name="address" rows="1"></textarea>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="mt-1">Vat Registration Number</label>
                                <input type="text" class="form-control form-control-sm" name="vat_reg">
                            </div>
                            <div class="col-lg-4 mb-2">
                                <label class="mt-1">Supplier Photo</label>
                                <input type="file" class="form-control form-control-sm" id="image" name="image">
                                <p class="text-primary text-bold" style="font-size: 12px">Use jpg,jpeg,png,gif only.</p>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="mt-1">Note</label>
                                <textarea class="form-control form-control-sm" name="note" rows="1"></textarea>
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
    <!-- JS for generating barcode for Supplier Code -->
    <script>
        $(document).ready(function() {
            $('.supplier_code_generate').click(function(e) {
                e.preventDefault();
                let barcode = Date.now();
                $('input[id="supplier_code"]').val(barcode);
            });
            $('.supplier_code_generate2').click(function(e) {
                e.preventDefault();
                let barcode = Date.now();
                $('input[id="supplier_code2"]').val(barcode);
            });
        });
    </script>
  </body>
</html>
