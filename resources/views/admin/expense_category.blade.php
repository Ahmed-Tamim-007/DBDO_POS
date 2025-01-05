<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>Admin - Expense Categories</title>
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
                <h2 class="h5 no-margin-bottom">Account Settings / Expense Categories</h2>
            </div>
        </div>
        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block table-responsive">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="text-center">List of Transaction Category</h3>
                                <button type="button" data-toggle="modal" data-target="#addTransCat" class="btn btn-primary ms-auto">Add Category</button>
                            </div>

                            <table class="table table-hover">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">SL.</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 1; @endphp
                                    @foreach ($exp_ctgs as $exp_ctg)
                                        <tr>
                                            <th scope="row">{{$count}}</th>
                                            <td>{{$exp_ctg->catName}}</td>
                                            <td>{{$exp_ctg->catType}}</td>
                                            <td>
                                                <button class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#editTransCat{{$exp_ctg->id}}">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <a onclick="confirmation(event)" href="{{ url('delete_trans_cat', $exp_ctg->id) }}" class="btn btn-outline-danger btn-xs"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                        @php $count++; @endphp

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editTransCat{{$exp_ctg->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$exp_ctg->id}}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{url('update_trans_cat', $exp_ctg->id)}}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Transaction Category</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-left">
                                                            <div class="row">
                                                                <div class="col-md-12 mb-4">
                                                                    <label class="form-label required-label">Category Name</label>
                                                                    <input type="text" class="form-control" name="catName" value="{{$exp_ctg->catName}}" required>
                                                                </div>
                                                                <div class="col-md-12 mb-4">
                                                                    <label class="required-label">Type</label>
                                                                    <select class="form-control form-select" name="catType" aria-label="Default select example" required>
                                                                        <option value="{{$exp_ctg->catType}}" selected>{{$exp_ctg->catType}}</option>
                                                                        <option value="Income">Income</option>
                                                                        <option value="Expense">Expense</option>
                                                                    </select>
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

    <!-- Add Transection Category Modal -->
    <div id="addTransCat" tabindex="-1" role="dialog" aria-labelledby="bank_modal" aria-hidden="true" class="modal fade text-left">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{url('add_trans_cat')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Transaction Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label required-label">Category Name</label>
                                <input type="text" class="form-control" name="catName" required>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="required-label">Type</label>
                                <select class="form-control form-select" name="catType" aria-label="Default select example" required>
                                    <option value="" selected>Select One</option>
                                    <option value="Income">Income</option>
                                    <option value="Expense">Expense</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
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
