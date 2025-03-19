<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>DEV POS - Customer Points</title>
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
                <h2 class="h5 no-margin-bottom">Customer / Customer Points</h2>
            </div>
        </div>
        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="block table-responsive">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="text-center">Point Earn Rate</h3>
                            </div>
                            <form action="{{url('update_earn_rate', $data->id)}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-4 my-2">
                                        <input type="text" class="form-control form-control-sm only_num" name="earn_rate" value="{{ $data->earn_rate }}" required>
                                    </div>
                                    <div class="col-2 my-2">
                                        <span class="text-bold text-primary">&#2547;</span>
                                    </div>
                                    <div class="col-2 my-2 text-right">
                                        <span>=</span>
                                    </div>
                                    <div class="col-4 my-2">
                                        <span>1 Point</span>
                                    </div>
                                    <div class="col-12 my-2">
                                        <input type="submit" class="btn btn-primary" value="Update">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="block table-responsive">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="text-center">Point Redeem Rate</h3>
                            </div>
                            <form action="{{url('update_redeem_rate', $data->id)}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-4 my-2">
                                        <span class="text-bold">1 Point</span>
                                    </div>
                                    <div class="col-2 my-2">
                                        <span>=</span>
                                    </div>
                                    <div class="col-4 my-2">
                                        <input type="text" class="form-control form-control-sm only_num" name="redeem_rate" value="{{ $data->redeem_rate }}" required>
                                    </div>
                                    <div class="col-2 my-2">
                                        <span class="text-primary">&#2547;</span>
                                    </div>
                                    <div class="col-12 my-2">
                                        <input type="submit" class="btn btn-primary" value="Update">
                                    </div>
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

    @include('admin.dash_script')

    <!-- Scripts -->
    <script>
        $(document).ready(function () {
            // Restriction on text type input to enter anything other than Numbers
            $(document).on('input', '.only_num', function() {
                let value = $(this).val();
                if (!/^\d*\.?\d*$/.test(value)) { // Validates the decimal format
                    $(this).val(value.slice(0, -1)); // Remove the last invalid character
                }
            });
        });
    </script>
  </body>
</html>
