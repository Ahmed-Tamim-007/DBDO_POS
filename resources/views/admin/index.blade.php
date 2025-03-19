<!DOCTYPE html>
<html>
  <head>
    @include('admin.dash_head')
    <title>DEV POS - Dashboard</title>
    <style>
        .table td {
            border-top: 1px solid white !important;
        }
        .table tfoot th {
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
                        <div class="col-lg-5 col-md-6">
                            <div class="block p-0" style="text-align: center;">
                                <div style="padding: 10px; background: linear-gradient(135deg, #019bee, #007bbf); color: white; font-size: 18px; font-weight: bold;">
                                    Total Stock Overview
                                </div>
                                <div style="padding: 25px;">
                                    <div style="font-size: 18px; font-weight: bold; color: #555;">Total Stock Value</div>
                                    <div style="font-size: 36px; font-weight: bold; color: #019bee; margin-top: 5px;">
                                        {{ number_format($totalStockValue, 2) }} &#2547;
                                    </div>
                                    <hr style="margin: 20px auto; width: 50%; border-top: 2px dashed #ddd;">
                                    <div style="display: flex; flex-direction: column; align-items: center;">
                                        <div style="background: #7ED321; color: white; padding: 10px 10px; font-size: 32px; font-weight: bold; border-radius: 12px; min-width: 150px;">
                                            {{ $totalProductsInStock }}
                                        </div>
                                        <div style="margin-top: 10px; font-size: 18px; font-weight: bold; color: #7ED321;">
                                            Products In Stock
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="block p-0">
                                <div style="padding: 10px; background: linear-gradient(135deg, #079f7f, #078267); color: white; font-size: 18px; font-weight: bold; text-align: center;">
                                    Last 4 Weeks Sales
                                </div>
                                <div class="pie-chart chart p-3">
                                    <div class="pie-chart chart margin-bottom-sm">
                                        <canvas id="last4weeksalechart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="block" style="padding: 30px; color: white !important; background: linear-gradient(135deg, #079f7f, #078267);">
                                <h4 class="text-center mb-3">Account Balance Table</h4>
                                <div class="table-responsive">
                                    <table class="table">
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
                        <div class="col-md-12">
                            <div class="block" style="background: linear-gradient(135deg, #019bee, #007bbf); color: white;">
                                <h4 class="text-center mb-3">Profit / Loss Table</h4>
                                <div>
                                    <button class="btn btn-light profit-filter" data-filter="today">Today</button>
                                    <button class="btn btn-secondary profit-filter" data-filter="last_week">Last Week</button>
                                    <button class="btn btn-warning profit-filter" data-filter="last_2_weeks">Last 2 Weeks</button>
                                    <button class="btn btn-success profit-filter" data-filter="last_month">Last Month</button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table mt-3">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Sales Price</th>
                                                <th>Buying Price</th>
                                                <th>Return Sale</th>
                                                <th>Return Buy</th>
                                                <th>Round</th>
                                                <th>Profit/Loss</th>
                                            </tr>
                                        </thead>
                                        <tbody id="profitLossTable">
                                            @foreach ($profitLossData as $data)
                                            <tr>
                                                <td>{{ $data['date'] }}</td>
                                                <td data-value="{{ $data['total_sales_amount'] }}">{{ number_format($data['total_sales_amount'], 2) }}</td>
                                                <td data-value="{{ $data['total_purchase_cost'] }}">{{ number_format($data['total_purchase_cost'], 2) }}</td>
                                                <td data-value="{{ $data['total_returns_amount'] }}">{{ number_format($data['total_returns_amount'], 2) }}</td>
                                                <td data-value="{{ $data['total_returns_cost'] }}">{{ number_format($data['total_returns_cost'], 2) }}</td>
                                                <td data-value="{{ $data['total_round_amount'] }}">{{ number_format($data['total_round_amount'], 2) }}</td>
                                                <td data-value="{{ $data['profit_or_loss'] }}">{{ number_format($data['profit_or_loss'], 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Total</th>
                                                <th id="totalSales">0.00</th>
                                                <th id="totalBuying">0.00</th>
                                                <th id="totalReturnSale">0.00</th>
                                                <th id="totalReturnBuy">0.00</th>
                                                <th id="totalRound">0.00</th>
                                                <th id="totalProfitLoss">0.00</th>
                                            </tr>
                                        </tfoot>
                                    </table>

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

    <!-- JavaScript files-->
    @include('admin.dash_script')

    <!-- JS for Last 4 week sales -->
    <script>
        $(document).ready(function () {
            'use strict';

            Chart.defaults.global.defaultFontColor = '#75787c';

            var PIECHARTEXMPLE = $('#last4weeksalechart');

            var salesData = @json(array_column($weeklySales, 'sales'));
            var labels = @json(array_column($weeklySales, 'week'));

            var pieChartExample = new Chart(PIECHARTEXMPLE, {
                type: 'pie',
                options: {
                    legend: {
                        display: true,
                        position: "left"
                    }
                },
                data: {
                    labels: labels,
                    datasets: [
                        {
                            data: salesData,
                            borderWidth: 0,
                            backgroundColor: [
                                '#019bee',
                                "#7ED321",
                                "#ff6122",
                                "#079f7f"
                            ],
                            hoverBackgroundColor: [
                                '#019bee',
                                "#7ED321",
                                "#ff6122",
                                "#079f7f"
                            ]
                        }
                    ]
                }
            });

            var pieChartExample = {
                responsive: true
            };
        });
    </script>
    <!-- JS for profit/loss table -->
    <script>
        $(document).ready(function(){
            // Function to calculate totals
            function updateFooterTotals() {
                let totalSales = 0, totalBuying = 0, totalReturnSale = 0;
                let totalReturnBuy = 0, totalRound = 0, totalProfitLoss = 0;

                $("#profitLossTable tr").each(function(){
                    let sales = parseFloat($(this).find("td:eq(1)").data("value")) || 0;
                    let buying = parseFloat($(this).find("td:eq(2)").data("value")) || 0;
                    let returnSale = parseFloat($(this).find("td:eq(3)").data("value")) || 0;
                    let returnBuy = parseFloat($(this).find("td:eq(4)").data("value")) || 0;
                    let round = parseFloat($(this).find("td:eq(5)").data("value")) || 0;
                    let profitLoss = parseFloat($(this).find("td:eq(6)").data("value")) || 0;

                    totalSales += sales;
                    totalBuying += buying;
                    totalReturnSale += returnSale;
                    totalReturnBuy += returnBuy;
                    totalRound += round;
                    totalProfitLoss += profitLoss;
                });

                // Update the footer with formatted numbers
                $("#totalSales").text(totalSales.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                $("#totalBuying").text(totalBuying.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                $("#totalReturnSale").text(totalReturnSale.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                $("#totalReturnBuy").text(totalReturnBuy.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                $("#totalRound").text(totalRound.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                $("#totalProfitLoss").text(totalProfitLoss.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            }

            // Call this function on page load to calculate initial totals
            updateFooterTotals();

            // Filter button click event
            $(".profit-filter").click(function(){
                let filter = $(this).data("filter");

                $.ajax({
                    url: "{{ route('profit.loss.filter') }}",
                    type: "GET",
                    data: { filter: filter },
                    success: function(response){
                        let tableBody = $("#profitLossTable");
                        tableBody.empty();

                        $.each(response, function(index, data){
                            tableBody.append(`<tr>
                                <td>${data.date}</td>
                                <td data-value="${data.total_sales_amount}">${parseFloat(data.total_sales_amount).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                <td data-value="${data.total_purchase_cost}">${parseFloat(data.total_purchase_cost).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                <td data-value="${data.total_returns_amount}">${parseFloat(data.total_returns_amount).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                <td data-value="${data.total_returns_cost}">${parseFloat(data.total_returns_cost).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                <td data-value="${data.total_round_amount}">${parseFloat(data.total_round_amount).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                <td data-value="${data.profit_or_loss}">${parseFloat(data.profit_or_loss).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                            </tr>`);
                        });

                        // Update totals after filtering
                        updateFooterTotals();
                    }
                });
            });
        });
    </script>

  </body>
</html>
