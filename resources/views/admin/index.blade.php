<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>Admin - Dashboard</title>
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
                <div class="col-lg-3 col-md-6">
                  <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                      <div class="title">
                        <div class="icon"><i class="icon-user-1"></i></div><strong>Total Clients</strong>
                      </div>
                      <div class="number dashtext-1">{{$user}}</div>
                    </div>
                    <div class="progress progress-template">
                      <div role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-1"></div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6">
                  <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                      <div class="title">
                        <div class="icon"><i class="icon-writing-whiteboard"></i></div><strong>Total Products</strong>
                      </div>
                      <div class="number dashtext-2">{{$product}}</div>
                    </div>
                    <div class="progress progress-template">
                      <div role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-2"></div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6">
                  <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                      <div class="title">
                        <div class="icon"><i class="icon-contract"></i></div><strong>Total Orders</strong>
                      </div>
                      <div class="number dashtext-3">{{$order}}</div>
                    </div>
                    <div class="progress progress-template">
                      <div role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-3"></div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6">
                  <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                      <div class="title">
                        <div class="icon"><i class="icon-windows"></i></div><strong>Total Delivered</strong>
                      </div>
                      <div class="number dashtext-4">{{$deliver}}</div>
                    </div>
                    <div class="progress progress-template">
                      <div role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-4"></div>
                    </div>
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
