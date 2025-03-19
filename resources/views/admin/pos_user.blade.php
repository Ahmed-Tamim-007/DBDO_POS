<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>DEV POS - User</title>
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
                    <h2 class="h5 no-margin-bottom">User Management / Users</h2>
                </div>
            </div>

            <section class="no-padding-top">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="block table-responsive">
                                @if (Auth::user()->usertype == 'Admin')
                                    <div class="text-right">
                                        <button type="button" data-toggle="modal" data-target="#addUser" class="btn btn-primary ms-auto">Add User</button>
                                    </div>
                                @endif
                                <table class="datatable table table-hover">
                                    <thead>
                                        <tr class="text-primary">
                                            <th scope="col">SL.</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">E-Mail</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">User Type</th>
                                            @if (Auth::user()->usertype == 'Admin')
                                                <th scope="col">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pos_users as $pos_user)
                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$pos_user->name}}</td>
                                                <td>{{$pos_user->email}}</td>
                                                <td>{{$pos_user->phone}}</td>
                                                <td>{{$pos_user->address}}</td>
                                                <td>{{$pos_user->usertype}}</td>
                                                @if (Auth::user()->usertype == 'Admin')
                                                    <td>
                                                        <button class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#editUser{{$pos_user->id}}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                        <a onclick="confirmation(event)" href="{{url('delete_user', $pos_user->id)}}" class="btn btn-outline-danger btn-xs">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </td>
                                                @endif
                                            </tr>
                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editUser{{$pos_user->id}}" tabindex="-1" role="dialog" aria-labelledby="editUserLabel{{$pos_user->id}}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <form class="validate_form" action="{{url('edit_user', $pos_user->id)}}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit User</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-left">
                                                                <div class="row">
                                                                    <div class="col-md-4 mb-4">
                                                                        <label class="required-label">Full Name</label>
                                                                        <input type="text" class="form-control form-control-sm" name="name" value="{{$pos_user->name}}" required>
                                                                    </div>
                                                                    <div class="col-md-4 mb-4">
                                                                        <label class="required-label">Email</label>
                                                                        <input type="email" class="form-control form-control-sm" name="email" value="{{$pos_user->email}}" required>
                                                                    </div>
                                                                    <div class="col-md-4 mb-4">
                                                                        <label class="required-label">User Type</label>
                                                                        <select class="form-control form-control-sm form-select" name="usertype" aria-label="Default select example" required>
                                                                            <option value="{{$pos_user->usertype}}" selected>{{$pos_user->usertype}}</option>
                                                                            <option value="Admin">Admin</option>
                                                                            <option value="Employee">Employee</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-4 mb-4">
                                                                        <label>Phone</label>
                                                                        <input type="text" class="form-control form-control-sm" name="phone" value="{{$pos_user->phone}}">
                                                                    </div>
                                                                    <div class="col-md-4 mb-4">
                                                                        <label>Job Title</label>
                                                                        <input type="text" class="form-control form-control-sm" name="job_title" value="{{$pos_user->job_title}}">
                                                                    </div>
                                                                    <div class="col-md-4 mb-4">
                                                                        <label>Date of Birth</label>
                                                                        <input type="date" class="form-control form-control-sm" name="dob" value="{{$pos_user->dob}}">
                                                                    </div>
                                                                    <div class="col-md-4 mb-4">
                                                                        <label>Joining Date</label>
                                                                        <input type="date" class="form-control form-control-sm" name="jod" value="{{$pos_user->jod}}">
                                                                    </div>
                                                                    <div class="col-md-4 mb-4">
                                                                        <label>Salary</label>
                                                                        <input type="text" class="form-control form-control-sm" name="salary" value="{{$pos_user->salary}}">
                                                                    </div>
                                                                    <div class="col-md-4 mb-4">
                                                                        <label>National ID</label>
                                                                        <input type="text" class="form-control form-control-sm" name="nid" value="{{$pos_user->nid}}">
                                                                    </div>
                                                                    <div class="col-md-4 mb-4">
                                                                        <label>Blood Group</label>
                                                                        <select class="form-control form-control-sm form-select" name="blood_group" aria-label="Default select example">
                                                                            <option value="{{$pos_user->blood_group}}" selected>{{$pos_user->blood_group}}</option>
                                                                            <option value="A+">A+</option>
                                                                            <option value="A-">A-</option>
                                                                            <option value="AB+">AB+</option>
                                                                            <option value="AB-">AB-</option>
                                                                            <option value="B+">B+</option>
                                                                            <option value="B-">B-</option>
                                                                            <option value="O+">O+</option>
                                                                            <option value="O-">O-</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-4 mb-4">
                                                                        <label>Address</label>
                                                                        <textarea class="form-control form-control-sm" name="address" rows="1">{{$pos_user->address}}</textarea>
                                                                    </div>
                                                                    <div class="col-md-4 mb-2">
                                                                        <label>Photo/Logo</label>
                                                                        <input type="file" class="form-control form-control-sm" id="image" name="image" value="{{$pos_user->image}}">
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

    <!-- Add User Modal -->
    <div id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="validate_form" id="user_submit_form" action="{{url('add_user')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header"><strong id="exampleModalLabel" class="modal-title">Add User</strong>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label class="required-label">Username</label>
                                <input type="text" class="form-control form-control-sm" name="name" required>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="required-label">Email</label>
                                <input type="email" class="form-control form-control-sm" name="email" required>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="required-label">Password</label>
                                <input type="text" class="form-control form-control-sm" id="password" name="password" required>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="required-label">User Type</label>
                                <select class="form-control form-control-sm form-select" name="usertype" aria-label="Default select example" required>
                                    <option value="" selected>Select One</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Employee">Employee</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="mt-md-1">Phone</label>
                                <input type="text" class="form-control form-control-sm" name="phone">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="mt-md-1">Job Title</label>
                                <input type="text" class="form-control form-control-sm" name="job_title">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label>Date of Birth</label>
                                <input type="date" class="form-control form-control-sm" name="dob">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label>Joining Date</label>
                                <input type="date" class="form-control form-control-sm" name="jod">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label>Salary</label>
                                <input type="text" class="form-control form-control-sm" name="salary">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label>National ID</label>
                                <input type="text" class="form-control form-control-sm" name="nid">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label>Blood Group</label>
                                <select class="form-control form-control-sm form-select" name="blood_group" aria-label="Default select example">
                                    <option value="" selected>Select One</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label>Address</label>
                                <textarea class="form-control form-control-sm" name="address" rows="1"></textarea>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Photo/Logo</label>
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

    <!-- JS for user submition -->
    <script>
        $('#user_submit_form').on('submit', function (e) {
            const password = $('#password').val();

            // Check if password is at least 8 characters long
            if (password.length < 8) {
                e.preventDefault(); // Prevent form submission
                alert('Password must be at least 8 characters long.');
            }
        });
    </script>
  </body>
</html>
