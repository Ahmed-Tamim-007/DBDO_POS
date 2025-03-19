<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>DEV POS - Accounts</title>
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
                <h2 class="h5 no-margin-bottom">Account Settings / Accounts</h2>
            </div>
        </div>
        <section class="no-padding-top">
            <div class="container-fluid">
                <div class="row">
                    <!-- Banks -->
                    <div class="col-md-12">
                        <div class="block">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3>List of Accounts</h3>
                            </div>

                            <div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <ul class="nav nav-pills my-2" id="pills-tab">
                                        <li class="nav-item">
                                            <button class="nav-link active mt-1" data-target="#nav_link_1">Bank Account</button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link mt-1" data-target="#nav_link_2">Cash Account</button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link mt-1" data-target="#nav_link_3">Mobile Account</button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link mt-1" data-target="#nav_link_4">Station Account</button>
                                        </li>
                                    </ul>
                                    <div>
                                        <button type="button" data-toggle="modal" id="bank_acc_modal" data-target="#addBankAcc" class="btn btn-primary ms-auto mt-1">Add Account</button>
                                        <button type="button" data-toggle="modal" id="cash_acc_modal" data-target="#addCashAcc" class="btn btn-primary ms-auto d-none mt-1">Add Account</button>
                                        <button type="button" data-toggle="modal" id="bank_mobile_modal" data-target="#addMobileAcc" class="btn btn-primary ms-auto d-none mt-1">Add Account</button>
                                        <button type="button" data-toggle="modal" id="bank_station_modal" data-target="#addStationAcc" class="btn btn-primary ms-auto d-none mt-1">Add Account</button>
                                    </div>
                                </div>

                                <div class="tab-content">
                                    <div id="nav_link_1" class="tab-pane table-responsive fade show active">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th scope="col">SL</th>
                                                    <th scope="col">Bank</th>
                                                    <th scope="col">Account No</th>
                                                    <th scope="col">Branch</th>
                                                    <th scope="col">Account Uses</th>
                                                    <th scope="col">Initial Balance</th>
                                                    <th scope="col">Current Balance</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $count = 1; @endphp
                                                @foreach ($accounts as $account)
                                                @if ($account->account_type == 'Bank')
                                                    <tr>
                                                        <th scope="row">{{$count}}</th>
                                                        <td>{{$account->acc_name}}</td>
                                                        <td>{{$account->acc_no}}</td>
                                                        <td>{{$account->acc_branch}}</td>
                                                        <td>{{$account->acc_uses}}</td>
                                                        <td>{{$account->ini_balance}}</td>
                                                        <td>{{$account->crnt_balance}}</td>
                                                        <td>
                                                            <button class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#editBankAcc{{$account->id}}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>

                                                            <a onclick="confirmation(event)" href="{{ url('delete_bankAcc', $account->id) }}" class="btn btn-outline-danger btn-xs"><i class="fas fa-trash-alt"></i></a>
                                                        </td>
                                                    </tr>
                                                    @php $count++; @endphp

                                                    <!-- Edit Modal -->
                                                    <div class="modal fade" id="editBankAcc{{$account->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$account->id}}" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <form action="{{url('update_bankAcc', $account->id)}}" method="POST">
                                                                    @csrf
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Edit Bank Account</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body text-left">
                                                                        <div class="row">
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="required-label">Account Uses</label>
                                                                                <select class="form-control form-select" name="acc_uses" aria-label="Default select example" required>
                                                                                    <option value="{{$account->acc_uses}}" selected>{{$account->acc_uses}}</option>
                                                                                    <option value="Office Accounnt">Office Accounnt</option>
                                                                                    <option value="Shop Accounnt">Shop Accounnt</option>
                                                                                    <option value="Both">Both</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="form-label required-label">Bank/Account Name</label>
                                                                                <select class="form-control form-select" name="acc_name" aria-label="Default select example" readonly>
                                                                                    <option value="{{$account->acc_name}}" selected>{{$account->acc_name}}</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="form-label required-label">Account No</label>
                                                                                <input type="text" class="form-control" name="acc_no" value="{{$account->acc_no}}" readonly>
                                                                            </div>
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="form-label required-label">Branch Name</label>
                                                                                <input type="text" class="form-control" name="acc_branch" value="{{$account->acc_branch}}" readonly>
                                                                            </div>
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="form-label">Address</label>
                                                                                <textarea name="address" class="form-control" rows="2">{{$account->address}}</textarea>
                                                                            </div>
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="form-label">Description</label>
                                                                                <textarea name="description" class="form-control" rows="2">{{$account->description}}</textarea>
                                                                            </div>
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="form-label required-label">Initial Balance</label>
                                                                                <input type="text" class="form-control" name="ini_balance" value="{{$account->ini_balance}}" readonly>
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
                                    <div id="nav_link_2" class="tab-pane table-responsive fade">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th scope="col">SL</th>
                                                    <th scope="col">Account Name</th>
                                                    <th scope="col">Account Uses</th>
                                                    <th scope="col">Initial Balance</th>
                                                    <th scope="col">Current Balance</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $count = 1; @endphp
                                                @foreach ($accounts as $account)
                                                @if ($account->account_type == 'Cash')
                                                    <tr>
                                                        <th scope="row">{{$count}}</th>
                                                        <td>{{$account->acc_name}}</td>
                                                        <td>{{$account->acc_uses}}</td>
                                                        <td>{{$account->ini_balance}}</td>
                                                        <td>{{$account->crnt_balance}}</td>
                                                        <td>
                                                            <button class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#editCashAcc{{$account->id}}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>

                                                            <a onclick="confirmation(event)" href="{{ url('delete_cashAcc', $account->id) }}" class="btn btn-outline-danger btn-xs"><i class="fas fa-trash-alt"></i></a>
                                                        </td>
                                                    </tr>
                                                    @php $count++; @endphp

                                                    <!-- Edit Modal -->
                                                    <div class="modal fade" id="editCashAcc{{$account->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$account->id}}" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <form action="{{url('update_cashAcc', $account->id)}}" method="POST">
                                                                    @csrf
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Edit Cash Account</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body text-left">
                                                                        <div class="row">
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="required-label">Account Uses</label>
                                                                                <select class="form-control form-select" name="acc_uses" aria-label="Default select example" required>
                                                                                    <option value="{{$account->acc_uses}}" selected>{{$account->acc_uses}}</option>
                                                                                    <option value="Office Accounnt">Office Accounnt</option>
                                                                                    <option value="Shop Accounnt">Shop Accounnt</option>
                                                                                    <option value="Both">Both</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="form-label required-label">Bank/Account Name</label>
                                                                                <input type="text" class="form-control" name="acc_name" value="{{$account->acc_name}}" readonly>
                                                                            </div>
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="form-label">Description</label>
                                                                                <textarea name="description" class="form-control" rows="2">{{$account->description}}</textarea>
                                                                            </div>
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="form-label required-label">Initial Balance</label>
                                                                                <input type="text" class="form-control" name="ini_balance" value="{{$account->ini_balance}}" readonly>
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
                                    <div id="nav_link_3" class="tab-pane table-responsive fade show">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th scope="col">SL</th>
                                                    <th scope="col">Mobile Bank</th>
                                                    <th scope="col">Account No</th>
                                                    <th scope="col">Account Uses</th>
                                                    <th scope="col">Initial Balance</th>
                                                    <th scope="col">Current Balance</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $count = 1; @endphp
                                                @foreach ($accounts as $account)
                                                @if ($account->account_type == 'Mobile')
                                                    <tr>
                                                        <th scope="row">{{$count}}</th>
                                                        <td>{{$account->acc_name}}</td>
                                                        <td>{{$account->acc_no}}</td>
                                                        <td>{{$account->acc_uses}}</td>
                                                        <td>{{$account->ini_balance}}</td>
                                                        <td>{{$account->crnt_balance}}</td>
                                                        <td>
                                                            <button class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#editMobileAcc{{$account->id}}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>

                                                            <a onclick="confirmation(event)" href="{{ url('delete_mobileAcc', $account->id) }}" class="btn btn-outline-danger btn-xs"><i class="fas fa-trash-alt"></i></a>
                                                        </td>
                                                    </tr>
                                                    @php $count++; @endphp

                                                    <!-- Edit Modal -->
                                                    <div class="modal fade" id="editMobileAcc{{$account->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$account->id}}" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <form action="{{url('update_mobileAcc', $account->id)}}" method="POST">
                                                                    @csrf
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Edit Mobile Account</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body text-left">
                                                                        <div class="row">
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="required-label">Account Uses</label>
                                                                                <select class="form-control form-select" name="acc_uses" aria-label="Default select example" required>
                                                                                    <option value="{{$account->acc_uses}}" selected>{{$account->acc_uses}}</option>
                                                                                    <option value="Office Accounnt">Office Accounnt</option>
                                                                                    <option value="Shop Accounnt">Shop Accounnt</option>
                                                                                    <option value="Both">Both</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="form-label required-label">Bank/Account Name</label>
                                                                                <select class="form-control form-select" name="acc_name" aria-label="Default select example" readonly>
                                                                                    <option value="{{$account->acc_name}}" selected>{{$account->acc_name}}</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="form-label required-label">Account No</label>
                                                                                <input type="text" class="form-control" name="acc_no" value="{{$account->acc_no}}" readonly>
                                                                            </div>
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="required-label">Type of Account</label>
                                                                                <select class="form-control form-select" name="acc_type" aria-label="Default select example" required>
                                                                                    <option value="{{$account->mob_acc_type}}">{{$account->mob_acc_type}}</option>
                                                                                    <option value="Business">Business</option>
                                                                                    <option value="Personal">Personal</option>
                                                                                    <option value="Agent">Agent</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="form-label required-label">Charge Per Transaction</label>
                                                                                <input type="text" class="form-control" name="trans_chrg" value="{{$account->trans_chrg}}" required>
                                                                            </div>
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="form-label required-label">Initial Balance</label>
                                                                                <input type="text" class="form-control" name="ini_balance" value="{{$account->ini_balance}}" readonly>
                                                                            </div>
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="form-label">Description</label>
                                                                                <textarea name="description" class="form-control" rows="2">{{$account->description}}</textarea>
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
                                    <div id="nav_link_4" class="tab-pane table-responsive fade">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="text-primary">
                                                    <th scope="col">SL</th>
                                                    <th scope="col">Account Name</th>
                                                    <th scope="col">Account Uses</th>
                                                    <th scope="col">Initial Balance</th>
                                                    <th scope="col">Current Balance</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $count = 1; @endphp
                                                @foreach ($accounts as $account)
                                                @if ($account->account_type == 'Station')
                                                    <tr>
                                                        <th scope="row">{{$count}}</th>
                                                        <td>{{$account->acc_name}}</td>
                                                        <td>{{$account->acc_uses}}</td>
                                                        <td>{{$account->ini_balance}}</td>
                                                        <td>{{$account->crnt_balance}}</td>
                                                        <td>
                                                            <button class="btn btn-outline-success btn-xs" data-toggle="modal" data-target="#editStationAcc{{$account->id}}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>

                                                            <a onclick="confirmation(event)" href="{{ url('delete_stationAcc', $account->id) }}" class="btn btn-outline-danger btn-xs"><i class="fas fa-trash-alt"></i></a>
                                                        </td>
                                                    </tr>
                                                    @php $count++; @endphp

                                                    <!-- Edit Modal -->
                                                    <div class="modal fade" id="editStationAcc{{$account->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$account->id}}" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <form action="{{url('update_stationAcc', $account->id)}}" method="POST">
                                                                    @csrf
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Edit Station Account</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body text-left">
                                                                        <div class="row">
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="required-label">Account Uses</label>
                                                                                <select class="form-control form-select" name="acc_uses" aria-label="Default select example" required>
                                                                                    <option value="{{$account->acc_uses}}" selected>{{$account->acc_uses}}</option>
                                                                                    <option value="Office Accounnt">Office Accounnt</option>
                                                                                    <option value="Shop Accounnt">Shop Accounnt</option>
                                                                                    <option value="Both">Both</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="form-label required-label">Bank/Account Name</label>
                                                                                <input type="text" class="form-control" name="acc_name" value="{{$account->acc_name}}" readonly>
                                                                            </div>
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="form-label">Description</label>
                                                                                <textarea name="description" class="form-control" rows="2">{{$account->description}}</textarea>
                                                                            </div>
                                                                            <div class="col-md-6 mb-4">
                                                                                <label class="form-label required-label">Initial Balance</label>
                                                                                <input type="text" class="form-control" name="ini_balance" value="{{$account->ini_balance}}" readonly>
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
                </div>
            </div>
        </section>

        <!-- Footer Sections -->
        @include('admin.dash_footer')

      </div>
    </div>

    <!-- Add Bank Account Modal -->
    <div id="addBankAcc" tabindex="-1" role="dialog" aria-labelledby="addBankAccModal" aria-hidden="true" class="modal fade text-left">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{url('add_bankAcc')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Bank Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="required-label">Account Uses</label>
                                <select class="form-control form-select" name="acc_uses" aria-label="Default select example" required>
                                    <option value="" selected>Select One</option>
                                    <option value="Office Accounnt">Office Accounnt</option>
                                    <option value="Shop Accounnt">Shop Accounnt</option>
                                    <option value="Both">Both</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label required-label">Bank/Account Name</label>
                                <select class="form-control form-select" name="acc_name" aria-label="Default select example" required>
                                    <option value="" selected>Select One</option>
                                    @foreach ($banks as $bank)
                                        @if ($bank->bank_type == 'General Bank')
                                            <option value="{{$bank->bank_name}}">{{$bank->bank_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label required-label">Account No</label>
                                <input type="text" class="form-control" name="acc_no" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label required-label">Branch Name</label>
                                <input type="text" class="form-control" name="acc_branch" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label required-label">Initial Balance</label>
                                <input type="text" class="form-control" name="ini_balance" required>
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

    <!-- Add Cash Account Modal -->
    <div id="addCashAcc" tabindex="-1" role="dialog" aria-labelledby="addBankAccModal" aria-hidden="true" class="modal fade text-left">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{url('add_cashAcc')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Cash Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="required-label">Account Uses</label>
                                <select class="form-control form-select" name="acc_uses" aria-label="Default select example" required>
                                    <option value="" selected>Select One</option>
                                    <option value="Office Accounnt">Office Accounnt</option>
                                    <option value="Shop Accounnt">Shop Accounnt</option>
                                    <option value="Both">Both</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label required-label">Bank/Account Name</label>
                                <input type="text" class="form-control" name="acc_name" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label required-label">Initial Balance</label>
                                <input type="text" class="form-control" name="ini_balance" required>
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

    <!-- Add Mobile Bank Account Modal -->
    <div id="addMobileAcc" tabindex="-1" role="dialog" aria-labelledby="addMobikeAccModal" aria-hidden="true" class="modal fade text-left">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{url('add_mobileAcc')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Mobile Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="required-label">Account Uses</label>
                                <select class="form-control form-select" name="acc_uses" aria-label="Default select example" required>
                                    <option value="" selected>Select One</option>
                                    <option value="Office Accounnt">Office Accounnt</option>
                                    <option value="Shop Accounnt">Shop Accounnt</option>
                                    <option value="Both">Both</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label required-label">Bank/Account Name</label>
                                <select class="form-control form-select" name="acc_name" aria-label="Default select example" required>
                                    <option value="" selected>Select One</option>
                                    @foreach ($banks as $bank)
                                        @if ($bank->bank_type == 'Mobile Bank')
                                            <option value="{{$bank->bank_name}}">{{$bank->bank_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label required-label">Account No</label>
                                <input type="text" class="form-control" name="acc_no" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="required-label">Type of Account</label>
                                <select class="form-control form-select" name="acc_type" aria-label="Default select example" required>
                                    <option value="Business">Business</option>
                                    <option value="Personal">Personal</option>
                                    <option value="Agent">Agent</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label required-label">Charge Per Transaction</label>
                                <input type="text" class="form-control" name="trans_chrg" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label required-label">Initial Balance</label>
                                <input type="text" class="form-control" name="ini_balance" required>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="1"></textarea>
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

    <!-- Add Station Account Modal -->
    <div id="addStationAcc" tabindex="-1" role="dialog" aria-labelledby="addStationAccModal" aria-hidden="true" class="modal fade text-left">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{url('add_stationAcc')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Station Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="required-label">Account Uses</label>
                                <select class="form-control form-select" name="acc_uses" aria-label="Default select example" required>
                                    <option value="" selected>Select One</option>
                                    <option value="Office Accounnt">Office Accounnt</option>
                                    <option value="Shop Accounnt">Shop Accounnt</option>
                                    <option value="Both">Both</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label required-label">Bank/Account Name</label>
                                <input type="text" class="form-control" name="acc_name" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label required-label">Initial Balance</label>
                                <input type="text" class="form-control" name="ini_balance" required>
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

                // Show/Hide buttons based on active link
                if (target === "#nav_link_1") {
                    $("#bank_acc_modal").removeClass("d-none");
                    $("#cash_acc_modal, #bank_mobile_modal, #bank_station_modal").addClass("d-none");
                } else if (target === "#nav_link_2") {
                    $("#cash_acc_modal").removeClass("d-none");
                    $("#bank_acc_modal, #bank_mobile_modal, #bank_station_modal").addClass("d-none");
                } else if (target === "#nav_link_3") {
                    $("#bank_mobile_modal").removeClass("d-none");
                    $("#bank_acc_modal, #cash_acc_modal, #bank_station_modal").addClass("d-none");
                } else if (target === "#nav_link_4") {
                    $("#bank_station_modal").removeClass("d-none");
                    $("#bank_acc_modal, #cash_acc_modal, #bank_mobile_modal").addClass("d-none");
                }
            });
        });
    </script>
  </body>
</html>
