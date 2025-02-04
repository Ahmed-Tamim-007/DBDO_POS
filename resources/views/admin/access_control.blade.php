<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>Admin - Access Control</title>
    <style>
        /* Switch container */

    </style>
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
                    <h2 class="h5 no-margin-bottom">User Management / Access Control</h2>
                </div>
            </div>

            <section class="no-padding-top">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="block">
                                <h3 class="mb-3 text-center">Employee Access Management</h3>
                                <form action="{{url('edit_access')}}" method="POST">
                                    @csrf
                                    <div class="table-responsive p-3">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th scope="col">SL.</th>
                                                    <th scope="col">Page Name</th>
                                                    <th scope="col">Access</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>Users</td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider"></span>
                                                        </label>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer Sections -->
            @include('admin.dash_footer')

        </div>
    </div>

    <!-- All JS Files -->
    @include('admin.dash_script')
  </body>
</html>
