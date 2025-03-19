<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>DEV POS - Banks & Cards</title>
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
                <h2 class="h5 no-margin-bottom">Account Settings / Banks & Cards</h2>
            </div>
        </div>
        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <!-- Banks -->
                    <div class="col-md-6">
                        <div class="block table-responsive">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="text-center">List of Banks</h3>
                                <button type="button" data-toggle="modal" data-target="#addBank" class="btn btn-primary ms-auto">Add Bank</button>
                            </div>

                            <div id="bank_nav">
                                <ul class="nav nav-pills my-2" id="pills-tab">
                                    <li class="nav-item">
                                        <button class="nav-link active" data-target="#nav_link_1">General Bank</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-target="#nav_link_2">Mobile Bank</button>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div id="nav_link_1" class="tab-pane fade show active">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th scope="col">SL.</th>
                                                    <th scope="col">Bank Name</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $count = 1; @endphp
                                                @foreach ($banks as $bank)
                                                    @if ($bank->bank_type == 'General Bank')
                                                        <tr>
                                                            <th scope="row">{{$count}}</th>
                                                            <td>{{$bank->bank_name}}</td>
                                                            <td>
                                                                <button class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#editBank{{$bank->id}}">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>

                                                                <a onclick="confirmation(event)" href="{{ url('delete_bank', $bank->id) }}" class="btn btn-outline-danger btn-xs"><i class="fas fa-trash-alt"></i></a>
                                                            </td>
                                                        </tr>
                                                        @php $count++; @endphp

                                                        <!-- Edit Modal -->
                                                        <div class="modal fade" id="editBank{{$bank->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$bank->id}}" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <form action="{{url('update_bank', $bank->id)}}" method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Edit Bank</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body text-left">
                                                                            <div class="row">
                                                                                <div class="col-md-12 mb-4">
                                                                                    <label class="form-label required-label">Bank Name</label>
                                                                                    <input type="text" class="form-control py-2 px-3 w-100" name="bankName" value="{{$bank->bank_name}}" required>
                                                                                </div>
                                                                                <div class="col-md-12 mb-4">
                                                                                    <label class="required-label">Bank Type</label>
                                                                                    <select class="form-control form-select" name="bankType" aria-label="Default select example" required>
                                                                                        <option value="{{$bank->bank_type}}" selected>{{$bank->bank_type}}</option>
                                                                                        <option value="General Bank">General Bank</option>
                                                                                        <option value="Mobile Bank">Mobile Bank</option>
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
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="nav_link_2" class="tab-pane fade">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th scope="col">SL.</th>
                                                    <th scope="col">Bank Name</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $count = 1; @endphp
                                                @foreach ($banks as $bank)
                                                    @if ($bank->bank_type == 'Mobile Bank')
                                                        <tr>
                                                            <th scope="row">{{$count}}</th>
                                                            <td>{{$bank->bank_name}}</td>
                                                            <td>
                                                                <button class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#editBank1{{$bank->id}}">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>

                                                                <a onclick="confirmation(event)" href="{{ url('delete_bank', $bank->id) }}" class="btn btn-outline-danger btn-xs"><i class="fas fa-trash-alt"></i></a>
                                                            </td>
                                                        </tr>
                                                        @php $count++; @endphp

                                                        <!-- Edit Modal -->
                                                        <div class="modal fade" id="editBank1{{$bank->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$bank->id}}" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <form action="{{url('update_bank', $bank->id)}}" method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Edit Bank</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body text-left">
                                                                            <div class="row">
                                                                                <div class="col-md-12 mb-4">
                                                                                    <label class="form-label required-label">Bank Name</label>
                                                                                    <input type="text" class="form-control py-2 px-3 w-100" name="bankName" value="{{$bank->bank_name}}" required>
                                                                                </div>
                                                                                <div class="col-md-12 mb-4">
                                                                                    <label class="required-label">Bank Type</label>
                                                                                    <select class="form-control form-select" name="bankType" aria-label="Default select example" required>
                                                                                        <option value="{{$bank->bank_type}}" selected>{{$bank->bank_type}}</option>
                                                                                        <option value="General Bank">General Bank</option>
                                                                                        <option value="Mobile Bank">Mobile Bank</option>
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
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cards -->
                    <div class="col-md-6">
                        <div class="block table-responsive">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="text-center">List of Cards</h3>
                                <button type="button" data-toggle="modal" data-target="#addCard" class="btn btn-primary ms-auto">Add Card</button>
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">SL.</th>
                                        <th scope="col">Card Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cards as $card)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$card->card_name}}</td>
                                            <td>
                                                <button class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#editCard{{$card->id}}">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <a onclick="confirmation(event)" href="{{ url('delete_card', $card->id) }}" class="btn btn-outline-danger btn-xs"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editCard{{$card->id}}" tabindex="-1" role="dialog" aria-labelledby="editCardLabel{{$card->id}}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{url('update_card', $card->id)}}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Card</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-left">
                                                            <div class="mb-4">
                                                                <label class="form-label required-label">Card Name</label>
                                                                <input type="text" class="form-control py-2 px-3 mx-auto" name="cardName" value="{{$card->card_name}}" required>
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

    <!-- Add Bank Modal -->
    <div id="addBank" tabindex="-1" role="dialog" aria-labelledby="bank_modal" aria-hidden="true" class="modal fade text-left">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{url('add_bank')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Bank</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label required-label">Bank Name</label>
                                <input type="text" class="form-control py-2 px-3 w-100" name="bankName" required>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="required-label">Bank Type</label>
                                <select class="form-control form-select" name="bankType" aria-label="Default select example" required>
                                    <option value="" selected>Select One</option>
                                    <option value="General Bank">General Bank</option>
                                    <option value="Mobile Bank">Mobile Bank</option>
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
    <!-- Add Card Modal -->
    <div id="addCard" tabindex="-1" role="dialog" aria-labelledby="card_modal" aria-hidden="true" class="modal fade text-left">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{url('add_card')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Card</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label required-label">Card Name</label>
                                <input type="text" class="form-control py-2 px-3 w-100" name="cardName" required>
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

    <!-- Nav-pills -->
    <script>
        $(document).ready(function() {
            $(".nav-link").click(function() {
                const target = $(this).data("target");
                $(".tab-pane").removeClass("show active");
                $(target).addClass("show active");
                $(".nav-link").removeClass("active");
                $(this).addClass("active");
            });
        });
    </script>
  </body>
</html>

