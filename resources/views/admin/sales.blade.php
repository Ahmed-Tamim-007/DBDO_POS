<!DOCTYPE html>
<html>
  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.dash_head')
    <title>Admin - Sales</title>
    <style>
        .td_1 {
            width: 80%;
        }

        .td_2 {
            width: 20%;
        }
        .table tr td {
            padding: 5px 7px;
        }

        #salesInfoTable td {
            padding: 1px 2px !important;
        }
    </style>
  </head>
  <body>
    <!-- Header -->
    @include('admin.dash_header')

    <div class="d-flex align-items-stretch" id="sales_content">
        <!-- Sidebar Navigation-->
        @include('admin.dash_sidebar')
        <!-- Sidebar Navigation end-->
        <div class="page-content" style="width: 100% !important;">
            <section class="no-padding-top" style="padding-top: 2rem !important">
                <div class="container-fluid">
                    <div class="row" id="wrapper">
                        <div class="col-md-8">
                            <div class="block" style="background-color: #019bee">
                                <form id="product_form">
                                    <div class="row mb-3" id="sales_search">
                                        <div class="col-md-12 position-relative">
                                            <div class="input-group">
                                                <input type="text" id="product_search" name="product" class="form-control" style="background-color: #ffffff" autocomplete="off" placeholder="Search Product...">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-success"><i class="icon-magnifying-glass-browser"></i></button>
                                                </div>
                                            </div>

                                            <div id="product_search_list" class="list-group"></div>
                                            <input type="hidden" name="batch_no" id="">
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-lg-4 col-md-7 position-relative pr-md-0">
                                        <div class="input-group">
                                            <input type="text" id="customer_search" name="customer" class="form-control" style="background-color: #ffffff" autocomplete="off" placeholder="Search Customer...">
                                            <div class="input-group-append">
                                                <button type="button" data-toggle="modal" data-target="#addCustomer" class="btn btn-success ms-auto"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="customerID" id="customerID">
                                        <div id="customer_search_list" class="list-group"></div>
                                    </div>
                                    <div class="col-lg-3 col-md-5" style="font-size: 14px; color: #ffffff;">
                                        <div>PH: <span id="cus_phone"></span></div>
                                        <div>Due: <span id="cus_due"></span> &#2547; &nbsp; PT: <span id="cus_points"></span></div>
                                    </div>
                                    <div class="col-lg-3 col-md-8" style="font-size: 14px; color: #ffffff;">
                                        <div>Type: <span id="cus_type"></span></div>
                                        <div>Dis: <span id="cus_dis"></span> % &nbsp; Tgt: <span id="cus_dis_ter"></span> &#2547;</div>
                                    </div>
                                    <div class="col-lg-2 col-md-4">
                                        <button type="button" data-toggle="modal" id="remitModal" data-target="#addRemitModal" class="btn btn-success w-100 d-none">Remit</button>
                                    </div>
                                </div>
                            </div>
                            <div class="block">
                                <div class="table-responsive">
                                    <table id="sales_table" class="table table-hover">
                                        <thead>
                                            <tr style="background-color: #019bee; color: #ffffff;">
                                                <th scope="col" style="display: none">ID</th>
                                                <th scope="col">Product</th>
                                                <th scope="col">Batch</th>
                                                <th scope="col">Stock</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Price (&#2547;)</th>
                                                <th scope="col">Total (&#2547;)</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        </tbody>

                                        <tfoot>
                                            <tr style="background-color: #019bee; color: #ffffff;">
                                                <th scope="col" colspan="3" class="text-right">Totals:</th>
                                                <th id="t_qty" scope="col">0</th>
                                                <th></th>
                                                <th id="total" scope="col">0.00</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="my-3">
                                    <label for="sale_note">Sale Note:</label>
                                    <textarea class="form-control" id="sale_note" rows="2" style="background-color: #d9edff;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="block px-0 py-0">
                                <h6 class="text-center mb-0 py-2" style="color: #ffffff; background-color: #019bee;">CART TOTAL : <span id="cart_total">0</span> &#2547;</h6>
                                <table class="table table-hover" id="count_table" style="font-size: 13px;">
                                    <tbody>
                                        <tr class="d-none font-weight-bold" id="discount_tr">
                                            <td class="td_1">Discount <span id="dis_amt"></span></td>
                                            <td class="td_2" id="grand_discount">0</td>
                                        </tr>
                                        <tr>
                                            <td class="td_1">Total</td>
                                            <td class="td_2" id="grand_total">0</td>
                                        </tr>
                                        <tr class="d-none" id="remit_tr">
                                            <td class="td_1">Remit</td>
                                            <td class="td_2" id="grand_remit">0</td>
                                        </tr>
                                        <tr class="d-none" id="replace_tr">
                                            <td class="td_1">Replace Total</td>
                                            <td class="td_2" id="grand_replace">0</td>
                                        </tr>
                                        <tr>
                                            <td class="td_1">Paid</td>
                                            <td class="td_2" id="grand_paid">0</td>
                                        </tr>
                                        <tr>
                                            <td class="td_1" id="round_td">
                                                <div class="label-switch-wrapper">
                                                    <label for="round_check" class="m-0">Round</label>
                                                    <label class="switch">
                                                        <input id="round_check" type="checkbox">
                                                        <span class="slider"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="td_2" id="grand_round">0</td>
                                        </tr>
                                        <tr class="text-primary">
                                            <td class="td_1">Total Due:</td>
                                            <td class="td_2" id="grand_due">0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="block" style="background-color: #d9edff;">
                                <h4 class="text-primary pb-2" style="border-bottom: 2px solid #019bee;">Payment Option:</h4>
                                <div class="row payment-options">
                                    <div class="col-lg-3 col-md-6">
                                        <label class="custom-radio w-100" for="radio_cash">
                                            <input type="radio" name="radio_amount" id="radio_cash">
                                            <span>Cash</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <label class="custom-radio w-100" for="radio_card">
                                            <input type="radio" name="radio_amount" id="radio_card">
                                            <span>Card</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <label class="custom-radio w-100" for="radio_mob">
                                            <input type="radio" name="radio_amount" id="radio_mob">
                                            <span>Mobile</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <label class="custom-radio w-100" for="radio_modal" id="multi_pay_btn" data-toggle="modal" data-target="#multi_pay">
                                            <input type="radio" name="radio_amount" id="radio_modal">
                                            <span>Multiple</span>
                                        </label>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <input class="form-control form-control-sm mb-3 sum_total only_num" type="text" name="cash_amt" id="cash_amt" placeholder="Cash Amount">
                                    </div>
                                </div>
                                <div class="row pay_option" id="cash_field">
                                    <div class="col-md-6">
                                        <input class="form-control form-control-sm mb-3 only_num" type="text" name="cash_paid" id="cash_paid" placeholder="Cash Paid">
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control form-control-sm mb-3 only_num" type="text" name="cash_change" id="cash_change" placeholder="Change Amount" readonly>
                                    </div>
                                </div>
                                <div class="row pay_option" id="card_field" style="display: none;">
                                    <div class="col-md-4">
                                        <input class="form-control form-control-sm mb-3 only_num" type="text" name="card_number" id="card_number" placeholder="Card Number">
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control form-control-sm mb-3" name="card_type" id="card_type">
                                            <option value="">Card Type</option>

                                            @foreach ($cardnames as $cardname)
                                                <option value="{{ $cardname->id }}">
                                                    {{ $cardname->card_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control form-control-sm mb-3" name="bank_type" id="bank_type">
                                            <option value="">Select Bank</option>

                                            @foreach ($accounts as $account)
                                                @if ($account->account_type == 'Bank')
                                                    <option value="{{ $account->id }}">
                                                        {{ $account->acc_name }} ({{ $account->acc_no }})
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row pay_option" id="mobile_field" style="display: none;">
                                    <div class="col-md-4">
                                        <select class="form-control form-control-sm mb-3" name="mobile_bank" id="mobile_bank">
                                            <option value="">Mobile Bank</option>

                                            @foreach ($accounts as $account)
                                                @if ($account->account_type == 'Mobile')
                                                    <option value="{{ $account->id }}">
                                                        {{ $account->acc_name }} ({{ $account->acc_no }})
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control form-control-sm mb-3 only_num" type="text" name="trans_no" id="trans_no" placeholder="Transaction No">
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control form-control-sm mb-3 only_num" type="text" name="rece_no" id="rece_no" placeholder="Reciever No">
                                    </div>
                                </div>
                                <div class="row multi_option d-none"></div>
                                <button class="btn btn-primary w-100 btn-sm my-2" id="add_sale_btn">Sale Now</button>
                            </div>
                            <div class="block d-flex flex-wrap" style="background-color: #d9edff;">
                                <button class="btn btn-warning btn-sm px-4 mb-1 mx-auto" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Discount" data-toggle="modal" data-target="#dis_modal"><i class="fa fa-percent"></i></button>
                                <button class="btn btn-danger btn-sm px-4 mb-1 mx-auto" id="hold_sale_btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hold Sale"><i class="fa fa-pause"></i></button>
                                <button class="btn btn-secondary btn-sm px-4 mb-1 mx-auto" data-toggle="modal" data-target="#sales_restore_modal" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Restore"><i class="fa fa-rotate-left"></i></button>
                                <button class="btn btn-info btn-sm px-4 mb-1 mx-auto" data-toggle="modal" data-target="#sale_replace_modal" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Sale Replace"><i class="fa fa-arrows-rotate"></i></button>
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
                <div class="modal-header"><strong id="exampleModalLabel" class="modal-title">Add Customer</strong>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="required-label">Membership ID</label>
                            <div class="d-flex">
                                <input type="number" class="form-control form-control-sm me-2" id="member_id" required>
                                <button class="btn btn-outline-info btn-sm member_id_generate"><i class="fas fa-sync-alt me-2"></i></button>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="required-label">Customer Type</label>
                            <select class="form-control form-control-sm form-select" id="c_type" aria-label="Default select example" required>
                                <option value="" selected>Select One</option>
                                <option value="Basic">Basic</option>

                                @foreach ($customer_types as $customer_type)
                                    <option value="{{$customer_type->type_name}}">{{$customer_type->type_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="required-label">Full Name</label>
                            <input type="text" class="form-control form-control-sm" id="c_name" required>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="mt-1">Email</label>
                            <input type="email" class="form-control form-control-sm" id="c_email">
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="required-label">Phone</label>
                            <input type="text" class="form-control form-control-sm" id="c_phone" required>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="mt-1">Gender</label>
                            <select class="form-control form-control-sm form-select" id="c_gender" aria-label="Default select example">
                                <option value="" selected>Select One</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-4">
                            <label class="mt-1">Date of Birth</label>
                            <input type="date" class="form-control form-control-sm" id="dob">
                        </div>
                        <div class="col-md-3 mb-4">
                            <label class="mt-1">Marital Status</label>
                            <select class="form-control form-control-sm form-select" id="m_status" aria-label="Default select example">
                                <option value="" selected>Select One</option>
                                <option value="married">Married</option>
                                <option value="unmarried">Unmarried</option>
                                <option value="divorced">Divorced</option>
                                <option value="widowed">Widowed</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-4">
                            <label class="mt-1">Anniversary Date</label>
                            <input type="date" class="form-control form-control-sm" id="anniversary">
                        </div>
                        <div class="col-md-3 mb-4">
                            <label class="mt-1">Address Type</label>
                            <select class="form-control form-control-sm form-select" id="adrs_type" aria-label="Default select example">
                                <option value="" selected>Select One</option>
                                <option value="present_address">Present Address</option>
                                <option value="permanent_address">Permanent Address</option>
                                <option value="shipping_address">Shipping Address</option>
                                <option value="billing_address">Billing Address</option>
                            </select>
                        </div>
                        <div class="col-md-5 mb-4">
                            <label class="mt-1">Address</label>
                            <textarea class="form-control form-control-sm" id="address" rows="1"></textarea>
                        </div>
                        <div class="col-lg-4 mb-2">
                            <label class="mt-1">Photo/Logo</label>
                            <input type="file" class="form-control form-control-sm" id="cusImage" name="imageFile">
                            <p class="text-primary text-bold" style="font-size: 12px">Use jpg,jpeg,png,gif only.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
                    <input type="submit" id="addCustomerSubmit" class="btn btn-primary" value="Submit">
                </div>
            </div>
        </div>
    </div>
    <!-- Remit Modal -->
    <div class="modal fade" id="addRemitModal" tabindex="-1" role="dialog" aria-labelledby="dis_modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="discount_modal">
                <div class="modal-header">
                    <h5 class="modal-title">Add Remit</h5>
                    <button type="button" class="close" id="remit_modal_close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-left">
                    <h5 class="mb-3 text-primary">
                        1 point = <span id="PointRateSpan"></span> &#2547;
                    </h5>
                    <div class="mb-3">
                        Current Points: <span id="CusPointSpan"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Redeem Points</label>
                        <input type="text" class="form-control only_num" name="remit_amt" id="remit_amt">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="remit_submit_btn" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Discount Modal -->
    <div class="modal fade" id="dis_modal" tabindex="-1" role="dialog" aria-labelledby="dis_modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="discount_modal">
                <div class="modal-header">
                    <h5 class="modal-title">Add Discount</h5>
                    <button type="button" class="close" id="dis_modal_close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-left">
                    <div class="mb-4">
                        <label class="form-label">Discount (%)</label>
                        <input type="text" class="form-control only_num" name="dis_per" id="dis_per">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Discount (&#2547;)</label>
                        <input type="text" class="form-control only_num" name="dis_tk" id="dis_tk">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="dis_submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Multi Pay Modal -->
    <div id="multi_pay" tabindex="-1" role="dialog" aria-labelledby="multi_payLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><strong id="exampleModalLabel" class="modal-title">Multiple Payment</strong>
                    <button type="button" data-dismiss="modal" id="multi_pay_close" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Cash Amount</label>
                            <input class="form-control form-control-sm mb-3 sum_total only_num" type="text" name="m_cash_amt" id="m_cash_amt" data-info="cash" placeholder="Enter Amount">
                        </div>
                        <div class="col-md-3">
                            <label for="">Card Amount</label>
                            <input class="form-control form-control-sm mb-3 sum_total only_num" type="text" name="m_card_paid" id="m_card_paid" data-info="card"  placeholder="Enter Amount">
                        </div>
                        <div class="col-md-3">
                            <label for="">Card Number</label>
                            <input class="form-control form-control-sm mb-3 only_num" type="text" name="m_card_number" id="m_card_number" placeholder="Card Number">
                        </div>
                        <div class="col-md-3">
                            <label for="">Select Card</label>
                            <select class="form-control form-control-sm mb-3" name="m_card_type" id="m_card_type">
                                <option value="">Card Type</option>

                                @foreach ($cardnames as $cardname)
                                    <option value="{{ $cardname->id }}">
                                        {{ $cardname->card_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Select Bank</label>
                            <select class="form-control form-control-sm mb-3" name="m_bank_type" id="m_bank_type">
                                <option value="">Select Bank</option>

                                @foreach ($accounts as $account)
                                    @if ($account->account_type == 'Bank')
                                        <option value="{{ $account->id }}">
                                            {{ $account->acc_name }} ({{ $account->acc_no }})
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Mobile Amount</label>
                            <input class="form-control form-control-sm mb-3 sum_total only_num" type="text" name="m_mobile_paid" id="m_mobile_paid" data-info="mob_bank" placeholder="Mobile Amount">
                        </div>
                        <div class="col-md-4">
                            <label for="">Transaction ID</label>
                            <input class="form-control form-control-sm mb-3 only_num" type="text" name="m_trans_no" id="m_trans_no" placeholder="Transaction No">
                        </div>
                        <div class="col-md-4">
                            <label for="">Select Mobile Bank</label>
                            <select class="form-control form-control-sm mb-3" name="m_mobile_bank" id="m_mobile_bank">
                                <option value="">Mobile Bank</option>

                                @foreach ($accounts as $account)
                                    @if ($account->account_type == 'Mobile')
                                        <option value="{{ $account->id }}">
                                            {{ $account->acc_name }} ({{ $account->acc_no }})
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="multi_cancel">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="multi_submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- After_Sale Modal -->
    <div class="modal fade" id="saleSummaryModal" tabindex="-1" aria-labelledby="saleSummaryLabel" aria-hidden="true">
        <div class="modal-dialog" id="printModal">
            <div class="modal-content">
                <div class="modal-body p-5" id="saleSummaryContent">
                    {{-- Dynamic Content --}}
                </div>
                <div id="modal_footer" class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="print_close_btn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="print_btn">Print</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Sales Restore Modal -->
    <div id="sales_restore_modal" tabindex="-1" role="dialog" aria-labelledby="sales_restore_modalmodal" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header"><strong id="category_modal" class="modal-title">Hold Sale List</strong>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close" id="restore_close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <thead>
                        <tr class="text-primary">
                            <th scope="col">SL.</th>
                            <th scope="col">Invoice No</th>
                            <th scope="col">Held Products</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($heldSales as $heldSale)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{ $heldSale->invoiceNo }}</td>
                                <td>{{ $heldSale->held_products }}</td>
                                <td>{{ \Carbon\Carbon::parse($heldSale->date)->format('d M Y, h:i A') }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm restore-sale-btn" data-invoice="{{ $heldSale->invoiceNo }}" data-count="{{ $heldSale->held_products }}">Restore</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
          </div>
        </div>
    </div>
    <!-- Sale Replace Modal -->
    <div class="modal fade" id="sale_replace_modal" tabindex="-1" role="dialog" aria-labelledby="sale_replace_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="">
                <div class="modal-header">
                    <h5 class="modal-title">Sale Replace</h5>
                    <button type="button" class="close" id="sale_replace_close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-left">
                    <div class="form-group my-0 mx-auto w-75" id="invoice_search">
                        <div class="input-group">
                            <input type="text" class="form-control" id="invoice_search_input" placeholder="Search Invoice No...">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" id="invoice_search_btn"><i class="icon-magnifying-glass-browser"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive" id="return_table_div">
                        <table class="table table-hover" id="return_table">
                            <thead>
                                <tr class="text-primary">
                                    <th scope="col">Check</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Batch</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Returned</th>
                                    <th scope="col" style="width: 140px;">Return Qty</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Total Price</th>
                                    <th scope="col" class="d-none">Product ID</th>
                                    <th scope="col" class="d-none">Sale ID</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-3 ml-auto">
                                <table class="table mt-3" id="salesInfoTable" style="font-size: 12px;">
                                    <tbody>
                                        <tr>
                                            <td>Card Total</td>
                                            <td class="text-right" id="card_total"></td>
                                        </tr>
                                        <tr>
                                            <td>Discount</td>
                                            <td class="text-right" id="sale_dis"></td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td class="text-right" id="sale_total"></td>
                                        </tr>
                                        <tr>
                                            <td>Round</td>
                                            <td class="text-right" id="sale_round"></td>
                                        </tr>
                                        <tr>
                                            <td>Paid Amount</td>
                                            <td class="text-right" id="paid_amt"></td>
                                        </tr>
                                        <tr>
                                            <td>Total Due</td>
                                            <td class="text-right" id="sale_due"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <button type="button" id="addToreturn" class="btn btn-primary btn-sm mt-3">Add Return</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Files -->
    @include('admin.dash_script')
    <!-- Print JS Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.min.css">


    <!-- JS For product search -->
    <script>
        $(document).ready(function() {
            let formSubmitted = false;

            $('#product_search').on('keyup', function(event) {
                let query = $(this).val().trim();
                var inputValue = event.which;
                if (!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)) {
                    event.preventDefault();
                }else{
                    if (query.length > 0 && !formSubmitted) {
                        $.ajax({
                            url: "{{ route('search.sales.products') }}",
                            type: "GET",
                            data: { query: query },
                            success: function(data) {
                            if (formSubmitted) return; // Stop processing if the form was already submitted
                            $('#product_search_list').empty();

                            if (data.length > 0) {
                                let oldestBatch; // Store the oldest batch for later use

                                $.each(data, function(index, product) {
                                    if (index === 0) {
                                        oldestBatch = product; // Assign the first item as the oldest batch
                                    }

                                    $('#product_search_list').append(
                                        `<a href="#" class="list-group-item list-group-item-action" data-batch-no="${product.batch_no}">
                                        ${product.title} (${product.batch_no})
                                        </a>`
                                    );
                                });
                            } else {
                                $('#product_search_list').append(`<div class="list-group-item">No products found</div>`);
                            }
                            },
                            error: function() {
                                $('#product_search_list').append(`<div class="list-group-item">Error fetching products</div>`);
                            }
                        });
                    }
                }
                if (!$(this).val().trim()) {
                    $('#product_search_list').empty();
                }
            });

            $('#product_form').on('submit', function() {
                $('#product_search_list').empty();
            });

            $(document).on('click', '.list-group-item-action', function(e) {
                e.preventDefault();
                const selectedText = $(this).text().split(' (')[0].trim();
                const batchNo = $(this).data('batch-no');

                $('#product_search').val(selectedText);
                $('input[name="batch_no"]').val(batchNo);
                $('#product_search_list').empty();
                $("#product_search").focus();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let exactMatch = false;
            let formSubmitted = false;

            $('#product_search').scannerDetection(function(){
                let query = $(this).val().trim();

                if (query.length > 0 && !formSubmitted) {
                    $.ajax({
                        url: "{{ route('search.sales.products') }}",
                        type: "GET",
                        data: { query: query },
                        success: function(data) {
                        if (formSubmitted) return; // Stop processing if the form was already submitted
                        $('#product_search_list').empty();
                        exactMatch = false;

                        if (data.length > 0) {
                            let oldestBatch; // Store the oldest batch for later use

                            $.each(data, function(index, product) {
                                if (index === 0) {
                                    oldestBatch = product; // Assign the first item as the oldest batch
                                }

                                if (product.title.toLowerCase() === query.toLowerCase() || product.barcode === query) {
                                    exactMatch = true;
                                }
                            });

                            if (exactMatch && !formSubmitted) {
                                formSubmitted = true;
                                $('#product_search').val(oldestBatch.title);
                                $('input[name="batch_no"]').val(oldestBatch.batch_no);
                                $('#product_search_list').empty();
                                $('#product_form').submit();
                                formSubmitted = false;
                            }
                        }
                        },
                    });
                } else {
                    $('#product_search_list').empty();
                }
            });
        });
    </script>
    <!-- JS For customer search -->
    <script>
        $(document).ready(function () {
            const customer_points = @json($customer_points);
            const customer_types = @json($customer_types);

            $('#customer_search').on('keyup', function () {
                let query = $(this).val();

                // Clear the phone, due, points, and type if the input is empty
                if (!query) {
                    $('#customer_search_list').html('');
                    $('#cus_phone').text('');
                    $('#cus_due').text('');
                    $('#cus_points').text('');
                    $('#customerID').val('');
                    $('#CusPointSpan').text('');
                    $('#cus_type').text('');
                    $('#cus_dis').text(''); // Clear discount
                    $('#cus_dis_ter').text(''); // Clear target_sale
                    $('#remitModal').addClass('d-none');
                    return;
                }

                $.ajax({
                    url: "{{ route('search.sales.customers') }}",
                    type: "GET",
                    data: { query: query },
                    success: function (data) {
                        let html = '';

                        if (data.length > 0) {
                            data.forEach(customer => {
                                html += `<a href="#" class="list-group-customer list-group-customer-action"
                                             data-id="${customer.id}" data-phone="${customer.phone.trim()}"
                                             data-due="${customer.due}" data-point="${customer.points}" data-type="${customer.type}">
                                             ${customer.name.trim()} (${customer.phone.trim()})
                                         </a>`;
                            });
                        } else {
                            html = '<a href="#" class="list-group-customer">No customers found</a>';
                        }

                        $('#customer_search_list').html(html);
                    },
                    error: function () {
                        $('#customer_search_list').html('<a href="#" class="list-group-customer">An error occurred</a>');
                    }
                });
            });

            // Event delegation for dynamically added elements
            $(document).on('click', '#customer_search_list .list-group-customer', function (e) {
                e.preventDefault();

                // Prevent appending customer if sales table is empty
                if ($('#sales_table tbody tr').length == 0) {
                    alert('Please select a product to add customer!');
                    $('#customer_search').val('');
                    $('#cus_phone').text('');
                    $('#cus_due').text('');
                    $('#cus_points').text('');
                    $('#CusPointSpan').text('');
                    $('#cus_type').text('');
                    $('#cus_dis').text('');
                    $('#cus_dis_ter').text('');
                    $('#remitModal').addClass('d-none');
                    $('#customerID').val('');
                    $('#customer_search_list').html('');
                    return;
                }

                let selectedName = $(this).text().trim();
                let customerId = $(this).data('id');
                let customerPhone = $(this).data('phone').trim();
                let customerDue = $(this).data('due');
                let customerPoint = $(this).data('point');
                let customerType = $(this).data('type');

                $('#customer_search').val(selectedName);
                $('#customerID').val(customerId);
                $('#cus_phone').text(customerPhone);
                $('#cus_due').text(customerDue);
                $('#cus_points').text(customerPoint);
                $('#PointRateSpan').text(customer_points.redeem_rate);
                $('#CusPointSpan').text(customerPoint);
                $('#cus_type').text(customerType);
                $('#remitModal').removeClass('d-none');
                $('#customer_search_list').html('');

                // Match the selected customer type with customer_types JSON
                let typeData = customer_types.find(type => type.type_name === customerType);

                if (typeData) {
                    $('#cus_dis').text(typeData.discount);
                    $('#cus_dis_ter').text(typeData.target_sale);
                } else {
                    $('#cus_dis').text('');
                    $('#cus_dis_ter').text('');
                }
            });

            // Listen for changes to the #customer_search field
            $('#customer_search').on('input', function () {
                if (!$(this).val().trim()) {
                    $('#cus_phone').text('');
                    $('#cus_due').text('');
                    $('#cus_points').text('');
                    $('#CusPointSpan').text('');
                    $('#cus_type').text('');
                    $('#cus_dis').text('');
                    $('#cus_dis_ter').text('');
                    $('#remitModal').addClass('d-none');
                    $('#customerID').val('');
                    $('#customer_search_list').html('');
                }
            });
        });
    </script>
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
    <!-- JS For adding customer -->
    <script>
        $(document).ready(function () {
            $('#addCustomerSubmit').on('click', function () {
                const memberCode = $('#member_id').val();
                const cusType = $('#c_type').val();
                const cusName = $('#c_name').val();
                const cusEmail = $('#c_email').val();
                const cusPhone = $('#c_phone').val();
                const cusGender = $('#c_gender').val();
                const dateOfBirth = $('#dob').val();
                const mStatus = $('#m_status').val();
                const anniversary = $('#anniversary').val();
                const adrsType = $('#adrs_type').val();
                const adrs = $('#address').val();
                const imageFile = $('#cusImage')[0].files[0];

                // Prepare the form data including stock_hidden data
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('memberCode', memberCode);
                formData.append('cusType', cusType);
                formData.append('cusName', cusName);
                formData.append('cusEmail', cusEmail);
                formData.append('cusPhone', cusPhone);
                formData.append('cusGender', cusGender);
                formData.append('dateOfBirth', dateOfBirth);
                formData.append('mStatus', mStatus);
                formData.append('anniversary', anniversary);
                formData.append('adrsType', adrsType);
                formData.append('adrs', adrs);
                formData.append('imageFile', imageFile);

                // Send data to the server via AJAX
                $.ajax({
                    url: '{{ route("add.customer.sales") }}', // Laravel route URL
                    type: 'POST',
                    data: formData,
                    processData: false,  // Prevent jQuery from processing the data
                    contentType: false,  // Prevent jQuery from setting the content type
                    success: function (response) {
                        if (response.success) {
                            // Show success toastr notification
                            toastr.success(response.message || 'Customer added successfully!', 'Success', {
                                timeOut: 5000,
                                closeButton: true,
                                progressBar: true
                            });

                            // Close modal (if applicable)
                            $('.close').click();
                        } else {
                            // Show error toastr notification
                            toastr.error(response.message || 'An error occurred.', 'Error', {
                                timeOut: 5000,
                                closeButton: true,
                                progressBar: true
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        // Show error toastr notification
                        toastr.error('An error occurred: ' + xhr.responseText, 'Error', {
                            timeOut: 5000,
                            closeButton: true,
                            progressBar: true
                        });
                    },
                });
            });
        });
    </script>
    <!-- Other JS -->
    <script>
        $(document).ready(function () {
            // Initialize Bootstrap tooltips with a delay
            var tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    delay: { "show": 500, "hide": 100 }  // 500ms delay before showing, 100ms before hiding
                })
            })

            // Restriction on text type input to enter anything other than Numbers
            $(document).on('input', '.only_num', function() {
                let value = $(this).val();
                if (!/^\d*\.?\d*$/.test(value)) { // Validates the decimal format
                    $(this).val(value.slice(0, -1)); // Remove the last invalid character
                }
            });

            // Monitor changes in #dis_per input field
            $('#dis_per').on('input', function () {
                if ($(this).val().trim() !== '') {
                    // Disable #dis_tk when #dis_per has a value
                    $('#dis_tk').prop('disabled', true);
                } else {
                    // Enable #dis_tk when #dis_per is empty
                    $('#dis_tk').prop('disabled', false);
                }
            });
            // Monitor changes in #dis_tk input field
            $('#dis_tk').on('input', function () {
                if ($(this).val().trim() !== '') {
                    // Disable #dis_per when #dis_tk has a value
                    $('#dis_per').prop('disabled', true);
                } else {
                    // Enable #dis_per when #dis_tk is empty
                    $('#dis_per').prop('disabled', false);
                }
            });
        });
    </script>
    <!-- JS for MultiPayment -->
    <script>
        $(document).ready(function () {
            // Show cash_field by default
            $('#cash_field').show();
            $('#card_field, #mobile_field').hide();

            // Toggle fields based on radio selection
            $('input[name="radio_amount"]').on('click', function () {
                const selectedId = $(this).attr('id');
                $('#cash_field, #card_field, #mobile_field').hide(); // Hide all fields
                if (selectedId === 'radio_cash') {
                    $('#cash_field').show();
                } else if (selectedId === 'radio_card') {
                    $('#card_field').show();
                } else if (selectedId === 'radio_mob') {
                    $('#mobile_field').show();
                }
            });

            // When "Multiple" radio is clicked, disable other radios
            $('#radio_modal').on('click', function () {
                $('input[name="radio_amount"]').not(this).prop('disabled', true);
            });

            // When the Cancel button is clicked, re-enable the other radios
            $('#multi_cancel').on('click', function () {
                $('input[name="radio_amount"]').prop('disabled', false); // Re-enable all radios
                $('#radio_modal').prop('checked', false); // Uncheck the "Multiple" radio

                // Clear appended divs and reset multiTotal
                $('.multi_option').empty();
                $('#grand_paid').text('0.00');
                $('#cash_amt').val('0.00');
                $('#grand_due').text($('#grand_total').text()); // Reset due to grand total

                // Programmatically trigger the click event on #multi_pay_close
                $('#multi_pay_close').click();
            });

            $('#multi_submit').on('click', function () {
                // Clear previous appended divs
                $('.multi_option').empty();

                $('.pay_option').hide();
                $('.multi_option').removeClass('d-none');

                var cashAmt = parseFloat($('#m_cash_amt').val());
                var cardAmt = parseFloat($('#m_card_paid').val());
                var mobileAmt = parseFloat($('#m_mobile_paid').val());

                const m_cardNumber = $('#m_card_number').val();
                const m_cardType = $('#m_card_type').val();
                const m_bankType = $('#m_bank_type').val();
                const m_mobTrans = $('#m_trans_no').val();
                const m_mobBank = $('#m_mobile_bank').val();

                // Validating when card paying option is selected
                if (cardAmt > 0) {
                    // Check if card number is null or empty
                    if (!m_cardNumber) {
                        alert("Enter Card number to proceed!");
                        return;
                    }

                    // Check if card type is not selected
                    if (!m_cardType) {
                        alert("Select a Card type to proceed!");
                        return;
                    }

                    // Check if bank type is not selected
                    if (!m_bankType) {
                        alert("Select a Bank to proceed!");
                        return;
                    }
                }

                // Validating when mobile paying option is selected
                if (mobileAmt > 0) {
                    // Check if card type is not selected
                    if (!m_mobTrans) {
                        alert("Enter transaction no. to proceed!");
                        return;
                    }

                    // Check if card number is null or empty
                    if (!m_mobBank) {
                        alert("Select a mobile bank to proceed!");
                        return;
                    }
                }

                let multiTotal = 0;

                if (cashAmt > 0) {
                    multiTotal += cashAmt;
                    $('.multi_option').append("<div class='col-md-4 mb-2'> Cash: <span class='m_cashAmt'>" + cashAmt + "</span> &#2547;</div>");
                }

                if (cardAmt > 0) {
                    var cardNumber = $('#m_card_number').val();
                    var cardType = $('#m_card_type').val();
                    var cardBank = $('#m_bank_type').val();
                    multiTotal += cardAmt;
                    $('.multi_option').append("<div class='col-md-4 mb-2'> Card: <span class='m_cardAmt'>" + cardAmt + "</span> &#2547;</div>");
                }

                if (mobileAmt > 0) {
                    var mobTrans = $('#m_trans_no').val();
                    var mobBank = $('#m_mobile_bank').val();
                    multiTotal += mobileAmt;
                    $('.multi_option').append("<div class='col-md-4 mb-2'> Mobile: <span class='m_mobAmt'>" + mobileAmt + "</span> &#2547;</div>");
                }

                $('#grand_paid').text(multiTotal.toFixed(2));
                var grandDue = parseFloat($('#grand_total').text()) - multiTotal;
                $('#cash_amt').val(multiTotal.toFixed(2));
                $('#grand_due').text(grandDue.toFixed(2));

                // Programmatically trigger the click event on #multi_pay_close
                $('#multi_pay_close').click();
            });
        });
    </script>
    <!-- JS For Sales -->
    <script>
        $(document).ready(function () {
            const stocks = @json($stocks);
            const restoreSale = @json($restoreSale);
            const products = @json($products);

            function updateTotals() {
                let totalQuantity = 0;
                let totalOfAll = 0;

                // Loop through each row in the sales table
                $('#sales_table tbody tr').each(function () {
                    const saleQty = parseFloat($(this).find('.so-qty-input').val()) || 0;
                    const totalPrice = parseFloat($(this).find('.total-input').val()) || 0;

                    totalQuantity += saleQty;
                    totalOfAll += totalPrice;
                });

                // Update table footer with total quantity and price
                $('#sales_table tfoot #t_qty').text(totalQuantity.toFixed(2));
                $('#sales_table tfoot #total').text(totalOfAll.toFixed(2));

                // Update cart total
                $('#cart_total').text(totalOfAll.toFixed(2));

                const replaceTotal = $('#count_table #grand_replace').text();

                const remitAmt = $('#remit_amt').val();
                const redeemPoint = $('#PointRateSpan').text();
                const totalRemitAmt = (remitAmt * redeemPoint)

                // Fetch user inputs for discount
                const disPer = parseFloat($('#dis_per').val()) || 0; // Percentage discount
                const disTk = parseFloat($('#dis_tk').val()) || 0;   // Direct value discount
                let discount = 0;

                // Calculate discount
                if (disPer > 0) {
                    discount = (disPer / 100) * totalOfAll;
                } else if (disTk > 0) {
                    discount = disTk;
                }

                // Ensure discount does not exceed totalOfAll
                if (discount > totalOfAll) {
                    discount = totalOfAll;
                }

                // Update discounted total
                const discountedTotal = totalOfAll - discount - totalRemitAmt;
                const discountedReplaceTotal = discountedTotal - replaceTotal;

                // Remove `d-none` class if there is a discount, else add it
                if (discount > 0) {
                    $('#count_table tbody #discount_tr.d-none').removeClass('d-none');
                    $('#count_table #dis_amt').eq(0).text(`${disPer > 0 ? disPer + '%' : disTk + 'TK'}`);
                    $('#count_table .td_2').eq(0).text(discountedTotal.toFixed(2));
                } else {
                    $('#count_table tbody #discount_tr').eq(0).addClass('d-none');
                }

                // Set cash amount and update paid to discounted total
                if (!$('#cash_amt').data('user-modified')) {
                    $('#cash_amt').val(discountedReplaceTotal.toFixed(2));  // Set only if not modified by user
                }

                const actCashAmt = (parseFloat($('#cash_amt').val()) || 0);

                const paid = actCashAmt;

                // Calculate total due
                const round = $('#round_check').is(':checked') ? 0 : 0; // Initially no round applied
                let totalDue = (discountedReplaceTotal - paid);

                // Handle rounding
                if ($('#round_check').is(':checked')) {
                    $('#count_table #grand_round').text(totalDue.toFixed(2)); // Set round value to due amount
                    totalDue = 0; // Set total due to 0
                } else {
                    $('#count_table #grand_round').text(round.toFixed(2)); // Reset round value to 0
                }

                // Update fields in count_table
                $('#count_table .td_2').eq(1).text(discountedTotal.toFixed(2));
                $('#count_table .td_2').eq(2).text(totalRemitAmt.toFixed(2));  // Paid amount
                $('#count_table .td_2').eq(4).text(paid.toFixed(2));  // Paid amount
                $('#count_table .td_2').eq(6).text(totalDue.toFixed(2)); // Total due

                // Set default cash_paid to null (if not modified)
                if (!$('#cash_paid').data('user-modified')) {
                    $('#cash_paid').val(actCashAmt.toFixed(2));
                }

                // Set cash_change to null initially (if not modified by user)
                if (!$('#cash_change').data('user-modified')) {
                    $('#cash_change').val(null);
                }

                // Update change amount (based on cash_paid input)
                const cashPaid = parseFloat($('#cash_paid').val()) || 0;
                const cashChange = cashPaid - parseFloat($('#cash_amt').val()) || 0;
                $('#cash_change').val(cashChange.toFixed(2));
            }

            // Event listener for the discount submission button
            $('#dis_submit').on('click', function () {
                $('#discount_modal').modal('hide');
                updateTotals();
                $('#dis_modal_close').click();
            });

            // Customer Discounts scripts
            $(document).on('click', '#customer_search_list .list-group-customer', function () {
                const cartTotal = parseFloat($('#cart_total').text());
                const cusDiscount = parseFloat($('#cus_dis').text());
                const targetSale = parseFloat($('#cus_dis_ter').text());
                if (targetSale < cartTotal) {
                    parseFloat($('#dis_per').val(cusDiscount.toFixed(2)));
                    console.log($('#dis_per').val());
                    updateTotals();
                }
            });

            // Remit scripts
            $('#remit_submit_btn').on('click', function () {
                let remitAmount = $('#remit_amt').val();
                let cusRemitAmt = $('#CusPointSpan').text();
                if (remitAmount > 0) {
                    $('#count_table #remit_tr').removeClass('d-none');
                } else {
                    $('#count_table #remit_tr').addClass('d-none');
                }
                if (remitAmount > cusRemitAmt) {
                    alert('Remit amount exist customer point!');
                    $('#remit_amt').val(0);
                    $('#count_table #remit_tr').addClass('d-none');
                    updateTotals();
                    $('#remit_modal_close').click();
                    return;
                }
                updateTotals();
                $('#remit_modal_close').click();
            });

            // Detect changes to the #cash_amt field
            $('#cash_amt').on('input', function () {
                $(this).data('user-modified', true);
                updateTotals();
            });

            // Detect changes to the #cash_paid field
            $('#cash_paid').on('input', function () {
                $(this).data('user-modified', true);
                updateTotals();
            });

            // Recalculate totals when the round checkbox changes
            $('#round_check').on('change', function () {

                if ($('#round_check').is(':checked')) {
                    $('#count_table #grand_round').text(parseFloat($('#grand_due').text()).toFixed(2));
                    $('#grand_due').text('0.00');
                } else {
                    $('#grand_due').text(parseFloat($('#grand_round').text()).toFixed(2));
                    $('#count_table #grand_round').text('0.00');
                }
            });

            // Trigger updateTotals initially to set values
            updateTotals();

            // Handle form submission
            $('#product_form').on('submit', function (e) {
                e.preventDefault();

                // Get form values
                const productName = $('input[name="product"]').val().trim();
                const productBatch = $('input[name="batch_no"]').val().trim();

                // Find all batches for the given product
                const productStocks = stocks.filter(p => p.product_name === productName);

                if (!productStocks.length) {
                    return;
                }

                // Find the selected batch
                const stock = productStocks.find(p => String(p.batch_no) === String(productBatch));

                if (!stock) {
                    toastr.warning('Product with the specified batch not found!');
                    return;
                }

                // Check if the product with the same batch already exists in the table
                const existingRow = $('#sales_table tbody tr').toArray().find(row => {
                    const productName = $(row).find('.st_product').text().trim();
                    const batchNo = $(row).find('td:nth-child(3) select').val();
                    return String(productName) === String(stock.product_name) && String(batchNo) === String(stock.batch_no);
                });

                if (existingRow) {
                    // If the row exists, increment the quantity by 1
                    const qtyInput = $(existingRow).find('.so-qty-input');
                    const availableStock = parseFloat($(existingRow).find('.qty-input').val()) || 0;

                    if (Number(qtyInput.val()) + 1 > availableStock) {
                        alert(`Cannot exceed available stock (${availableStock}).`);
                        return;
                    }

                    qtyInput.val(Number(qtyInput.val()) + 1);

                    // Update the total
                    const price = parseFloat($(existingRow).find('.price-input').val());
                    const totalInput = $(existingRow).find('.total-input');
                    totalInput.val(price * Number(qtyInput.val()));
                } else {
                    const product = products.find(p => p.id === stock.product_id);
                    const barcode = product ? product.barcode : '';
                    // Append a new row if the product with the batch doesn't exist
                    $('#sales_table tbody').append(
                        `<tr>
                            <td style="display: none">${stock.product_id}</td>
                            <td class="text-center"><span class="st_product">${stock.product_name}</span> (${barcode})</td>
                            <td>
                                <select class="form-control form-control-sm batch-input">
                                    ${productStocks
                                        .map(batch => `<option value="${batch.batch_no}" ${batch.batch_no === stock.batch_no ? 'selected' : ''}>${batch.batch_no}</option>`)
                                        .join('')}
                                </select>
                            </td>
                            <td><input type="number" class="form-control form-control-sm qty-input" value="${stock.quantity}" readonly></td>
                            <td><input type="number" class="form-control form-control-sm so-qty-input" value="1" min="1"></td>
                            <td><input type="number" class="form-control form-control-sm price-input" value="${stock.sale_price}" readonly></td>
                            <td><input type="number" class="form-control form-control-sm total-input" value="${stock.sale_price}" readonly></td>
                            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash-alt"></i></button></td>
                        </tr>`
                    );
                }

                // Reset the form fields and update the totals
                this.reset();
                updateTotals();
            });

            // Restrict duplicate batch selection in the dropdown
            $(document).on('change', '.batch-input', function () {
                const selectedBatch = $(this).val();
                const productName = $(this).closest('tr').find('.st_product').text().trim();

                // Check if the selected batch with the same product already exists in the table
                const isDuplicate = $('#sales_table tbody tr').toArray().some(row => {
                    const rowProductName = $(row).find('.st_product').text().trim();
                    const rowBatchNo = $(row).find('.batch-input').val();
                    return rowProductName === productName && rowBatchNo === selectedBatch && row !== $(this).closest('tr')[0];
                });

                if (isDuplicate) {
                    alert('This batch number already exist.');
                    // Revert to the previous value
                    $(this).val($(this).data('previous'));
                } else {
                    // Store the current value as the previous value for next change
                    $(this).data('previous', selectedBatch);
                }
            });

            // Store the initial value of the dropdown on page load
            $(document).on('focus', '.batch-input', function () {
                $(this).data('previous', $(this).val());
            });

            // Update quantity and price when the batch changes
            $(document).on('change', '.batch-input', function () {
                const $row = $(this).closest('tr');
                const selectedBatch = $(this).val(); // Get the selected batch number
                const productName = $row.find('.st_product').text(); // Get the product name

                // Find the corresponding stock for the selected batch
                const stock = stocks.find(p => p.product_name === productName && String(p.batch_no) === String(selectedBatch));

                if (stock) {
                    // Update the quantity and sale price
                    $row.find('.qty-input').val(stock.quantity);
                    $row.find('.price-input').val(stock.sale_price);

                    // Update the total price based on the new batch
                    const saleQty = parseFloat($row.find('.so-qty-input').val()) || 0;
                    const total = saleQty * stock.sale_price; // Calculate the total price
                    $row.find('.total-input').val(total.toFixed(2));
                } else {
                    alert("Batch information not found.");
                }

                // Recalculate totals
                updateTotals();
            });

            // Update total-input dynamically based on so-qty-input and validate against quantity
            $(document).on('input', '.so-qty-input', function () {
                const $row = $(this).closest('tr');
                const qtyInput = parseFloat($row.find('.qty-input').val()) || 0;
                const saleQty = parseFloat($(this).val()) || 0;

                if (saleQty > qtyInput) {
                    alert(`Sale quantity cannot exceed available stock. Available stock is: ${qtyInput}`);
                    $(this).val(""); // Reset the sale quantity input
                    $row.find('.total-input').val("0.00"); // Reset total price
                } else {
                    const price = parseFloat($row.find('.price-input').val());
                    const total = saleQty * price;
                    $row.find('.total-input').val(total.toFixed(2));
                }

                // Recalculate totals
                updateTotals();
            });

            // Remove row and update totals
            $(document).on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
                updateTotals();
            });

            // Declare variables
            let r_cashPay = 0, r_cardPay = 0, r_mobilePay = 0, r_multPay = 0;

            // Add change event listener to the radio buttons
            $('input[name="radio_amount"]').on('change', function () {
                // Get the value of #cash_amt
                let r_cashAmt = $('#cash_amt').val();

                // Check which radio button is selected and assign the value accordingly
                if ($('#radio_cash').is(':checked')) {
                    r_cashPay = r_cashAmt;
                    r_cardPay = 0;
                    r_mobilePay = 0;
                    r_multPay = 0;
                } else if ($('#radio_card').is(':checked')) {
                    r_cardPay = r_cashAmt;
                    r_cashPay = 0;
                    r_mobilePay = 0;
                    r_multPay = 0;
                } else if ($('#radio_mob').is(':checked')) {
                    r_mobilePay = r_cashAmt;
                    r_cashPay = 0;
                    r_cardPay = 0;
                    r_multPay = 0;
                } else if ($('#radio_modal').is(':checked')) {
                    r_multPay = r_cashAmt;
                    r_cashPay = 0;
                    r_cardPay = 0;
                    r_mobilePay = 0;
                }
            });

            // Optionally, handle input changes for #cash_amt
            $('#cash_amt').on('input', function () {
                $('input[name="radio_amount"]:checked').trigger('change');
            });


            // Sales Replace Functions --------------------------------------->
            const sale_details = @json($sale_details);
            const sales = @json($sales);

            // Initially hide the return table div
            $('#return_table_div').toggle();

            // Function to handle the search logic
            function searchInvoice() {
                const saleInvoice = $('#invoice_search_input').val().trim();

                // Find the matching sale detail
                const saleDetail = sale_details.find(p => p.invoiceNo === saleInvoice);

                if (!saleDetail) {
                    alert("Invoice not found.");
                    return;
                }

                // Find all sales related to this sale detail
                const relatedSales = sales.filter(sale => sale.sales_ID === saleDetail.id);

                if (relatedSales.length === 0) {
                    alert("No sales found for this invoice.");
                    return;
                } else {
                    $('#return_table_div').toggle();
                }

                // Clear the previous rows
                $('#return_table tbody').empty();

                // Append rows for each related sale
                relatedSales.forEach(sale => {
                    $('#return_table tbody').append(`
                        <tr>
                            <td class="td-check">
                                <label class="custom-checkbox">
                                    <input type="checkbox" value="">
                                    <span></span>
                                </label>
                            </td>
                            <td>${sale.product_name}</td>
                            <td>${sale.batch_no}</td>
                            <td>${sale.so_qty}</td>
                            <td>${sale.returned || 0}</td>
                            <td><input type="number" class="form-control form-control-sm return_qty" min="0"></td>
                            <td>${sale.price}</td>
                            <td>${sale.total}</td>
                            <td class="d-none">${sale.product_id}</td>
                            <td class="d-none">${sale.sales_ID}</td>
                        </tr>
                    `);
                });

                let cardTotal = 0;
                if (saleDetail) {
                    $("#return_table tbody tr").each(function () {
                        cardTotal += parseFloat($(this).find("td").eq(7).text()) || 0;
                    });
                    let saleTotal = parseFloat(saleDetail.cashTotal) || 0;
                    let saleDiscount = saleDetail.cashDiscount;
                    let saleRound = parseFloat(saleDetail.cashRound) || 0;
                    let paidTotal = parseFloat(saleDetail.cashAmount + saleDetail.cardAmount + saleDetail.mobileAmount) || 0;
                    let saleDue = parseFloat(saleDetail.cashDue) || 0;

                    // Update table total quantity and price
                    $('#salesInfoTable #card_total').text(cardTotal.toFixed(2));
                    $('#salesInfoTable #sale_dis').text(saleDiscount);
                    $('#salesInfoTable #sale_total').text(saleTotal.toFixed(2));
                    $('#salesInfoTable #sale_round').text(saleRound.toFixed(2));
                    $('#salesInfoTable #paid_amt').text(paidTotal.toFixed(2));
                    $('#salesInfoTable #sale_due').text(saleDue.toFixed(2));
                }

                // Update the visibility of the return button
                toggleReturn();
            }

            // Function to toggle the visibility of the return button
            function toggleReturn() {
                const hasRows = $('#return_table tbody tr').length > 0;
                $('#addToreturn').toggle(hasRows); // Show or hide the button based on rows
                $('#salesInfoTable').toggle(hasRows); // Show or hide the button based on rows
            }

            // Function to handle the add to return button logic
            function handleAddToReturn() {
                // Get all checked rows
                const checkedRows = $('#return_table tbody tr').filter(function () {
                    return $(this).find('input[type="checkbox"]').is(':checked');
                });

                // If no rows are checked, show an alert and return
                if (checkedRows.length === 0) {
                    alert('Please select an item first');
                    return;
                }

                // Create the second table if it doesn't exist
                if ($('#appended_table').length === 0) {

                    if ($('#sales_table tbody tr').length === 0) {
                        alert('Please add product first!');
                        return;
                    }

                    const appendedTableHtml = `
                        <div class="table-responsive mt-5">
                            <h6 class="pl-2">Replace Product List</h6>
                            <table class="table table-hover" id="appended_table">
                                <thead>
                                    <tr class="text-primary">
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Batch</th>
                                        <th scope="col">Return Qty</th>
                                        <th scope="col">Unit Price</th>
                                        <th scope="col">Total Price</th>
                                        <th scope="col" class="d-none">Product ID</th>
                                        <th scope="col" class="d-none">Sale ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    `;

                    // Append the table after the #addToreturn button
                    $('#sales_table').after(appendedTableHtml);
                    // Programmatically trigger the click event on #sale_replace_close
                    $('#sale_replace_close').click();
                }

                // Clear previous appended rows in the second table
                $('#appended_table tbody').empty();
                $('#sale_replace_close').click();

                // Append checked rows to the second table
                checkedRows.each(function () {
                    const row = $(this);
                    const productName = row.find('td').eq(1).text();
                    const batch = row.find('td').eq(2).text();
                    const quantity = parseFloat(row.find('td').eq(3).text()).toFixed(2);
                    const returned = parseFloat(row.find('td').eq(4).text()).toFixed(2);
                    const returnQty = parseFloat(row.find('td').eq(5).find('input').val()).toFixed(2);
                    const unitPrice = row.find('td').eq(6).text();
                    const totalPrice = parseFloat(returnQty * unitPrice).toFixed(2);
                    const productID = row.find('td').eq(8).text();
                    const saleID = row.find('td').eq(9).text();

                    // Check if Return Qty is empty or not a number
                    if (!returnQty || isNaN(returnQty)) {
                        alert(`Return quantity for ${productName} is empty. Please enter a valid quantity.`);
                        $('#count_table #grand_replace').text(null);
                        return; // Skip this row
                    }

                    // Check if the item is completely returned
                    if (quantity === returned) {
                        alert(`This item (${productName}) is completely returned.`);
                        $('#count_table #grand_replace').text(null);
                        return; // Skip this row
                    }

                    // Check if the return quantity exceeds the available quantity
                    if (returnQty > (quantity - returned)) {
                        alert(`Return quantity for ${productName} exceeds the available quantity.`);
                        $('#count_table #grand_replace').text(null);
                        return; // Skip this row
                    }

                    // Append to the appended table
                    $('#appended_table tbody').append(`
                        <tr>
                            <td>${productName}</td>
                            <td>${batch}</td>
                            <td>${returnQty}</td>
                            <td>${unitPrice}</td>
                            <td>${totalPrice}</td>
                            <td class="d-none">${productID}</td>
                            <td class="d-none">${saleID}</td>
                        </tr>
                    `);
                });

                let totalReplace = 0;
                // Loop through each row in the sale replace table
                $('#appended_table tbody tr').each(function () {
                    totalReplace += parseFloat($(this).find("td").eq(4).text()) || 0;
                });

                // Remove `d-none` class if there is a totalReplace, else add it
                if (totalReplace > 0) {
                    $('#count_table tbody #replace_tr.d-none').removeClass('d-none');
                    $('#count_table #grand_replace').text(totalReplace.toFixed(2));
                } else {
                    $('#count_table tbody #replace_tr').addClass('d-none');
                }

                // Uncheck the checkboxes in the original table after moving rows
                $('#return_table tbody input[type="checkbox"]').prop('checked', false);

                // Toggle the visibility of the addToReturn button
                toggleReturn();
                updateTotals();
            }

            // Attach the click event to the add to return button
            $('#addToreturn').on('click', function () {
                handleAddToReturn();
            });

            // Click event for the search button
            $('#invoice_search_btn').on('click', function () {
                searchInvoice();
            });

            // Keydown event for the input field
            $('#invoice_search_input').on('keydown', function (event) {
                if (event.key === "Enter" || event.keyCode === 13) {
                    event.preventDefault();
                    searchInvoice();
                }
            });

            // Initial check for the return button visibility on page load
            $(document).ready(function () {
                toggleReturn();
            });


            // Sending Data to the BackEnd ------------------------------->
            $('#add_sale_btn').on('click', function () {
                $('#add_sale_btn').prop('disabled', true);
                const cashTotal = parseFloat($('#grand_total').text() || "0.00").toFixed(2);
                const cashDiscount = $('#dis_amt').text() || "0.00";
                let cashRound = parseFloat($('#grand_round').text() || "0.00");
                // Changing the round value
                cashRound = cashRound * -1;
                cashRound = cashRound.toFixed(2);
                console.log(cashDiscount);

                const cashDue = parseFloat($('#grand_due').text() || "0.00").toFixed(2);
                const replaceAmount = parseFloat($('#grand_replace').text() || "0.00").toFixed(2);
                const customer_id = $('#customerID').val();
                const remit_amt = parseFloat($('#remit_amt').val() || "0.00");

                const cashAmount = parseFloat($('#cash_amt').val() || "0.00").toFixed(2);
                const s_cashPaid = parseFloat($('#grand_paid').text() || "0.00").toFixed(2);
                const s_cashChange = parseFloat($('#cash_change').val() || "0.00").toFixed(2);

                let cashPay;
                if (!$('input[name="radio_amount"]').is(':checked')) {
                    cashPay = parseFloat($('#cash_amt').val() || "0.00").toFixed(2);
                } else {
                    cashPay = parseFloat(r_cashPay).toFixed(2);
                }

                // Conditioning the submit for Over Payment
                if (cashAmount > cashTotal) {
                    if (!$('#round_check').is(':checked')) {
                        alert('Over Payment is not allowed!');
                        $('#add_sale_btn').prop('disabled', false);
                        return;
                    }
                }

                const cardPay = parseFloat(r_cardPay).toFixed(2);
                const mobilePay = parseFloat(r_mobilePay).toFixed(2);
                const multPay = parseFloat(r_multPay).toFixed(2);

                const s_cardNumber = $('#card_number').val();
                const s_cardType = $('#card_type').val();
                const s_bankType = $('#bank_type').val();
                const s_mobBank = $('#mobile_bank').val();
                const s_mobTrans = $('#trans_no').val();
                const s_mobRcv = $('#rece_no').val();

                const m_cashAmt = parseFloat($('.m_cashAmt').text() || 0).toFixed(2);
                const m_cardAmt = parseFloat($('.m_cardAmt').text() || 0).toFixed(2);
                const m_mobAmt = parseFloat($('.m_mobAmt').text() || 0).toFixed(2);

                const m_cardNumber = $('#m_card_number').val();
                const m_cardType = $('#m_card_type').val();
                const m_bankType = $('#m_bank_type').val();
                const m_mobTrans = $('#m_trans_no').val();
                const m_mobBank = $('#m_mobile_bank').val();

                let invoice_no = Date.now() + 1;
                let return_invoice_no = Date.now() + 2;

                // Validate required fields
                if (cashTotal == 0) {
                    alert('Please Select a Product to proceed!');
                    $('#add_sale_btn').prop('disabled', false);
                    return;
                }

                if (cashDue > 0 && !customer_id) {
                    alert('Please enter a Customer to have Due!');
                    $('#add_sale_btn').prop('disabled', false);
                    return;
                }

                // Validating when card paying option is selected
                if (cardPay > 0) {
                    // Check if card number is null or empty
                    if (!s_cardNumber) {
                        alert("Enter Card number to proceed!");
                        $('#add_sale_btn').prop('disabled', false);
                        return;
                    }

                    // Check if card type is not selected
                    if (!s_cardType) {
                        alert("Select a Card type to proceed!");
                        $('#add_sale_btn').prop('disabled', false);
                        return;
                    }

                    // Check if bank type is not selected
                    if (!s_bankType) {
                        alert("Select a Bank to proceed!");
                        $('#add_sale_btn').prop('disabled', false);
                        return;
                    }
                }

                // Validating when mobile paying option is selected
                if (mobilePay > 0) {
                    // Check if card number is null or empty
                    if (!s_mobBank) {
                        alert("Select a mobile bank to proceed!");
                        $('#add_sale_btn').prop('disabled', false);
                        return;
                    }

                    // Check if card type is not selected
                    if (!s_mobTrans) {
                        alert("Enter transaction no. to proceed!");
                        $('#add_sale_btn').prop('disabled', false);
                        return;
                    }

                    // Check if bank type is not selected
                    if (!s_mobRcv) {
                        alert("Enter Reciever no. to proceed!");
                        $('#add_sale_btn').prop('disabled', false);
                        return;
                    }
                }

                const rows = [];
                // Loop through each row in the table and collect row data
                $('#sales_table tbody tr').each(function () {
                    rows.push({
                        product_id: $(this).find('td:eq(0)').text(),
                        product_name: $(this).find('td:eq(1)').text(),
                        batch_no: $(this).find('.batch-input').val(),
                        so_qty: parseFloat($(this).find('.so-qty-input').val()) || 0,
                        price: parseFloat($(this).find('.price-input').val()) || 0,
                        total_price: parseFloat($(this).find('.total-input').val()) || 0,
                    });
                });

                const r_rows = [];
                // Loop through each row in the table and collect row data
                $('#appended_table tbody tr').each(function () {
                    r_rows.push({
                        r_product_name: $(this).find('td:eq(0)').text(),
                        r_batch: $(this).find('td:eq(1)').text(),
                        r_return_qty: $(this).find('td:eq(2)').text(),
                        r_price: $(this).find('td:eq(3)').text(),
                        r_total_price: $(this).find('td:eq(4)').text(),
                        r_product_id: $(this).find('td:eq(5)').text(),
                        r_sales_ID: $(this).find('td:eq(6)').text(),
                    });
                });

                // Preparing the Sales infos
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('invoice_no', invoice_no);
                formData.append('r_invoice_no', return_invoice_no);
                formData.append('cash_total', cashTotal);
                formData.append('cash_dis', cashDiscount);
                formData.append('cash_round', cashRound);
                formData.append('cash_due', cashDue);
                formData.append('replace_amt', replaceAmount);
                formData.append('customerID', customer_id);
                formData.append('remitAmt', remit_amt);

                formData.append('s_cash_amt', cashPay);
                formData.append('m_cash_amt', m_cashAmt);
                formData.append('s_cash_paid', s_cashPaid);
                formData.append('s_cash_change', s_cashChange);

                formData.append('s_card_amt', cardPay);
                formData.append('m_card_amt', m_cardAmt);
                formData.append('s_card_num', s_cardNumber);
                formData.append('m_card_num', m_cardNumber);
                formData.append('s_card_type', s_cardType);
                formData.append('m_card_type', m_cardType);
                formData.append('s_bank_type', s_bankType);
                formData.append('m_bank_type', m_bankType);

                formData.append('s_mob_amt', mobilePay);
                formData.append('m_mob_amt', m_mobAmt);
                formData.append('s_mob_bank', s_mobBank);
                formData.append('m_mob_bank', m_mobBank);
                formData.append('s_mob_trans', s_mobTrans);
                formData.append('m_mob_trans', m_mobTrans);
                formData.append('s_mob_rcv', s_mobRcv);

                formData.append('rows', JSON.stringify(rows));
                formData.append('r_rows', JSON.stringify(r_rows));

                // Send data to the server via AJAX
                $.ajax({
                    url: '{{ route("save.sales") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        // Save response to local storage
                        localStorage.setItem('saleSummary', JSON.stringify(response));

                        // Reload the page
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        toastr.error('An error occurred: ' + xhr.responseText);
                    },
                });
            });

            // Hold Sales Script
            $('#hold_sale_btn').on('click', function () {

                let invoiceNo = Date.now();
                const rows = [];

                // Loop through each row in the table and collect row data
                $('#sales_table tbody tr').each(function () {
                    rows.push({
                        product_id: $(this).find('td:eq(0)').text(),
                        product_name: $(this).find('td:eq(1)').text(),
                        batch_no: $(this).find('.batch-input').val(),
                        so_qty: parseFloat($(this).find('.so-qty-input').val()) || 0,
                        price: parseFloat($(this).find('.price-input').val()) || 0,
                        total_price: parseFloat($(this).find('.total-input').val()) || 0,
                    });
                });

                // Check if rows are empty
                if (rows.length === 0) {
                    toastr.warning('Select a product to hold sale!');
                    return;
                }

                // Preparing the Sales infos
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('invoiceNo', invoiceNo);
                formData.append('rows', JSON.stringify(rows));

                // Send data to the server via AJAX
                $.ajax({
                    url: '{{ route("hold.sales") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        toastr.error('An error occurred: ' + xhr.responseText);
                    },
                });
            });

            // Restore sales Script
            $('.restore-sale-btn').on('click', function () {
                const invoiceNo = $(this).attr('data-invoice').trim();
                const product_count = $(this).attr('data-count').trim();
                const invoice_item = restoreSale.filter(p => p.invoiceNo === invoiceNo);

                for (const element of invoice_item) {
                    const productName = element.product_name;
                    const productBatch = element.batch_no;
                    const productStocks = stocks.filter(p => p.product_name === productName);

                    if (!productStocks.length) {
                        alert("Product not found.");
                        return;
                    }

                    const stock = productStocks.find(p => String(p.batch_no) === String(productBatch));
                    if (!stock) {
                        alert("Product with the specified batch not found.");
                        return;
                    }

                    const existingRow = $('#sales_table tbody tr').toArray().find(row => {
                        const productName = $(row).find('td:nth-child(2)').text().trim();
                        const batchNo = $(row).find('td:nth-child(3) select').val();
                        return String(productName) === String(stock.product_name) && String(batchNo) === String(stock.batch_no);
                    });

                    if (existingRow) {
                        const qtyInput = $(existingRow).find('.so-qty-input');
                        const availableStock = parseFloat($(existingRow).find('.qty-input').val()) || 0;

                        if (Number(qtyInput.val()) + 1 > availableStock) {
                            alert(`Cannot exceed available stock (${availableStock}).`);
                            return;
                        }

                        qtyInput.val(Number(qtyInput.val()) + 1);
                        const price = parseFloat($(existingRow).find('.price-input').val());
                        const totalInput = $(existingRow).find('.total-input');
                        totalInput.val(price * Number(qtyInput.val()));
                    } else {
                        $('#sales_table tbody').append(
                            `<tr>
                                <td style="display: none">${stock.product_id}</td>
                                <td>${stock.product_name}</td>
                                <td>
                                    <select class="form-control form-control-sm batch-input">
                                        ${productStocks
                                            .map(batch => `<option value="${batch.batch_no}" ${batch.batch_no === stock.batch_no ? 'selected' : ''}>${batch.batch_no}</option>`)
                                            .join('')}
                                    </select>
                                </td>
                                <td><input type="number" class="form-control form-control-sm qty-input" value="${stock.quantity}" readonly></td>
                                <td><input type="number" class="form-control form-control-sm so-qty-input" value="1" min="1"></td>
                                <td><input type="number" class="form-control form-control-sm price-input" value="${stock.sale_price}" readonly></td>
                                <td><input type="number" class="form-control form-control-sm total-input" value="${stock.sale_price}" readonly></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>`
                        );
                    }
                    updateTotals();
                }

                // AJAX request to delete the record from the database
                $.ajax({
                    url: '/delete-hold-sale', // Adjust the route as needed
                    type: 'POST',
                    data: {
                        invoiceNo: invoiceNo,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "timeOut": "5000",
                            "positionClass": "toast-top-right"
                        };
                        toastr.success(response.message, "Success!");

                        // Remove the row from the table
                        $(`button[data-invoice="${invoiceNo}"]`).closest('tr').remove();
                    },
                    error: function () {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "timeOut": "5000",
                            "positionClass": "toast-top-right"
                        };
                        toastr.error("Error deleting the record.", "Error!");
                    }
                });

                // Programmatically trigger the click event on Modal
                $('#restore_close').click();
            });
        });
    </script>
    <!-- JS for AfterSale Modal -->
    <script>
        $(document).ready(function () {
            function getFormattedDateTime() {
                const now = new Date();

                const months = [
                    "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                ];

                const day = now.getDate();
                const month = months[now.getMonth()];
                const year = now.getFullYear();

                let hours = now.getHours();
                const minutes = now.getMinutes().toString().padStart(2, '0');
                const ampm = hours >= 12 ? 'PM' : 'AM';

                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'

                return `${day} ${month}, ${year} ${hours}:${minutes} ${ampm}`;
            }

            // Example usage
            const dateTime = getFormattedDateTime();

            // Check if there is stored sale summary data
            let saleSummary = localStorage.getItem('saleSummary');
            if (saleSummary) {
                let response = JSON.parse(saleSummary);

                // Populate the modal with the stored data
                let summaryHtml = `
                    <div id="p_top" class="text-center">
                        <h5 id="p_head" style="font-size: 25px; font-weight: 400;">SAFI2 SUPER SHOP</h5>
                        <p id="p_address" style="font-size: 13px;">Taleb Ali Mosjid Road,Nijumbag,Sarulia,Demra,Dhaka -1361</p>
                        <hr style="border: 1px solid black; margin: 0px;">
                        <p id="p_vat" class="m-0">VAT Reg:</p>
                        <hr style="border: 1px solid black; margin: 0px;">
                    </div>
                    <div id="p_info" class="my-1" style="font-size: 13px;">
                        <p class="m-0" style="line-height: 1.1;">
                            ServedBy: ${response.user}
                        </p>
                        <p class="m-0" style="line-height: 1.1;">
                            Date: ${dateTime}
                        </p>
                        <p class="m-0" style="line-height: 1.1;">
                            Customer Name: ${response.customer_name}
                        </p>
                    </div>
                    <h5 id="p_invoice" class="text-center" style="font-size: 18px; font-weight: 400;">Invoive: ${response.invoiceNo}</h5>
                    <table class="table" border="0">
                        <thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
                            <tr>
                                <td>Product</td>
                                <td>U.Price</td>
                                <td>Qty</td>
                                <td>Total(&#2547;)</td>
                            </tr>
                        </thead>
                        <tbody style="font-size: 13px;">
                            ${response.rows.map(row => `
                                <tr>
                                    <td>${row.product_name}</td>
                                    <td>${parseFloat(row.price).toFixed(2)}</td>
                                    <td>${parseFloat(row.so_qty).toFixed(2)}</td>
                                    <td>${parseFloat(row.total_price).toFixed(2)}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                        <tfoot>
                            <tr class="bottom_border" style="border-bottom: 2px solid black;">
                                <td colspan="2">${response.items} Items</td>
                                <td>${parseFloat(response.total_qty).toFixed(2)}</td>
                                <td>${parseFloat(response.total_price).toFixed(2)}</td>
                            </tr>
                            <tr>
                                <td colspan="3">Discount</td>
                                <td>${response.discount}</td>
                            </tr>
                            <tr>
                                <td colspan="3">Round:</td>
                                <td>${response.cashRound}</td>
                            </tr>
                            <tr class="bottom_border" style="border-bottom: 2px solid black;">
                                <td colspan="3">Net Amount (&#2547;)</td>
                                <td>${response.cashTotal}</td>
                            </tr>
                            <tr class="dash_border" style="border-bottom:1px dashed black;">
                                <td colspan="3">Payment Type</td>
                                <td>Amount</td>
                            </tr>
                            ${response.cashAmount > 0 ? `
                                <tr>
                                    <td colspan="3">Cash</td>
                                    <td>${parseFloat(response.cashAmount).toFixed(2)}</td>
                                </tr>
                            ` : ''}
                            ${response.cardAmount > 0 ? `
                                <tr>
                                    <td colspan="3">Card</td>
                                    <td>${parseFloat(response.cardAmount).toFixed(2)}</td>
                                </tr>
                            ` : ''}
                            ${response.mobileAmount > 0 ? `
                                <tr>
                                    <td colspan="3">Mobile</td>
                                    <td>${parseFloat(response.mobileAmount).toFixed(2)}</td>
                                </tr>
                            ` : ''}
                            ${response.replaceAmount > 0 ? `
                                <tr>
                                    <td colspan="3">Replace</td>
                                    <td>${parseFloat(response.replaceAmount).toFixed(2)}</td>
                                </tr>
                            ` : ''}
                            <tr class="bottom_border" style="border-bottom: 2px solid black;" class="mt-1">
                                <td colspan="3">Total Paid:</td>
                                <td>${parseFloat(response.totalPaidAmt).toFixed(2)}</td>
                            </tr>
                            <tr class="mt-2">
                                <td colspan="3">Paid Amount:</td>
                                <td>${response.cashPaid}</td>
                            </tr>
                            <tr>
                                <td colspan="3">Due Amount:</td>
                                <td>${response.cashDue}</td>
                            </tr>
                            <tr class="dash_border" style="border-bottom: 1px dashed black;">
                                <td colspan="3">Change Amt:</td>
                                <td>${response.cashChange}</td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="text-center" style="font-size: 13px; margin-top: 30px;">
                        <p class="m-0 font-weight-bold" style="line-height: 1.1;">Shop Mobile No:01703338080</p>
                        <p class="m-0" style="line-height: 1.1;">Email-safi2supershop@gmail.com</p>
                        <p class="m-0" style="line-height: 1.1;">Web-www.safi2-supershop.com</p>
                        <p class="m-0" style="line-height: 1.1;">www.facebook.com/safi2supershop</p>
                        <p class="m-0" style="line-height: 1.1;">Software Developed By: www.dbdo.com</p>
                    </div>
                `;

                // Insert the HTML into the modal content
                $('#saleSummaryContent').html(summaryHtml);

                // Show the modal
                $('#saleSummaryModal').modal('show');

                // Clear the stored data
                localStorage.removeItem('saleSummary');
            }
        });
    </script>
    <!-- Script for Print -->
    <script>
        $(document).ready(function () {
            $(document).on('click', '#print_btn', function () {
                // Temporarily hide #modal_footer
                $('#modal_footer').hide();

                // Use a slight delay to ensure the print dialog is triggered first
                setTimeout(function () {
                    printJS({
                        printable: 'printModal',
                        type: 'html',
                        css: [
                            '{{ asset("admin_css/css/print.css") }}',
                            '{{ asset("admin_css/vendor/bootstrap/css/bootstrap.min.css") }}',
                        ]
                    });

                    // Restore #modal_footer after the print attempt
                    $('#modal_footer').show();
                }, 100);  // Short delay to ensure printJS runs first
            });
        });
    </script>

  </body>
</html>
