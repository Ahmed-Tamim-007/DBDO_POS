<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>Admin - Dashboard</title>
    <style>
        .table td {
            border-top: 1px solid white !important;
        }
        .block {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden; /* Ensures child elements don't overflow during scaling */
        }

        .block:hover {
            transform: scale(1.0); /* Slight zoom-in */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3); /* Cool shadow effect */
        }
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
            <h2 class="h5 no-margin-bottom">Dashboard</h2>
          </div>
        </div>

        <!-- Body Sections -->
        <section class="no-padding-top no-padding-bottom">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="block p-0">
                            <div style="text-align: center; background-color: #019bee; color: white; padding: 10px; font-size: 18px; font-weight: bold;">
                                Total Stock Value
                            </div>
                            <div style="text-align: center; color: #019bee; padding: 40px; font-size: 40px; font-weight: bold;">
                                {{ number_format($totalStockValue, 2) }} &#2547;
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="block p-0">
                            <div style="display: flex; flex-direction: row; align-items: center; justify-content: center; padding: 22px;">
                                <span style="border: 2px solid #7ED321; border-radius: 50%; padding: 40px; font-size: 40px; font-weight: bold; color: #7ED321; display: inline-block;">
                                    {{$totalProductsInStock}}
                                </span>
                                <span style="margin-left: 20px; font-size: 24px; font-weight: bold; color: #7ED321; text-align: center;">
                                    Product In Stock
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="block p-0">
                            <div style="text-align: center; background-color: #ff6122; color: white; padding: 10px; font-size: 18px; font-weight: bold;">
                                Last Week Sale <br> {{ $fromDate->format('d M Y') }} - {{ $toDate->format('d M Y') }}
                            </div>
                            <div style="text-align: center; color: #ff6122; padding: 30px; font-size: 35px; font-weight: bold;">
                                {{ number_format($lastWeekSales, 2) }} &#2547;
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="block" style="padding: 30px; background-color: #079f7f;">
                            <table class="table" style="color: white !important;">
                                <thead>
                                    <tr>
                                        <th scope="col">SL.</th>
                                        <th scope="col">Account Name</th>
                                        <th scope="col">Account No</th>
                                        <th scope="col">Account Type</th>
                                        <th scope="col">Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accounts as $account)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$account->acc_name}}</td>
                                            <td>{{$account->acc_no}}</td>
                                            <td>{{$account->account_type}}</td>
                                            <td>{{$account->crnt_balance}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- <section class="no-padding-top no-padding-bottom">
            <div class="container-fluid">
                <div class="row px-3">
                    <div class="col-12 block">
                        <h3 class="text-center mx-auto my-4">Sales Report</h3>

                        <!-- Date Filters -->
                        <div class="btn-group mb-3">
                            <a href="{{ route('sales_report', ['filter' => 'today']) }}" class="btn btn-primary">Today</a>
                            <a href="{{ route('sales_report', ['filter' => 'yesterday']) }}" class="btn btn-secondary">Yesterday</a>
                            <a href="{{ route('sales_report', ['filter' => 'last_week']) }}" class="btn btn-info">Last Week</a>
                            <a href="{{ route('sales_report', ['filter' => 'last_month']) }}" class="btn btn-warning">Last Month</a>
                            <a href="{{ route('sales_report', ['filter' => 'last_year']) }}" class="btn btn-danger">Last Year</a>
                        </div>

                        <!-- Date Range Filter -->
                        <form method="GET" action="{{ route('sales_report') }}" class="mb-3">
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date', $from->toDateString()) }}">
                                </div>
                                <div class="col-md-5">
                                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date', $to->toDateString()) }}">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-secondary">Filter</button>
                                </div>
                            </div>
                        </form>

                        <!-- Report Table -->
                        <div class="table-responsive">
                            <table class="datatable table table-striped table-hover">
                                <thead class="text-primary">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Type</th>
                                        <th>Product Name</th>
                                        <th>Batch No</th>
                                        <th>Quantity</th>
                                        <th>Selling Price</th>
                                        <th>Buying Price</th>
                                        <th>Profit/Loss</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reportData as $data)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{ $data['type'] }}</td>
                                            <td>{{ $data['product_id'] }}</td>
                                            <td>{{ $data['batch_no'] }}</td>
                                            <td>{{ $data['quantity'] }}</td>
                                            <td>&#2547; {{ $data['selling_price'] ? $data['selling_price'] : 'N/A' }}</td>
                                            <td>&#2547; {{ $data['buying_price'] }}</td>
                                            <td style="color: {{ $data['profit'] >= 0 ? 'green' : 'red' }};">
                                                {{ $data['profit'] >= 0 ? '+' : '' }}&#2547; {{ $data['profit'] }}
                                            </td>
                                            <td>{{ $data['date']->format('Y-m-d H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div style="text-align:center; font-weight:bold; margin:10px 0px;">
                                Total Profit: &#2547; <span style="color: {{ $totalProfit >= 0 ? 'green' : 'red' }};">{{ $totalProfit }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}

        {{-- <section class="no-padding-bottom">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-5">
                    <div class="pie-chart chart block">
                        <div class="title"><strong>Pie Chart Example</strong></div>
                        <div class="pie-chart chart margin-bottom-sm">
                            <canvas id="pieChartCustom1"></canvas>
                        </div>
                    </div>
                    <div class="bar-chart block">
                        <canvas id="barChartExample1"></canvas>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="line-chart block chart">
                        <div class="title"><strong>Line Chart Example</strong></div>
                        <canvas id="lineChartCustom1"></canvas>
                    </div>
                    <div class="stats-3-block block d-flex">
                        <div class="stats-3"><strong class="d-block">745</strong><span class="d-block">Total requests</span>
                          <div class="progress progress-template progress-small">
                            <div role="progressbar" style="width: 35%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template progress-bar-small dashbg-1"></div>
                          </div>
                        </div>
                        <div class="stats-3 d-flex justify-content-between text-center">
                          <div class="item"><strong class="d-block strong-sm">4.124</strong><span class="d-block span-sm">Threats</span>
                            <div class="line"></div><small>+246</small>
                          </div>
                          <div class="item"><strong class="d-block strong-sm">2.147</strong><span class="d-block span-sm">Neutral</span>
                            <div class="line"></div><small>+416</small>
                          </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
        </section> --}}

        <!-- Footer Sections -->
        @include('admin.dash_footer')

      </div>
    </div>
    <!-- JavaScript files-->
    @include('admin.dash_script')
  </body>
</html>
