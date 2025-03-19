<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>DEV POS - Category</title>
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
                <h2 class="h5 no-margin-bottom">Product / Classifications</h2>
            </div>
        </div>
        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <!-- Categories -->
                    <div class="col-md-6">
                        <div class="block table-responsive">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="text-center">Categories</h3>
                                <button type="button" data-toggle="modal" data-target="#addCategory" class="btn btn-primary ms-auto">Add Category</button>
                            </div>
                            <table class="datatable table table-hover">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">No.</th>
                                        <th scope="col">Categories</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $data)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$data->category_name}}</td>
                                            <td>
                                                <button class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#editModal{{$data->id}}">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <a onclick="confirmation(event)" href="{{ url('delete_category', $data->id) }}" class="btn btn-outline-danger btn-xs"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$data->id}}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{url('update_category', $data->id)}}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Category</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-left">
                                                            <div class="mb-4">
                                                                <label class="form-label required-label">Category Name</label>
                                                                <input type="text" class="form-control py-2 px-3 mx-auto" name="e_category" value="{{$data->category_name}}" required>
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

                    <!-- Sub Categories -->
                    <div class="col-md-6">
                        <div class="block table-responsive">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="text-center">Sub Categories</h3>
                                <button type="button" data-toggle="modal" data-target="#addsubCategory" class="btn btn-primary ms-auto">Add Category</button>
                            </div>
                            <table class="datatable table table-hover">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">No.</th>
                                        <th scope="col">Sub Ctg</th>
                                        <th scope="col">Parent Ctg</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subcategories as $subcategory)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$subcategory->sub_category}}</td>
                                            <td>{{$subcategory->category}}</td>
                                            <td>
                                                <button class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#editModal2{{$subcategory->id}}">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <a onclick="confirmation(event)" href="{{ url('delete_sub_category', $subcategory->id) }}" class="btn btn-outline-danger btn-xs"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal2{{$subcategory->id}}" tabindex="-1" role="dialog" aria-labelledby="editModal2Label{{$subcategory->id}}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{url('update_sub_category', $subcategory->id)}}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Sub Category</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-left">
                                                            <div class="mb-4">
                                                                <label class="form-label required-label">Sub Category</label>
                                                                <input type="text" class="form-control py-2 px-3 mx-auto" name="sub_category" value="{{$subcategory->sub_category}}" required>
                                                            </div>
                                                            <div class="mb-4">
                                                                <label>Parent Category</label>
                                                                <select class="form-control form-select" name="category" aria-label="Default select example" required>
                                                                    <option value="{{$subcategory->category}}" selected>{{$subcategory->category}}</option>

                                                                    @foreach ($datas as $data)
                                                                        <option value="{{$data->category_name}}">{{$data->category_name}}</option>
                                                                    @endforeach
                                                                </select>
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

                    <!-- Brands -->
                    <div class="col-md-6">
                        <div class="block table-responsive">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="text-center">Brands</h3>
                                <button type="button" data-toggle="modal" data-target="#addBrand" class="btn btn-primary ms-auto">Add Brand</button>
                            </div>
                            <table class="datatable table table-hover">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">No.</th>
                                        <th scope="col">Brands</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($brands as $brand)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$brand->brand_name}}</td>
                                            <td>
                                                <button class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#editModal3{{$brand->id}}">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <a onclick="confirmation(event)" href="{{ url('delete_brand', $brand->id) }}" class="btn btn-outline-danger btn-xs"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal3{{$brand->id}}" tabindex="-1" role="dialog" aria-labelledby="editModal3Label{{$brand->id}}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{url('update_brand', $brand->id)}}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Brand</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-left">
                                                            <div class="mb-4">
                                                                <label class="form-label required-label">Brand Name</label>
                                                                <input type="text" class="form-control py-2 px-3 mx-auto" name="brand_name" value="{{$brand->brand_name}}" required>
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

                    <!-- Units -->
                    <div class="col-md-6">
                        <div class="block table-responsive">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="text-center">Units</h3>
                                <button type="button" data-toggle="modal" data-target="#addUnit" class="btn btn-primary ms-auto">Add Unit</button>
                            </div>
                            <table class="datatable table table-hover">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">No.</th>
                                        <th scope="col">Units</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($units as $unit)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$unit->unit}}</td>
                                            <td>
                                                <button class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#editModal4{{$unit->id}}">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <a onclick="confirmation(event)" href="{{ url('delete_unit', $unit->id) }}" class="btn btn-outline-danger btn-xs"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal4{{$unit->id}}" tabindex="-1" role="dialog" aria-labelledby="editModal3Label{{$unit->id}}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{url('update_unit', $unit->id)}}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Unit</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-left">
                                                            <div class="mb-4">
                                                                <label class="form-label required-label">Unit Name</label>
                                                                <input type="text" class="form-control py-2 px-3 mx-auto" name="unit" value="{{$unit->unit}}" required>
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

    <!-- Add category Modal -->
    <div id="addCategory" tabindex="-1" role="dialog" aria-labelledby="category_modal" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header"><strong id="category_modal" class="modal-title">Add Category</strong>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{url('add_category')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label class="form-label required-label">Category Name</label>
                            <input type="text" class="form-control py-2 px-3 w-100" name="category" required>
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
    </div>
    <!-- Add sub category Modal -->
    <div id="addsubCategory" tabindex="-1" role="dialog" aria-labelledby="sub_cat_modal" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header"><strong id="sub_cat_modal" class="modal-title">Add Sub Category</strong>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{url('add_sub_category')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label class="form-label required-label">Sub Category Name</label>
                            <input type="text" class="form-control py-2 px-3 w-100" name="sub_category" required>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="required-label">Parent Category</label>
                            <select class="form-control form-select" name="category" aria-label="Default select example" required>
                                <option value="" selected>Select One</option>

                                @foreach ($datas as $data)
                                    <option value="{{$data->category_name}}">{{$data->category_name}}</option>
                                @endforeach
                            </select>
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
    </div>
    <!-- Add brand Modal -->
    <div id="addBrand" tabindex="-1" role="dialog" aria-labelledby="brand_modal" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><strong id="brand_modal" class="modal-title">Add new Brand</strong>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{url('add_brand')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label required-label">Brand Name</label>
                                <input type="text" class="form-control py-2 px-3 w-100" name="brand_name" required>
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
    </div>
    <!-- Add unit Modal -->
    <div id="addUnit" tabindex="-1" role="dialog" aria-labelledby="Unit_modal" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><strong id="Unit_modal" class="modal-title">Add new Unit</strong>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{url('add_unit')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label required-label">Unit Name</label>
                                <input type="text" class="form-control py-2 px-3 w-100" name="unit" required>
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
    </div>

    <!-- Delete Confirmation -->
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
    @include('admin.dash_script')
  </body>
</html>

